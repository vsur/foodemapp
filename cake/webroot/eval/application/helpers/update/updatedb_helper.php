<?PHP

/*
* LimeSurvey
* Copyright (C) 2007-2011 The LimeSurvey Project Team / Carsten Schmitz
* All rights reserved.
* License: GNU/GPL License v2 or later, see LICENSE.php
* LimeSurvey is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*
*/

/* Rules:
- Never use models in the upgrade process - never ever!
- Use the provided addColumn, alterColumn, dropPrimaryKey etc. functions where applicable - they ensure cross-DB compatibility
- Never use foreign keys
- Use only the field types listed here:

    pk: auto-incremental primary key type (“int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY”).
    string: string type (“varchar(255)”).
    text: a long string type (“text”) - MySQL: max size 64kb - Postgres: unlimited - MSSQL: max size 2.1GB
    mediumtext: a long string type (“text”) - MySQL: max size 16MB - Postgres: unlimited - MSSQL: max size 2.1GB
    longtext: a long string type (“text”) - MySQL: max size 2.1 GB - Postgres: unlimited - MSSQL: max size 2.1GB
    integer: integer type (“int(11)”).
    boolean: boolean type (“tinyint(1)”).
    float: float number type (“float”).
    decimal: decimal number type (“decimal”).
    datetime: datetime type (“datetime”).
    time: time type (“time”).
    date: date type (“date”).
    binary: binary data type (“blob”).

    These are case-sensitive - only use lowercase!
- If you want to use database functions make sure they exist on all three supported database types
- Always prefix key names by using curly brackets {{ }}

*/

/**
* @param integer $iOldDBVersion The previous database version
* @param boolean $bSilent Run update silently with no output - this checks if the update can be run silently at all. If not it will not run any updates at all.
*/
function db_upgrade_all($iOldDBVersion, $bSilent = false)
{
    /**
     * If you add a new database version add any critical database version numbers to this array. See link
     * @link https://manual.limesurvey.org/Database_versioning for explanations
     * @var array $aCriticalDBVersions An array of cricital database version.
     */
    $aCriticalDBVersions = array(310, 400, 450);
    $aAllUpdates         = range($iOldDBVersion + 1, Yii::app()->getConfig('dbversionnumber'));

    // If trying to update silenty check if it is really possible
    if ($bSilent && (count(array_intersect($aCriticalDBVersions, $aAllUpdates)) > 0)) {
        return false;
    }
    // If DBVersion is older than 184 don't allow database update
    if ($iOldDBVersion < 132) {
        return false;
    }

    /// This function does anything necessary to upgrade
    /// older versions to match current functionality

    Yii::app()->loadHelper('database');
    Yii::import('application.helpers.admin.import_helper', true);
    $sUserTemplateRootDir       = Yii::app()->getConfig('userthemerootdir');
    $sStandardTemplateRootDir   = Yii::app()->getConfig('standardthemerootdir');
    $oDB                        = Yii::app()->getDb();
    $oDB->schemaCachingDuration = 0; // Deactivate schema caching
    Yii::app()->setConfig('Updating', true);
    $options = "";
    // The engine has to be explicitely set because MYSQL 8 switches the default engine to INNODB
    if (Yii::app()->db->driverName == 'mysql') {
        $options = 'ENGINE=' . Yii::app()->getConfig('mysqlEngine') . ' DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
        if (Yii::app()->getConfig('mysqlEngine') == 'INNODB') {
            $options .= ' ROW_FORMAT=DYNAMIC'; // Same than create-database
        }
    }
    try {
        // Version 1.80 had database version 132
        // This is currently the oldest version we need support to update from
        if ($iOldDBVersion < 133) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{users}}', 'one_time_pw', 'binary');
            // Add new assessment setting
            addColumn('{{surveys}}', 'assessments', "string(1) NOT NULL default 'N'");
            // add new assessment value fields to answers & labels
            addColumn('{{answers}}', 'assessment_value', "integer NOT NULL default '0'");
            addColumn('{{labels}}', 'assessment_value', "integer NOT NULL default '0'");
            // copy any valid codes from code field to assessment field
            switch (Yii::app()->db->driverName) {
                case 'mysql':
                    $oDB->createCommand(
                        "UPDATE {{answers}} SET assessment_value=CAST(`code` as SIGNED) where `code` REGEXP '^-?[0-9]+$'"
                    )->execute();
                    $oDB->createCommand(
                        "UPDATE {{labels}} SET assessment_value=CAST(`code` as SIGNED) where `code` REGEXP '^-?[0-9]+$'"
                    )->execute();
                    // copy assessment link to message since from now on we will have HTML assignment messages
                    $oDB->createCommand(
                        "UPDATE {{assessments}} set message=concat(replace(message,'/''',''''),'<br /><a href=\"',link,'\">',link,'</a>')"
                    )->execute();
                    break;
                case 'sqlsrv':
                case 'dblib':
                case 'mssql':
                    try {
                        $oDB->createCommand(
                            "UPDATE {{answers}} SET assessment_value=CAST([code] as int) WHERE ISNUMERIC([code])=1"
                        )->execute();
                        $oDB->createCommand(
                            "UPDATE {{labels}} SET assessment_value=CAST([code] as int) WHERE ISNUMERIC([code])=1"
                        )->execute();
                    } catch (Exception $e) {
                    };
                    // copy assessment link to message since from now on we will have HTML assignment messages
                    alterColumn('{{assessments}}', 'link', "text", false);
                    alterColumn('{{assessments}}', 'message', "text", false);
                    $oDB->createCommand(
                        "UPDATE {{assessments}} set message=replace(message,'/''','''')+'<br /><a href=\"'+link+'\">'+link+'</a>'"
                    )->execute();
                    break;
                case 'pgsql':
                    $oDB->createCommand(
                        "UPDATE {{answers}} SET assessment_value=CAST(code as integer) where code ~ '^[0-9]+'"
                    )->execute();
                    $oDB->createCommand(
                        "UPDATE {{labels}} SET assessment_value=CAST(code as integer) where code ~ '^[0-9]+'"
                    )->execute();
                    // copy assessment link to message since from now on we will have HTML assignment messages
                    $oDB->createCommand(
                        "UPDATE {{assessments}} set message=replace(message,'/''','''')||'<br /><a href=\"'||link||'\">'||link||'</a>'"
                    )->execute();
                    break;
            }
            // activate assessment where assessment rules exist
            $oDB->createCommand(
                "UPDATE {{surveys}} SET assessments='Y' where sid in (SELECT sid FROM {{assessments}} group by sid)"
            )->execute();
            // add language field to assessment table
            addColumn('{{assessments}}', 'language', "string(20) NOT NULL default 'en'");
            // update language field with default language of that particular survey
            $oDB->createCommand(
                "UPDATE {{assessments}} SET language=(select language from {{surveys}} where sid={{assessments}}.sid)"
            )->execute();
            // drop the old link field
            dropColumn('{{assessments}}', 'link');

            // Add new fields to survey language settings
            addColumn('{{surveys_languagesettings}}', 'surveyls_url', "string");
            addColumn('{{surveys_languagesettings}}', 'surveyls_endtext', 'text');
            // copy old URL fields ot language specific entries
            $oDB->createCommand(
                "UPDATE {{surveys_languagesettings}} set surveyls_url=(select url from {{surveys}} where sid={{surveys_languagesettings}}.surveyls_survey_id)"
            )->execute();
            // drop old URL field
            dropColumn('{{surveys}}', 'url');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 133), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 134) {
            $oTransaction = $oDB->beginTransaction();
            // Add new tokens setting
            addColumn('{{surveys}}', 'usetokens', "string(1) NOT NULL default 'N'");
            addColumn('{{surveys}}', 'attributedescriptions', 'text');
            dropColumn('{{surveys}}', 'attribute1');
            dropColumn('{{surveys}}', 'attribute2');
            upgradeTokenTables134();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 134), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 135) {
            $oTransaction = $oDB->beginTransaction();
            alterColumn('{{question_attributes}}', 'value', 'text');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 135), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 136) { //New Quota Functions
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{quota}}', 'autoload_url', "integer NOT NULL default 0");
            // Create quota table
            $aFields = array(
                'quotals_id' => 'pk',
                'quotals_quota_id' => 'integer NOT NULL DEFAULT 0',
                'quotals_language' => "string(45) NOT NULL default 'en'",
                'quotals_name' => 'string',
                'quotals_message' => 'text NOT NULL',
                'quotals_url' => 'string',
                'quotals_urldescrip' => 'string',
            );
            $oDB->createCommand()->createTable('{{quota_languagesettings}}', $aFields);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 136), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 137) { //New Quota Functions
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{surveys_languagesettings}}', 'surveyls_dateformat', "integer NOT NULL default 1");
            addColumn('{{users}}', 'dateformat', "integer NOT NULL default 1");
            $oDB->createCommand()->update('{{surveys}}', array('startdate' => null), "usestartdate='N'");
            $oDB->createCommand()->update('{{surveys}}', array('expires' => null), "useexpiry='N'");
            dropColumn('{{surveys}}', 'useexpiry');
            dropColumn('{{surveys}}', 'usestartdate');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 137), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 138) { //Modify quota field
            $oTransaction = $oDB->beginTransaction();
            alterColumn('{{quota_members}}', 'code', "string(11)");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 138), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 139) { //Modify quota field
            $oTransaction = $oDB->beginTransaction();
            upgradeSurveyTables139();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 139), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 140) { //Modify surveys table
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{surveys}}', 'emailresponseto', 'text');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 140), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 141) { //Modify surveys table
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{surveys}}', 'tokenlength', 'integer NOT NULL default 15');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 141), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 142) { //Modify surveys table
            $oTransaction = $oDB->beginTransaction();
            upgradeQuestionAttributes142();
            $oDB->createCommand()->alterColumn('{{surveys}}', 'expires', "datetime");
            $oDB->createCommand()->alterColumn('{{surveys}}', 'startdate', "datetime");
            $oDB->createCommand()->update('{{question_attributes}}', array('value' => 0), "value='false'");
            $oDB->createCommand()->update('{{question_attributes}}', array('value' => 1), "value='true'");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 142), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 143) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{questions}}', 'parent_qid', 'integer NOT NULL default 0');
            addColumn('{{answers}}', 'scale_id', 'integer NOT NULL default 0');
            addColumn('{{questions}}', 'scale_id', 'integer NOT NULL default 0');
            addColumn('{{questions}}', 'same_default', 'integer NOT NULL default 0');
            dropPrimaryKey('answers');
            addPrimaryKey('answers', array('qid', 'code', 'language', 'scale_id'));

            $aFields = array(
                'qid' => "integer NOT NULL default 0",
                'scale_id' => 'integer NOT NULL default 0',
                'sqid' => 'integer  NOT NULL default 0',
                'language' => 'string(20) NOT NULL',
                'specialtype' => "string(20) NOT NULL default ''",
                'defaultvalue' => 'text',
            );
            $oDB->createCommand()->createTable('{{defaultvalues}}', $aFields);
            addPrimaryKey('defaultvalues', array('qid', 'specialtype', 'language', 'scale_id', 'sqid'));

            // -Move all 'answers' that are subquestions to the questions table
            // -Move all 'labels' that are answers to the answers table
            // -Transscribe the default values where applicable
            // -Move default values from answers to questions
            upgradeTables143();

            dropColumn('{{answers}}', 'default_value');
            dropColumn('{{questions}}', 'lid');
            dropColumn('{{questions}}', 'lid1');

            $aFields = array(
                'sesskey' => "string(64) NOT NULL DEFAULT ''",
                'expiry' => "datetime NOT NULL",
                'expireref' => "string(250) DEFAULT ''",
                'created' => "datetime NOT NULL",
                'modified' => "datetime NOT NULL",
                'sessdata' => 'text'
            );
            $oDB->createCommand()->createTable('{{sessions}}', $aFields);
            addPrimaryKey('sessions', array('sesskey'));
            $oDB->createCommand()->createIndex('sess2_expiry', '{{sessions}}', 'expiry');
            $oDB->createCommand()->createIndex('sess2_expireref', '{{sessions}}', 'expireref');
            // Move all user templates to the new user template directory
            echo "<br>" . sprintf(
                gT("Moving user templates to new location at %s..."),
                $sUserTemplateRootDir
            ) . "<br />";
            $hTemplateDirectory = opendir($sStandardTemplateRootDir);
            $aFailedTemplates = array();
            // get each entry
            while ($entryName = readdir($hTemplateDirectory)) {
                if (
                    !in_array($entryName, array('.', '..', '.svn')) && is_dir(
                        $sStandardTemplateRootDir . DIRECTORY_SEPARATOR . $entryName
                    ) && !Template::isStandardTemplate($entryName)
                ) {
                    if (
                        !rename(
                            $sStandardTemplateRootDir . DIRECTORY_SEPARATOR . $entryName,
                            $sUserTemplateRootDir . DIRECTORY_SEPARATOR . $entryName
                        )
                    ) {
                        $aFailedTemplates[] = $entryName;
                    };
                }
            }
            if (count($aFailedTemplates) > 0) {
                echo "The following templates at {$sStandardTemplateRootDir} could not be moved to the new location at {$sUserTemplateRootDir}:<br /><ul>";
                foreach ($aFailedTemplates as $sFailedTemplate) {
                    echo "<li>{$sFailedTemplate}</li>";
                }
                echo "</ul>Please move these templates manually after the upgrade has finished.<br />";
            }
            // close directory
            closedir($hTemplateDirectory);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 143), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 145) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{surveys}}', 'savetimings', "string(1) NULL default 'N'");
            addColumn('{{surveys}}', 'showXquestions', "string(1) NULL default 'Y'");
            addColumn('{{surveys}}', 'showgroupinfo', "string(1) NULL default 'B'");
            addColumn('{{surveys}}', 'shownoanswer', "string(1) NULL default 'Y'");
            addColumn('{{surveys}}', 'showqnumcode', "string(1) NULL default 'X'");
            addColumn('{{surveys}}', 'bouncetime', 'integer');
            addColumn('{{surveys}}', 'bounceprocessing', "string(1) NULL default 'N'");
            addColumn('{{surveys}}', 'bounceaccounttype', "string(4)");
            addColumn('{{surveys}}', 'bounceaccounthost', "string(200)");
            addColumn('{{surveys}}', 'bounceaccountpass', "string(100)");
            addColumn('{{surveys}}', 'bounceaccountencryption', "string(3)");
            addColumn('{{surveys}}', 'bounceaccountuser', "string(200)");
            addColumn('{{surveys}}', 'showwelcome', "string(1) default 'Y'");
            addColumn('{{surveys}}', 'showprogress', "string(1) default 'Y'");
            addColumn('{{surveys}}', 'allowjumps', "string(1) default 'N'");
            addColumn('{{surveys}}', 'navigationdelay', "integer default 0");
            addColumn('{{surveys}}', 'nokeyboard', "string(1) default 'N'");
            addColumn('{{surveys}}', 'alloweditaftercompletion', "string(1) default 'N'");


            $aFields = array(
                'sid' => "integer NOT NULL",
                'uid' => "integer NOT NULL",
                'permission' => 'string(20) NOT NULL',
                'create_p' => "integer NOT NULL default 0",
                'read_p' => "integer NOT NULL default 0",
                'update_p' => "integer NOT NULL default 0",
                'delete_p' => "integer NOT NULL default 0",
                'import_p' => "integer NOT NULL default 0",
                'export_p' => "integer NOT NULL default 0"
            );
            $oDB->createCommand()->createTable('{{survey_permissions}}', $aFields);
            addPrimaryKey('survey_permissions', array('sid', 'uid', 'permission'));

            upgradeSurveyPermissions145();

            // drop the old survey rights table
            $oDB->createCommand()->dropTable('{{surveys_rights}}');

            // Add new fields for email templates
            addColumn('{{surveys_languagesettings}}', 'email_admin_notification_subj', "string");
            addColumn('{{surveys_languagesettings}}', 'email_admin_responses_subj', "string");
            addColumn('{{surveys_languagesettings}}', 'email_admin_notification', "text");
            addColumn('{{surveys_languagesettings}}', 'email_admin_responses', "text");

            //Add index to questions table to speed up subquestions
            $oDB->createCommand()->createIndex('parent_qid_idx', '{{questions}}', 'parent_qid');

            addColumn('{{surveys}}', 'emailnotificationto', "text");

            upgradeSurveys145();
            dropColumn('{{surveys}}', 'notification');
            alterColumn('{{conditions}}', 'method', "string(5)", false, '');

            $oDB->createCommand()->renameColumn('{{surveys}}', 'private', 'anonymized');
            $oDB->createCommand()->update('{{surveys}}', array('anonymized' => 'N'), "anonymized is NULL");
            alterColumn('{{surveys}}', 'anonymized', "string(1)", false, 'N');

            //now we clean up things that were not properly set in previous DB upgrades
            $oDB->createCommand()->update('{{answers}}', array('answer' => ''), "answer is NULL");
            $oDB->createCommand()->update('{{assessments}}', array('scope' => ''), "scope is NULL");
            $oDB->createCommand()->update('{{assessments}}', array('name' => ''), "name is NULL");
            $oDB->createCommand()->update('{{assessments}}', array('message' => ''), "message is NULL");
            $oDB->createCommand()->update('{{assessments}}', array('minimum' => ''), "minimum is NULL");
            $oDB->createCommand()->update('{{assessments}}', array('maximum' => ''), "maximum is NULL");
            $oDB->createCommand()->update('{{groups}}', array('group_name' => ''), "group_name is NULL");
            $oDB->createCommand()->update('{{labels}}', array('code' => ''), "code is NULL");
            $oDB->createCommand()->update('{{labelsets}}', array('label_name' => ''), "label_name is NULL");
            $oDB->createCommand()->update('{{questions}}', array('type' => 'T'), "type is NULL");
            $oDB->createCommand()->update('{{questions}}', array('title' => ''), "title is NULL");
            $oDB->createCommand()->update('{{questions}}', array('question' => ''), "question is NULL");
            $oDB->createCommand()->update('{{questions}}', array('other' => 'N'), "other is NULL");

            alterColumn('{{answers}}', 'answer', "text", false);
            alterColumn('{{answers}}', 'assessment_value', 'integer', false, '0');
            alterColumn('{{assessments}}', 'scope', "string(5)", false, '');
            alterColumn('{{assessments}}', 'name', "text", false);
            alterColumn('{{assessments}}', 'message', "text", false);
            alterColumn('{{assessments}}', 'minimum', "string(50)", false, '');
            alterColumn('{{assessments}}', 'maximum', "string(50)", false, '');
            // change the primary index to include language
            if (
                Yii::app(
                )->db->driverName == 'mysql'
            ) { // special treatment for mysql because this needs to be in one step since an AUTOINC field is involved
                modifyPrimaryKey('assessments', array('id', 'language'));
            } else {
                dropPrimaryKey('assessments');
                addPrimaryKey('assessments', array('id', 'language'));
            }


            alterColumn('{{conditions}}', 'cfieldname', "string(50)", false, '');
            dropPrimaryKey('defaultvalues');
            alterColumn('{{defaultvalues}}', 'specialtype', "string(20)", false, '');
            addPrimaryKey('defaultvalues', array('qid', 'specialtype', 'language', 'scale_id', 'sqid'));

            alterColumn('{{groups}}', 'group_name', "string(100)", false, '');
            alterColumn('{{labels}}', 'code', "string(5)", false, '');
            dropPrimaryKey('labels');
            alterColumn('{{labels}}', 'language', "string(20)", false, 'en');
            addPrimaryKey('labels', array('lid', 'sortorder', 'language'));
            alterColumn('{{labelsets}}', 'label_name', "string(100)", false, '');
            alterColumn('{{questions}}', 'parent_qid', 'integer', false, '0');
            alterColumn('{{questions}}', 'title', "string(20)", false, '');
            alterColumn('{{questions}}', 'question', "text", false);
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex('questions_idx4', '{{questions}}');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }

            alterColumn('{{questions}}', 'type', "string(1)", false, 'T');
            try {
                $oDB->createCommand()->createIndex('questions_idx4', '{{questions}}', 'type');
            } catch (Exception $e) {
            };
            alterColumn('{{questions}}', 'other', "string(1)", false, 'N');
            alterColumn('{{questions}}', 'mandatory', "string(1)");
            alterColumn('{{question_attributes}}', 'attribute', "string(50)");
            alterColumn('{{quota}}', 'qlimit', 'integer');

            $oDB->createCommand()->update('{{saved_control}}', array('identifier' => ''), "identifier is NULL");
            alterColumn('{{saved_control}}', 'identifier', "text", false);
            $oDB->createCommand()->update('{{saved_control}}', array('access_code' => ''), "access_code is NULL");
            alterColumn('{{saved_control}}', 'access_code', "text", false);
            alterColumn('{{saved_control}}', 'email', "string(320)");
            $oDB->createCommand()->update('{{saved_control}}', array('ip' => ''), "ip is NULL");
            alterColumn('{{saved_control}}', 'ip', "text", false);
            $oDB->createCommand()->update('{{saved_control}}', array('saved_thisstep' => ''), "saved_thisstep is NULL");
            alterColumn('{{saved_control}}', 'saved_thisstep', "text", false);
            $oDB->createCommand()->update('{{saved_control}}', array('status' => ''), "status is NULL");
            alterColumn('{{saved_control}}', 'status', "string(1)", false, '');
            $oDB->createCommand()->update(
                '{{saved_control}}',
                array('saved_date' => '1980-01-01 00:00:00'),
                "saved_date is NULL"
            );
            alterColumn('{{saved_control}}', 'saved_date', "datetime", false);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => ''), "stg_value is NULL");
            alterColumn('{{settings_global}}', 'stg_value', "string", false, '');

            alterColumn('{{surveys}}', 'admin', "string(50)");
            $oDB->createCommand()->update('{{surveys}}', array('active' => 'N'), "active is NULL");

            alterColumn('{{surveys}}', 'active', "string(1)", false, 'N');

            alterColumn('{{surveys}}', 'startdate', "datetime");
            alterColumn('{{surveys}}', 'adminemail', "string(320)");
            alterColumn('{{surveys}}', 'anonymized', "string(1)", false, 'N');

            alterColumn('{{surveys}}', 'faxto', "string(20)");
            alterColumn('{{surveys}}', 'format', "string(1)");
            alterColumn('{{surveys}}', 'language', "string(50)");
            alterColumn('{{surveys}}', 'additional_languages', "string");
            alterColumn('{{surveys}}', 'printanswers', "string(1)", true, 'N');
            alterColumn('{{surveys}}', 'publicstatistics', "string(1)", true, 'N');
            alterColumn('{{surveys}}', 'publicgraphs', "string(1)", true, 'N');
            alterColumn('{{surveys}}', 'assessments', "string(1)", true, 'N');
            alterColumn('{{surveys}}', 'usetokens', "string(1)", true, 'N');
            alterColumn('{{surveys}}', 'bounce_email', "string(320)");
            alterColumn('{{surveys}}', 'tokenlength', 'integer', true, 15);

            $oDB->createCommand()->update(
                '{{surveys_languagesettings}}',
                array('surveyls_title' => ''),
                "surveyls_title is NULL"
            );
            alterColumn('{{surveys_languagesettings}}', 'surveyls_title', "string(200)", false);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_endtext', "text");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_url', "string");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_urldescription', "string");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_invite_subj', "string");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_remind_subj', "string");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_register_subj', "string");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_confirm_subj', "string");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_dateformat', 'integer', false, 1);

            $oDB->createCommand()->update('{{users}}', array('users_name' => ''), "users_name is NULL");
            $oDB->createCommand()->update('{{users}}', array('full_name' => ''), "full_name is NULL");
            alterColumn('{{users}}', 'users_name', "string(64)", false, '');
            alterColumn('{{users}}', 'full_name', "string(50)", false);
            alterColumn('{{users}}', 'lang', "string(20)");
            alterColumn('{{users}}', 'email', "string(320)");
            alterColumn('{{users}}', 'superadmin', 'integer', false, 0);
            alterColumn('{{users}}', 'htmleditormode', "string(7)", true, 'default');
            alterColumn('{{users}}', 'dateformat', 'integer', false, 1);
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex('email', '{{users}}');
            } catch (Exception $e) {
                // do nothing
                rollBackToTransactionBookmark();
            }

            $oDB->createCommand()->update('{{user_groups}}', array('name' => ''), "name is NULL");
            $oDB->createCommand()->update('{{user_groups}}', array('description' => ''), "description is NULL");
            alterColumn('{{user_groups}}', 'name', "string(20)", false);
            alterColumn('{{user_groups}}', 'description', "text", false);

            try {
                $oDB->createCommand()->dropIndex('user_in_groups_idx1', '{{user_in_groups}}');
            } catch (Exception $e) {
            }
            try {
                addPrimaryKey('user_in_groups', array('ugid', 'uid'));
            } catch (Exception $e) {
            }

            addColumn('{{surveys_languagesettings}}', 'surveyls_numberformat', "integer NOT NULL DEFAULT 0");

            $oDB->createCommand()->createTable(
                '{{failed_login_attempts}}',
                array(
                    'id' => "pk",
                    'ip' => 'string(37) NOT NULL',
                    'last_attempt' => 'string(20) NOT NULL',
                    'number_attempts' => "integer NOT NULL"
                )
            );
            upgradeTokens145();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 145), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 146) { //Modify surveys table
            $oTransaction = $oDB->beginTransaction();
            upgradeSurveyTimings146();
            // Fix permissions for new feature quick-translation
            try {
                setTransactionBookmark();
                $oDB->createCommand(
                    "INSERT into {{survey_permissions}} (sid,uid,permission,read_p,update_p) SELECT sid,owner_id,'translations','1','1' from {{surveys}}"
                )->execute();
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 146), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 147) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{users}}', 'templateeditormode', "string(7) NOT NULL default 'default'");
            addColumn('{{users}}', 'questionselectormode', "string(7) NOT NULL default 'default'");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 147), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 148) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{users}}', 'participant_panel', "integer NOT NULL default 0");

            $oDB->createCommand()->createTable(
                '{{participants}}',
                array(
                    'participant_id' => 'string(50) NOT NULL',
                    'firstname' => 'string(40) default NULL',
                    'lastname' => 'string(40) default NULL',
                    'email' => 'string(80) default NULL',
                    'language' => 'string(40) default NULL',
                    'blacklisted' => 'string(1) NOT NULL',
                    'owner_uid' => "integer NOT NULL"
                )
            );
            addPrimaryKey('participants', array('participant_id'));

            $oDB->createCommand()->createTable(
                '{{participant_attribute}}',
                array(
                    'participant_id' => 'string(50) NOT NULL',
                    'attribute_id' => "integer NOT NULL",
                    'value' => 'string(50) NOT NULL'
                )
            );
            addPrimaryKey('participant_attribute', array('participant_id', 'attribute_id'));

            $oDB->createCommand()->createTable(
                '{{participant_attribute_names}}',
                array(
                    'attribute_id' => 'autoincrement',
                    'attribute_type' => 'string(4) NOT NULL',
                    'visible' => 'string(5) NOT NULL',
                    'PRIMARY KEY (attribute_id,attribute_type)'
                )
            );

            $oDB->createCommand()->createTable(
                '{{participant_attribute_names_lang}}',
                array(
                    'attribute_id' => 'integer NOT NULL',
                    'attribute_name' => 'string(30) NOT NULL',
                    'lang' => 'string(20) NOT NULL'
                )
            );
            addPrimaryKey('participant_attribute_names_lang', array('attribute_id', 'lang'));

            $oDB->createCommand()->createTable(
                '{{participant_attribute_values}}',
                array(
                    'attribute_id' => 'integer NOT NULL',
                    'value_id' => 'pk',
                    'value' => 'string(20) NOT NULL'
                )
            );

            $oDB->createCommand()->createTable(
                '{{participant_shares}}',
                array(
                    'participant_id' => 'string(50) NOT NULL',
                    'share_uid' => 'integer NOT NULL',
                    'date_added' => 'datetime NOT NULL',
                    'can_edit' => 'string(5) NOT NULL'
                )
            );
            addPrimaryKey('participant_shares', array('participant_id', 'share_uid'));

            $oDB->createCommand()->createTable(
                '{{survey_links}}',
                array(
                    'participant_id' => 'string(50) NOT NULL',
                    'token_id' => 'integer NOT NULL',
                    'survey_id' => 'integer NOT NULL',
                    'date_created' => 'datetime NOT NULL'
                )
            );
            addPrimaryKey('survey_links', array('participant_id', 'token_id', 'survey_id'));
            // Add language field to question_attributes table
            addColumn('{{question_attributes}}', 'language', "string(20)");
            upgradeQuestionAttributes148();
            fixSubquestions();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 148), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 149) {
            $oTransaction = $oDB->beginTransaction();
            $aFields = array(
                'id' => 'integer',
                'sid' => 'integer',
                'parameter' => 'string(50)',
                'targetqid' => 'integer',
                'targetsqid' => 'integer'
            );
            $oDB->createCommand()->createTable('{{survey_url_parameters}}', $aFields);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 149), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 150) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{questions}}', 'relevance', 'text');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 150), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 151) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{groups}}', 'randomization_group', "string(20) NOT NULL default ''");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 151), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 152) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->createIndex('question_attributes_idx3', '{{question_attributes}}', 'attribute');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 152), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 153) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->createTable(
                '{{expression_errors}}',
                array(
                    'id' => 'pk',
                    'errortime' => 'string(50)',
                    'sid' => 'integer',
                    'gid' => 'integer',
                    'qid' => 'integer',
                    'gseq' => 'integer',
                    'qseq' => 'integer',
                    'type' => 'string(50)',
                    'eqn' => 'text',
                    'prettyprint' => 'text'
                )
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 153), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 154) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->addColumn('{{groups}}', 'grelevance', "text");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 154), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 155) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{surveys}}', 'googleanalyticsstyle', "string(1)");
            addColumn('{{surveys}}', 'googleanalyticsapikey', "string(25)");
            try {
                setTransactionBookmark();
                $oDB->createCommand()->renameColumn('{{surveys}}', 'showXquestions', 'showxquestions');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 155), "stg_name='DBVersion'");
            $oTransaction->commit();
        }


        if ($iOldDBVersion < 156) {
            $oTransaction = $oDB->beginTransaction();
            try {
                $oDB->createCommand()->dropTable('{{survey_url_parameters}}');
            } catch (Exception $e) {
                // do nothing
            }
            $oDB->createCommand()->createTable(
                '{{survey_url_parameters}}',
                array(
                    'id' => 'pk',
                    'sid' => 'integer NOT NULL',
                    'parameter' => 'string(50) NOT NULL',
                    'targetqid' => 'integer',
                    'targetsqid' => 'integer'
                )
            );

            try {
                $oDB->createCommand()->dropTable('{{sessions}}');
            } catch (Exception $e) {
                // do nothing
            }
            if (Yii::app()->db->driverName == 'mysql') {
                $oDB->createCommand()->createTable(
                    '{{sessions}}',
                    array(
                        'id' => 'string(32) NOT NULL',
                        'expire' => 'integer',
                        'data' => 'longtext'
                    )
                );
            } else {
                $oDB->createCommand()->createTable(
                    '{{sessions}}',
                    array(
                        'id' => 'string(32) NOT NULL',
                        'expire' => 'integer',
                        'data' => 'text'
                    )
                );
            }

            addPrimaryKey('sessions', array('id'));
            addColumn('{{surveys_languagesettings}}', 'surveyls_attributecaptions', "text");
            addColumn('{{surveys}}', 'sendconfirmation', "string(1) default 'Y'");

            upgradeSurveys156();

            // If a survey has an deleted owner, re-own the survey to the superadmin
            $sSurveyQuery = "SELECT sid, uid  from {{surveys}} LEFT JOIN {{users}} ON uid=owner_id WHERE uid IS null";
            $oSurveyResult = $oDB->createCommand($sSurveyQuery)->queryAll();
            foreach ($oSurveyResult as $row) {
                $oDB->createCommand("UPDATE {{surveys}} SET owner_id=1 WHERE sid={$row['sid']}")->execute();
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 156), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 157) {
            $oTransaction = $oDB->beginTransaction();
            // MySQL DB corrections
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex('questions_idx4', '{{questions}}');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }

            alterColumn('{{answers}}', 'assessment_value', 'integer', false, '0');
            dropPrimaryKey('answers');
            alterColumn('{{answers}}', 'scale_id', 'integer', false, '0');
            addPrimaryKey('answers', array('qid', 'code', 'language', 'scale_id'));
            alterColumn('{{conditions}}', 'method', "string(5)", false, '');
            alterColumn('{{participants}}', 'owner_uid', 'integer', false);
            alterColumn('{{participant_attribute_names}}', 'visible', 'string(5)', false);
            alterColumn('{{questions}}', 'type', "string(1)", false, 'T');
            alterColumn('{{questions}}', 'other', "string(1)", false, 'N');
            alterColumn('{{questions}}', 'mandatory', "string(1)");
            alterColumn('{{questions}}', 'scale_id', 'integer', false, '0');
            alterColumn('{{questions}}', 'parent_qid', 'integer', false, '0');

            alterColumn('{{questions}}', 'same_default', 'integer', false, '0');
            alterColumn('{{quota}}', 'qlimit', 'integer');
            alterColumn('{{quota}}', 'action', 'integer');
            alterColumn('{{quota}}', 'active', 'integer', false, '1');
            alterColumn('{{quota}}', 'autoload_url', 'integer', false, '0');
            alterColumn('{{saved_control}}', 'status', "string(1)", false, '');
            try {
                setTransactionBookmark();
                alterColumn('{{sessions}}', 'id', "string(32)", false);
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            alterColumn('{{surveys}}', 'active', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'anonymized', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'format', "string(1)");
            alterColumn('{{surveys}}', 'savetimings', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'datestamp', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'usecookie', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'allowregister', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'allowsave', "string(1)", false, 'Y');
            alterColumn('{{surveys}}', 'autonumber_start', 'integer', false, '0');
            alterColumn('{{surveys}}', 'autoredirect', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'allowprev', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'printanswers', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'ipaddr', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'refurl', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'publicstatistics', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'publicgraphs', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'listpublic', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'htmlemail', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'sendconfirmation', "string(1)", false, 'Y');
            alterColumn('{{surveys}}', 'tokenanswerspersistence', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'assessments', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'usecaptcha', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'usetokens', "string(1)", false, 'N');
            alterColumn('{{surveys}}', 'tokenlength', 'integer', false, '15');
            alterColumn('{{surveys}}', 'showxquestions', "string(1)", true, 'Y');
            alterColumn('{{surveys}}', 'showgroupinfo', "string(1) ", true, 'B');
            alterColumn('{{surveys}}', 'shownoanswer', "string(1) ", true, 'Y');
            alterColumn('{{surveys}}', 'showqnumcode', "string(1) ", true, 'X');
            alterColumn('{{surveys}}', 'bouncetime', 'integer');
            alterColumn('{{surveys}}', 'showwelcome', "string(1)", true, 'Y');
            alterColumn('{{surveys}}', 'showprogress', "string(1)", true, 'Y');
            alterColumn('{{surveys}}', 'allowjumps', "string(1)", true, 'N');
            alterColumn('{{surveys}}', 'navigationdelay', 'integer', false, '0');
            alterColumn('{{surveys}}', 'nokeyboard', "string(1)", true, 'N');
            alterColumn('{{surveys}}', 'alloweditaftercompletion', "string(1)", true, 'N');
            alterColumn('{{surveys}}', 'googleanalyticsstyle', "string(1)");

            alterColumn('{{surveys_languagesettings}}', 'surveyls_dateformat', 'integer', false, 1);
            try {
                setTransactionBookmark();
                alterColumn('{{survey_permissions}}', 'sid', "integer", false);
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            try {
                setTransactionBookmark();
                alterColumn('{{survey_permissions}}', 'uid', "integer", false);
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            alterColumn('{{survey_permissions}}', 'create_p', 'integer', false, '0');
            alterColumn('{{survey_permissions}}', 'read_p', 'integer', false, '0');
            alterColumn('{{survey_permissions}}', 'update_p', 'integer', false, '0');
            alterColumn('{{survey_permissions}}', 'delete_p', 'integer', false, '0');
            alterColumn('{{survey_permissions}}', 'import_p', 'integer', false, '0');
            alterColumn('{{survey_permissions}}', 'export_p', 'integer', false, '0');

            alterColumn('{{survey_url_parameters}}', 'targetqid', 'integer');
            alterColumn('{{survey_url_parameters}}', 'targetsqid', 'integer');

            alterColumn('{{templates_rights}}', 'use', 'integer', false);

            alterColumn('{{users}}', 'create_survey', 'integer', false, '0');
            alterColumn('{{users}}', 'create_user', 'integer', false, '0');
            alterColumn('{{users}}', 'participant_panel', 'integer', false, '0');
            alterColumn('{{users}}', 'delete_user', 'integer', false, '0');
            alterColumn('{{users}}', 'superadmin', 'integer', false, '0');
            alterColumn('{{users}}', 'configurator', 'integer', false, '0');
            alterColumn('{{users}}', 'manage_template', 'integer', false, '0');
            alterColumn('{{users}}', 'manage_label', 'integer', false, '0');
            alterColumn('{{users}}', 'dateformat', 'integer', false, 1);
            alterColumn('{{users}}', 'participant_panel', 'integer', false, '0');
            alterColumn('{{users}}', 'parent_id', 'integer', false);
            try {
                setTransactionBookmark();
                alterColumn('{{surveys_languagesettings}}', 'surveyls_survey_id', "integer", false);
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            alterColumn('{{user_groups}}', 'owner_id', "integer", false);
            dropPrimaryKey('user_in_groups');
            alterColumn('{{user_in_groups}}', 'ugid', "integer", false);
            alterColumn('{{user_in_groups}}', 'uid', "integer", false);

            // Additional corrections for Postgres
            try {
                setTransactionBookmark();
                $oDB->createCommand()->createIndex('questions_idx3', '{{questions}}', 'gid');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                $oDB->createCommand()->createIndex('conditions_idx3', '{{conditions}}', 'cqid');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                $oDB->createCommand()->createIndex('questions_idx4', '{{questions}}', 'type');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex('user_in_groups_idx1', '{{user_in_groups}}');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex('{{user_name_key}}', '{{users}}');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                $oDB->createCommand()->createIndex('users_name', '{{users}}', 'users_name', true);
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                addPrimaryKey('user_in_groups', array('ugid', 'uid'));
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };

            alterColumn('{{participant_attribute}}', 'value', "string(50)", false);
            try {
                setTransactionBookmark();
                alterColumn('{{participant_attribute_names}}', 'attribute_type', "string(4)", false);
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                dropColumn('{{participant_attribute_names_lang}}', 'id');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                addPrimaryKey('participant_attribute_names_lang', array('attribute_id', 'lang'));
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                $oDB->createCommand()->renameColumn('{{participant_shares}}', 'shared_uid', 'share_uid');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            alterColumn('{{participant_shares}}', 'date_added', "datetime", false);
            alterColumn('{{participants}}', 'firstname', "string(40)");
            alterColumn('{{participants}}', 'lastname', "string(40)");
            alterColumn('{{participants}}', 'email', "string(80)");
            alterColumn('{{participants}}', 'language', "string(40)");
            alterColumn('{{quota_languagesettings}}', 'quotals_name', "string");
            try {
                setTransactionBookmark();
                alterColumn('{{survey_permissions}}', 'sid', 'integer', false);
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                alterColumn('{{survey_permissions}}', 'uid', 'integer', false);
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            alterColumn('{{users}}', 'htmleditormode', "string(7)", true, 'default');

            // Sometimes the survey_links table was deleted before this step, if so
            // we recreate it (copied from line 663)
            if (!tableExists('{survey_links}')) {
                $oDB->createCommand()->createTable(
                    '{{survey_links}}',
                    array(
                        'participant_id' => 'string(50) NOT NULL',
                        'token_id' => 'integer NOT NULL',
                        'survey_id' => 'integer NOT NULL',
                        'date_created' => 'datetime NOT NULL'
                    )
                );
                addPrimaryKey('survey_links', array('participant_id', 'token_id', 'survey_id'));
            }
            alterColumn('{{survey_links}}', 'date_created', "datetime", true);
            alterColumn('{{saved_control}}', 'identifier', "text", false);
            alterColumn('{{saved_control}}', 'email', "string(320)");
            alterColumn('{{surveys}}', 'adminemail', "string(320)");
            alterColumn('{{surveys}}', 'bounce_email', "string(320)");
            alterColumn('{{users}}', 'email', "string(320)");

            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex('assessments_idx', '{{assessments}}');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                $oDB->createCommand()->createIndex('assessments_idx3', '{{assessments}}', 'gid');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };

            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex('ixcode', '{{labels}}');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex('{{labels_ixcode_idx}}', '{{labels}}');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };
            try {
                setTransactionBookmark();
                $oDB->createCommand()->createIndex('labels_code_idx', '{{labels}}', 'code');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };


            if (Yii::app()->db->driverName == 'pgsql') {
                try {
                    setTransactionBookmark();
                    $oDB->createCommand("ALTER TABLE ONLY {{user_groups}} ADD PRIMARY KEY (ugid); ")->execute;
                } catch (Exception $e) {
                    rollBackToTransactionBookmark();
                };
                try {
                    setTransactionBookmark();
                    $oDB->createCommand("ALTER TABLE ONLY {{users}} ADD PRIMARY KEY (uid); ")->execute;
                } catch (Exception $e) {
                    rollBackToTransactionBookmark();
                };
            }

            // Additional corrections for MSSQL
            alterColumn('{{answers}}', 'answer', "text", false);
            alterColumn('{{assessments}}', 'name', "text", false);
            alterColumn('{{assessments}}', 'message', "text", false);
            alterColumn('{{defaultvalues}}', 'defaultvalue', "text");
            alterColumn('{{expression_errors}}', 'eqn', "text");
            alterColumn('{{expression_errors}}', 'prettyprint', "text");
            alterColumn('{{groups}}', 'description', "text");
            alterColumn('{{groups}}', 'grelevance', "text");
            alterColumn('{{labels}}', 'title', "text");
            alterColumn('{{question_attributes}}', 'value', "text");
            alterColumn('{{questions}}', 'preg', "text");
            alterColumn('{{questions}}', 'help', "text");
            alterColumn('{{questions}}', 'relevance', "text");
            alterColumn('{{questions}}', 'question', "text", false);
            alterColumn('{{quota_languagesettings}}', 'quotals_quota_id', "integer", false);
            alterColumn('{{quota_languagesettings}}', 'quotals_message', "text", false);
            alterColumn('{{saved_control}}', 'refurl', "text");
            alterColumn('{{saved_control}}', 'access_code', "text", false);
            alterColumn('{{saved_control}}', 'ip', "text", false);
            alterColumn('{{saved_control}}', 'saved_thisstep', "text", false);
            alterColumn('{{saved_control}}', 'saved_date', "datetime", false);
            alterColumn('{{surveys}}', 'attributedescriptions', "text");
            alterColumn('{{surveys}}', 'emailresponseto', "text");
            alterColumn('{{surveys}}', 'emailnotificationto', "text");

            alterColumn('{{surveys_languagesettings}}', 'surveyls_description', "text");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_welcometext', "text");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_invite', "text");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_remind', "text");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_register', "text");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_confirm', "text");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_attributecaptions', "text");
            alterColumn('{{surveys_languagesettings}}', 'email_admin_notification', "text");
            alterColumn('{{surveys_languagesettings}}', 'email_admin_responses', "text");
            alterColumn('{{surveys_languagesettings}}', 'surveyls_endtext', "text");
            alterColumn('{{user_groups}}', 'description', "text", false);


            alterColumn('{{conditions}}', 'value', 'string', false, '');
            alterColumn('{{participant_shares}}', 'can_edit', "string(5)", false);

            alterColumn('{{users}}', 'password', "binary", false);
            dropColumn('{{users}}', 'one_time_pw');
            addColumn('{{users}}', 'one_time_pw', 'binary');


            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'random_order' and value = '2'"
            );

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 157), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 158) {
            $oTransaction = $oDB->beginTransaction();
            LimeExpressionManager::UpgradeConditionsToRelevance();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 158), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 159) {
            $oTransaction = $oDB->beginTransaction();
            alterColumn('{{failed_login_attempts}}', 'ip', "string(40)", false);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 159), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 160) {
            $oTransaction = $oDB->beginTransaction();
            alterLanguageCode('it', 'it-informal');
            alterLanguageCode('it-formal', 'it');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 160), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 161) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{survey_links}}', 'date_invited', 'datetime NULL default NULL');
            addColumn('{{survey_links}}', 'date_completed', 'datetime NULL default NULL');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 161), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 162) {
            $oTransaction = $oDB->beginTransaction();
            // Fix participant db types
            alterColumn('{{participant_attribute}}', 'value', "text", false);
            alterColumn('{{participant_attribute_names_lang}}', 'attribute_name', "string(255)", false);
            alterColumn('{{participant_attribute_values}}', 'value', "text", false);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 162), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 163) {
            // Removed because it was obsolete template changes
        }

        if ($iOldDBVersion < 164) {
            $oTransaction = $oDB->beginTransaction();
            upgradeTokens148(); // this should have bee done in 148 - that's why it is named this way
            // fix survey tables for missing or incorrect token field
            upgradeSurveyTables164();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 164), "stg_name='DBVersion'");
            $oTransaction->commit();
            // Not updating settings table as upgrade process takes care of that step now
        }

        if ($iOldDBVersion < 165) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->createTable(
                '{{plugins}}',
                array(
                    'id' => 'pk',
                    'name' => 'string NOT NULL',
                    'active' => 'boolean'
                )
            );
            $oDB->createCommand()->createTable(
                '{{plugin_settings}}',
                array(
                    'id' => 'pk',
                    'plugin_id' => 'integer NOT NULL',
                    'model' => 'string',
                    'model_id' => 'integer',
                    'key' => 'string',
                    'value' => 'text'
                )
            );
            alterColumn('{{surveys_languagesettings}}', 'surveyls_url', "text");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 165), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 166) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->renameTable('{{survey_permissions}}', '{{permissions}}');
            dropPrimaryKey('permissions');
            alterColumn('{{permissions}}', 'permission', "string(100)", false);
            $oDB->createCommand()->renameColumn('{{permissions}}', 'sid', 'entity_id');
            alterColumn('{{permissions}}', 'entity_id', "string(100)", false);
            addColumn('{{permissions}}', 'entity', "string(50)");
            $oDB->createCommand("update {{permissions}} set entity='survey'")->query();
            addColumn('{{permissions}}', 'id', 'pk');
            try {
                setTransactionBookmark();
                $oDB->createCommand()->createIndex(
                    'idxPermissions',
                    '{{permissions}}',
                    'entity_id,entity,permission,uid',
                    true
                );
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            upgradePermissions166();
            dropColumn('{{users}}', 'create_survey');
            dropColumn('{{users}}', 'create_user');
            dropColumn('{{users}}', 'delete_user');
            dropColumn('{{users}}', 'superadmin');
            dropColumn('{{users}}', 'configurator');
            dropColumn('{{users}}', 'manage_template');
            dropColumn('{{users}}', 'manage_label');
            dropColumn('{{users}}', 'participant_panel');
            $oDB->createCommand()->dropTable('{{templates_rights}}');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 166), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 167) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{surveys_languagesettings}}', 'attachments', 'text');
            addColumn('{{users}}', 'created', 'datetime');
            addColumn('{{users}}', 'modified', 'datetime');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 167), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 168) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{participants}}', 'created', 'datetime');
            addColumn('{{participants}}', 'modified', 'datetime');
            addColumn('{{participants}}', 'created_by', 'integer');
            $oDB->createCommand('update {{participants}} set created_by=owner_uid')->query();
            alterColumn('{{participants}}', 'created_by', "integer", false);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 168), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 169) {
            $oTransaction = $oDB->beginTransaction();
            // Add new column for question index options.
            addColumn('{{surveys}}', 'questionindex', 'integer not null default 0');
            // Set values for existing surveys.
            $oDB->createCommand("update {{surveys}} set questionindex = 0 where allowjumps <> 'Y'")->query();
            $oDB->createCommand("update {{surveys}} set questionindex = 1 where allowjumps = 'Y'")->query();

            // Remove old column.
            dropColumn('{{surveys}}', 'allowjumps');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 169), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 170) {
            $oTransaction = $oDB->beginTransaction();
            // renamed advanced attributes fields dropdown_dates_year_min/max
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('attribute' => 'date_min'),
                "attribute='dropdown_dates_year_min'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('attribute' => 'date_max'),
                "attribute='dropdown_dates_year_max'"
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 170), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 171) {
            $oTransaction = $oDB->beginTransaction();
            try {
                dropColumn('{{sessions}}', 'data');
            } catch (Exception $e) {
            }
            switch (Yii::app()->db->driverName) {
                case 'mysql':
                    addColumn('{{sessions}}', 'data', 'longbinary');
                    break;
                case 'sqlsrv':
                case 'dblib':
                case 'mssql':
                    addColumn('{{sessions}}', 'data', 'VARBINARY(MAX)');
                    break;
                case 'pgsql':
                    addColumn('{{sessions}}', 'data', 'BYTEA');
                    break;
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 171), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 172) {
            $oTransaction = $oDB->beginTransaction();
            switch (Yii::app()->db->driverName) {
                case 'pgsql':
                    // Special treatment for Postgres as it is too dumb to convert a string to a number without explicit being told to do so ... seriously?
                    alterColumn('{{permissions}}', 'entity_id', "INTEGER USING (entity_id::integer)", false);
                    break;
                case 'sqlsrv':
                case 'dblib':
                case 'mssql':
                    try {
                        setTransactionBookmark();
                        $oDB->createCommand()->dropIndex('permissions_idx2', '{{permissions}}');
                    } catch (Exception $e) {
                        rollBackToTransactionBookmark();
                    };
                    try {
                        setTransactionBookmark();
                        $oDB->createCommand()->dropIndex('idxPermissions', '{{permissions}}');
                    } catch (Exception $e) {
                        rollBackToTransactionBookmark();
                    };
                    alterColumn('{{permissions}}', 'entity_id', "INTEGER", false);
                    $oDB->createCommand()->createIndex(
                        'permissions_idx2',
                        '{{permissions}}',
                        'entity_id,entity,permission,uid',
                        true
                    );
                    break;
                default:
                    alterColumn('{{permissions}}', 'entity_id', "INTEGER", false);
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 172), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 173) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{participant_attribute_names}}', 'defaultname', "string(50) NOT NULL default ''");
            upgradeCPDBAttributeDefaultNames173();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 173), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 174) {
            $oTransaction = $oDB->beginTransaction();
            alterColumn('{{participants}}', 'email', "string(254)");
            alterColumn('{{saved_control}}', 'email', "string(254)");
            alterColumn('{{surveys}}', 'adminemail', "string(254)");
            alterColumn('{{surveys}}', 'bounce_email', "string(254)");
            switch (Yii::app()->db->driverName) {
                case 'sqlsrv':
                case 'dblib':
                case 'mssql':
                    dropUniqueKeyMSSQL('email', '{{users}}');
            }
            alterColumn('{{users}}', 'email', "string(254)");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 174), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 175) {
            $oTransaction = $oDB->beginTransaction();
            switch (Yii::app()->db->driverName) {
                case 'pgsql':
                    // Special treatment for Postgres as it is too dumb to convert a boolean to a number without explicit being told to do so
                    alterColumn('{{plugins}}', 'active', "INTEGER USING (active::integer)", false);
                    break;
                default:
                    alterColumn('{{plugins}}', 'active', "integer", false, '0');
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 175), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 176) {
            $oTransaction = $oDB->beginTransaction();
            upgradeTokens176();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 176), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 177) {
            $oTransaction = $oDB->beginTransaction();
            if (Yii::app()->getConfig('auth_webserver') === true) {
                // using auth webserver, now activate the plugin with default settings.
                if (!class_exists('Authwebserver', false)) {
                    $plugin = Plugin::model()->findByAttributes(array('name' => 'Authwebserver'));
                    if (!$plugin) {
                        $plugin = new Plugin();
                        $plugin->name = 'Authwebserver';
                        $plugin->active = 1;
                        $plugin->save();
                        $plugin = App()->getPluginManager()->loadPlugin('Authwebserver', $plugin->id);
                        $aPluginSettings = $plugin->getPluginSettings(true);
                        $aDefaultSettings = array();
                        foreach ($aPluginSettings as $key => $settings) {
                            if (is_array($settings) && array_key_exists('current', $settings)) {
                                $aDefaultSettings[$key] = $settings['current'];
                            }
                        }
                        $plugin->saveSettings($aDefaultSettings);
                    } else {
                        $plugin->active = 1;
                        $plugin->save();
                    }
                }
            }
            upgradeSurveys177();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 177), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 178) {
            $oTransaction = $oDB->beginTransaction();
            if (Yii::app()->db->driverName == 'mysql') {
                modifyPrimaryKey('questions', array('qid', 'language'));
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 178), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 179) {
            $oTransaction = $oDB->beginTransaction();
            upgradeSurveys177(); // Needs to be run again to make sure
            upgradeTokenTables179();
            alterColumn('{{participants}}', 'email', "string(254)", false);
            alterColumn('{{participants}}', 'firstname', "string(150)", false);
            alterColumn('{{participants}}', 'lastname', "string(150)", false);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 179), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 180) {
            $oTransaction = $oDB->beginTransaction();
            $aUsers = User::model()->findAll();
            $aPerm = array(
                'entity_id' => 0,
                'entity' => 'global',
                'uid' => 0,
                'permission' => 'auth_db',
                'create_p' => 0,
                'read_p' => 1,
                'update_p' => 0,
                'delete_p' => 0,
                'import_p' => 0,
                'export_p' => 0
            );

            foreach ($aUsers as $oUser) {
                $permissionExists = $oDB->createCommand()->select('id')->from("{{permissions}}")->where(
                    "(permission='auth_db' OR permission='superadmin') and read_p=1 and entity='global' and uid=:uid",
                    [':uid' => $oUser->uid]
                )->queryScalar();
                if ($permissionExists == false) {
                    $newPermission = $aPerm;
                    $newPermission['uid'] = $oUser->uid;
                    $oDB->createCommand()->insert("{{permissions}}", $newPermission);
                }
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 180), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 181) {
            $oTransaction = $oDB->beginTransaction();
            upgradeTokenTables181('utf8_bin');
            upgradeSurveyTables181('utf8_bin');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 181), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 183) {
            $oTransaction = $oDB->beginTransaction();
            upgradeSurveyTables183();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 183), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 184) {
            $oTransaction = $oDB->beginTransaction();
            fixKCFinder184();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 184), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        // LS 2.5 table start at 250
        if ($iOldDBVersion < 250) {
            $oTransaction = $oDB->beginTransaction();
            createBoxes250();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 250), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 251) {
            $oTransaction = $oDB->beginTransaction();
            upgradeBoxesTable251();

            // Update DBVersion
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 251), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 252) {
            $oTransaction = $oDB->beginTransaction();
            Yii::app()->db->createCommand()->addColumn('{{questions}}', 'modulename', 'string');
            // Update DBVersion
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 252), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 253) {
            $oTransaction = $oDB->beginTransaction();
            upgradeSurveyTables253();

            // Update DBVersion
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 253), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 254) {
            $oTransaction = $oDB->beginTransaction();
            upgradeSurveyTables254();
            // Update DBVersion
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 254), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 255) {
            $oTransaction = $oDB->beginTransaction();
            upgradeSurveyTables255();
            // Update DBVersion
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 255), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 256) {
            $oTransaction = $oDB->beginTransaction();
            upgradeTokenTables256();
            alterColumn('{{participants}}', 'email', "text", false);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 256), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 257) {
            $oTransaction = $oDB->beginTransaction();
            switch (Yii::app()->db->driverName) {
                case 'pgsql':
                    $sSubstringCommand = 'substr';
                    break;
                default:
                    $sSubstringCommand = 'substring';
            }
            $oDB->createCommand("UPDATE {{templates}} set folder={$sSubstringCommand}(folder,1,50)")->execute();
            try {
                dropPrimaryKey('templates');
            } catch (Exception $e) {
            };
            alterColumn('{{templates}}', 'folder', "string(50)", false);
            addPrimaryKey('templates', 'folder');
            dropPrimaryKey('participant_attribute_names_lang');
            alterColumn('{{participant_attribute_names_lang}}', 'lang', "string(20)", false);
            addPrimaryKey('participant_attribute_names_lang', array('attribute_id', 'lang'));
            //Fixes the collation for the complete DB, tables and columns
            if (Yii::app()->db->driverName == 'mysql') {
                fixMySQLCollations('utf8mb4', 'utf8mb4_unicode_ci');
                // Also apply again fixes from DBVersion 181 again for case sensitive token fields
                upgradeSurveyTables181('utf8mb4_bin');
                upgradeTokenTables181('utf8mb4_bin');
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 257), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Remove adminimageurl from global settings
         */
        if ($iOldDBVersion < 258) {
            $oTransaction = $oDB->beginTransaction();
            Yii::app()->getDb()->createCommand(
                "DELETE FROM {{settings_global}} WHERE stg_name='adminimageurl'"
            )->execute();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 258), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Add table for notifications
         * @since 2016-08-04
         * @author LimeSurvey GmbH
         */
        if ($iOldDBVersion < 259) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->createTable(
                '{{notifications}}',
                array(
                    'id' => 'pk',
                    'entity' => 'string(15) not null',
                    'entity_id' => 'integer not null',
                    'title' => 'string not null', // varchar(255) in postgres
                    'message' => 'text not null',
                    'status' => "string(15) not null default 'new' ",
                    'importance' => 'integer not null default 1',
                    'display_class' => "string(31) default 'default'",
                    'created' => 'datetime',
                    'first_read' => 'datetime'
                )
            );
            $oDB->createCommand()->createIndex(
                '{{notif_index}}',
                '{{notifications}}',
                'entity, entity_id, status',
                false
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 259), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 260) {
            $oTransaction = $oDB->beginTransaction();
            alterColumn('{{participant_attribute_names}}', 'defaultname', "string(255)", false);
            alterColumn('{{participant_attribute_names_lang}}', 'attribute_name', "string(255)", false);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 260), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 261) {
            $oTransaction = $oDB->beginTransaction();
            /*
            * The hash value of a notification is used to calculate uniqueness.
            * @since 2016-08-10
            * @author LimeSurvey GmbH
            */
            addColumn('{{notifications}}', 'hash', 'string(64)');
            $oDB->createCommand()->createIndex('{{notif_hash_index}}', '{{notifications}}', 'hash', false);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 261), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 262) {
            $oTransaction = $oDB->beginTransaction();
            alterColumn('{{settings_global}}', 'stg_value', "text", false);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 262), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 263) {
            $oTransaction = $oDB->beginTransaction();
            // Dummy version update for hash column in installation SQL.
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 263), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Add seed column in all active survey tables
         * Might take time to execute
         * @since 2016-09-01
         */
        if ($iOldDBVersion < 290) {
            $oTransaction = $oDB->beginTransaction();
            $aTables = dbGetTablesLike("survey\_%");
            $oSchema = Yii::app()->db->schema;
            foreach ($aTables as $sTableName) {
                $oTableSchema = $oSchema->getTable($sTableName);
                // Only update the table if it really is a survey response table - there are other tables that start the same
                if (!in_array('lastpage', $oTableSchema->columnNames)) {
                    continue;
                }
                //If seed already exists, due to whatsoever
                if (in_array('seed', $oTableSchema->columnNames)) {
                    continue;
                }
                removeMysqlZeroDate($sTableName, $oTableSchema, $oDB);
                // If survey has active table, create seed column
                Yii::app()->db->createCommand()->addColumn($sTableName, 'seed', 'string(31)');

                // RAND is RANDOM in Postgres
                switch (Yii::app()->db->driverName) {
                    case 'pgsql':
                        Yii::app()->db->createCommand(
                            "UPDATE {$sTableName} SET seed = ROUND(RANDOM() * 10000000)"
                        )->execute();
                        break;
                    default:
                        Yii::app()->db->createCommand(
                            "UPDATE {$sTableName} SET seed = ROUND(RAND() * 10000000, 0)"
                        )->execute();
                        break;
                }
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 290), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Plugin JSON config file
         * @since 2016-08-22
         */
        if ($iOldDBVersion < 291) {
            $oTransaction = $oDB->beginTransaction();

            addColumn('{{plugins}}', 'version', 'string(32)');

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 291), "stg_name='DBVersion'");
            $oTransaction->commit();
        }


        /**
         * Survey menue table
         * @since 2017-07-03
         */
        if ($iOldDBVersion < 293) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 293), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Survey menue table update
         * @since 2017-07-03
         */
        if ($iOldDBVersion < 294) {
            $oTransaction = $oDB->beginTransaction();


            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 294), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Survey menue table update
         * @since 2017-07-12
         */
        if ($iOldDBVersion < 296) {
            $oTransaction = $oDB->beginTransaction();


            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 296), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Template tables
         * @since 2017-07-12
         */
        if ($iOldDBVersion < 298) {
            $oTransaction = $oDB->beginTransaction();
            upgradeTemplateTables298($oDB);
            $oTransaction->commit();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 298), "stg_name='DBVersion'");
        }

        /**
         * Template tables
         * @since 2017-07-12
         */
        if ($iOldDBVersion < 304) {
            $oTransaction = $oDB->beginTransaction();
            upgradeTemplateTables304($oDB);
            $oTransaction->commit();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 304), "stg_name='DBVersion'");
        }

        /**
         * Update to sidemenu rendering
         */
        if ($iOldDBVersion < 305) {
            $oTransaction = $oDB->beginTransaction();
            $oTransaction->commit();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 305), "stg_name='DBVersion'");
        }

        /**
         * Template tables
         * @since 2017-07-12
         */
        if ($iOldDBVersion < 306) {
            $oTransaction = $oDB->beginTransaction();
            createSurveyGroupTables306($oDB);
            $oTransaction->commit();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 306), "stg_name='DBVersion'");
        }

        /**
         * User settings table
         * @since 2016-08-29
         */
        if ($iOldDBVersion < 307) {
            $oTransaction = $oDB->beginTransaction();
            if (tableExists('{settings_user}')) {
                $oDB->createCommand()->dropTable('{{settings_user}}');
            }
            $oDB->createCommand()->createTable(
                '{{settings_user}}',
                array(
                    'id' => 'pk',
                    'uid' => 'integer NOT NULL',
                    'entity' => 'string(15)',
                    'entity_id' => 'string(31)',
                    'stg_name' => 'string(63) not null',
                    'stg_value' => 'text',

                )
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 307), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /*
        * Change dbfieldnames to be more functional
        */
        if ($iOldDBVersion < 308) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 308), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        /*
        * Add survey template editing to menu
        */
        if ($iOldDBVersion < 309) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 309), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /*
        * Reset all surveymenu tables, because there were too many errors
        */
        if ($iOldDBVersion < 310) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 310), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /*
        * Add template settings to survey groups
        */
        if ($iOldDBVersion < 311) {
            $oTransaction = $oDB->beginTransaction();
            addColumn('{{surveys_groups}}', 'template', "string(128) DEFAULT 'default'");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 311), "stg_name='DBVersion'");
            $oTransaction->commit();
        }


        /*
        * Add ltr/rtl capability to template configuration
        */
        if ($iOldDBVersion < 312) {
            $oTransaction = $oDB->beginTransaction();
            // Already added in beta 2 but with wrong type
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropColumn('{{template_configuration}}', 'packages_ltr');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropColumn('{{template_configuration}}', 'packages_rtl');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }

            addColumn('{{template_configuration}}', 'packages_ltr', "text");
            addColumn('{{template_configuration}}', 'packages_rtl', "text");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 312), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /*
        * Add ltr/rtl capability to template configuration
        */
        if ($iOldDBVersion < 313) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 313), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /*
        * Add ltr/rtl capability to template configuration
        */
        if ($iOldDBVersion < 314) {
            $oTransaction = $oDB->beginTransaction();


            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 314), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 315) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update(
                '{{template_configuration}}',
                array('packages_to_load' => '["pjax"]'),
                "templates_name='default' OR templates_name='material'"
            );

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 315), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 316) {
            $oTransaction = $oDB->beginTransaction();

            //$oDB->createCommand()->renameColumn('{{template_configuration}}', 'templates_name', 'template_name');

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 316), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        //Transition of the password field to a TEXT type

        if ($iOldDBVersion < 317) {
            $oTransaction = $oDB->beginTransaction();

            transferPasswordFieldToText($oDB);

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 317), "stg_name='DBVersion'");
            $oTransaction->commit();
        }


        //Rename order to sortorder

        if ($iOldDBVersion < 318) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 318), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        //force panelintegration to a full reload

        if ($iOldDBVersion < 319) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 319), "stg_name='DBVersion'");

            $table = Yii::app()->db->schema->getTable('{{surveys_groups}}');
            if (isset($table->columns['order'])) {
                $oDB->createCommand()->renameColumn('{{surveys_groups}}', 'order', 'sortorder');
            }

            $table = Yii::app()->db->schema->getTable('{{templates}}');
            if (isset($table->columns['extends_template_name'])) {
                $oDB->createCommand()->renameColumn('{{templates}}', 'extends_template_name', 'extends');
            }

            $oTransaction->commit();
        }

        if ($iOldDBVersion < 320) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 320), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 321) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 321), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 322) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->createTable(
                '{{tutorials}}',
                [
                    'tid' => 'pk',
                    'name' => 'string(128)',
                    'description' => 'text',
                    'active' => 'integer DEFAULT 0',
                    'settings' => 'text',
                    'permission' => 'string(128) NOT NULL',
                    'permission_grade' => 'string(128) NOT NULL'
                ]
            );
            $oDB->createCommand()->createTable(
                '{{tutorial_entries}}',
                [
                    'teid' => 'pk',
                    'tid' => 'integer NOT NULL',
                    'title' => 'text',
                    'content' => 'text',
                    'settings' => 'text'
                ]
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 322), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 323) {
            $oTransaction = $oDB->beginTransaction();
            dropPrimaryKey('labels', 'lid');
            $oDB->createCommand()->addColumn('{{labels}}', 'id', 'pk');
            $oDB->createCommand()->createIndex(
                '{{idx4_labels}}',
                '{{labels}}',
                ['lid', 'sortorder', 'language'],
                false
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 323), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 324) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 324), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 325) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->dropTable('{{templates}}');
            $oDB->createCommand()->dropTable('{{template_configuration}}');

            // templates
            $oDB->createCommand()->createTable(
                '{{templates}}',
                array(
                    'id' => "pk",
                    'name' => "string(150) NOT NULL",
                    'folder' => "string(45) NULL",
                    'title' => "string(100) NOT NULL",
                    'creation_date' => "datetime NULL",
                    'author' => "string(150) NULL",
                    'author_email' => "string(255) NULL",
                    'author_url' => "string(255) NULL",
                    'copyright' => "text ",
                    'license' => "text ",
                    'version' => "string(45) NULL",
                    'api_version' => "string(45) NOT NULL",
                    'view_folder' => "string(45) NOT NULL",
                    'files_folder' => "string(45) NOT NULL",
                    'description' => "text ",
                    'last_update' => "datetime NULL",
                    'owner_id' => "integer NULL",
                    'extends' => "string(150)  NULL",
                )
            );

            $oDB->createCommand()->createIndex('{{idx1_templates}}', '{{templates}}', 'name', false);
            $oDB->createCommand()->createIndex('{{idx2_templates}}', '{{templates}}', 'title', false);
            $oDB->createCommand()->createIndex('{{idx3_templates}}', '{{templates}}', 'owner_id', false);
            $oDB->createCommand()->createIndex('{{idx4_templates}}', '{{templates}}', 'extends', false);

            $headerArray = [
                'name',
                'folder',
                'title',
                'creation_date',
                'author',
                'author_email',
                'author_url',
                'copyright',
                'license',
                'version',
                'api_version',
                'view_folder',
                'files_folder',
                'description',
                'last_update',
                'owner_id',
                'extends'
            ];
            $oDB->createCommand()->insert(
                "{{templates}}",
                array_combine(
                    $headerArray,
                    [
                        'default',
                        'default',
                        'Advanced Template',
                        date('Y-m-d H:i:s'),
                        'LimeSurvey GmbH',
                        'info@limesurvey.org',
                        'https://www.limesurvey.org/',
                        'Copyright (C) 2007-2017 The LimeSurvey Project Team\\r\\nAll rights reserved.',
                        'License: GNU/GPL License v2 or later, see LICENSE.php\\r\\n\\r\\nLimeSurvey is free software. This version may have been modified pursuant to the GNU General Public License, and as distributed it includes or is derivative of works licensed under the GNU General Public License or other free or open source software licenses. See COPYRIGHT.php for copyright notices and details.',
                        '1.0',
                        '3.0',
                        'views',
                        'files',
                        "<strong>LimeSurvey Advanced Template</strong><br>A template with custom options to show what it's possible to do with the new engines. Each template provider will be able to offer its own option page (loaded from template)",
                        null,
                        1,
                        ''
                    ]
                )
            );

            $oDB->createCommand()->insert(
                "{{templates}}",
                array_combine(
                    $headerArray,
                    [
                        'material',
                        'material',
                        'Material Template',
                        date('Y-m-d H:i:s'),
                        'LimeSurvey GmbH',
                        'info@limesurvey.org',
                        'https://www.limesurvey.org/',
                        'Copyright (C) 2007-2017 The LimeSurvey Project Team\\r\\nAll rights reserved.',
                        'License: GNU/GPL License v2 or later, see LICENSE.php\\r\\n\\r\\nLimeSurvey is free software. This version may have been modified pursuant to the GNU General Public License, and as distributed it includes or is derivative of works licensed under the GNU General Public License or other free or open source software licenses. See COPYRIGHT.php for copyright notices and details.',
                        '1.0',
                        '3.0',
                        'views',
                        'files',
                        '<strong>LimeSurvey Advanced Template</strong><br> A template extending default, to show the inheritance concept. Notice the options, differents from Default.<br><small>uses FezVrasta\'s Material design theme for Bootstrap 3</small>',
                        null,
                        1,
                        'default'
                    ]
                )
            );

            $oDB->createCommand()->insert(
                "{{templates}}",
                array_combine(
                    $headerArray,
                    [
                        'monochrome',
                        'monochrome',
                        'Monochrome Templates',
                        date('Y-m-d H:i:s'),
                        'LimeSurvey GmbH',
                        'info@limesurvey.org',
                        'https://www.limesurvey.org/',
                        'Copyright (C) 2007-2017 The LimeSurvey Project Team\\r\\nAll rights reserved.',
                        'License: GNU/GPL License v2 or later, see LICENSE.php\\r\\n\\r\\nLimeSurvey is free software. This version may have been modified pursuant to the GNU General Public License, and as distributed it includes or is derivative of works licensed under the GNU General Public License or other free or open source software licenses. See COPYRIGHT.php for copyright notices and details.',
                        '1.0',
                        '3.0',
                        'views',
                        'files',
                        '<strong>LimeSurvey Monochrome Templates</strong><br>A template with monochrome colors for easy customization.',
                        null,
                        1,
                        ''
                    ]
                )
            );


            // template_configuration
            $oDB->createCommand()->createTable(
                '{{template_configuration}}',
                array(
                    'id' => "pk",
                    'template_name' => "string(150)  NOT NULL",
                    'sid' => "integer NULL",
                    'gsid' => "integer NULL",
                    'uid' => "integer NULL",
                    'files_css' => "text",
                    'files_js' => "text",
                    'files_print_css' => "text",
                    'options' => "text ",
                    'cssframework_name' => "string(45) NULL",
                    'cssframework_css' => "text",
                    'cssframework_js' => "text",
                    'packages_to_load' => "text",
                    'packages_ltr' => "text",
                    'packages_rtl' => "text",
                )
            );

            $oDB->createCommand()->createIndex(
                '{{idx1_template_configuration}}',
                '{{template_configuration}}',
                'template_name',
                false
            );
            $oDB->createCommand()->createIndex(
                '{{idx2_template_configuration}}',
                '{{template_configuration}}',
                'sid',
                false
            );
            $oDB->createCommand()->createIndex(
                '{{idx3_template_configuration}}',
                '{{template_configuration}}',
                'gsid',
                false
            );
            $oDB->createCommand()->createIndex(
                '{{idx4_template_configuration}}',
                '{{template_configuration}}',
                'uid',
                false
            );

            $headerArray = [
                'template_name',
                'sid',
                'gsid',
                'uid',
                'files_css',
                'files_js',
                'files_print_css',
                'options',
                'cssframework_name',
                'cssframework_css',
                'cssframework_js',
                'packages_to_load',
                'packages_ltr',
                'packages_rtl'
            ];
            $oDB->createCommand()->insert(
                "{{template_configuration}}",
                array_combine(
                    $headerArray,
                    [
                        'default',
                        null,
                        null,
                        null,
                        '{"add": ["css/animate.css","css/template.css"]}',
                        '{"add": ["scripts/template.js", "scripts/ajaxify.js"]}',
                        '{"add":"css/print_template.css"}',
                        '{"ajaxmode":"off","brandlogo":"on", "brandlogofile": "./files/logo.png", "boxcontainer":"on", "backgroundimage":"off","animatebody":"off","bodyanimation":"fadeInRight","animatequestion":"off","questionanimation":"flipInX","animatealert":"off","alertanimation":"shake"}',
                        'bootstrap',
                        '{"replace": [["css/bootstrap.css","css/flatly.css"]]}',
                        '',
                        '["pjax"]',
                        '',
                        ''
                    ]
                )
            );

            $oDB->createCommand()->insert(
                "{{template_configuration}}",
                array_combine(
                    $headerArray,
                    [
                        'material',
                        null,
                        null,
                        null,
                        '{"add": ["css/bootstrap-material-design.css", "css/ripples.min.css", "css/template.css"]}',
                        '{"add": ["scripts/template.js", "scripts/material.js", "scripts/ripples.min.js", "scripts/ajaxify.js"]}',
                        '{"add":"css/print_template.css"}',
                        '{"ajaxmode":"off","brandlogo":"on", "brandlogofile": "./files/logo.png", "animatebody":"off","bodyanimation":"fadeInRight","animatequestion":"off","questionanimation":"flipInX","animatealert":"off","alertanimation":"shake"}',
                        'bootstrap',
                        '{"replace": [["css/bootstrap.css","css/bootstrap.css"]]}',
                        '',
                        '["pjax"]',
                        '',
                        ''
                    ]
                )
            );

            $oDB->createCommand()->insert(
                "{{template_configuration}}",
                array_combine(
                    $headerArray,
                    [
                        'monochrome',
                        null,
                        null,
                        null,
                        '{"add":["css/animate.css","css/ajaxify.css","css/sea_green.css", "css/template.css"]}',
                        '{"add":["scripts/template.js","scripts/ajaxify.js"]}',
                        '{"add":"css/print_template.css"}',
                        '{"ajaxmode":"off","brandlogo":"on","brandlogofile":".\/files\/logo.png","boxcontainer":"on","backgroundimage":"off","animatebody":"off","bodyanimation":"fadeInRight","animatequestion":"off","questionanimation":"flipInX","animatealert":"off","alertanimation":"shake"}',
                        'bootstrap',
                        '{}',
                        '',
                        '["pjax"]',
                        '',
                        ''
                    ]
                )
            );

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 325), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 326) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->alterColumn('{{surveys}}', 'datecreated', 'datetime');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 326), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 327) {
            $oTransaction = $oDB->beginTransaction();
            upgrade327($oDB);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 327), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 328) {
            $oTransaction = $oDB->beginTransaction();
            upgrade328($oDB);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 328), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 329) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 329), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 330) {
            $oTransaction = $oDB->beginTransaction();
            upgrade330($oDB);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 330), "stg_name='DBVersion'");
            $oTransaction->commit();
        }


        if ($iOldDBVersion < 331) {
            $oTransaction = $oDB->beginTransaction();
            upgrade331($oDB);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 331), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 332) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 332), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 333) {
            $oTransaction = $oDB->beginTransaction();
            upgrade333($oDB);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 333), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 334) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->addColumn('{{tutorials}}', 'title', 'string(192)');
            $oDB->createCommand()->addColumn('{{tutorials}}', 'icon', 'string(64)');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 334), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 335) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 335), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 336) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 336), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 337) {
            $oTransaction = $oDB->beginTransaction();
            resetTutorials337($oDB);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 337), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 338) {
            $oTransaction = $oDB->beginTransaction();
            $rowToRemove = $oDB->createCommand()->select("position, id")->from("{{boxes}}")->where(
                'ico=:ico',
                [':ico' => 'templates']
            )->queryRow();
            $position = 6;
            if ($rowToRemove !== false) {
                $oDB->createCommand()->delete("{{boxes}}", 'id=:id', [':id' => $rowToRemove['id']]);
                $position = $rowToRemove['position'];
            }
            $oDB->createCommand()->insert(
                "{{boxes}}",
                [
                    'position' => $position,
                    'url' => 'admin/themeoptions',
                    'title' => 'Themes',
                    'ico' => 'templates',
                    'desc' => 'Themes',
                    'page' => 'welcome',
                    'usergroup' => '-2'
                ]
            );

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 338), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 339) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 339), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Rename 'First start tour' to 'Take beginner tour'.
         */
        if ($iOldDBVersion < 340) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 340), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Recreate basic tour again from DefaultDataSet
         */
        if ($iOldDBVersion < 341) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->truncateTable('{{tutorials}}');
            $oDB->createCommand()->truncateTable('{{tutorial_entries}}');
            $oDB->createCommand()->truncateTable('{{tutorial_entry_relation}}');


            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 341), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        /**
         * Url parameter "surveyid" should be "sid" for this link.
         */
        if ($iOldDBVersion < 342) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 342), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Column assessment_value not null but default to 0.
         */
        if ($iOldDBVersion < 343) {
            $oTransaction = $oDB->beginTransaction();
            alterColumn('{{answers}}', 'assessment_value', 'integer', false, '0');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 343), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Fix missing database values for templates after updating
         * from 2.7x.
         */
        if ($iOldDBVersion < 344) {
            $oTransaction = $oDB->beginTransaction();

            // All templates should inherit from vanilla as default (if extends is empty).
            $oDB->createCommand()->update(
                '{{templates}}',
                [
                    'extends' => 'vanilla',
                ],
                "extends = '' AND name != 'vanilla'"
            );

            // If vanilla template is missing, install it.
            $vanilla = $oDB
                ->createCommand()
                ->select('*')
                ->from('{{templates}}')
                ->where('name=:name', ['name' => 'vanilla'])
                ->queryRow();
            if (empty($vanilla)) {
                $vanillaData = [
                    'name' => 'vanilla',
                    'folder' => 'vanilla',
                    'title' => 'Vanilla Theme',
                    'creation_date' => date('Y-m-d H:i:s'),
                    'author' => 'LimeSurvey GmbH',
                    'author_email' => 'info@limesurvey.org',
                    'author_url' => 'https://www.limesurvey.org/',
                    'copyright' => 'Copyright (C) 2007-2017 The LimeSurvey Project Team\\r\\nAll rights reserved.',
                    'license' => 'License: GNU/GPL License v2 or later, see LICENSE.php\\r\\n\\r\\nLimeSurvey is free software. This version may have been modified pursuant to the GNU General Public License, and as distributed it includes or is derivative of works licensed under the GNU General Public License or other free or open source software licenses. See COPYRIGHT.php for copyright notices and details.',
                    'version' => '3.0',
                    'api_version' => '3.0',
                    'view_folder' => 'views',
                    'files_folder' => 'files',
                    'description' => '<strong>LimeSurvey Bootstrap Vanilla Survey Theme</strong><br>A clean and simple base that can be used by developers to create their own Bootstrap based theme.',
                    'last_update' => null,
                    'owner_id' => 1,
                    'extends' => '',
                ];
                $oDB->createCommand()->insert('{{templates}}', $vanillaData);
            }
            $vanillaConf = $oDB
                ->createCommand()
                ->select('*')
                ->from('{{template_configuration}}')
                ->where('template_name=:template_name', ['template_name' => 'vanilla'])
                ->queryRow();
            if (empty($vanillaConf)) {
                $vanillaConfData = [
                    'template_name' => 'vanilla',
                    'sid' => null,
                    'gsid' => null,
                    'uid' => null,
                    'files_css' => '{"add":["css/ajaxify.css","css/theme.css","css/custom.css"]}',
                    'files_js' => '{"add":["scripts/theme.js","scripts/ajaxify.js","scripts/custom.js"]}',
                    'files_print_css' => '{"add":["css/print_theme.css"]}',
                    'options' => '{"ajaxmode":"off","brandlogo":"on","container":"on","brandlogofile":"./files/logo.png","font":"noto"}',
                    'cssframework_name' => 'bootstrap',
                    'cssframework_css' => '{}',
                    'cssframework_js' => '',
                    'packages_to_load' => '{"add":["pjax","font-noto"]}',
                    'packages_ltr' => null,
                    'packages_rtl' => null
                ];
                $oDB->createCommand()->insert('{{template_configuration}}', $vanillaConfData);
            }

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 344], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Fruit template configuration might be faulty when updating
         * from 2.7x, as well as bootswatch.
         */
        if ($iOldDBVersion < 345) {
            $oTransaction = $oDB->beginTransaction();
            $fruityConf = $oDB
                ->createCommand()
                ->select('*')
                ->from('{{template_configuration}}')
                ->where('template_name=:template_name', ['template_name' => 'fruity'])
                ->queryRow();
            if ($fruityConf) {
                // Brute force way. Just have to hope noone changed the default
                // config yet.
                $oDB->createCommand()->update(
                    '{{template_configuration}}',
                    [
                        'files_css' => '{"add":["css/ajaxify.css","css/animate.css","css/variations/sea_green.css","css/theme.css","css/custom.css"]}',
                        'files_js' => '{"add":["scripts/theme.js","scripts/ajaxify.js","scripts/custom.js"]}',
                        'files_print_css' => '{"add":["css/print_theme.css"]}',
                        'options' => '{"ajaxmode":"off","brandlogo":"on","brandlogofile":"./files/logo.png","container":"on","backgroundimage":"off","backgroundimagefile":"./files/pattern.png","animatebody":"off","bodyanimation":"fadeInRight","bodyanimationduration":"1.0","animatequestion":"off","questionanimation":"flipInX","questionanimationduration":"1.0","animatealert":"off","alertanimation":"shake","alertanimationduration":"1.0","font":"noto","bodybackgroundcolor":"#ffffff","fontcolor":"#444444","questionbackgroundcolor":"#ffffff","questionborder":"on","questioncontainershadow":"on","checkicon":"f00c","animatecheckbox":"on","checkboxanimation":"rubberBand","checkboxanimationduration":"0.5","animateradio":"on","radioanimation":"zoomIn","radioanimationduration":"0.3","showpopups":"1", "showclearall":"off", "questionhelptextposition":"top"}',
                        'cssframework_name' => 'bootstrap',
                        'cssframework_css' => '{}',
                        'cssframework_js' => '',
                        'packages_to_load' => '{"add":["pjax","font-noto","moment"]}',
                    ],
                    "template_name = 'fruity'"
                );
            } else {
                $fruityConfData = [
                    'template_name' => 'fruity',
                    'sid' => null,
                    'gsid' => null,
                    'uid' => null,
                    'files_css' => '{"add":["css/ajaxify.css","css/animate.css","css/variations/sea_green.css","css/theme.css","css/custom.css"]}',
                    'files_js' => '{"add":["scripts/theme.js","scripts/ajaxify.js","scripts/custom.js"]}',
                    'files_print_css' => '{"add":["css/print_theme.css"]}',
                    'options' => '{"ajaxmode":"off","brandlogo":"on","brandlogofile":"./files/logo.png","container":"on","backgroundimage":"off","backgroundimagefile":"./files/pattern.png","animatebody":"off","bodyanimation":"fadeInRight","bodyanimationduration":"1.0","animatequestion":"off","questionanimation":"flipInX","questionanimationduration":"1.0","animatealert":"off","alertanimation":"shake","alertanimationduration":"1.0","font":"noto","bodybackgroundcolor":"#ffffff","fontcolor":"#444444","questionbackgroundcolor":"#ffffff","questionborder":"on","questioncontainershadow":"on","checkicon":"f00c","animatecheckbox":"on","checkboxanimation":"rubberBand","checkboxanimationduration":"0.5","animateradio":"on","radioanimation":"zoomIn","radioanimationduration":"0.3","showpopups":"1", "showclearall":"off", "questionhelptextposition":"top"}',
                    'cssframework_name' => 'bootstrap',
                    'cssframework_css' => '{}',
                    'cssframework_js' => '',
                    'packages_to_load' => '{"add":["pjax","font-noto","moment"]}',
                    'packages_ltr' => null,
                    'packages_rtl' => null
                ];
                $oDB->createCommand()->insert('{{template_configuration}}', $fruityConfData);
            }
            $bootswatchConf = $oDB
                ->createCommand()
                ->select('*')
                ->from('{{template_configuration}}')
                ->where('template_name=:template_name', ['template_name' => 'bootswatch'])
                ->queryRow();
            if ($bootswatchConf) {
                $oDB->createCommand()->update(
                    '{{template_configuration}}',
                    [
                        'files_css' => '{"add":["css/ajaxify.css","css/theme.css","css/custom.css"]}',
                        'files_js' => '{"add":["scripts/theme.js","scripts/ajaxify.js","scripts/custom.js"]}',
                        'files_print_css' => '{"add":["css/print_theme.css"]}',
                        'options' => '{"ajaxmode":"off","brandlogo":"on","container":"on","brandlogofile":"./files/logo.png"}',
                        'cssframework_name' => 'bootstrap',
                        'cssframework_css' => '{"replace":[["css/bootstrap.css","css/variations/flatly.min.css"]]}',
                        'cssframework_js' => '',
                        'packages_to_load' => '{"add":["pjax","font-noto"]}',
                    ],
                    "template_name = 'bootswatch'"
                );
            } else {
                $bootswatchConfData = [
                    'template_name' => 'bootswatch',
                    'sid' => null,
                    'gsid' => null,
                    'uid' => null,
                    'files_css' => '{"add":["css/ajaxify.css","css/theme.css","css/custom.css"]}',
                    'files_js' => '{"add":["scripts/theme.js","scripts/ajaxify.js","scripts/custom.js"]}',
                    'files_print_css' => '{"add":["css/print_theme.css"]}',
                    'options' => '{"ajaxmode":"off","brandlogo":"on","container":"on","brandlogofile":"./files/logo.png"}',
                    'cssframework_name' => 'bootstrap',
                    'cssframework_css' => '{"replace":[["css/bootstrap.css","css/variations/flatly.min.css"]]}',
                    'cssframework_js' => '',
                    'packages_to_load' => '{"add":["pjax","font-noto"]}',
                    'packages_ltr' => null,
                    'packages_rtl' => null
                ];
                $oDB->createCommand()->insert('{{template_configuration}}', $bootswatchConfData);
            }
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 345], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        //Reset Surveymenues and tutorials to fix translation issues
        if ($iOldDBVersion < 346) {
            $oTransaction = $oDB->beginTransaction();
            createSurveyMenuTable($oDB);
            $oDB->createCommand()->truncateTable('{{tutorials}}');
            $oDB->createCommand()->truncateTable('{{tutorial_entries}}');
            $oDB->createCommand()->truncateTable('{{tutorial_entry_relation}}');
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 346], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Correct permission for survey menu email template (surveylocale, not assessments).
         */
        if ($iOldDBVersion < 347) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                [
                    'permission' => 'surveylocale',
                ],
                'name=\'emailtemplates\''
            );
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 347], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Adding security message and settings
         */
        if ($iOldDBVersion < 348) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->addColumn('{{surveys_languagesettings}}', 'surveyls_policy_notice', 'text');
            $oDB->createCommand()->addColumn('{{surveys_languagesettings}}', 'surveyls_policy_error', 'text');
            $oDB->createCommand()->addColumn(
                '{{surveys_languagesettings}}',
                'surveyls_policy_notice_label',
                'string(192)'
            );
            $oDB->createCommand()->addColumn('{{surveys}}', 'showsurveypolicynotice', 'integer DEFAULT 0');

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 348], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 349) {
            $oTransaction = $oDB->beginTransaction();
            dropColumn('{{users}}', 'one_time_pw');
            addColumn('{{users}}', 'one_time_pw', 'text');
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 349], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Adding asset version to allow to reset asset without write inside
         */
        if ($iOldDBVersion < 350) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->createTable(
                '{{asset_version}}',
                array(
                    'id' => 'pk',
                    'path' => 'text NOT NULL',
                    'version' => 'integer NOT NULL',
                )
            );
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 350], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Turning on ajax mode at global level for all themes (survey level not affected)
         */
        if ($iOldDBVersion < 351) {
            $oTransaction = $oDB->beginTransaction();

            $aTHemes = TemplateConfiguration::model()->findAll();

            foreach ($aTHemes as $oTheme) {
                $oTheme->setGlobalOption("ajaxmode", "on");
            }

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 351], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 352) {
            $oTransaction = $oDB->beginTransaction();
            dropColumn('{{sessions}}', 'data');
            addColumn('{{sessions}}', 'data', 'binary');

            $aTHemes = TemplateConfiguration::model()->findAll();

            foreach ($aTHemes as $oTheme) {
                $oTheme->setGlobalOption("ajaxmode", "off");
            }

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 352], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 353) {
            $oTransaction = $oDB->beginTransaction();

            $aTHemes = TemplateConfiguration::model()->findAll();

            foreach ($aTHemes as $oTheme) {
                $oTheme->addOptionFromXMLToLiveTheme();
            }

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 353], "stg_name='DBVersion'");
            $oTransaction->commit();
        }


        if ($iOldDBVersion < 354) {
            $oTransaction = $oDB->beginTransaction();
            $surveymenuTable = Yii::app()->db->schema->getTable('{{surveymenu}}');

            if (!isset($surveymenuTable->columns['showincollapse'])) {
                $oDB->createCommand()->addColumn('{{surveymenu}}', 'showincollapse', 'integer DEFAULT 0');
            }

            $surveymenuEntryTable = Yii::app()->db->schema->getTable('{{surveymenu}}');
            if (!isset($surveymenuEntryTable->columns['showincollapse'])) {
                $oDB->createCommand()->addColumn('{{surveymenu_entries}}', 'showincollapse', 'integer DEFAULT 0');
            }

            $aIdMap = [];
            $aDefaultSurveyMenus = LsDefaultDataSets::getSurveyMenuData();
            switchMSSQLIdentityInsert('surveymenu', true);
            foreach ($aDefaultSurveyMenus as $i => $aSurveymenu) {
                $oDB->createCommand()->delete('{{surveymenu}}', 'name=:name', [':name' => $aSurveymenu['name']]);
                $oDB->createCommand()->delete('{{surveymenu}}', 'id=:id', [':id' => $aSurveymenu['id']]);
                $oDB->createCommand()->insert('{{surveymenu}}', $aSurveymenu);
                $aIdMap[$aSurveymenu['name']] = $aSurveymenu['id'];
            }
            switchMSSQLIdentityInsert('surveymenu', false);

            $aDefaultSurveyMenuEntries = LsDefaultDataSets::getSurveyMenuEntryData();
            foreach ($aDefaultSurveyMenuEntries as $i => $aSurveymenuentry) {
                $oDB->createCommand()->delete(
                    '{{surveymenu_entries}}',
                    'name=:name',
                    [':name' => $aSurveymenuentry['name']]
                );
                switch ($aSurveymenuentry['menu_id']) {
                    case 1:
                        $aSurveymenuentry['menu_id'] = $aIdMap['settings'];
                        break;
                    case 2:
                        $aSurveymenuentry['menu_id'] = $aIdMap['mainmenu'];
                        break;
                    case 3:
                        $aSurveymenuentry['menu_id'] = $aIdMap['quickmenu'];
                        break;
                    case 4:
                        $aSurveymenuentry['menu_id'] = $aIdMap['pluginmenu'];
                        break;
                }
                $oDB->createCommand()->insert('{{surveymenu_entries}}', $aSurveymenuentry);
            }
            unset($aDefaultSurveyMenuEntries);

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 354], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 355) {
            $oTransaction = $oDB->beginTransaction();

            $aIdMap = [];
            $aDefaultSurveyMenus = LsDefaultDataSets::getSurveyMenuData();
            foreach ($aDefaultSurveyMenus as $i => $aSurveymenu) {
                $aIdMap[$aSurveymenu['name']] = $oDB->createCommand()
                    ->select(['id'])
                    ->from('{{surveymenu}}')
                    ->where('name=:name', [':name' => $aSurveymenu['name']])
                    ->queryScalar();
            }

            $aDefaultSurveyMenuEntries = LsDefaultDataSets::getSurveyMenuEntryData();
            foreach ($aDefaultSurveyMenuEntries as $i => $aSurveymenuentry) {
                $oDB->createCommand()->delete(
                    '{{surveymenu_entries}}',
                    'name=:name',
                    [':name' => $aSurveymenuentry['name']]
                );
                switch ($aSurveymenuentry['menu_id']) {
                    case 1:
                        $aSurveymenuentry['menu_id'] = $aIdMap['settings'];
                        break;
                    case 2:
                        $aSurveymenuentry['menu_id'] = $aIdMap['mainmenu'];
                        break;
                    case 3:
                        $aSurveymenuentry['menu_id'] = $aIdMap['quickmenu'];
                        break;
                    case 4:
                        $aSurveymenuentry['menu_id'] = $aIdMap['pluginmenu'];
                        break;
                }
                $oDB->createCommand()->insert('{{surveymenu_entries}}', $aSurveymenuentry);
            }


            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 355], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        // Replace "Label sets" box with "LimeStore" box.
        if ($iOldDBVersion < 356) {
            $oTransaction = $oDB->beginTransaction();
            switch (Yii::app()->db->driverName) {
                case 'sqlsrv':
                case 'dblib':
                case 'mssql':
                    $oDB->createCommand("UPDATE {{boxes}} SET ico = 'icon-' + ico")->execute();
                    break;
                default:
                    $oDB->createCommand("UPDATE {{boxes}} SET ico = CONCAT('icon-', ico)")->execute();
                    break;
            }
            // Only change label box if it's there.
            $labelBox = $oDB->createCommand(
                "SELECT * FROM {{boxes}} WHERE id = 5 AND position = 5 AND title = 'Label sets'"
            )->queryRow();
            if ($labelBox) {
                $oDB
                    ->createCommand()
                    ->update(
                        '{{boxes}}',
                        [
                            'title' => 'LimeStore',
                            'ico' => 'fa fa-cart-plus',
                            'desc' => 'LimeSurvey extension marketplace',
                            'url' => 'https://account.limesurvey.org/limestore'
                        ],
                        'id = 5'
                    );
            }
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 356], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 357) {
            $oTransaction = $oDB->beginTransaction();
            //// IKI
            $oDB->createCommand()->renameColumn('{{surveys_groups}}', 'owner_uid', 'owner_id');
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 357], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 358) {
            $oTransaction = $oDB->beginTransaction();
            dropColumn('{{sessions}}', 'data');
            addColumn('{{sessions}}', 'data', 'longbinary');
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 358], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 359) {
            $oTransaction = $oDB->beginTransaction();
            alterColumn('{{notifications}}', 'message', "text", false);
            alterColumn('{{settings_user}}', 'stg_value', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_description', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_welcometext', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_endtext', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_policy_notice', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_policy_error', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_url', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_invite', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_remind', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_register', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_email_confirm', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_attributecaptions', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'email_admin_notification', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'email_admin_responses', "text", true);
            alterColumn('{{surveys_languagesettings}}', 'surveyls_numberformat', "integer", false, '0');
            alterColumn('{{user_groups}}', 'description', "text", false);
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 359], "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        /**
         * Correct permission for survey menu Survey Participants (tokens, not surveysettings).
         */
        if ($iOldDBVersion < 360) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                [
                    'permission' => 'tokens',
                ],
                'name=\'participants\''
            );
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 360], "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        /*
        * DBVersion 361 & 362 were intentionally left out to sync with Cloud Hosting
        */

        /*
         * Speed up token tables import/search by setting indexes
         */
        if ($iOldDBVersion < 363) {
            $oTransaction = $oDB->beginTransaction();
            $aTableNames = dbGetTablesLike("tokens%");
            $oDB = Yii::app()->getDb();
            foreach ($aTableNames as $sTableName) {
                try {
                    setTransactionBookmark();
                    switch (Yii::app()->db->driverName) {
                        case 'mysql':
                        case 'mysqli':
                            $oDB->createCommand()->createIndex('idx_email', $sTableName, 'email(30)', false);
                            break;
                        case 'pgsql':
                            $oDB->createCommand()->createIndex(
                                'idx_email_' . substr($sTableName, 7) . '_' . rand(1, 50000),
                                $sTableName,
                                'email',
                                false
                            );
                            break;
                        // MSSQL does not support indexes on text fields so no dice
                    }
                } catch (Exception $e) {
                    rollBackToTransactionBookmark();
                }
            }
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 363], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /*
         * Extend text datafield lengths for MySQL
         * Extend datafield length for additional languages in survey table
         */
        if ($iOldDBVersion < 364) {
            $oTransaction = $oDB->beginTransaction();
            extendDatafields364($oDB);
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 364], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 400) {
            // Fix database default collation, again
            if (Yii::app()->db->driverName == 'mysql') {
                Yii::app()->db->createCommand(
                    "ALTER DATABASE `" . getDBConnectionStringProperty(
                        'dbname'
                    ) . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
                );
            }

            // This update moves localization-dependant strings from question group/question/answer tables to related localization tables
            $oTransaction = $oDB->beginTransaction();

            // Question table
            /* l10ns question table */
            if (Yii::app()->db->schema->getTable('{{question_l10ns}}')) {
                $oDB->createCommand()->dropTable('{{question_l10ns}}');
            }
            $oDB->createCommand()->createTable(
                '{{question_l10ns}}',
                array(
                    'id' => "pk",
                    'qid' => "integer NOT NULL",
                    'question' => "mediumtext NOT NULL",
                    'help' => "mediumtext",
                    'language' => "string(20) NOT NULL"
                ),
                $options
            );
            $oDB->createCommand()->createIndex(
                '{{idx1_question_l10ns}}',
                '{{question_l10ns}}',
                ['qid', 'language'],
                true
            );
            $oDB->createCommand(
                "INSERT INTO {{question_l10ns}} (qid, question, help, language) select qid, question, help, language from {{questions}}"
            )->execute();
            /* questions by rename/insert */
            if (Yii::app()->db->schema->getTable('{{questions_update400}}')) {
                $oDB->createCommand()->dropTable('{{questions_update400}}');
            }
            $oDB->createCommand()->renameTable('{{questions}}', '{{questions_update400}}');
            $oDB->createCommand()->createTable(
                '{{questions}}',
                array(
                    'qid' => "pk",
                    'parent_qid' => "integer NOT NULL default '0'",
                    'sid' => "integer NOT NULL default '0'",
                    'gid' => "integer NOT NULL default '0'",
                    'type' => "string(30) NOT NULL default 'T'",
                    'title' => "string(20) NOT NULL default ''",
                    'preg' => "text",
                    'other' => "string(1) NOT NULL default 'N'",
                    'mandatory' => "string(1) NULL",
                    //'encrypted' =>  "string(1) NULL default 'N'", DB version 406
                    'question_order' => "integer NOT NULL",
                    'scale_id' => "integer NOT NULL default '0'",
                    'same_default' => "integer NOT NULL default '0'",
                    'relevance' => "text",
                    'modulename' => "string(255) NULL"
                ),
                $options
            );
            switchMSSQLIdentityInsert('questions', true); // Untested
            $oDB->createCommand(
                "INSERT INTO {{questions}}
                (qid, parent_qid, sid, gid, type, title, preg, other, mandatory, question_order, scale_id, same_default, relevance, modulename)
                SELECT qid, parent_qid, {{questions_update400}}.sid, gid, type, title, COALESCE(preg,''), other, COALESCE(mandatory,''), question_order, scale_id, same_default, COALESCE(relevance,''), COALESCE(modulename,'')
                FROM {{questions_update400}}
                    INNER JOIN {{surveys}} ON {{questions_update400}}.sid = {{surveys}}.sid AND {{questions_update400}}.language = {{surveys}}.language
                "
            )->execute();
            switchMSSQLIdentityInsert('questions', false); // Untested
            $oDB->createCommand()->dropTable('{{questions_update400}}'); // Drop the table before create index for pgsql
            $oDB->createCommand()->createIndex('{{idx1_questions}}', '{{questions}}', 'sid', false);
            $oDB->createCommand()->createIndex('{{idx2_questions}}', '{{questions}}', 'gid', false);
            $oDB->createCommand()->createIndex('{{idx3_questions}}', '{{questions}}', 'type', false);
            $oDB->createCommand()->createIndex('{{idx4_questions}}', '{{questions}}', 'title', false);
            $oDB->createCommand()->createIndex('{{idx5_questions}}', '{{questions}}', 'parent_qid', false);

            // Groups table
            if (Yii::app()->db->schema->getTable('{{group_l10ns}}')) {
                $oDB->createCommand()->dropTable('{{group_l10ns}}');
            }
            $oDB->createCommand()->createTable(
                '{{group_l10ns}}',
                array(
                    'id' => "pk",
                    'gid' => "integer NOT NULL",
                    'group_name' => "text NOT NULL",
                    'description' => "mediumtext",
                    'language' => "string(20) NOT NULL"
                ),
                $options
            );
            $oDB->createCommand()->createIndex('{{idx1_group_l10ns}}', '{{group_l10ns}}', ['gid', 'language'], true);
            $quotedGroups = Yii::app()->db->quoteTableName('{{groups}}');
            $oDB->createCommand(
                sprintf(
                    "INSERT INTO {{group_l10ns}} (gid, group_name, description, language) SELECT gid, group_name, description, language FROM %s",
                    $quotedGroups
                )
            )->execute();
            if (Yii::app()->db->schema->getTable('{{groups_update400}}')) {
                $oDB->createCommand()->dropTable('{{groups_update400}}');
            }
            $oDB->createCommand()->renameTable('{{groups}}', '{{groups_update400}}');
            $oDB->createCommand()->createTable(
                '{{groups}}',
                array(
                    'gid' => "pk",
                    'sid' => "integer NOT NULL default '0'",
                    'group_order' => "integer NOT NULL default '0'",
                    'randomization_group' => "string(20) NOT NULL default ''",
                    'grelevance' => "text NULL"
                ),
                $options
            );
            switchMSSQLIdentityInsert('groups', true); // Untested
            $oDB->createCommand(
                "INSERT INTO " . $quotedGroups . "
                (gid, sid, group_order, randomization_group, grelevance)
                SELECT gid, {{groups_update400}}.sid, group_order, randomization_group, COALESCE(grelevance,'')
                FROM {{groups_update400}}
                    INNER JOIN {{surveys}} ON {{groups_update400}}.sid = {{surveys}}.sid AND {{groups_update400}}.language = {{surveys}}.language
                "
            )->execute();
            switchMSSQLIdentityInsert('groups', false); // Untested
            $oDB->createCommand()->dropTable('{{groups_update400}}'); // Drop the table before create index for pgsql
            $oDB->createCommand()->createIndex('{{idx1_groups}}', '{{groups}}', 'sid', false);

            // Answers table
            if (Yii::app()->db->schema->getTable('{{answer_l10ns}}')) {
                $oDB->createCommand()->dropTable('{{answer_l10ns}}');
            }
            $oDB->createCommand()->createTable(
                '{{answer_l10ns}}',
                array(
                    'id' => "pk",
                    'aid' => "integer NOT NULL",
                    'answer' => "mediumtext NOT NULL",
                    'language' => "string(20) NOT NULL"
                ),
                $options
            );
            $oDB->createCommand()->createIndex('{{idx1_answer_l10ns}}', '{{answer_l10ns}}', ['aid', 'language'], true);
            /* Renaming old without pk answers */
            if (Yii::app()->db->schema->getTable('{{answers_update400}}')) {
                $oDB->createCommand()->dropTable('{{answers_update400}}');
            }
            $oDB->createCommand()->renameTable('{{answers}}', '{{answers_update400}}');
            /* Create new answers with pk and copy answers_update400 Grouping by unique part */
            $oDB->createCommand()->createTable(
                '{{answers}}',
                [
                    'aid' => 'pk',
                    'qid' => 'integer NOT NULL',
                    'code' => 'string(5) NOT NULL',
                    'sortorder' => 'integer NOT NULL',
                    'assessment_value' => 'integer NOT NULL DEFAULT 0',
                    'scale_id' => 'integer NOT NULL DEFAULT 0'
                ],
                $options
            );
            $oDB->createCommand()->createIndex(
                'answer_update400_idx_10',
                '{{answers_update400}}',
                ['qid', 'code', 'scale_id']
            );
            /* No pk in insert */
            $oDB->createCommand(
                "INSERT INTO {{answers}}
                (qid, code, sortorder, assessment_value, scale_id)
                SELECT {{answers_update400}}.qid, {{answers_update400}}.code, {{answers_update400}}.sortorder, {{answers_update400}}.assessment_value, {{answers_update400}}.scale_id
                FROM {{answers_update400}}
                    INNER JOIN {{questions}} ON {{answers_update400}}.qid = {{questions}}.qid
                    INNER JOIN {{surveys}} ON {{questions}}.sid = {{surveys}}.sid AND {{surveys}}.language = {{answers_update400}}.language
                "
            )->execute();
            /* no pk in insert, get aid by INNER join */
            $oDB->createCommand(
                "INSERT INTO {{answer_l10ns}}
                (aid, answer, language)
                SELECT {{answers}}.aid, {{answers_update400}}.answer, {{answers_update400}}.language
                FROM {{answers_update400}}
                INNER JOIN {{answers}}
                ON {{answers_update400}}.qid = {{answers}}.qid AND {{answers_update400}}.code = {{answers}}.code AND {{answers_update400}}.scale_id = {{answers}}.scale_id
            "
            )->execute();

            $oDB->createCommand()->dropTable('{{answers_update400}}');
            $oDB->createCommand()->createIndex('{{answers_idx}}', '{{answers}}', ['qid', 'code', 'scale_id'], true);
            $oDB->createCommand()->createIndex('{{answers_idx2}}', '{{answers}}', 'sortorder', false);

            // Apply integrity fix before starting label set update.
            // List of label set ids which contain code duplicates.
            $lids = $oDB->createCommand(
                "SELECT {{labels}}.lid AS lid
                FROM {{labels}}
                GROUP BY {{labels}}.lid, {{labels}}.language
                HAVING COUNT(DISTINCT({{labels}}.code)) < COUNT({{labels}}.id)"
            )->queryAll();
            foreach ($lids as $lid) {
                regenerateLabelCodes400($lid['lid']);
            }

            // Labels table
            if (Yii::app()->db->schema->getTable('{{label_l10ns}}')) {
                $oDB->createCommand()->dropTable('{{label_l10ns}}');
            }
            if (Yii::app()->db->schema->getTable('{{labels_update400}}')) {
                $oDB->createCommand()->dropTable('{{labels_update400}}');
            }
            $oDB->createCommand()->renameTable('{{labels}}', '{{labels_update400}}');
            $oDB->createCommand()->createTable(
                '{{labels}}',
                [
                    'id' => "pk",
                    'lid' => 'integer NOT NULL',
                    'code' => 'string(5) NOT NULL',
                    'sortorder' => 'integer NOT NULL',
                    'assessment_value' => 'integer NOT NULL DEFAULT 0'
                ],
                $options
            );
            /* The previous id is broken and can not be used, create a new one */
            /* we can groub by lid and code, adding min(sortorder), min(assessment_value) if they are different (this fix different value for deifferent language) */
            $oDB->createCommand(
                "INSERT INTO {{labels}}
                (lid, code, sortorder, assessment_value)
                SELECT lid, code, min(sortorder), min(assessment_value)
                FROM {{labels_update400}}
                GROUP BY lid, code"
            )->execute();
            $oDB->createCommand()->createTable(
                '{{label_l10ns}}',
                array(
                    'id' => "pk",
                    'label_id' => "integer NOT NULL",
                    'title' => "text",
                    'language' => "string(20) NOT NULL DEFAULT 'en'"
                ),
                $options
            );
            $oDB->createCommand()->createIndex(
                '{{idx1_label_l10ns}}',
                '{{label_l10ns}}',
                ['label_id', 'language'],
                true
            );
            // Remove invalid labels, otherwise update will fail because of index duplicates in the next query
            $oDB->createCommand("delete from {{labels_update400}} WHERE code=''")->execute();
            $oDB->createCommand(
                "INSERT INTO {{label_l10ns}}
                (label_id, title, language)
                SELECT {{labels}}.id ,{{labels_update400}}.title,{{labels_update400}}.language
                FROM {{labels_update400}}
                    INNER JOIN {{labels}} ON {{labels_update400}}.lid = {{labels}}.lid AND {{labels_update400}}.code = {{labels}}.code 
                "
            )->execute();
            $oDB->createCommand()->dropTable('{{labels_update400}}');

            // Extend language field on labelsets
            alterColumn('{{labelsets}}', 'languages', "string(255)", false);

            // Extend question type field length
            alterColumn('{{questions}}', 'type', 'string(30)', false, 'T');

            // Drop autoincrement on timings table primary key
            upgradeSurveyTimings350();

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 400), "stg_name='DBVersion'");

            $oTransaction->commit();
        }

        /**
         * Add load_error and load_error_message to plugin system.
         */
        if ($iOldDBVersion < 401) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->addColumn('{{plugins}}', 'load_error', 'int default 0');
            $oDB->createCommand()->addColumn('{{plugins}}', 'load_error_message', 'text');

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 401), "stg_name='DBVersion'");

            $oTransaction->commit();
        }

        if ($iOldDBVersion < 402) {
            $oTransaction = $oDB->beginTransaction();

            // Plugin type is either "core", "user" or "upload" (different folder locations).
            $oDB->createCommand()->addColumn('{{plugins}}', 'plugin_type', "string(6) default 'user'");

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 402), "stg_name='DBVersion'");

            $oTransaction->commit();
        }

        /**
         * Make tokens fit UUID 36 chars
         */
        if ($iOldDBVersion < 403) {
            $oTransaction = $oDB->beginTransaction();
            upgradeTokenTables402('utf8mb4_bin');
            upgradeSurveyTables402('utf8mb4_bin');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 403), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Add sureys_groupsettings table and update settings_global table
         */
        if ($iOldDBVersion < 404) {
            $oTransaction = $oDB->beginTransaction();
            createSurveysGroupSettingsTable($oDB);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 404), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        // In case any LS4 user missed database update from version 356.
        if ($iOldDBVersion < 405) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand(
                "
                UPDATE
                    {{boxes}}
                SET ico = CASE
                    WHEN ico IN ('add', 'list', 'settings', 'shield', 'templates', 'label') THEN CONCAT('icon-', ico)
                    ELSE ico
                END
                "
            )->execute();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 405), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Database modification for encryption feature
         */
        if ($iOldDBVersion < 406) {
            $oTransaction = $oDB->beginTransaction();
            // surveys
            $oDB->createCommand()->addColumn('{{surveys}}', 'tokenencryptionoptions', "text");
            $oDB->createCommand()->update(
                '{{surveys}}',
                array(
                    'tokenencryptionoptions' => json_encode(
                        Token::getDefaultEncryptionOptions()
                    )
                )
            );
            // participants
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex('{{idx1_participants}}', '{{participants}}');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex('{{idx2_participants}}', '{{participants}}');
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            alterColumn('{{participants}}', 'firstname', "text");
            alterColumn('{{participants}}', 'lastname', "text");
            $oDB->createCommand()->addColumn('{{participant_attribute_names}}', 'encrypted', "string(5) NOT NULL DEFAULT ''");
            $oDB->createCommand()->addColumn('{{participant_attribute_names}}', 'core_attribute', "string(5) NOT NULL DEFAULT ''");
            $aCoreAttributes = array('firstname', 'lastname', 'email');
            foreach ($aCoreAttributes as $attribute) {
                $oDB->createCommand()->insert(
                    '{{participant_attribute_names}}',
                    array(
                        'attribute_type' => 'TB',
                        'defaultname' => $attribute,
                        'visible' => 'TRUE',
                        'encrypted' => 'N',
                        'core_attribute' => 'Y'
                    )
                );
            }
            $oDB->createCommand()->addColumn('{{questions}}', 'encrypted', "string(1) NULL default 'N'");

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 406), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 407) {
            $oTransaction = $oDB->beginTransaction();
            // defaultvalues
            if (Yii::app()->db->schema->getTable('{{defaultvalue_l10ns}}')) {
                $oDB->createCommand()->dropTable('{{defaultvalue_l10ns}}');
            }
            $oDB->createCommand()->createTable(
                '{{defaultvalue_l10ns}}',
                array(
                    'id' => "pk",
                    'dvid' => "integer NOT NULL default '0'",
                    'language' => "string(20) NOT NULL",
                    'defaultvalue' => "text",
                ),
                $options
            );
            $oDB->createCommand()->createIndex(
                '{{idx1_defaultvalue_l10ns}}',
                '{{defaultvalue_l10ns}}',
                ['dvid', 'language'],
                true
            );
            if (Yii::app()->db->schema->getTable('{{defaultvalues_update407}}')) {
                $oDB->createCommand()->dropTable('{{defaultvalues_update407}}');
            }
            $oDB->createCommand()->renameTable('{{defaultvalues}}', '{{defaultvalues_update407}}');
            $oDB->createCommand()->createIndex(
                'defaultvalues_update407_idx_10',
                '{{defaultvalues_update407}}',
                ['qid', 'scale_id', 'sqid', 'specialtype', 'language']
            );
            $oDB->createCommand()->createTable(
                '{{defaultvalues}}',
                [
                    'dvid' => "pk",
                    'qid' => "integer NOT NULL default '0'",
                    'scale_id' => "integer NOT NULL default '0'",
                    'sqid' => "integer NOT NULL default '0'",
                    'specialtype' => "string(20) NOT NULL default ''",
                ],
                $options
            );
            /* Get only survey->language */
            $oDB->createCommand(
                "INSERT INTO {{defaultvalues}} (qid, sqid, scale_id, specialtype)
                SELECT qid, sqid, scale_id, specialtype
                FROM {{defaultvalues_update407}}
                GROUP BY qid, sqid, scale_id, specialtype
                "
            )->execute();
            $oDB->createCommand()->createIndex(
                '{{idx1_defaultvalue}}',
                '{{defaultvalues}}',
                ['qid', 'scale_id', 'sqid', 'specialtype'],
                false
            );
            $oDB->createCommand(
                "INSERT INTO {{defaultvalue_l10ns}} (dvid, language, defaultvalue)
                SELECT {{defaultvalues}}.dvid, {{defaultvalues_update407}}.language, {{defaultvalues_update407}}.defaultvalue
                FROM {{defaultvalues}}
                INNER JOIN {{defaultvalues_update407}}
                    ON {{defaultvalues}}.qid = {{defaultvalues_update407}}.qid AND {{defaultvalues}}.sqid = {{defaultvalues_update407}}.sqid AND {{defaultvalues}}.scale_id = {{defaultvalues_update407}}.scale_id AND {{defaultvalues}}.specialtype = {{defaultvalues_update407}}.specialtype
                "
            )->execute();
            $oDB->createCommand()->dropTable('{{defaultvalues_update407}}');

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 407), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 408) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update(
                '{{participant_attribute_names}}',
                array('encrypted' => 'Y'),
                "core_attribute='Y'"
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 408), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 409) {
            $oTransaction = $oDB->beginTransaction();

            $sEncrypted = 'N';
            $oDB->createCommand()->update(
                '{{participant_attribute_names}}',
                array('encrypted' => $sEncrypted),
                "core_attribute='Y'"
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 409), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 410) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->addColumn('{{question_l10ns}}', 'script', " text NULL default NULL");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 410), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 411) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->addColumn('{{plugins}}', 'priority', "int NOT NULL default 0");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 411), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 412) {
            $oTransaction = $oDB->beginTransaction();
            $sSurveyGroupQuery = "SELECT gsid  from {{surveys_groups}} order by gsid";
            $aGroups = $oDB->createCommand($sSurveyGroupQuery)->queryColumn();
            $sSurveyGroupSettingsQuery = "SELECT gsid  from {{surveys_groupsettings}} order by gsid";
            $aGroupSettings = $oDB->createCommand($sSurveyGroupSettingsQuery)->queryColumn();
            foreach ($aGroups as $group) {
                if (!array_key_exists($group, $aGroupSettings)) {
                    $settings = new SurveysGroupsettings();
                    $settings->setToInherit();
                    $settings->gsid = $group;
                    $oDB->createCommand()->insert("{{surveys_groupsettings}}", $settings->attributes);
                }
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 412), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 413) {
            /*
             *  changes for this version are removed, but this block stays for the continuity
             */

            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 413), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 414) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->addColumn('{{users}}', 'lastLogin', "datetime NULL");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 414), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 415) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                [
                    "menu_link" => "admin/filemanager",
                    "action" => '',
                    "template" => '',
                    "partial" => '',
                    "classes" => '',
                    "data" => '{"render": { "link": {"data": {"surveyid": ["survey","sid"]}}}}',
                ],
                'name=:name',
                [':name' => 'resources']
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 415), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 416) {
            $oTransaction = $oDB->beginTransaction();

            // encrypt values in db
            SettingGlobal::setSetting(
                'emailsmtppassword',
                LSActiveRecord::encryptSingle(App()->getConfig('emailsmtppassword'))
            );
            SettingGlobal::setSetting(
                'bounceaccountpass',
                LSActiveRecord::encryptSingle(App()->getConfig('bounceaccountpass'))
            );

            // encrypt bounceaccountpass value in db
            alterColumn('{{surveys}}', 'bounceaccountpass', "text", true, 'NULL');
            $sSurveyQuery = "SELECT * from {{surveys}} order by sid";
            $aSurveys = $oDB->createCommand($sSurveyQuery)->queryAll();
            foreach ($aSurveys as $aSurvey) {
                if (!empty($aSurvey['bounceaccountpass'])) {
                    $oDB->createCommand()->update(
                        '{{surveys}}',
                        [
                            'bounceaccountpass' => LSActiveRecord::encryptSingle(
                                $aSurvey['bounceaccountpass']
                            )
                        ],
                        "sid=" . $aSurvey['sid']
                    );
                }
            }

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 416), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 417) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->delete('{{surveymenu_entries}}', 'name=:name', [':name' => 'reorder']);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 417), "stg_name='DBVersion'");
            $oTransaction->commit();

            SurveymenuEntries::reorderMenu(2);
        }

        if ($iOldDBVersion < 418) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->insert(
                "{{plugins}}",
                [
                    'name' => 'PasswordRequirement',
                    'plugin_type' => 'core',
                    'active' => 1,
                    'version' => '1.0.0',
                    'load_error' => 0,
                    'load_error_message' => null
                ]
            );

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 418), "stg_name='DBVersion'");
            $oTransaction->commit();

            SurveymenuEntries::reorderMenu(2);
        }

        if ($iOldDBVersion < 419) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->createTable(
                "{{permissiontemplates}}",
                [
                    'ptid' => "pk",
                    'name' => "string(127) NOT NULL",
                    'description' => "text NULL",
                    'renewed_last' => "datetime NULL",
                    'created_at' => "datetime NOT NULL",
                    'created_by' => "int NOT NULL"
                ]
            );

            $oDB->createCommand()->createIndex('{{idx1_name}}', '{{permissiontemplates}}', 'name', true);

            $oDB->createCommand()->createTable(
                '{{user_in_permissionrole}}',
                array(
                    'ptid' => "integer NOT NULL",
                    'uid' => "integer NOT NULL",
                ),
                $options
            );

            $oDB->createCommand()->addPrimaryKey(
                '{{user_in_permissionrole_pk}}',
                '{{user_in_permissionrole}}',
                ['ptid', 'uid']
            );

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 419), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 420) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update(
                "{{surveymenu_entries}}",
                [
                    'name' => "listSurveyGroups",
                    'title' => gT('Group list', 'unescaped'),
                    'menu_title' => gT('Group list', 'unescaped'),
                    'menu_description' => gT('List question groups', 'unescaped'),
                ],
                'name=\'listQuestionGroups\''
            );

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 420), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 421) {
            $oTransaction = $oDB->beginTransaction();
            // question_themes
            $oDB->createCommand()->createTable(
                '{{question_themes}}',
                [
                    'id' => "pk",
                    'name' => "string(150) NOT NULL",
                    'visible' => "string(1) NULL",
                    'xml_path' => "string(255) NULL",
                    'image_path' => 'string(255) NULL',
                    'title' => "string(100) NOT NULL",
                    'creation_date' => "datetime NULL",
                    'author' => "string(150) NULL",
                    'author_email' => "string(255) NULL",
                    'author_url' => "string(255) NULL",
                    'copyright' => "text",
                    'license' => "text",
                    'version' => "string(45) NULL",
                    'api_version' => "string(45) NOT NULL",
                    'description' => "text",
                    'last_update' => "datetime NULL",
                    'owner_id' => "integer NULL",
                    'theme_type' => "string(150)",
                    'question_type' => "string(150) NOT NULL",
                    'core_theme' => 'boolean',
                    'extends' => "string(150) NULL",
                    'group' => "string(150)",
                    'settings' => "text"
                ],
                $options
            );

            $oDB->createCommand()->createIndex('{{idx1_question_themes}}', '{{question_themes}}', 'name', false);

            $baseQuestionThemeEntries = LsDefaultDataSets::getBaseQuestionThemeEntries();
            foreach ($baseQuestionThemeEntries as $baseQuestionThemeEntry) {
                $oDB->createCommand()->insert("{{question_themes}}", $baseQuestionThemeEntry);
            }
            unset($baseQuestionThemeEntries);

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 421), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 422) {
            $oTransaction = $oDB->beginTransaction();
            //update core themes api_version
            $oDB->createCommand()->update(
                '{{templates}}',
                array(
                    'api_version' => "4.0",
                    'version' => "4.0",
                    'copyright' => "Copyright (C) 2007-2019 The LimeSurvey Project Team\r\nAll rights reserved."
                ),
                "name='fruity'"
            );
            $oDB->createCommand()->update(
                '{{templates}}',
                array(
                    'api_version' => "4.0",
                    'version' => "4.0",
                    'copyright' => "Copyright (C) 2007-2019 The LimeSurvey Project Team\r\nAll rights reserved."
                ),
                "name='vanilla'"
            );
            $oDB->createCommand()->update(
                '{{templates}}',
                array(
                    'api_version' => "4.0",
                    'version' => "4.0",
                    'copyright' => "Copyright (C) 2007-2019 The LimeSurvey Project Team\r\nAll rights reserved."
                ),
                "name='bootwatch'"
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 422), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 423) {
            $oTransaction = $oDB->beginTransaction();
            //update core themes api_version
            $oDB->createCommand()->update(
                '{{templates}}',
                array(
                    'api_version' => "3.0",
                    'version' => "3.0",
                    'copyright' => "Copyright (C) 2007-2019 The LimeSurvey Project Team\r\nAll rights reserved."
                ),
                "name='fruity'"
            );
            $oDB->createCommand()->update(
                '{{templates}}',
                array(
                    'api_version' => "3.0",
                    'version' => "3.0",
                    'copyright' => "Copyright (C) 2007-2019 The LimeSurvey Project Team\r\nAll rights reserved."
                ),
                "name='vanilla'"
            );
            $oDB->createCommand()->update(
                '{{templates}}',
                array(
                    'api_version' => "3.0",
                    'version' => "3.0",
                    'copyright' => "Copyright (C) 2007-2019 The LimeSurvey Project Team\r\nAll rights reserved."
                ),
                "name='bootwatch'"
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 423), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 424) {
            $oTransaction = $oDB->beginTransaction();
            $installedPlugins = array_map(
                function ($v) {
                    return $v['name'];
                },
                $oDB->createCommand('SELECT name FROM {{plugins}}')->queryAll()
            );
            /**
             * @param string $name Name of plugin
             * @param int $active
             */
            $insertPlugin = function ($name, $active = 0) use ($installedPlugins, $oDB) {
                if (!in_array($name, $installedPlugins)) {
                    $oDB->createCommand()->insert(
                        "{{plugins}}",
                        [
                            'name' => $name,
                            'plugin_type' => 'core',
                            'active' => $active,
                            'version' => '1.0.0',
                            'load_error' => 0,
                            'load_error_message' => null
                        ]
                    );
                } else {
                    $oDB->createCommand()->update(
                        "{{plugins}}",
                        [
                            'plugin_type' => 'core',
                            'version' => '1.0.0',
                        ],
                        App()->db->quoteColumnName('name') . " = " . dbQuoteAll($name)
                    );
                }
            };
            $insertPlugin('AuthLDAP');
            $insertPlugin('Authdb');
            $insertPlugin('ComfortUpdateChecker');
            $insertPlugin('AuditLog');
            $insertPlugin('Authwebserver');
            $insertPlugin('ExportR', 1);
            $insertPlugin('ExportSTATAxml', 1);
            $insertPlugin('oldUrlCompat');
            $insertPlugin('expressionQuestionHelp');
            $insertPlugin('expressionQuestionForAll');
            $insertPlugin('expressionFixedDbVar');
            $insertPlugin('customToken');
            $insertPlugin('mailSenderToFrom');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 424), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 425) {
            $oTransaction = $oDB->beginTransaction();
            $aUserDirectory = QuestionTheme::getAllQuestionXMLPaths(false, false, true);
            if (!empty($aUserDirectory)) {
                reset($aUserDirectory);
                $aUserXMLPaths = key($aUserDirectory);
                foreach ($aUserDirectory[$aUserXMLPaths] as $sXMLDirectoryPath) {
                    try {
                        $aSuccess = QuestionTheme::convertLS3toLS5($sXMLDirectoryPath);
                        if ($aSuccess['success']) {
                            $oQuestionTheme = new QuestionTheme();
                            $oQuestionTheme->importManifest($sXMLDirectoryPath, true);
                        }
                    } catch (throwable $e) {
                        continue;
                    }
                }
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 425), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 426) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->addColumn(
                '{{surveys_groupsettings}}',
                'ipanonymize',
                "string(1) NOT NULL default 'N'"
            );
            $oDB->createCommand()->addColumn('{{surveys}}', 'ipanonymize', "string(1) NOT NULL default 'N'");

            //all groups (except default group gsid=0), must have inheritance value
            $oDB->createCommand()->update('{{surveys_groupsettings}}', array('ipanonymize' => 'I'), 'gsid<>0');

            //change gsid=1 for inheritance logic ...(redundant, but for better understanding and securit)
            $oDB->createCommand()->update('{{surveys_groupsettings}}', array('ipanonymize' => 'I'), 'gsid=1');

            //for all non active surveys,the value must be "I" for inheritance ...
            $oDB->createCommand()->update('{{surveys}}', array('ipanonymize' => 'I'), "active='N'");

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 426), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 427) {
            $oTransaction = $oDB->beginTransaction();

            // Menu Link needs to be updated, cause we will revert the filemanager and enable the older one.
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'menu_link' => '',
                    'action' => 'updatesurveylocalsettings',
                    'template' => 'editLocalSettings_main_view',
                    'partial' => '/admin/survey/subview/accordion/_resources_panel'
                ),
                "name='resources'"
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 427), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Add missing noTablesOnMobile.css to vanilla and bootswatch configs
         */
        if ($iOldDBVersion < 428) {
            $oTransaction = $oDB->beginTransaction();
            // Update vanilla config
            $oDB->createCommand()->update(
                '{{template_configuration}}',
                [
                    'files_css' => '{"add":["css/base.css","css/theme.css","css/custom.css","css/noTablesOnMobile.css"]}',
                ],
                "template_name = 'vanilla' AND files_css != 'inherit'"
            );
            // Update bootswatch config
            $oDB->createCommand()->update(
                '{{template_configuration}}',
                [
                    'files_css' => '{"add":["css/base.css","css/theme.css","css/custom.css","css/noTablesOnMobile.css"]}',
                ],
                "template_name = 'bootswatch' AND files_css != 'inherit'"
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 428), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        /** THIS CAME FROM MASTER **/
        //~ if ($iOldDBVersion < 429) {
        //~ $oTransaction = $oDB->beginTransaction();
        //~ extendDatafields429($oDB); // Do it again for people already using 4.x before this was introduced
        //~ $oDB->createCommand()->update('{{settings_global}}', ['stg_value'=>429], "stg_name='DBVersion'");
        //~ $oTransaction->commit();
        //~ }

        if ($iOldDBVersion < 429) {
            // Update the Resources Entry in Survey Menu Entries (cause of refactoring resources controller)
            $oTransaction = $oDB->beginTransaction();
            extendDatafields429($oDB); // Do it again for people already using 4.x before this was introduced
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'menu_link' => '',
                    'action' => 'updatesurveylocalesettings',
                    'template' => 'editLocalSettings_main_view',
                    'partial' => '/admin/survey/subview/accordion/_resources_panel',
                    'getdatamethod' => 'tabResourceManagement'
                ),
                "name='resources'"
            );

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 429), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 430) { //REFACTORING surveyadmin to surveyAdministrationController ...
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->insert(
                "{{plugins}}",
                [
                    'name' => 'ComfortUpdateChecker',
                    'plugin_type' => 'core',
                    'active' => 1,
                    'version' => '1.0.0',
                    'load_error' => 0,
                    'load_error_message' => null
                ]
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 430), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Re-add question organizer menu entry
         */
        if ($iOldDBVersion < 431) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update(
                '{{boxes}}',
                array(
                    'url' => 'surveyAdministration/listsurveys',
                ),
                "url='admin/survey/sa/listsurveys'"
            );
            $oDB->createCommand()->update(
                '{{boxes}}',
                array(
                    'url' => 'surveyAdministration/newSurvey',
                ),
                "url='admin/survey/sa/newSurvey'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'name' => 'listQuestionGroups',
                    'menu_link' => 'questionGroupsAdministration/listquestiongroups',
                ),
                "name='listSurveyGroups'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'menu_link' => 'questionAdministration/listQuestions',
                ),
                "name='listQuestions'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'menu_link' => 'surveyAdministration/view',
                ),
                "name='overview'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'menu_link' => 'surveyAdministration/activate',
                ),
                "name='activateSurvey'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'menu_link' => 'surveyAdministration/deactivate',
                ),
                "name='deactivateSurvey'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'getdatamethod' => 'generalTabEditSurvey',
                ),
                "name='generalsettings'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'getdatamethod' => 'getTextEditData',
                ),
                "name='surveytexts'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'getdatamethod' => 'getDataSecurityEditData',
                ),
                "name='datasecurity'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'getdatamethod' => 'tabPresentationNavigation',
                ),
                "name='presentation'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'getdatamethod' => 'tabTokens',
                ),
                "name='tokens'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'getdatamethod' => 'tabNotificationDataManagement',
                ),
                "name='notification'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'getdatamethod' => 'tabPublicationAccess',
                ),
                "name='publication'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'getdatamethod' => 'tabPanelIntegration',
                ),
                "name='panelintegration'"
            );
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'getdatamethod' => 'pluginTabSurvey',
                ),
                "name='plugins'"
            );


            $aDefaultSurveyMenuEntries = LsDefaultDataSets::getSurveyMenuEntryData();
            foreach ($aDefaultSurveyMenuEntries as $aSurveymenuentry) {
                if ($aSurveymenuentry['name'] == 'reorder') {
                    if (SurveymenuEntries::model()->findByAttributes(['name' => $aSurveymenuentry['name']]) == null) {
                        $oDB->createCommand()->insert('{{surveymenu_entries}}', $aSurveymenuentry);
                        SurveymenuEntries::reorderMenu(2);
                    }
                    break;
                }
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 431), "stg_name='DBVersion'");
            $oTransaction->commit();
        }


        if ($iOldDBVersion < 432) {
            // Update 'Theme Options' Entry (Side Menu Link) in Survey Menu Entries.
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'menu_link' => 'themeOptions/updateSurvey',
                    'data' => '{"render": {"link": { "pjaxed": true, "data": {"sid": ["survey","sid"], "gsid":["survey","gsid"]}}}}'
                ),
                "name='theme_options'"
            );

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 432), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /*
         * Correct permission for survey menu Survey Participants (tokens, not surveysettings).
         * This is a copy of DBVersion 363 so this might have been already set
         */
        if ($iOldDBVersion < 433) {
            $oTransaction = $oDB->beginTransaction();
            $aTableNames = dbGetTablesLike("tokens%");
            $oDB = Yii::app()->getDb();
            foreach ($aTableNames as $sTableName) {
                try {
                    setTransactionBookmark();
                    switch (Yii::app()->db->driverName) {
                        case 'mysql':
                        case 'mysqli':
                            try {
                                setTransactionBookmark();
                                $oDB->createCommand()->createIndex('idx_email', $sTableName, 'email(30)', false);
                            } catch (Exception $e) {
                                rollBackToTransactionBookmark();
                            }
                            break;
                        case 'pgsql':
                            try {
                                setTransactionBookmark();
                                $oDB->createCommand()->createIndex('idx_email', $sTableName, 'email', false);
                            } catch (Exception $e) {
                                rollBackToTransactionBookmark();
                            }
                            break;
                        // MSSQL does not support indexes on text fields so no dice
                    }
                } catch (Exception $e) {
                    rollBackToTransactionBookmark();
                }
            }
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 433], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Implemented default value for user administration global settings
         */
        if ($iOldDBVersion < 434) {
            $oTransaction = $oDB->beginTransaction();
            $defaultSetting = LsDefaultDataSets::getDefaultUserAdministrationSettings();

            $oDB->createCommand()->delete('{{settings_global}}', 'stg_name=:name', [':name' => 'sendadmincreationemail']);
            $oDB->createCommand()->delete('{{settings_global}}', 'stg_name=:name', [':name' => 'admincreationemailsubject']);
            $oDB->createCommand()->delete('{{settings_global}}', 'stg_name=:name', [':name' => 'admincreationemailtemplate']);

            $oDB->createCommand()->insert(
                '{{settings_global}}',
                [
                    "stg_name" => 'sendadmincreationemail',
                    "stg_value" => $defaultSetting['sendadmincreationemail'],
                ]
            );

            $oDB->createCommand()->insert(
                '{{settings_global}}',
                [
                    "stg_name" => 'admincreationemailsubject',
                    "stg_value" => $defaultSetting['admincreationemailsubject'],
                ]
            );

            $oDB->createCommand()->insert(
                '{{settings_global}}',
                [
                    "stg_name" => 'admincreationemailtemplate',
                    "stg_value" => $defaultSetting['admincreationemailtemplate'],
                ]
            );

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 434], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /* Add public boolean to surveygroup : view forl all in list */
        if ($iOldDBVersion < 435) {
            $oTransaction = $oDB->beginTransaction();
            // Check if default survey groups exists - at some point it was possible to delete it
            $defaultSurveyGroupExists = $oDB->createCommand()
            ->select('gsid')
            ->from("{{surveys_groups}}")
            ->where('gsid = 1')
            ->queryScalar();
            if ($defaultSurveyGroupExists == false) {
                // Add missing default template
                $date = date("Y-m-d H:i:s");
                $oDB->createCommand()->insert('{{surveys_groups}}', array(
                    'gsid'        => 1,
                    'name'        => 'default',
                    'title'       => 'Default',
                    'description' => 'Default survey group',
                    'sortorder'   => '0',
                    'owner_id'   => '1',
                    'created'     => $date,
                    'modified'    => $date,
                    'created_by'  => '1'
                ));
            }
            $oDB->createCommand()->addColumn('{{surveys_groups}}', 'alwaysavailable', "boolean NULL");
            $oDB->createCommand()->update(
                '{{surveys_groups}}',
                array(
                    'alwaysavailable' => '0',
                )
            );
            $oDB->createCommand()->update(
                '{{surveys_groups}}',
                array(
                    'alwaysavailable' => '0',
                ),
                "gsid=1"
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 435), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 436) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->update('{{boxes}}', array('url' => 'themeOptions'), "url='admin/themeoptions'");
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 436), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 437) {
            $oTransaction = $oDB->beginTransaction();
            //refactore controller assessment (surveymenu_entry link changes to new controller rout)
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                array(
                    'menu_link' => 'assessment/index',
                ),
                "name='assessments'"
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 437), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 438) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'hidden' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'hidden' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'statistics_showgraph' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'statistics_showgraph' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'public_statistics' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'public_statistics' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'page_break' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'page_break' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'other_numbers_only' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'other_numbers_only' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'other_comment_mandatory' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'other_comment_mandatory' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'hide_tip' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'hide_tip' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'exclude_all_others_auto' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'exclude_all_others_auto' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'commented_checkbox_auto' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'commented_checkbox_auto' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'num_value_int_only' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'num_value_int_only' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'alphasort' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'alphasort' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'use_dropdown' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'use_dropdown' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'num_value_int_only' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'num_value_int_only' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'slider_default_set' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'slider_default_set' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'slider_layout' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'slider_layout' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'slider_middlestart' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'slider_middlestart' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'slider_reset' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'slider_reset' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'slider_reversed' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'slider_reversed' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'slider_showminmax' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'slider_showminmax' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'value_range_allows_missing' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'value_range_allows_missing' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'multiflexible_checkbox' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'multiflexible_checkbox' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'reverse' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'reverse' and value = 'N'"
            );

            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '1'),
                "attribute = 'input_boxes' and value = 'Y'"
            );
            $oDB->createCommand()->update(
                '{{question_attributes}}',
                array('value' => '0'),
                "attribute = 'input_boxes' and value = 'N'"
            );


            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 438), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 439) {
            $oTransaction = $oDB->beginTransaction();

            // Some tables were renamed in dbversion 400 - their sequence needs to be fixed in Postgres
            if (Yii::app()->db->driverName == 'pgsql') {
                fixPostgresSequence('questions');
                fixPostgresSequence('groups');
                fixPostgresSequence('answers');
                fixPostgresSequence('labels');
                fixPostgresSequence('defaultvalues');
            }
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 439), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 440) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->createIndex('sess_expire', '{{sessions}}', 'expire');
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 440], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 441) {
            $oTransaction = $oDB->beginTransaction();
            // Convert old html editor modes if present in global settings
            $oDB->createCommand()->update(
                '{{settings_global}}',
                array(
                    'stg_value' => 'inline',
                ),
                "stg_name='defaulthtmleditormode' AND stg_value='wysiwyg'"
            );
            $oDB->createCommand()->update(
                '{{settings_global}}',
                array(
                    'stg_value' => 'none',
                ),
                "stg_name='defaulthtmleditormode' AND stg_value='source'"
            );
            // Convert old html editor modes if present in profile settings
            $oDB->createCommand()->update(
                '{{users}}',
                array(
                    'htmleditormode' => 'inline',
                ),
                "htmleditormode='wysiwyg'"
            );
            $oDB->createCommand()->update(
                '{{users}}',
                array(
                    'htmleditormode' => 'none',
                ),
                "htmleditormode='source'"
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 441), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 442) {
            $oTransaction = $oDB->beginTransaction();
            $questionTheme = new QuestionTheme();
            $questionsMetaData = $questionTheme->getAllQuestionMetaData(false, false, true)['available_themes'];
            foreach ($questionsMetaData as $questionMetaData) {
                $oDB->createCommand()->update(
                    '{{question_themes}}',
                    ['image_path' => $questionMetaData['image_path']],
                    "name = :name AND extends = :extends AND theme_type = :type",
                    [
                        "name" => $questionMetaData['name'],
                        "extends" => $questionMetaData['questionType'],
                        "type" => $questionMetaData['type']
                    ]
                );
            }
            $oDB->createCommand()->insert(
                "{{plugins}}",
                [
                    'name' => 'TwoFactorAdminLogin',
                    'plugin_type' => 'core',
                    'active' => 0,
                    'version' => '1.2.5',
                    'load_error' => 0,
                    'load_error_message' => null
                ]
            );
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 442), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 443) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand()->renameColumn('{{users}}', 'lastLogin', 'last_login');
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 443), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 444) {
            $oTransaction = $oDB->beginTransaction();
            // Delete duplicate template configurations
            $deleteQuery = "DELETE FROM {{template_configuration}}
                WHERE id NOT IN (
                    SELECT id FROM (
                        SELECT MIN(id) as id
                            FROM {{template_configuration}} t 
                            GROUP BY t.template_name, t.sid, t.gsid, t.uid
                    ) x
                )";
            $oDB->createCommand($deleteQuery)->execute();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 444), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 445) {
            $oTransaction = $oDB->beginTransaction();

            $table = '{{surveymenu_entries}}';
            $data_to_be_updated = [
                'data' => '{"render": {"isActive": false, "link": {"data": {"iSurveyID": ["survey","sid"]}}}}',
            ];
            $where = "name = 'activateSurvey'";
            $oDB->createCommand()->update(
                $table,
                $data_to_be_updated,
                $where
            );

            // Increase Database version
            $oDB->createCommand()->update(
                '{{settings_global}}',
                array('stg_value' => 445),
                "stg_name = 'DBVersion'"
            );

            $oTransaction->commit();
        }

        if ($iOldDBVersion < 446) {
            $oTransaction = $oDB->beginTransaction();
            // archived_table_settings
            $oDB->createCommand()->createTable(
                '{{archived_table_settings}}',
                [
                    'id' => "pk",
                    'survey_id' => "int NOT NULL",
                    'user_id' => "int NOT NULL",
                    'tbl_name' => "string(255) NOT NULL",
                    'tbl_type' => "string(10) NOT NULL",
                    'created' => "datetime NOT NULL",
                    'properties' => "text NOT NULL",
                ],
                $options
            );
            upgradeArchivedTableSettings446();

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 446), "stg_name='DBVersion'");

            $oTransaction->commit();
        }

        if ($iOldDBVersion < 447) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->addColumn('{{users}}', 'validation_key', 'string(38)');
            $oDB->createCommand()->addColumn('{{users}}', 'validation_key_expiration', 'datetime');

            //override existing email text (take out password there)
            $sqlGetAdminCreationEmailTemplat = "SELECT stg_value FROM {{settings_global}} WHERE stg_name='admincreationemailtemplate'";
            $adminCreationEmailTemplateValue = $oDB->createCommand($sqlGetAdminCreationEmailTemplat)->queryAll();
            if ($adminCreationEmailTemplateValue) {
                if ($adminCreationEmailTemplateValue[0]['stg_value'] === null || $adminCreationEmailTemplateValue[0]['stg_value'] === '') {
                    // if text in admincreationemailtemplate is empty use the default from LsDafaultDataSets
                    $defaultCreationEmailContent = LsDefaultDataSets::getDefaultUserAdministrationSettings();
                    $replaceValue = $defaultCreationEmailContent['admincreationemailtemplate'];
                } else { // if not empty replace PASSWORD with *** and write it back to DB
                    $replaceValue = str_replace('PASSWORD', '***', $adminCreationEmailTemplateValue[0]['stg_value']);
                }
                $oDB->createCommand()->update(
                    '{{settings_global}}',
                    array('stg_value' => $replaceValue),
                    "stg_name='admincreationemailtemplate'"
                );
            }

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 447), "stg_name='DBVersion'");
            $oTransaction->commit();
        }


        if ($iOldDBVersion < 448) {
            $oTransaction = $oDB->beginTransaction();
            $oDB->createCommand('UPDATE {{question_themes}} SET settings=\'{"subquestions":"1","answerscales":"2","hasdefaultvalues":"0","assessable":"1","class":"array-flexible-dual-scale"}\' WHERE name=\'arrays/dualscale\'')->execute();
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 448), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 449) {
            $oTransaction = $oDB->beginTransaction();

            //updating the default values for htmleditor
            //surveys_groupsettings htmlemail should be 'Y'
            alterColumn('{{surveys_groupsettings}}', 'htmlemail', 'string(1)', false, 'Y');
            alterColumn('{{surveys}}', 'htmlemail', 'string(1)', false, 'Y');

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 449), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 450) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->addColumn('{{archived_table_settings}}', 'attributes', 'text NULL');
            $archivedTableSettings = Yii::app()->db->createCommand("SELECT * FROM {{archived_table_settings}}")->queryAll();
            foreach ($archivedTableSettings as $archivedTableSetting) {
                if ($archivedTableSetting['tbl_type'] === 'token') {
                    $oDB->createCommand()->update('{{archived_table_settings}}', ['attributes' => json_encode(['unknown'])], 'id = :id', ['id' => $archivedTableSetting['id']]);
                }
            }
            // When encryptionkeypair is empty, encryption was never used (user comes from LS3), so it's safe to skip this udpate.
            if (!empty(Yii::app()->getConfig('encryptionkeypair'))) {
                updateEncryptedValues450($oDB);
            }

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 450], "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 451) {
            $oTransaction = $oDB->beginTransaction();

            // When encryptionkeypair is empty, encryption was never used (user comes from LS3), so it's safe to skip this udpate.
            if (!empty(Yii::app()->getConfig('encryptionkeypair'))) {
                // update wrongly encrypted custom attribute values for cpdb participants
                $encryptedAttributes = $oDB->createCommand()
                    ->select('attribute_id')
                    ->from('{{participant_attribute_names}}')
                    ->where('encrypted = :encrypted AND core_attribute <> :core_attribute', ['encrypted' => 'Y', 'core_attribute' => 'Y'])
                    ->queryAll();
                $nrOfAttributes = count($encryptedAttributes);
                foreach ($encryptedAttributes as $encryptedAttribute) {
                    $attributes = $oDB->createCommand()
                        ->select('*')
                        ->from('{{participant_attribute}}')
                        ->where('attribute_id = :attribute_id', ['attribute_id' => $encryptedAttribute['attribute_id']])
                        ->queryAll();
                    foreach ($attributes as $attribute) {
                        $attributeValue = LSActiveRecord::decryptSingle($attribute['value']);
                        // This extra decrypt loop is needed because of wrongly encrypted attributes.
                        // @see d1eb8afbc8eb010104f94e143173f7d8802c607d
                        for ($i = 1; $i < $nrOfAttributes; $i++) {
                            $attributeValue = LSActiveRecord::decryptSingleOld($attributeValue);
                        }
                        $recryptedValue = LSActiveRecord::encryptSingle($attributeValue);
                        $updateArray['value'] = $recryptedValue;
                        $oDB->createCommand()->update(
                            '{{participant_attribute}}',
                            $updateArray,
                            'participant_id = :participant_id AND attribute_id = :attribute_id',
                            ['participant_id' => $attribute['participant_id'], 'attribute_id' => $attribute['attribute_id']]
                        );
                    }
                }
            }
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 451], "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 452) {
            $oTransaction = $oDB->beginTransaction();

            // When encryptionkeypair is empty, encryption was never used (user comes from LS3), so it's safe to skip this udpate.
            if (!empty(Yii::app()->getConfig('encryptionkeypair'))) {
                // update encryption for smtppassword
                $emailsmtppassword = $oDB->createCommand()
                    ->select('*')
                    ->from('{{settings_global}}')
                    ->where('stg_name = :stg_name', ['stg_name' => 'emailsmtppassword'])
                    ->queryRow();
                if ($emailsmtppassword && !empty($emailsmtppassword['stg_value']) && $emailsmtppassword['stg_value'] !== 'somepassword') {
                    $decryptedValue = LSActiveRecord::decryptSingleOld($emailsmtppassword['stg_value']);
                    $encryptedValue = LSActiveRecord::encryptSingle($decryptedValue);
                    $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => $encryptedValue], "stg_name='emailsmtppassword'");
                }

                // update encryption for bounceaccountpass
                $bounceaccountpass = $oDB->createCommand()
                    ->select('*')
                    ->from('{{settings_global}}')
                    ->where('stg_name = :stg_name', ['stg_name' => 'bounceaccountpass'])
                    ->queryRow();
                if ($bounceaccountpass && !empty($bounceaccountpass['stg_value']) && $bounceaccountpass['stg_value'] !== 'enteredpassword') {
                    $decryptedValue = LSActiveRecord::decryptSingleOld($bounceaccountpass['stg_value']);
                    $encryptedValue = LSActiveRecord::encryptSingle($decryptedValue);
                    $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => $encryptedValue], "stg_name='bounceaccountpass'");
                }
            }

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 452], "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 453) {
            $oTransaction = $oDB->beginTransaction();

            $columnSchema = $oDB->getSchema()->getTable('{{archived_table_settings}}')->getColumn('attributes');
            if ($columnSchema === null) {
                $oDB->createCommand()->addColumn('{{archived_table_settings}}', 'attributes', 'text NULL');
            }
            $archivedTableSettings = Yii::app()->db->createCommand("SELECT * FROM {{archived_table_settings}}")->queryAll();
            foreach ($archivedTableSettings as $archivedTableSetting) {
                if ($archivedTableSetting['tbl_type'] === 'token') {
                    $oDB->createCommand()->update('{{archived_table_settings}}', ['attributes' => json_encode(['unknown'])], 'id = :id', ['id' => $archivedTableSetting['id']]);
                }
            }

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 453], "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 460) { //ExportSPSSsav plugin
            $oTransaction = $oDB->beginTransaction();
            $installedPlugins = array_map(
                function ($v) {
                    return $v['name'];
                },
                $oDB->createCommand('SELECT name FROM {{plugins}}')->queryAll()
            );
            /**
             * @param string $name Name of plugin
             * @param int $active
             */
            $insertPlugin = function ($name, $active = 0) use ($installedPlugins, $oDB) {
                if (!in_array($name, $installedPlugins)) {
                    $oDB->createCommand()->insert(
                        "{{plugins}}",
                        [
                            'name'               => $name,
                            'plugin_type'        => 'core',
                            'active'             => $active,
                            'version'            => '1.0.0',
                            'load_error'         => 0,
                            'load_error_message' => null
                        ]
                    );
                } else {
                    $oDB->createCommand()->update(
                        "{{plugins}}",
                        [
                            'plugin_type' => 'core',
                            'version'     => '1.0.0',
                        ],
                        App()->db->quoteColumnName('name') . " = " . dbQuoteAll($name)
                    );
                }
            };
            $insertPlugin('ExportSPSSsav', 1);
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 460], "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 470) {
            $oTransaction = $oDB->beginTransaction();
            // Add the new column to questions table
            $oDB->createCommand()->addColumn('{{questions}}', 'question_theme_name', 'string(150) NULL');
            switch (Yii::app()->db->driverName) {
                case 'sqlsrv':
                case 'dblib':
                case 'mssql':
                    $updateExtendedQuery = "UPDATE q SET q.question_theme_name = qt.value
                        FROM {{questions}} q
                        LEFT JOIN {{question_attributes}} qt ON qt.qid = q.qid AND qt.attribute = 'question_template' 
                        WHERE qt.value IS NOT NULL AND qt.value <> 'core' AND qt.value <> ''";
                    $updateCoreQuery = "UPDATE q SET q.question_theme_name = qt.name
                        FROM {{questions}} q
                        LEFT JOIN {{question_themes}} qt ON qt.question_type = q.type AND qt.core_theme = 1 AND qt.extends = ''
                        WHERE q.question_theme_name IS NULL";
                    $updateUserSettingsQuery = "UPDATE su SET stg_value = qt.name
                        FROM {{settings_user}} su
                        JOIN {{settings_user}} su2 ON su2.uid = su.uid AND su2.stg_name = 'preselectquestiontype'
                        JOIN {{question_themes}} qt ON qt.question_type = su2.stg_value
                        WHERE su.stg_name = 'preselectquestiontheme' AND su.stg_value = 'core'";
                    break;
                case 'pgsql':
                    $updateExtendedQuery = "UPDATE {{questions}} q SET question_theme_name = qt.value
                        FROM {{questions}} q2
                        LEFT JOIN {{question_attributes}} qt ON qt.qid = q2.qid AND qt.attribute = 'question_template' 
                        WHERE qt.value IS NOT NULL AND qt.value <> 'core' AND qt.value <> '' AND q.qid = q2.qid";
                    $updateCoreQuery = "UPDATE {{questions}} q SET question_theme_name = qt.name
                        FROM {{questions}} q2
                        LEFT JOIN {{question_themes}} qt ON qt.question_type = q2.type AND qt.core_theme = true AND qt.extends = ''
                        WHERE q.question_theme_name IS NULL AND q.qid = q2.qid";
                    $updateUserSettingsQuery = "UPDATE {{settings_user}} su SET stg_value = qt.name
                        FROM {{settings_user}} su1
                        JOIN {{settings_user}} su2 ON su2.uid = su1.uid AND su2.stg_name = 'preselectquestiontype'
                        JOIN {{question_themes}} qt ON qt.question_type = su2.stg_value
                        WHERE su1.stg_name = 'preselectquestiontheme' AND su1.stg_value = 'core' AND su.id = su1.id";
                    break;
                default:
                    $updateExtendedQuery = "UPDATE {{questions}} q LEFT JOIN {{question_attributes}} qt ON qt.qid = q.qid AND qt.attribute = 'question_template'
                        SET q.question_theme_name = qt.value 
                        WHERE qt.value IS NOT NULL AND qt.value <> 'core' AND qt.value <> ''";
                    $updateCoreQuery = "UPDATE {{questions}} q LEFT JOIN {{question_themes}} qt ON qt.question_type = q.type AND qt.core_theme = 1 AND qt.extends = ''
                        SET q.question_theme_name = qt.name 
                        WHERE q.question_theme_name IS NULL";
                    $updateUserSettingsQuery = "UPDATE {{settings_user}} su
                        JOIN {{settings_user}} su2 ON su2.uid = su.uid AND su2.stg_name = 'preselectquestiontype'
                        JOIN {{question_themes}} qt ON qt.question_type = su2.stg_value
                        SET su.stg_value = qt.name
                        WHERE su.stg_name = 'preselectquestiontheme' AND su.stg_value = 'core'";
            }

            // Fill column from question_attributes when it's not null or 'core'
            $oDB->createCommand($updateExtendedQuery)->execute();
            // Fill null question_theme_name values using the proper theme name
            $oDB->createCommand($updateCoreQuery)->execute();
            // Also update 'preselectquestiontheme' user settings where the value is 'core'
            $oDB->createCommand($updateUserSettingsQuery)->execute();

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 470), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 471) {
            $oTransaction = $oDB->beginTransaction();

            $fixedTitles = [
                '5pointchoice' => '5 point choice',
                'arrays/10point' => 'Array (10 point choice)',
                'arrays/5point' => 'Array (5 point choice)',
                'hugefreetext' => 'Huge free text',
                'multiplenumeric' => 'Multiple numerical input',
                'multipleshorttext' => 'Multiple short text',
                'numerical' => 'Numerical input',
                'shortfreetext' => 'Short free text',
                'image_select-listradio' => 'Image select list (Radio)',
                'image_select-multiplechoice' => 'Image select multiple choice',
                'ranking_advanced' => 'Ranking advanced'
            ];

            foreach ($fixedTitles as $themeName => $newTitle) {
                $oDB->createCommand()->update('{{question_themes}}', array('title' => $newTitle), "name='$themeName'");
            }

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 471), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 472) {
            $oTransaction = $oDB->beginTransaction();

            $oDB->createCommand()->addColumn('{{users}}', 'last_forgot_email_password', 'datetime');

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 472), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Loop through all plugins in core folder and make sure they have the correct plugin type.
         *
         * @todo What if a plugin is both in user and core?
         * @todo Add integrity test when plugin manager is opened.
         */
        if ($iOldDBVersion < 473) {
            $oTransaction = $oDB->beginTransaction();
            $dir = new DirectoryIterator(APPPATH . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'plugins');
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot()) {
                    $plugin = $oDB->createCommand()
                        ->select('*')
                        ->from('{{plugins}}')
                        ->where("name = :name", [':name' => $fileinfo->getFilename()])
                        ->queryRow();

                    if (!empty($plugin)) {
                        if ($plugin['plugin_type'] !== 'core') {
                            $oDB->createCommand()->update(
                                '{{plugins}}',
                                ['plugin_type' => 'core'],
                                'name = :name',
                                [':name' => $plugin->name]
                            );
                        }
                    } else {
                        // Plugin in folder but not in database?
                    }
                }
            }

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 473), "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        // 474 was left out for technical reasons
        if ($iOldDBVersion < 475) {
            $oTransaction = $oDB->beginTransaction();
            // Apply integrity fix before adding unique constraint.
            // List of label set ids which contain code duplicates.
            $lids = $oDB->createCommand(
                "SELECT {{labels}}.lid AS lid
                FROM {{labels}}
                GROUP BY {{labels}}.lid
                HAVING COUNT(DISTINCT({{labels}}.code)) < COUNT({{labels}}.id)"
            )->queryAll();
            foreach ($lids as $lid) {
                regenerateLabelCodes400($lid['lid'], $hasLanguageColumn = false);
            }
            $oDB->createCommand()->createIndex('{{idx5_labels}}', '{{labels}}', ['lid','code'], true);
            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 475), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        /**
         * Sanitize theme option paths
         */
        if ($iOldDBVersion < 476) {
            $oTransaction = $oDB->beginTransaction();
            Yii::import('application.helpers.SurveyThemeHelper');
            $templateConfigurations = $oDB->createCommand()->select(['id', 'template_name', 'sid', 'options'])->from('{{template_configuration}}')->queryAll();
            if (!empty($templateConfigurations)) {
                foreach ($templateConfigurations as $templateConfiguration) {
                    $decodedOptions = json_decode($templateConfiguration['options'], true);
                    if (is_array($decodedOptions)) {
                        foreach ($decodedOptions as &$value) {
                            $value = SurveyThemeHelper::sanitizePathInOption($value, $templateConfiguration['template_name'], $templateConfiguration['sid']);
                        }
                        $sanitizedOptions = json_encode($decodedOptions);
                        $oDB->createCommand()->update('{{template_configuration}}', ['options' => $sanitizedOptions], 'id=:id', [':id' => $templateConfiguration['id']]);
                    }
                }
            }

            $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 476), "stg_name='DBVersion'");
            $oTransaction->commit();
        }

        if ($iOldDBVersion < 477) {
            $oTransaction = $oDB->beginTransaction();

            // refactored controller ResponsesController (surveymenu_entry link changes to new controller rout)
            $oDB->createCommand()->update(
                '{{surveymenu_entries}}',
                [
                    'menu_link' => 'responses/browse',
                    'data'      => '{"render": {"isActive": true, "link": {"data": {"surveyId": ["survey", "sid"]}}}}'
                ],
                "name='responses'"
            );
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 477], "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 478) {
            $oTransaction = $oDB->beginTransaction();

            //intentionally left blank to  sync db changes with LimeSurvey Cloud

            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 478], "stg_name='DBVersion'");
            $oTransaction->commit();
        }
        if ($iOldDBVersion < 479) {
            $oTransaction = $oDB->beginTransaction();
            $baseQuestionThemeEntries = LsDefaultDataSets::getBaseQuestionThemeEntries();
            $oDB->createCommand()->update("{{question_themes}}", ['name' => 'bootstrap_buttons_multi'], "name='bootstrap_buttons' and extends='M'");
            foreach ($baseQuestionThemeEntries as $baseQuestionThemeEntry) {
                unset($baseQuestionThemeEntry['visible']);
                $oDB->createCommand()->update("{{question_themes}}", $baseQuestionThemeEntry, 'name=:themename', [':themename' => $baseQuestionThemeEntry['name']]);
            }
            unset($baseQuestionThemeEntries);
            $oDB->createCommand()->update('{{settings_global}}', ['stg_value' => 479], "stg_name='DBVersion'");
            $oTransaction->commit();
        }
    } catch (Exception $e) {
        Yii::app()->setConfig('Updating', false);
        $oTransaction->rollback();
        // Activate schema caching
        $oDB->schemaCachingDuration = 3600;
        // Load all tables of the application in the schema
        $oDB->schema->getTables();
        // clear the cache of all loaded tables
        $oDB->schema->refresh();
        $trace = $e->getTrace();
        $fileInfo = explode('/', $trace[1]['file']);
        $file = end($fileInfo);
        Yii::app()->user->setFlash(
            'error',
            gT('An non-recoverable error happened during the update. Error details:')
            . '<p>'
            . htmlspecialchars($e->getMessage())
            . '</p><br />'
            . sprintf(gT('File %s, line %s.'), $file, $trace[1]['line'])
        );
        // If we're debugging, re-throw the exception.
        if (defined('YII_DEBUG') && YII_DEBUG) {
            throw $e;
        }
        return false;
    }

    // Activate schema cache first - otherwise it won't be refreshed!
    $oDB->schemaCachingDuration = 3600;
    // Load all tables of the application in the schema
    $oDB->schema->getTables();
    // clear the cache of all loaded tables
    $oDB->schema->refresh();
    $oDB->active = false;
    $oDB->active = true;

    // Force User model to refresh meta data (for updates from very old versions)
    User::model()->refreshMetaData();
    Yii::app()->db->schema->getTable('{{surveys}}', true);
    Yii::app()->db->schema->getTable('{{templates}}', true);
    Survey::model()->refreshMetaData();
    Notification::model()->refreshMetaData();

    // Try to clear tmp/runtime (database cache files).
    // Related to problems like https://bugs.limesurvey.org/view.php?id=13699.
    // Some cache implementations may not have 'flush' method. Only call flush if method exists.
    if (method_exists(Yii::app()->cache, 'flush')) {
        Yii::app()->cache->flush();
    }
    // Some cache implementations (ex: CRedisCache, CDummyCache) may not have 'gc' method. Only call gc if method exists.
    if (method_exists(Yii::app()->cache, 'gc')) {
        Yii::app()->cache->gc();
    }

    // Inform superadmin about update
    $superadmins = User::model()->getSuperAdmins();
    $currentDbVersion = $oDB->createCommand()->select('stg_value')->from('{{settings_global}}')->where("stg_name=:stg_name", array('stg_name' => 'DBVersion'))->queryRow();
    // Update the global config object because it is static and set at start of App
    Yii::app()->setConfig('DBVersion', $currentDbVersion['stg_value']);

    Notification::broadcast(array(
        'title' => gT('Database update'),
        'message' => sprintf(gT('The database has been updated from version %s to version %s.'), $iOldDBVersion, $currentDbVersion['stg_value'])
        ), $superadmins);

    fixLanguageConsistencyAllSurveys();

    Yii::app()->setConfig('Updating', false);
    return true;
}

/**
 * Update previous encrpted values to new encryption
 * @param CDbConnection $oDB
 * @throws CException
 */
function updateEncryptedValues450(CDbConnection $oDB)
{
    Yii::app()->sodium;
    // All these functions decrypt and then re-encrypt the values.
    decryptarchivedtables450($oDB);
    decryptResponseTables450($oDB);
    decryptParticipantTables450($oDB);
    decryptCPDBTable450($oDB);
}

/**
 * Update encryption for CPDB participants
 *
 * @param CDbConnection $oDB
 * @return void
 * @throws CException
 */
function decryptCPDBTable450($oDB)
{
    // decrypt CPDB participants
    $CPDBParticipants = $oDB->createCommand()
        ->select('*')
        ->from('{{participants}}')
        ->queryAll();
    $participantAttributeNames = $oDB->createCommand()
        ->select('*')
        ->from('{{participant_attribute_names}}')
        ->queryAll();
    foreach ($CPDBParticipants as $CPDBParticipant) {
        $extraAttributes = $oDB->createCommand()
            ->select('*')
            ->from('{{participant_attribute}}')
            ->where('participant_id =:participant_id', ['participant_id' => $CPDBParticipant['participant_id']])
            ->queryAll();
        $recryptedParticipant = [];
        foreach ($participantAttributeNames as $key => $participantAttributeValue) {
            if ($participantAttributeValue['encrypted'] === 'Y') {
                if ($participantAttributeValue['core_attribute'] === 'N') {
                    foreach ($extraAttributes as $extraAttribute) {
                        if ($extraAttribute['attribute_id'] === $participantAttributeValue['attribute_id']) {
                            $encryptedValue = $extraAttribute['value'];
                            $decrypedParticipantAttribute = LSActiveRecord::decryptSingleOld($encryptedValue);
                            $recryptedParticipantAttribute['value'] = LSActiveRecord::encryptSingle($decrypedParticipantAttribute);
                            $oDB->createCommand()->update('{{participant_attribute}}', $recryptedParticipantAttribute, 'participant_id=' . $oDB->quoteValue($CPDBParticipant['participant_id']) . 'AND attribute_id=' . $oDB->quoteValue($extraAttribute['attribute_id']));
                            break;
                        }
                    }
                } else {
                    $encryptedValue = $CPDBParticipant[$participantAttributeValue['defaultname']];
                    $decrypedParticipantAttribute = LSActiveRecord::decryptSingleOld($encryptedValue);
                    $recryptedParticipant[$participantAttributeValue['defaultname']] = LSActiveRecord::encryptSingle($decrypedParticipantAttribute);
                }
            }
        }
        if ($recryptedParticipant) {
            $oDB->createCommand()->update('{{participants}}', $recryptedParticipant, 'participant_id=' . $oDB->quoteValue($CPDBParticipant['participant_id']));
        }
    }
}

/**
 * Update encryption for survey participants
 * @param CDbConnection $oDB
 * @return void
 */
function decryptParticipantTables450($oDB)
{
    // decrypt survey participants
    $surveys = $oDB->createCommand()
        ->select('*')
        ->from('{{surveys}}')
        ->queryAll();
    foreach ($surveys as $survey) {
        $tableExists = tableExists("{{tokens_{$survey['sid']}}}");
        if (!$tableExists) {
            continue;
        }
        $tableSchema = $oDB->getSchema()->getTable("{{tokens_{$survey['sid']}}}");
        $tokens = $oDB->createCommand()
            ->select('*')
            ->from("{{tokens_{$survey['sid']}}}")
            ->queryAll();
        $tokenencryptionoptions = json_decode($survey['tokenencryptionoptions'], true);

        // default attributes
        if (!empty($tokenencryptionoptions)) {
            foreach ($tokenencryptionoptions['columns'] as $column => $encrypted) {
                $columnEncryptions[$column]['encrypted'] = $encrypted;
            }
        }

        // find custom attribute column names
        $aCustomAttributes = array_filter(array_keys($tableSchema->columns), 'filterForAttributes');

        // custom attributes
        foreach ($aCustomAttributes as $attributeName) {
            if (isset(json_decode($survey['attributedescriptions'])->$attributeName->encrypted)) {
                $columnEncryptions[$attributeName]['encrypted'] = json_decode($survey['attributedescriptions'], true)[$attributeName]['encrypted'];
            } else {
                $columnEncryptions[$attributeName]['encrypted'] = 'N';
            }
        }

        if (isset($columnEncryptions) && $columnEncryptions) {
            foreach ($tokens as $token) {
                $recryptedToken = [];
                foreach ($columnEncryptions as $column => $value) {
                    if ($columnEncryptions[$column]['encrypted'] === 'Y' && isset($token[$column])) {
                        $decryptedTokenColumn = LSActiveRecord::decryptSingleOld($token[$column]);
                        $recryptedToken[$column] = LSActiveRecord::encryptSingle($decryptedTokenColumn);
                    }
                }
                if ($recryptedToken) {
                    $oDB->createCommand()->update("{{tokens_{$survey['sid']}}}", $recryptedToken, 'tid=' . $token['tid']);
                }
            }
        }
    }
}

/**
 * Update encryption for survey responses
 *
 * @param CDbConnection $oDB
 * @return void
 * @throws CException
 */
function decryptResponseTables450($oDB)
{
    $surveys = $oDB->createCommand()
        ->select('*')
        ->from('{{surveys}}')
        ->where('active =:active', ['active' => 'Y'])
        ->queryAll();
    foreach ($surveys as $survey) {
        $tableExists = tableExists("{{survey_{$survey['sid']}}}");
        if (!$tableExists) {
            continue;
        }
        $responsesCount = $oDB->createCommand()
            ->select('count(*)')
            ->from("{{survey_{$survey['sid']}}}")
            ->queryScalar();
        if ($responsesCount) {
            $maxRows = 100;
            $maxPages = ceil($responsesCount / $maxRows);

            for ($i = 0; $i < $maxPages; $i++) {
                $offset = $i * $maxRows;
                $responses = $oDB->createCommand()
                    ->select('*')
                    ->from("{{survey_{$survey['sid']}}}")
                    ->offset($offset)
                    ->limit($maxRows)
                    ->queryAll();
                $fieldmapFields = createFieldMap450($survey);
                foreach ($responses as $response) {
                    $recryptedResponse = [];
                    foreach ($fieldmapFields as $fieldname => $field) {
                        if (array_key_exists('encrypted', $field) && $field['encrypted'] === 'Y') {
                            $decryptedResponseField = LSActiveRecord::decryptSingleOld($response[$fieldname]);
                            $recryptedResponse[$fieldname] = LSActiveRecord::encryptSingle($decryptedResponseField);
                        }
                    }
                    if ($recryptedResponse) {
                        // use createUpdateCommand() because the update() function does not properly escape auto generated params causing errors
                        $criteria = $oDB->getCommandBuilder()->createCriteria('id=:id', ['id' => $response['id']]);
                        $oDB->getCommandBuilder()->createUpdateCommand("{{survey_{$survey['sid']}}}", $recryptedResponse, $criteria)->execute();
                    }
                }
            }
        }
    }
}

/**
 * Update Encryption for archived tables
 *
 * @param CDbConnection $oDB
 * @return void
 * @throws CDbException
 * @throws CException
 */
function decryptArchivedTables450($oDB)
{
    $archivedTablesSettings = $oDB->createCommand('SELECT * FROM {{archived_table_settings}}')->queryAll();
    foreach ($archivedTablesSettings as $archivedTableSettings) {
        $tableExists = tableExists("{{{$archivedTableSettings['tbl_name']}}}");
        if (!$tableExists) {
            continue;
        }
        $archivedTableSettingsProperties = json_decode($archivedTableSettings['properties'], true);
        $archivedTableSettingsAttributes = json_decode($archivedTableSettings['attributes'], true);

        // recrypt tokens
        if ($archivedTableSettings['tbl_type'] === 'token') {
            // skip if the encryption status is unknown, use reset because of mixed array types
            if (!empty($archivedTableSettingsProperties) && reset($archivedTableSettingsProperties) !== 'unknown') {
                $tokenencryptionoptions = $archivedTableSettingsProperties;

                // default attributes
                foreach ($tokenencryptionoptions['columns'] as $column => $encrypted) {
                    $columnEncryptions[$column]['encrypted'] = $encrypted;
                }
            }
            // skip if the encryption status is unknown, use reset because of mixed array types
            if (!empty($archivedTableSettingsAttributes) && reset($archivedTableSettingsAttributes) !== 'unknown') {
                // find custom attribute column names
                $table = tableExists("{{{$archivedTableSettings['tbl_name']}}}");
                if (!$table) {
                    $aCustomAttributes = [];
                } else {
                    $aCustomAttributes = array_filter(array_keys($oDB->schema->getTable("{{{$archivedTableSettings['tbl_name']}}}")->columns), 'filterForAttributes');
                }

                // custom attributes
                foreach ($aCustomAttributes as $attributeName) {
                    if (isset(json_decode($archivedTableSettings['attributes'])->$attributeName->encrypted)) {
                        $columnEncryptions[$attributeName]['encrypted'] = $archivedTableSettingsAttributes[$attributeName]['encrypted'];
                    } else {
                        $columnEncryptions[$attributeName]['encrypted'] = 'N';
                    }
                }
            }
            if (isset($columnEncryptions) && $columnEncryptions) {
                $archivedTableRows = $oDB
                    ->createCommand()
                    ->select('*')
                    ->from("{{{$archivedTableSettings['tbl_name']}}}")
                    ->queryAll();
                foreach ($archivedTableRows as $archivedToken) {
                    $recryptedToken = [];
                    foreach ($columnEncryptions as $column => $value) {
                        if ($value['encrypted'] === 'Y') {
                            $decryptedTokenColumn = LSActiveRecord::decryptSingleOld($archivedToken[$column]);
                            $recryptedToken[$column] = LSActiveRecord::encryptSingle($decryptedTokenColumn);
                        }
                    }
                    if ($recryptedToken) {
                        $oDB->createCommand()->update("{{{$archivedTableSettings['tbl_name']}}}", $recryptedToken, 'tid=' . $archivedToken['tid']);
                    }
                }
            }
        }

        // recrypt responses // skip if the encryption status is unknown, use reset because of mixed array types
        if ($archivedTableSettings['tbl_type'] === 'response' && !empty($archivedTableSettingsProperties) && reset($archivedTableSettingsProperties) !== 'unknown') {
            $responsesCount = $oDB->createCommand()
                ->select('count(*)')
                ->from("{{{$archivedTableSettings['tbl_name']}}}")
                ->queryScalar();
            if ($responsesCount) {
                $responseTableSchema = $oDB->schema->getTable("{{{$archivedTableSettings['tbl_name']}}}");
                $encryptedResponseAttributes = $archivedTableSettingsProperties;

                $fieldMap = [];
                foreach ($responseTableSchema->getColumnNames() as $name) {
                    // Skip id field.
                    if ($name === 'id') {
                        continue;
                    }
                    $fieldMap[$name] = $name;
                }

                $maxRows = 100;
                $maxPages = ceil($responsesCount / $maxRows);
                for ($i = 0; $i < $maxPages; $i++) {
                    $offset = $i * $maxRows;
                    $archivedTableRows = $oDB
                        ->createCommand()
                        ->select('*')
                        ->from("{{{$archivedTableSettings['tbl_name']}}}")
                        ->offset($offset)
                        ->limit($maxRows)
                        ->queryAll();
                    foreach ($archivedTableRows as $archivedResponse) {
                        $recryptedResponseValues = [];
                        foreach ($fieldMap as $column) {
                            if (in_array($column, $encryptedResponseAttributes, false)) {
                                $decryptedColumnValue = LSActiveRecord::decryptSingleOld($archivedResponse[$column]);
                                $recryptedResponseValues[$column] = LSActiveRecord::encryptSingle($decryptedColumnValue);
                            }
                        }
                        if ($recryptedResponseValues) {
                            // use createUpdateCommand() because the update() function does not properly escape auto generated params causing errors
                            $criteria = $oDB->getCommandBuilder()->createCriteria('id=:id', ['id' => $archivedResponse['id']]);
                            $oDB->getCommandBuilder()->createUpdateCommand("{{{$archivedTableSettings['tbl_name']}}}", $recryptedResponseValues, $criteria)->execute();
                        }
                    }
                }
            }
        }
    }
}

/**
 * Returns the fieldmap for responses
 *
 * @param $survey
 * @return array
 * @throws CException
 */
function createFieldMap450($survey): array
{
    // Main query
    $style = 'full';
    $defaultValues = null;
    $quotedGroups = Yii::app()->db->quoteTableName('{{groups}}');
    $aquery = 'SELECT g.*, q.*, gls.*, qls.*, qa.attribute, qa.value'
        . " FROM $quotedGroups g"
        . ' JOIN {{questions}} q on q.gid=g.gid '
        . ' JOIN {{group_l10ns}} gls on gls.gid=g.gid '
        . ' JOIN {{question_l10ns}} qls on qls.qid=q.qid '
        . " LEFT JOIN {{question_attributes}} qa ON qa.qid=q.qid AND qa.attribute='question_template' "
        . " WHERE qls.language='{$survey['language']}' and gls.language='{$survey['language']}' AND"
        . " g.sid={$survey['sid']} AND"
        . ' q.parent_qid=0'
        . ' ORDER BY group_order, question_order';
    $questions = Yii::app()->db->createCommand($aquery)->queryAll();
    $questionSeq = -1; // this is incremental question sequence across all groups
    $groupSeq = -1;
    $_groupOrder = -1;

    //getting all question_types which are NOT extended
    $baseQuestions = Yii::app()->db->createCommand()
        ->select('*')
        ->from('{{question_themes}}')
        ->where('extends = :extends', ['extends' => ''])
        ->queryAll();
    $questionTypeMetaData = [];
    foreach ($baseQuestions as $baseQuestion) {
        $baseQuestion['settings'] = json_decode($baseQuestion['settings']);
        $questionTypeMetaData[$baseQuestion['question_type']] = $baseQuestion;
    }

    foreach ($questions as $arow) {
        //For each question, create the appropriate field(s))

        ++$questionSeq;

        // fix fact that the group_order may have gaps
        if ($_groupOrder !== $arow['group_order']) {
            $_groupOrder = $arow['group_order'];
            ++$groupSeq;
        }
        // Condition indicators are obsolete with EM.  However, they are so tightly coupled into LS code that easider to just set values to 'N' for now and refactor later.
        $conditions = 'N';
        $usedinconditions = 'N';

        // Check if answertable has custom setting for current question
        if (isset($arow['attribute']) && isset($arow['type']) && $arow['attribute'] === 'question_template') {
            // cache the value between function calls
            static $cacheMemo = [];
            $cacheKey = $arow['value'] . '_' . $arow['type'];
            if (isset($cacheMemo[$cacheKey])) {
                $answerColumnDefinition = $cacheMemo[$cacheKey];
            } else {
                if ($arow['value'] === 'core') {
                    $questionTheme = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('{{question_themes}}')
                        ->where('question_type=:question_type AND extends=:extends', ['question_type' => $arow['type'], 'extends' => ''])
                        ->queryAll();
                } else {
                    $questionTheme = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('{{question_themes}}')
                        ->where('name=:name AND question_type=:question_type', ['name' => $arow['value'], 'question_type' => $arow['type']])
                        ->queryAll();
                }

                $answerColumnDefinition = '';
                if (isset($questionTheme['xml_path'])) {
                    if (PHP_VERSION_ID < 80000) {
                        $bOldEntityLoaderState = libxml_disable_entity_loader(true);
                    }
                    $sQuestionConfigFile = file_get_contents(App()->getConfig('rootdir') . DIRECTORY_SEPARATOR . $questionTheme['xml_path'] . DIRECTORY_SEPARATOR . 'config.xml');  // @see: Now that entity loader is disabled, we can't use simplexml_load_file; so we must read the file with file_get_contents and convert it as a string
                    $oQuestionConfig = simplexml_load_string($sQuestionConfigFile);
                    if (isset($oQuestionConfig->metadata->answercolumndefinition)) {
                        $answerColumnDefinition = json_decode(json_encode($oQuestionConfig->metadata->answercolumndefinition), true)[0];
                    }
                    if (PHP_VERSION_ID < 80000) {
                        libxml_disable_entity_loader($bOldEntityLoaderState);
                    }
                }
                $cacheMemo[$cacheKey] = $answerColumnDefinition;
            }
        }

        // Field identifier
        // GXQXSXA
        // G=Group  Q=Question S=Subquestion A=Answer Option
        // If S or A don't exist then set it to 0
        // Implicit (subqestion intermal to a question type) or explicit qubquestions/answer count starts at 1

        // Types "L", "!", "O", "D", "G", "N", "X", "Y", "5", "S", "T", "U"
        $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}";

        if ($questionTypeMetaData[$arow['type']]['settings']->subquestions == 0 && $arow['type'] != Question::QT_R_RANKING && $arow['type'] != Question::QT_VERTICAL_FILE_UPLOAD) {
            if (isset($fieldmap[$fieldname])) {
                $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
            }

            $fieldmap[$fieldname] = ["fieldname" => $fieldname, 'type' => "{$arow['type']}", 'sid' => $survey['sid'], "gid" => $arow['gid'], "qid" => $arow['qid'], "aid" => ""];
            if (isset($answerColumnDefinition)) {
                $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
            }

            if ($style === 'full') {
                $fieldmap[$fieldname]['title'] = $arow['title'];
                $fieldmap[$fieldname]['question'] = $arow['question'];
                $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                $fieldmap[$fieldname]['hasconditions'] = $conditions;
                $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                if (isset($defaultValues[$arow['qid'] . '~0'])) {
                    $fieldmap[$fieldname]['defaultvalue'] = $defaultValues[$arow['qid'] . '~0'];
                }
            }
            switch ($arow['type']) {
                case Question::QT_L_LIST:  //RADIO LIST
                case Question::QT_EXCLAMATION_LIST_DROPDOWN:  //DROPDOWN LIST
                    if ($arow['other'] === 'Y') {
                        $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}other";
                        if (isset($fieldmap[$fieldname])) {
                            $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
                        }

                        $fieldmap[$fieldname] = [
                            "fieldname" => $fieldname,
                            'type'      => $arow['type'],
                            'sid'       => $survey['sid'],
                            "gid"       => $arow['gid'],
                            "qid"       => $arow['qid'],
                            "aid"       => "other"
                        ];
                        if (isset($answerColumnDefinition)) {
                            $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
                        }

                        // dgk bug fix line above. aid should be set to "other" for export to append to the field name in the header line.
                        if ($style === 'full') {
                            $fieldmap[$fieldname]['title'] = $arow['title'];
                            $fieldmap[$fieldname]['question'] = $arow['question'];
                            $fieldmap[$fieldname]['subquestion'] = gT("Other");
                            $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                            $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                            $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                            $fieldmap[$fieldname]['hasconditions'] = $conditions;
                            $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                            $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                            $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                            if (isset($defaultValues[$arow['qid'] . '~other'])) {
                                $fieldmap[$fieldname]['defaultvalue'] = $defaultValues[$arow['qid'] . '~other'];
                            }
                        }
                    }
                    break;
                case Question::QT_O_LIST_WITH_COMMENT: //DROPDOWN LIST WITH COMMENT
                    $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}comment";
                    if (isset($fieldmap[$fieldname])) {
                        $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
                    }

                    $fieldmap[$fieldname] = [
                        "fieldname" => $fieldname,
                        'type'      => $arow['type'],
                        'sid'       => $survey['sid'],
                        "gid"       => $arow['gid'],
                        "qid"       => $arow['qid'],
                        "aid"       => "comment"
                    ];
                    if (isset($answerColumnDefinition)) {
                        $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
                    }

                    // dgk bug fix line below. aid should be set to "comment" for export to append to the field name in the header line. Also needed set the type element correctly.
                    if ($style === 'full') {
                        $fieldmap[$fieldname]['title'] = $arow['title'];
                        $fieldmap[$fieldname]['question'] = $arow['question'];
                        $fieldmap[$fieldname]['subquestion'] = gT("Comment");
                        $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                        $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                        $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                        $fieldmap[$fieldname]['hasconditions'] = $conditions;
                        $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                        $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                        $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                    }
                    break;
            }
        } elseif ($questionTypeMetaData[$arow['type']]['settings']->subquestions == 2 && $questionTypeMetaData[$arow['type']]['settings']->answerscales == 0) {
            //MULTI FLEXI
            $abrows = getSubQuestions($survey['sid'], $arow['qid'], $survey['language']);
            //Now first process scale=1
            $answerset = [];
            $answerList = [];
            foreach ($abrows as $key => $abrow) {
                if ($abrow['scale_id'] == 1) {
                    $answerset[] = $abrow;
                    $answerList[] = [
                        'code'   => $abrow['title'],
                        'answer' => $abrow['question'],
                    ];
                    unset($abrows[$key]);
                }
            }
            reset($abrows);
            foreach ($abrows as $abrow) {
                foreach ($answerset as $answer) {
                    $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}{$abrow['title']}_{$answer['title']}";
                    if (isset($fieldmap[$fieldname])) {
                        $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
                    }
                    $fieldmap[$fieldname] = [
                        "fieldname" => $fieldname,
                        'type'      => $arow['type'],
                        'sid'       => $survey['sid'],
                        "gid"       => $arow['gid'],
                        "qid"       => $arow['qid'],
                        "aid"       => $abrow['title'] . "_" . $answer['title'],
                        "sqid"      => $abrow['qid']
                    ];
                    if (isset($answerColumnDefinition)) {
                        $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
                    }

                    if ($style === 'full') {
                        $fieldmap[$fieldname]['title'] = $arow['title'];
                        $fieldmap[$fieldname]['question'] = $arow['question'];
                        $fieldmap[$fieldname]['subquestion1'] = $abrow['question'];
                        $fieldmap[$fieldname]['subquestion2'] = $answer['question'];
                        $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                        $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                        $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                        $fieldmap[$fieldname]['hasconditions'] = $conditions;
                        $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                        $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                        $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                        $fieldmap[$fieldname]['preg'] = $arow['preg'];
                        $fieldmap[$fieldname]['answerList'] = $answerList;
                        $fieldmap[$fieldname]['SQrelevance'] = $abrow['relevance'];
                    }
                }
            }
            unset($answerset);
        } elseif ($arow['type'] === Question::QT_1_ARRAY_DUAL) {
            $abrows = getSubQuestions($survey['sid'], $arow['qid'], $survey['language']);
            foreach ($abrows as $abrow) {
                $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}{$abrow['title']}#0";
                if (isset($fieldmap[$fieldname])) {
                    $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
                }

                $fieldmap[$fieldname] = ["fieldname" => $fieldname, 'type' => $arow['type'], 'sid' => $survey['sid'], "gid" => $arow['gid'], "qid" => $arow['qid'], "aid" => $abrow['title'], "scale_id" => 0];
                if (isset($answerColumnDefinition)) {
                    $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
                }

                if ($style === 'full') {
                    $fieldmap[$fieldname]['title'] = $arow['title'];
                    $fieldmap[$fieldname]['question'] = $arow['question'];
                    $fieldmap[$fieldname]['subquestion'] = $abrow['question'];
                    $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                    $fieldmap[$fieldname]['scale'] = gT('Scale 1');
                    $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                    $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                    $fieldmap[$fieldname]['hasconditions'] = $conditions;
                    $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                    $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                    $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                    $fieldmap[$fieldname]['SQrelevance'] = $abrow['relevance'];
                }

                $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}{$abrow['title']}#1";
                if (isset($fieldmap[$fieldname])) {
                    $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
                }
                $fieldmap[$fieldname] = ["fieldname" => $fieldname, 'type' => $arow['type'], 'sid' => $survey['sid'], "gid" => $arow['gid'], "qid" => $arow['qid'], "aid" => $abrow['title'], "scale_id" => 1];
                if (isset($answerColumnDefinition)) {
                    $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
                }

                if ($style === 'full') {
                    $fieldmap[$fieldname]['title'] = $arow['title'];
                    $fieldmap[$fieldname]['question'] = $arow['question'];
                    $fieldmap[$fieldname]['subquestion'] = $abrow['question'];
                    $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                    $fieldmap[$fieldname]['scale'] = gT('Scale 2');
                    $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                    $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                    $fieldmap[$fieldname]['hasconditions'] = $conditions;
                    $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                    $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                    $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                }
            }
        } elseif ($arow['type'] === Question::QT_R_RANKING) {
            // Sub question by answer number OR attribute
            $answersCount = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from('{{answers}}')
                ->where('qid = :qid', ['qid' => $arow['qid']])
                ->queryScalar();
            $maxDbAnswer = Yii::app()->db->createCommand()
                ->select('*')
                ->from('{{question_attributes}}')
                ->where("qid = :qid AND attribute = 'max_subquestions'", [':qid' => $arow['qid']])
                ->queryRow();
            $columnsCount = (!$maxDbAnswer || (int)$maxDbAnswer['value'] < 1) ? $answersCount : (int)$maxDbAnswer['value'];
            $columnsCount = min($columnsCount, $answersCount); // Can not be upper than current answers #14899
            for ($i = 1; $i <= $columnsCount; $i++) {
                $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}$i";
                if (isset($fieldmap[$fieldname])) {
                    $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
                }
                $fieldmap[$fieldname] = ["fieldname" => $fieldname, 'type' => $arow['type'], 'sid' => $survey['sid'], "gid" => $arow['gid'], "qid" => $arow['qid'], "aid" => $i];
                if (isset($answerColumnDefinition)) {
                    $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
                }

                if ($style === 'full') {
                    $fieldmap[$fieldname]['title'] = $arow['title'];
                    $fieldmap[$fieldname]['question'] = $arow['question'];
                    $fieldmap[$fieldname]['subquestion'] = sprintf(gT('Rank %s'), $i);
                    $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                    $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                    $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                    $fieldmap[$fieldname]['hasconditions'] = $conditions;
                    $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                    $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                    $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                }
            }
        } elseif ($arow['type'] === Question::QT_VERTICAL_FILE_UPLOAD) {
            $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}";
            $fieldmap[$fieldname] = [
                "fieldname" => $fieldname,
                'type'      => $arow['type'],
                'sid'       => $survey['sid'],
                "gid"       => $arow['gid'],
                "qid"       => $arow['qid'],
                "aid"       => ''
            ];
            if (isset($answerColumnDefinition)) {
                $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
            }

            if ($style === 'full') {
                $fieldmap[$fieldname]['title'] = $arow['title'];
                $fieldmap[$fieldname]['question'] = $arow['question'];
                $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                $fieldmap[$fieldname]['hasconditions'] = $conditions;
                $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
            }
            $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}" . "_filecount";
            $fieldmap[$fieldname] = [
                "fieldname" => $fieldname,
                'type'      => $arow['type'],
                'sid'       => $survey['sid'],
                "gid"       => $arow['gid'],
                "qid"       => $arow['qid'],
                "aid"       => "filecount"
            ];
            if (isset($answerColumnDefinition)) {
                $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
            }

            if ($style === 'full') {
                $fieldmap[$fieldname]['title'] = $arow['title'];
                $fieldmap[$fieldname]['question'] = "filecount - " . $arow['question'];
                $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                $fieldmap[$fieldname]['hasconditions'] = $conditions;
                $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
            }
        } else {
            // Question types with subquestions and one answer per subquestion  (M/A/B/C/E/F/H/P)
            //MULTI ENTRY
            $abrows = getSubQuestions($survey['sid'], $arow['qid'], $survey['language']);
            foreach ($abrows as $abrow) {
                $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}{$abrow['title']}";

                if (isset($fieldmap[$fieldname])) {
                    $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
                }
                $fieldmap[$fieldname] = [
                    "fieldname" => $fieldname,
                    'type'      => $arow['type'],
                    'sid'       => $survey['sid'],
                    'gid'       => $arow['gid'],
                    'qid'       => $arow['qid'],
                    'aid'       => $abrow['title'],
                    'sqid'      => $abrow['qid']
                ];
                if (isset($answerColumnDefinition)) {
                    $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
                }

                if ($style === 'full') {
                    $fieldmap[$fieldname]['title'] = $arow['title'];
                    $fieldmap[$fieldname]['question'] = $arow['question'];
                    $fieldmap[$fieldname]['subquestion'] = $abrow['question'];
                    $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                    $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                    $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                    $fieldmap[$fieldname]['hasconditions'] = $conditions;
                    $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                    $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                    $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                    $fieldmap[$fieldname]['preg'] = $arow['preg'];
                    // get SQrelevance from DB
                    $fieldmap[$fieldname]['SQrelevance'] = $abrow['relevance'];
                    if (isset($defaultValues[$arow['qid'] . '~' . $abrow['qid']])) {
                        $fieldmap[$fieldname]['defaultvalue'] = $defaultValues[$arow['qid'] . '~' . $abrow['qid']];
                    }
                }
                if ($arow['type'] === Question::QT_P_MULTIPLE_CHOICE_WITH_COMMENTS) {
                    $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}{$abrow['title']}comment";
                    if (isset($fieldmap[$fieldname])) {
                        $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
                    }
                    $fieldmap[$fieldname] = ["fieldname" => $fieldname, 'type' => $arow['type'], 'sid' => $survey['sid'], "gid" => $arow['gid'], "qid" => $arow['qid'], "aid" => $abrow['title'] . "comment"];
                    if (isset($answerColumnDefinition)) {
                        $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
                    }
                    if ($style === 'full') {
                        $fieldmap[$fieldname]['title'] = $arow['title'];
                        $fieldmap[$fieldname]['question'] = $arow['question'];
                        $fieldmap[$fieldname]['subquestion1'] = gT('Comment');
                        $fieldmap[$fieldname]['subquestion'] = $abrow['question'];
                        $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                        $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                        $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                        $fieldmap[$fieldname]['hasconditions'] = $conditions;
                        $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                        $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                        $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                    }
                }
            }
            if ($arow['other'] === 'Y' && ($arow['type'] === Question::QT_M_MULTIPLE_CHOICE || $arow['type'] === Question::QT_P_MULTIPLE_CHOICE_WITH_COMMENTS)) {
                $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}other";
                if (isset($fieldmap[$fieldname])) {
                    $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
                }
                $fieldmap[$fieldname] = ["fieldname" => $fieldname, 'type' => $arow['type'], 'sid' => $survey['sid'], "gid" => $arow['gid'], "qid" => $arow['qid'], "aid" => "other"];
                if (isset($answerColumnDefinition)) {
                    $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
                }

                if ($style === 'full') {
                    $fieldmap[$fieldname]['title'] = $arow['title'];
                    $fieldmap[$fieldname]['question'] = $arow['question'];
                    $fieldmap[$fieldname]['subquestion'] = gT('Other');
                    $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                    $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                    $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                    $fieldmap[$fieldname]['hasconditions'] = $conditions;
                    $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                    $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                    $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                    $fieldmap[$fieldname]['other'] = $arow['other'];
                }
                if ($arow['type'] === Question::QT_P_MULTIPLE_CHOICE_WITH_COMMENTS) {
                    $fieldname = "{$arow['sid']}X{$arow['gid']}X{$arow['qid']}othercomment";
                    if (isset($fieldmap[$fieldname])) {
                        $aDuplicateQIDs[$arow['qid']] = ['fieldname' => $fieldname, 'question' => $arow['question'], 'gid' => $arow['gid']];
                    }
                    $fieldmap[$fieldname] = ["fieldname" => $fieldname, 'type' => $arow['type'], 'sid' => $survey['sid'], "gid" => $arow['gid'], "qid" => $arow['qid'], "aid" => "othercomment"];
                    if (isset($answerColumnDefinition)) {
                        $fieldmap[$fieldname]['answertabledefinition'] = $answerColumnDefinition;
                    }

                    if ($style === 'full') {
                        $fieldmap[$fieldname]['title'] = $arow['title'];
                        $fieldmap[$fieldname]['question'] = $arow['question'];
                        $fieldmap[$fieldname]['subquestion'] = gT('Other comment');
                        $fieldmap[$fieldname]['group_name'] = $arow['group_name'];
                        $fieldmap[$fieldname]['mandatory'] = $arow['mandatory'];
                        $fieldmap[$fieldname]['encrypted'] = $arow['encrypted'];
                        $fieldmap[$fieldname]['hasconditions'] = $conditions;
                        $fieldmap[$fieldname]['usedinconditions'] = $usedinconditions;
                        $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
                        $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
                        $fieldmap[$fieldname]['other'] = $arow['other'];
                    }
                }
            }
        }
        if (isset($fieldmap[$fieldname])) {
            //set question relevance (uses last SQ's relevance field for question relevance)
            $fieldmap[$fieldname]['relevance'] = $arow['relevance'];
            $fieldmap[$fieldname]['grelevance'] = $arow['grelevance'];
            $fieldmap[$fieldname]['questionSeq'] = $questionSeq;
            $fieldmap[$fieldname]['groupSeq'] = $groupSeq;
            $fieldmap[$fieldname]['preg'] = $arow['preg'];
            $fieldmap[$fieldname]['other'] = $arow['other'];
            $fieldmap[$fieldname]['help'] = $arow['help'];
            // Set typeName
        } else {
            --$questionSeq; // didn't generate a valid $fieldmap entry, so decrement the question counter to ensure they are sequential
        }

        if (isset($fieldmap[$fieldname]['typename'])) {
            $fieldmap[$fieldname]['typename'] = $typename[$fieldname] = $arow['typename'];
        }
    }
    return $fieldmap;
}

/**
 * Import previously archived tables to ArchivedTableSettings
 *
 * @return void
 * @throws CException
 */
function upgradeArchivedTableSettings446()
{
    $db = Yii::app()->db;
    $DBPrefix = Yii::app()->db->tablePrefix;
    $datestamp = time();
    $DBDate = date('Y-m-d H:i:s', $datestamp);
    // TODO: Inject user model instead. Polling for user will create a session, which breaks on command-line.
    $userID = php_sapi_name() === 'cli' ? null : Yii::app()->user->getId();
    $forcedSuperadmin = Yii::app()->getConfig('forcedsuperadmin');
    $adminUserId = 1;

    if ($forcedSuperadmin && is_array($forcedSuperadmin)) {
        $adminUserId = $forcedSuperadmin[0];
    }
    $query = dbSelectTablesLike('{{old_}}%');
    $archivedTables = Yii::app()->db->createCommand($query)->queryColumn();
    $archivedTableSettings = Yii::app()->db->createCommand("SELECT * FROM {{archived_table_settings}}")->queryAll();
    foreach ($archivedTables as $archivedTable) {
        $tableName = substr($archivedTable, strlen($DBPrefix));
        $tableNameParts = explode('_', $tableName);
        $type = $tableNameParts[1] ?? '';
        $surveyID = $tableNameParts[2] ?? '';
        $typeExtended = $tableNameParts[3] ?? '';
        // skip if table entry allready exists
        foreach ($archivedTableSettings as $archivedTableSetting) {
            if ($archivedTableSetting['tbl_name'] === $tableName) {
                continue 2;
            }
        }

        $newArchivedTableSettings = [
            'survey_id'  => (int)$surveyID,
            'user_id'    => (int)($userID ?? $adminUserId),
            'tbl_name'   => $tableName,
            'created'    => $DBDate,
            'properties' => json_encode(['unknown'])
        ];
        if ($type === 'survey') {
            $newArchivedTableSettings['tbl_type'] = 'response';
            if ($typeExtended === 'timings') {
                $newArchivedTableSettings['tbl_type'] = 'timings';
                $db->createCommand()->insert('{{archived_table_settings}}', $newArchivedTableSettings);
                continue;
            }
            $db->createCommand()->insert('{{archived_table_settings}}', $newArchivedTableSettings);
            continue;
        }
        if ($type === 'tokens') {
            $newArchivedTableSettings['tbl_type'] = 'token';
            $db->createCommand()->insert('{{archived_table_settings}}', $newArchivedTableSettings);
            continue;
        }
    }
}

function extendDatafields429($oDB)
{
    if (Yii::app()->db->driverName == 'mysql' || Yii::app()->db->driverName == 'mysqi') {
        alterColumn('{{answer_l10ns}}', 'answer', "mediumtext", false);
        alterColumn('{{assessments}}', 'message', "mediumtext", false);
        alterColumn('{{group_l10ns}}', 'description', "mediumtext");
        alterColumn('{{notifications}}', 'message', "mediumtext", false);
        alterColumn('{{participant_attribute_values}}', 'value', "mediumtext", false);
        alterColumn('{{plugin_settings}}', 'value', "mediumtext");
        alterColumn('{{question_l10ns}}', 'question', "mediumtext", false);
        alterColumn('{{question_l10ns}}', 'help', "mediumtext");
        alterColumn('{{question_attributes}}', 'value', "mediumtext");
        alterColumn('{{quota_languagesettings}}', 'quotals_message', "mediumtext", false);
        alterColumn('{{settings_global}}', 'stg_value', "mediumtext", false);
        alterColumn('{{settings_user}}', 'stg_value', "mediumtext");
        alterColumn('{{surveymenu_entries}}', 'data', "mediumtext");
        // The following line fixes invalid entries having set 0000-00-00 00:00:00 as date
        $oDB->createCommand()->update('{{surveys}}', ['expires' => null], "expires=0");
        alterColumn('{{surveys}}', 'attributedescriptions', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_description', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_welcometext', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_endtext', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_policy_notice', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_email_invite', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_email_remind', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_email_register', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_email_confirm', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'email_admin_notification', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'email_admin_responses', "mediumtext");
        alterColumn('{{templates}}', 'license', "mediumtext");
        alterColumn('{{templates}}', 'description', "mediumtext");
        alterColumn('{{template_configuration}}', 'cssframework_css', "mediumtext");
        alterColumn('{{template_configuration}}', 'cssframework_js', "mediumtext");
        alterColumn('{{tutorials}}', 'settings', "mediumtext");
        alterColumn('{{tutorial_entries}}', 'content', "mediumtext");
        alterColumn('{{tutorial_entries}}', 'settings', "mediumtext");
    }
            alterColumn('{{surveys}}', 'additional_languages', "text");
}


/**
 * @param string $sMySQLCollation
 */
function upgradeSurveyTables402($sMySQLCollation)
{
    $oDB = Yii::app()->db;
    $oSchema = Yii::app()->db->schema;
    if (Yii::app()->db->driverName != 'pgsql') {
        $aTables = dbGetTablesLike("survey\_%");
        foreach ($aTables as $sTableName) {
            $oTableSchema = $oSchema->getTable($sTableName);
            if (!in_array('token', $oTableSchema->columnNames)) {
                continue;
            }
            removeMysqlZeroDate($sTableName, $oTableSchema, $oDB);
            // No token field in this table
            switch (Yii::app()->db->driverName) {
                case 'sqlsrv':
                case 'dblib':
                case 'mssql':
                    dropSecondaryKeyMSSQL('token', $sTableName);
                    alterColumn($sTableName, 'token', "string(36) COLLATE SQL_Latin1_General_CP1_CS_AS");
                    break;
                case 'mysql':
                    alterColumn($sTableName, 'token', "string(36) COLLATE '{$sMySQLCollation}'");
                    break;
                default:
                    die('Unknown database driver');
            }
        }
    }
}

/**
 * @param string $sMySQLCollation
 */
function upgradeTokenTables402($sMySQLCollation)
{
    $oDB = Yii::app()->db;
    if (Yii::app()->db->driverName != 'pgsql') {
        $aTables = dbGetTablesLike("tokens%");
        if (!empty($aTables)) {
            foreach ($aTables as $sTableName) {
                switch (Yii::app()->db->driverName) {
                    case 'sqlsrv':
                    case 'dblib':
                    case 'mssql':
                        dropSecondaryKeyMSSQL('token', $sTableName);
                        alterColumn($sTableName, 'token', "string(36) COLLATE SQL_Latin1_General_CP1_CS_AS");
                        break;
                    case 'mysql':
                        alterColumn($sTableName, 'token', "string(36) COLLATE '{$sMySQLCollation}'");
                        break;
                    default:
                        die('Unknown database driver');
                }
            }
        }
    }
}

function extendDatafields364($oDB)
{
    if (Yii::app()->db->driverName == 'mysql' || Yii::app()->db->driverName == 'mysqi') {
        alterColumn('{{answers}}', 'answer', "mediumtext", false);
        alterColumn('{{assessments}}', 'message', "mediumtext", false);
        alterColumn('{{groups}}', 'description', "mediumtext");
        alterColumn('{{notifications}}', 'message', "mediumtext", false);
        alterColumn('{{participant_attribute_values}}', 'value', "mediumtext", false);
        alterColumn('{{plugin_settings}}', 'value', "mediumtext");
        alterColumn('{{questions}}', 'question', "mediumtext", false);
        alterColumn('{{questions}}', 'help', "mediumtext");
        alterColumn('{{question_attributes}}', 'value', "mediumtext");
        alterColumn('{{quota_languagesettings}}', 'quotals_message', "mediumtext", false);
        alterColumn('{{settings_global}}', 'stg_value', "mediumtext", false);
        alterColumn('{{settings_user}}', 'stg_value', "mediumtext");
        alterColumn('{{surveymenu_entries}}', 'data', "mediumtext");
        alterColumn('{{surveys}}', 'attributedescriptions', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_description', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_welcometext', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_endtext', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_policy_notice', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_email_invite', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_email_remind', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_email_register', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'surveyls_email_confirm', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'email_admin_notification', "mediumtext");
        alterColumn('{{surveys_languagesettings}}', 'email_admin_responses', "mediumtext");
        alterColumn('{{templates}}', 'license', "mediumtext");
        alterColumn('{{templates}}', 'description', "mediumtext");
        alterColumn('{{template_configuration}}', 'cssframework_css', "mediumtext");
        alterColumn('{{template_configuration}}', 'cssframework_js', "mediumtext");
        alterColumn('{{tutorials}}', 'settings', "mediumtext");
        alterColumn('{{tutorial_entries}}', 'content', "mediumtext");
        alterColumn('{{tutorial_entries}}', 'settings', "mediumtext");
    }
            alterColumn('{{surveys}}', 'additional_languages', "text");
}

function upgradeSurveyTimings350()
{
    $aTables = dbGetTablesLike("%timings");
    foreach ($aTables as $sTable) {
            alterColumn($sTable, 'id', "int", false);
    }
}



/**
 * @param CDbConnection $oDB
 *
 * @return void
 */
function resetTutorials337($oDB)
{
    $oDB->createCommand()->truncateTable('{{tutorials}}');
    $oDB->createCommand()->truncateTable('{{tutorial_entries}}');
    $oDB->createCommand()->truncateTable('{{tutorial_entry_relation}}');
}

/**
* @param CDbConnection $oDB
* @return void
*/
function upgrade333($oDB)
{
    $oDB->createCommand()->createTable('{{map_tutorial_users}}', array(
        'tid' => 'integer NOT NULL',
        'uid' => 'integer NOT NULL',
        'taken' => 'integer DEFAULT 1',
    ));

    $oDB->createCommand()->addPrimaryKey('{{map_tutorial_users_pk}}', '{{map_tutorial_users}}', ['uid', 'tid']);

    $oDB->createCommand()->createTable('{{tutorial_entry_relation}}', array(
        'teid' => 'integer NOT NULL',
        'tid' => 'integer NOT NULL',
        'uid' => 'integer DEFAULT NULL',
        'sid' => 'integer DEFAULT NULL',
    ));

    $oDB->createCommand()->addPrimaryKey('{{tutorial_entry_relation_pk}}', '{{tutorial_entry_relation}}', ['teid', 'tid']);
    $oDB->createCommand()->createIndex('{{idx1_tutorial_entry_relation}}', '{{tutorial_entry_relation}}', 'uid', false);
    $oDB->createCommand()->createIndex('{{idx2_tutorial_entry_relation}}', '{{tutorial_entry_relation}}', 'sid', false);
    $oDB->createCommand()->createIndex('{{idx1_tutorials}}', '{{tutorials}}', 'name', true);

    $oDB->createCommand()->dropColumn('{{tutorial_entries}}', 'tid');
    $oDB->createCommand()->addColumn('{{tutorial_entries}}', 'ordering', 'integer');
}

/**
* @param CDbConnection $oDB
* @return void
*/
function upgrade331($oDB)
{
    $oDB->createCommand()->update('{{templates}}', array(
        'name'        => 'bootswatch',
        'folder'      => 'bootswatch',
        'title'       => 'Bootswatch Theme',
        'description' => '<strong>LimeSurvey Bootwatch Theme</strong><br>Based on BootsWatch Themes: <a href=\'https://bootswatch.com/3/\'>Visit BootsWatch page</a>',
    ), "name='default'");

    $oDB->createCommand()->update('{{templates}}', array(
        'extends' => 'bootswatch',
    ), "extends='default'");

    $oDB->createCommand()->update('{{template_configuration}}', array(
            'template_name'   => 'bootswatch',
    ), "template_name='default'");

    $oDB->createCommand()->update('{{templates}}', array(
        'description' => '<strong>LimeSurvey Material Design Theme</strong><br> A theme based on FezVrasta\'s Material design for Bootstrap 3 <a href=\'https://cdn.rawgit.com/FezVrasta/bootstrap-material-design/gh-pages-v3/index.html\'></a>',
    ), "name='material'");

    $oDB->createCommand()->update('{{templates}}', array(
        'name'        => 'fruity',
        'folder'      => 'fruity',
        'title'       => 'Fruity Theme',
        'description' => '<strong>LimeSurvey Fruity Theme</strong><br>Some color themes for a flexible use. This theme offers many options.',
    ), "name='monochrome'");

    $oDB->createCommand()->update('{{templates}}', array(
        'extends' => 'fruity',
    ), "extends='monochrome'");

    $oDB->createCommand()->update('{{template_configuration}}', array(
            'template_name'   => 'fruity',
    ), "template_name='monochrome'");

    $oDB->createCommand()->update('{{settings_global}}', array('stg_value' => 'fruity'), "stg_name='defaulttheme'");
}

/**
* @param CDbConnection $oDB
* @return void
*/
function upgrade330($oDB)
{
    $oDB->createCommand()->update('{{template_configuration}}', array(
            'files_css'       => '{"add": ["css/animate.css","css/theme.css"]}',
            'files_js'        => '{"add": ["scripts/theme.js", "scripts/ajaxify.js"]}',
            'files_print_css' => '{"add":"css/print_theme.css"}',
    ), "template_name='default' AND  files_css != 'inherit' ");

    $oDB->createCommand()->update('{{template_configuration}}', array(
            'files_css'       => '{"add": ["css/bootstrap-material-design.css", "css/ripples.min.css", "css/theme.css"]}',
            'files_js'        => '{"add": ["scripts/theme.js", "scripts/material.js", "scripts/ripples.min.js", "scripts/ajaxify.js"]}',
            'files_print_css' => '{"add":"css/print_theme.css"}',
    ), "template_name='material' AND  files_css != 'inherit'");

    $oDB->createCommand()->update('{{template_configuration}}', array(
            'files_css'       => '{"add":["css/animate.css","css/ajaxify.css","css/sea_green.css", "css/theme.css"]}',
            'files_js'        => '{"add":["scripts/theme.js","scripts/ajaxify.js"]}',
            'files_print_css' => '{"add":"css/print_theme.css"}',
    ), "template_name='monochrome' AND  files_css != 'inherit'");

    $oDB->createCommand()->update('{{template_configuration}}', array(
            'files_css'         => '{"add":["css/ajaxify.css","css/theme.css","css/custom.css"]}',
            'files_js'          =>  '{"add":["scripts/theme.js","scripts/ajaxify.js","scripts/custom.js"]}',
            'files_print_css'   => '{"add":["css/print_theme.css"]}',
    ), "template_name='vanilla' AND  files_css != 'inherit'");
}

/**
* @param CDbConnection $oDB
* @return void
*/
function upgrade328($oDB)
{
    $oDB->createCommand()->update('{{templates}}', array(
            'description' =>  "<strong>LimeSurvey Advanced Theme</strong><br>A theme with custom options to show what it's possible to do with the new engines. Each theme provider will be able to offer its own option page (loaded from theme)",
    ), "name='default'");
}

/**
* @param CDbConnection $oDB
* @return void
*/
function upgrade327($oDB)
{
    // Update the box value so it uses to the the themeoptions controler
    $oDB->createCommand()->update('{{boxes}}', array(
        'position' =>  '6',
        'url'      =>  'admin/themeoptions',
        'title'    =>  'Themes',
        'ico'      =>  'templates',
        'desc'     =>  'Edit LimeSurvey Themes',
        'page'     =>  'welcome',
        'usergroup' => '-2',
    ), "url='admin/templateoptions'");
}

/**
 * @param CDbConnection $oDB
 */
function transferPasswordFieldToText($oDB)
{
    switch ($oDB->getDriverName()) {
        case 'mysql':
            $oDB->createCommand()->alterColumn('{{users}}', 'password', 'text NOT NULL');
            break;
        case 'pgsql':
            $userPasswords = $oDB->createCommand()->select(['uid', "encode(password::bytea, 'escape') as password"])->from('{{users}}')->queryAll();

            $oDB->createCommand()->renameColumn('{{users}}', 'password', 'password_blob');
            $oDB->createCommand()->addColumn('{{users}}', 'password', "text NOT NULL DEFAULT 'nopw'");

            foreach ($userPasswords as $userArray) {
                $oDB->createCommand()->update('{{users}}', ['password' => $userArray['password']], 'uid=:uid', [':uid' => $userArray['uid']]);
            }

            $oDB->createCommand()->dropColumn('{{users}}', 'password_blob');
            break;
        case 'sqlsrv':
        case 'dblib':
        case 'mssql':
        default:
            break;
    }
}

/**
* @param CDbConnection $oDB
* @return void
*/
function createSurveyMenuTable(CDbConnection $oDB)
{
    // NB: Need to refresh here, since surveymenu table is
    // created in earlier version in same script.
    $oDB->schema->getTables();
    $oDB->schema->refresh();

    // Drop the old surveymenu_entries table.
    if (tableExists('{surveymenu_entries}')) {
        $oDB->createCommand()->dropTable('{{surveymenu_entries}}');
    }

    // Drop the old surveymenu table.
    if (tableExists('{surveymenu}')) {
        $oDB->createCommand()->dropTable('{{surveymenu}}');
    }

    $oDB->createCommand()->createTable('{{surveymenu}}', array(
        'id' => "pk",
        'parent_id' => "integer NULL",
        'survey_id' => "integer NULL",
        'user_id' => "integer NULL",
        'name' => "string(128)",
        'ordering' => "integer NULL DEFAULT '0'",
        'level' => "integer NULL DEFAULT '0'",
        'title' => "string(168)  NOT NULL DEFAULT ''",
        'position' => "string(192)  NOT NULL DEFAULT 'side'",
        'description' => "text ",
        'active' => "integer NOT NULL DEFAULT '0'",
        'showincollapse' =>  "integer DEFAULT 0",
        'changed_at' => "datetime",
        'changed_by' => "integer NOT NULL DEFAULT '0'",
        'created_at' => "datetime",
        'created_by' => "integer NOT NULL DEFAULT '0'",
    ));

    $oDB->createCommand()->createIndex('{{surveymenu_name}}', '{{surveymenu}}', 'name', true);
    $oDB->createCommand()->createIndex('{{idx2_surveymenu}}', '{{surveymenu}}', 'title', false);

    $surveyMenuRowData = LsDefaultDataSets::getSurveyMenuData();
    switchMSSQLIdentityInsert('surveymenu', true);
    foreach ($surveyMenuRowData as $surveyMenuRow) {
        $oDB->createCommand()->insert("{{surveymenu}}", $surveyMenuRow);
    }
    switchMSSQLIdentityInsert('surveymenu', false);

    $oDB->createCommand()->createTable('{{surveymenu_entries}}', array(
        'id' =>  "pk",
        'menu_id' =>  "integer NULL",
        'user_id' =>  "integer NULL",
        'ordering' =>  "integer DEFAULT '0'",
        'name' =>  "string(168)  DEFAULT ''",
        'title' =>  "string(168)  NOT NULL DEFAULT ''",
        'menu_title' =>  "string(168)  NOT NULL DEFAULT ''",
        'menu_description' =>  "text ",
        'menu_icon' =>  "string(192)  NOT NULL DEFAULT ''",
        'menu_icon_type' =>  "string(192)  NOT NULL DEFAULT ''",
        'menu_class' =>  "string(192)  NOT NULL DEFAULT ''",
        'menu_link' =>  "string(192)  NOT NULL DEFAULT ''",
        'action' =>  "string(192)  NOT NULL DEFAULT ''",
        'template' =>  "string(192)  NOT NULL DEFAULT ''",
        'partial' =>  "string(192)  NOT NULL DEFAULT ''",
        'classes' =>  "string(192)  NOT NULL DEFAULT ''",
        'permission' =>  "string(192)  NOT NULL DEFAULT ''",
        'permission_grade' =>  "string(192)  NULL",
        'data' =>  "text ",
        'getdatamethod' =>  "string(192)  NOT NULL DEFAULT ''",
        'language' =>  "string(32)  NOT NULL DEFAULT 'en-GB'",
        'active' =>  "integer NOT NULL DEFAULT '0'",
        'showincollapse' =>  "integer DEFAULT 0",
        'changed_at' =>  "datetime NULL",
        'changed_by' =>  "integer NOT NULL DEFAULT '0'",
        'created_at' =>  "datetime NULL",
        'created_by' =>  "integer NOT NULL DEFAULT '0'",
    ));

    $oDB->createCommand()->createIndex('{{idx1_surveymenu_entries}}', '{{surveymenu_entries}}', 'menu_id', false);
    $oDB->createCommand()->createIndex('{{idx5_surveymenu_entries}}', '{{surveymenu_entries}}', 'menu_title', false);
    $oDB->createCommand()->createIndex('{{surveymenu_entries_name}}', '{{surveymenu_entries}}', 'name', true);

    foreach ($surveyMenuEntryRowData = LsDefaultDataSets::getSurveyMenuEntryData() as $surveyMenuEntryRow) {
        $oDB->createCommand()->insert("{{surveymenu_entries}}", $surveyMenuEntryRow);
    }
}

/**
* @param CDbConnection $oDB
* @return void
*/
function createSurveysGroupSettingsTable(CDbConnection $oDB)
{
    // Drop the old surveys_groupsettings table.
    if (tableExists('{surveys_groupsettings}')) {
        $oDB->createCommand()->dropTable('{{surveys_groupsettings}}');
    }

    // create surveys_groupsettings table
    $oDB->createCommand()->createTable('{{surveys_groupsettings}}', array(
        'gsid' => "integer NOT NULL",
        'owner_id' => "integer NULL DEFAULT NULL",
        'admin' => "string(50) NULL DEFAULT NULL",
        'adminemail' => "string(254) NULL DEFAULT NULL",
        'anonymized' => "string(1) NOT NULL DEFAULT 'N'",
        'format' => "string(1) NULL DEFAULT NULL",
        'savetimings' => "string(1) NOT NULL DEFAULT 'N'",
        'template' => "string(100) NULL DEFAULT 'default'",
        'datestamp' => "string(1) NOT NULL DEFAULT 'N'",
        'usecookie' => "string(1) NOT NULL DEFAULT 'N'",
        'allowregister' => "string(1) NOT NULL DEFAULT 'N'",
        'allowsave' => "string(1) NOT NULL DEFAULT 'Y'",
        'autonumber_start' => "integer NULL DEFAULT '0'",
        'autoredirect' => "string(1) NOT NULL DEFAULT 'N'",
        'allowprev' => "string(1) NOT NULL DEFAULT 'N'",
        'printanswers' => "string(1) NOT NULL DEFAULT 'N'",
        'ipaddr' => "string(1) NOT NULL DEFAULT 'N'",
        'refurl' => "string(1) NOT NULL DEFAULT 'N'",
        'showsurveypolicynotice' => "integer NULL DEFAULT '0'",
        'publicstatistics' => "string(1) NOT NULL DEFAULT 'N'",
        'publicgraphs' => "string(1) NOT NULL DEFAULT 'N'",
        'listpublic' => "string(1) NOT NULL DEFAULT 'N'",
        'htmlemail' => "string(1) NOT NULL DEFAULT 'N'",
        'sendconfirmation' => "string(1) NOT NULL DEFAULT 'Y'",
        'tokenanswerspersistence' => "string(1) NOT NULL DEFAULT 'N'",
        'assessments' => "string(1) NOT NULL DEFAULT 'N'",
        'usecaptcha' => "string(1) NOT NULL DEFAULT 'N'",
        'bounce_email' => "string(254) NULL DEFAULT NULL",
        'attributedescriptions' => "text NULL",
        'emailresponseto' => "text NULL",
        'emailnotificationto' => "text NULL",
        'tokenlength' => "integer NULL DEFAULT '15'",
        'showxquestions' => "string(1) NULL DEFAULT 'Y'",
        'showgroupinfo' => "string(1) NULL DEFAULT 'B'",
        'shownoanswer' => "string(1) NULL DEFAULT 'Y'",
        'showqnumcode' => "string(1) NULL DEFAULT 'X'",
        'showwelcome' => "string(1) NULL DEFAULT 'Y'",
        'showprogress' => "string(1) NULL DEFAULT 'Y'",
        'questionindex' => "integer NULL DEFAULT '0'",
        'navigationdelay' => "integer NULL DEFAULT '0'",
        'nokeyboard' => "string(1) NULL DEFAULT 'N'",
        'alloweditaftercompletion' => "string(1) NULL DEFAULT 'N'"
    ));
    addPrimaryKey('surveys_groupsettings', array('gsid'));

    // insert settings for global level
    $settings1 = new SurveysGroupsettings();
    $settings1->setToDefault();
    $settings1->gsid = 0;
    // get global settings from db
    $globalSetting1 = $oDB->createCommand()->select('stg_value')->from('{{settings_global}}')->where("stg_name=:stg_name", array('stg_name' => 'showqnumcode'))->queryRow();
    $globalSetting2 = $oDB->createCommand()->select('stg_value')->from('{{settings_global}}')->where("stg_name=:stg_name", array('stg_name' => 'showgroupinfo'))->queryRow();
    $globalSetting3 = $oDB->createCommand()->select('stg_value')->from('{{settings_global}}')->where("stg_name=:stg_name", array('stg_name' => 'shownoanswer'))->queryRow();
    $globalSetting4 = $oDB->createCommand()->select('stg_value')->from('{{settings_global}}')->where("stg_name=:stg_name", array('stg_name' => 'showxquestions'))->queryRow();
    // set db values to model
    $settings1->showqnumcode = ($globalSetting1 === false || $globalSetting1['stg_value'] == 'choose') ? 'X' : str_replace(array('both', 'number', 'code', 'none'), array('B', 'N', 'C', 'X'), $globalSetting1['stg_value']);
    $settings1->showgroupinfo = ($globalSetting2 === false || $globalSetting2['stg_value'] == 'choose') ? 'B' : str_replace(array('both', 'name', 'description', 'none'), array('B', 'N', 'D', 'X'), $globalSetting2['stg_value']);
    $settings1->shownoanswer = ($globalSetting3 === false || $globalSetting3['stg_value'] == '2') ? 'Y' : str_replace(array('1', '0'), array('Y', 'N'), $globalSetting3['stg_value']);
    $settings1->showxquestions = ($globalSetting4 === false || $globalSetting4['stg_value'] == 'choose') ? 'Y' : str_replace(array('show', 'hide'), array('Y', 'N'), $globalSetting4['stg_value']);

    // Quick hack to remote ipanonymize.
    // TODO: Don't use models in updatedb_helper.
    $attributes = $settings1->attributes;
    unset($attributes['ipanonymize']);

    $oDB->createCommand()->insert("{{surveys_groupsettings}}", $attributes);

    //this will fail because of using model in updatedb_helper ...
    // insert settings for default survey group
    //$settings2 = new SurveysGroupsettings;
    //$settings2->gsid = 1;
    //$settings2->setToInherit(); //we can not use this function because of ipanonymize (again: never use models in update_helper)

    $attributes2 =  array(
        "gsid" => 1,
        "owner_id" => -1,
        "admin" => "inherit",
        "adminemail" => "inherit",
        "anonymized" => "I",
        "format" => "I",
        "savetimings" => "I",
        "template" => "inherit",
        "datestamp" => "I",
        "usecookie" => "I",
        "allowregister" => "I",
        "allowsave" => "I",
        "autonumber_start" => 0,
        "autoredirect" => "I",
        "allowprev" => "I",
        "printanswers" => "I",
        "ipaddr" => "I",
        "refurl" => "I",
        "showsurveypolicynotice" => 0,
        "publicstatistics" => "I",
        "publicgraphs" => "I",
        "listpublic" => "I",
        "htmlemail" => "I",
        "sendconfirmation" => "I",
        "tokenanswerspersistence" => "I",
        "assessments" => "I",
        "usecaptcha" => "E",
        "bounce_email" => "inherit",
        "attributedescriptions" => null,
        "emailresponseto" => "inherit",
        "emailnotificationto" => "inherit",
        "tokenlength" => -1,
        "showxquestions" => "I",
        "showgroupinfo" => "I",
        "shownoanswer" => "I",
        "showqnumcode" => "I",
        "showwelcome" => "I",
        "showprogress" => "I",
        "questionindex" => -1,
        "navigationdelay" => -1,
        "nokeyboard" => "I",
        "alloweditaftercompletion" => "I",
    );

    $oDB->createCommand()->insert("{{surveys_groupsettings}}", $attributes2);
}
/**
* @param CDbConnection $oDB
* @return void
*/
function createSurveyGroupTables306($oDB)
{
    // Drop the old survey groups table.
    if (tableExists('{surveys_groups}')) {
        $oDB->createCommand()->dropTable('{{surveys_groups}}');
    }


    // Create templates table
    $oDB->createCommand()->createTable('{{surveys_groups}}', array(
        'gsid'        => 'pk',
        'name'        => 'string(45) NOT NULL',
        'title'       => 'string(100) DEFAULT NULL',
        'description' => 'text DEFAULT NULL',
        'sortorder'   => 'integer NOT NULL',
        'owner_uid'   => 'integer DEFAULT NULL',
        'parent_id'   => 'integer DEFAULT NULL',
        'created'     => 'datetime',
        'modified'    => 'datetime',
        'created_by'  => 'integer NOT NULL'
    ));

    // Add default template
    $date = date("Y-m-d H:i:s");
    $oDB->createCommand()->insert('{{surveys_groups}}', array(
        'name'        => 'default',
        'title'       => 'Default Survey Group',
        'description' => 'LimeSurvey core default survey group',
        'sortorder'   => '0',
        'owner_uid'   => '1',
        'created'     => $date,
        'modified'    => $date,
        'created_by'  => '1'
    ));

    $oDB->createCommand()->addColumn('{{surveys}}', 'gsid', "integer DEFAULT 1");
}



/**
* @param CDbConnection $oDB
* @return void
*/
function upgradeTemplateTables304($oDB)
{
    // Drop the old survey rights table.
    if (tableExists('{{templates}}')) {
        $oDB->createCommand()->dropTable('{{templates}}');
    }

    if (tableExists('{{template_configuration}}')) {
        $oDB->createCommand()->dropTable('{{template_configuration}}');
    }

    // Create templates table
    $oDB->createCommand()->createTable('{{templates}}', array(
        'name'                   => 'string(150) NOT NULL',
        'folder'                 => 'string(45) DEFAULT NULL',
        'title'                  => 'string(100) NOT NULL',
        'creation_date'          => 'datetime',
        'author'                 => 'string(150) DEFAULT NULL',
        'author_email'           => 'string DEFAULT NULL',
        'author_url'             => 'string DEFAULT NULL',
        'copyright'              => 'text',
        'license'                => 'text',
        'version'                => 'string(45) DEFAULT NULL',
        'api_version'            => 'string(45) NOT NULL',
        'view_folder'            => 'string(45) NOT NULL',
        'files_folder'           => 'string(45) NOT NULL',
        'description'            => 'text',
        'last_update'            => 'datetime DEFAULT NULL',
        'owner_id'               => 'integer DEFAULT NULL',
        'extends_template_name' => 'string(150) DEFAULT NULL',
        'PRIMARY KEY (name)'
    ));

    // Add default template
    $oDB->createCommand()->insert('{{templates}}', array(
        'name'                   => 'default',
        'folder'                 => 'default',
        'title'                  => 'Advanced Template',
        'creation_date'          => '2017-07-12 12:00:00',
        'author'                 => 'LimeSurvey GmbH',
        'author_email'           => 'info@limesurvey.org',
        'author_url'             => 'https://www.limesurvey.org/',
        'copyright'              => 'Copyright (C) 2007-2017 The LimeSurvey Project Team\r\nAll rights reserved.',
        'license'                => 'License: GNU/GPL License v2 or later, see LICENSE.php\r\n\r\nLimeSurvey is free software. This version may have been modified pursuant to the GNU General Public License, and as distributed it includes or is derivative of works licensed under the GNU General Public License or other free or open source software licenses. See COPYRIGHT.php for copyright notices and details.',
        'version'                => '1.0',
        'api_version'            => '3.0',
        'view_folder'            => 'views',
        'files_folder'           => 'files',
        'description'            => "<strong>LimeSurvey Advanced Template</strong><br>A template with custom options to show what it's possible to do with the new engines. Each template provider will be able to offer its own option page (loaded from template)",
        'owner_id'               => '1',
        'extends_template_name' => '',
    ));

    // Add minimal template
    $oDB->createCommand()->insert('{{templates}}', array(
        'name'                   => 'minimal',
        'folder'                 => 'minimal',
        'title'                  => 'Minimal Template',
        'creation_date'          => '2017-07-12 12:00:00',
        'author'                 => 'LimeSurvey GmbH',
        'author_email'           => 'info@limesurvey.org',
        'author_url'             => 'https://www.limesurvey.org/',
        'copyright'              => 'Copyright (C) 2007-2017 The LimeSurvey Project Team\r\nAll rights reserved.',
        'license'                => 'License: GNU/GPL License v2 or later, see LICENSE.php\r\n\r\nLimeSurvey is free software. This version may have been modified pursuant to the GNU General Public License, and as distributed it includes or is derivative of works licensed under the GNU General Public License or other free or open source software licenses. See COPYRIGHT.php for copyright notices and details.',
        'version'                => '1.0',
        'api_version'            => '3.0',
        'view_folder'            => 'views',
        'files_folder'           => 'files',
        'description'            => '<strong>LimeSurvey Minimal Template</strong><br>A clean and simple base that can be used by developers to create their own solution.',
        'owner_id'               => '1',
        'extends_template_name' => '',
    ));



    // Add material template
    $oDB->createCommand()->insert('{{templates}}', array(
        'name'                   => 'material',
        'folder'                 => 'material',
        'title'                  => 'Material Template',
        'creation_date'          => '2017-07-12 12:00:00',
        'author'                 => 'LimeSurvey GmbH',
        'author_email'           => 'info@limesurvey.org',
        'author_url'             => 'https://www.limesurvey.org/',
        'copyright'              => 'Copyright (C) 2007-2017 The LimeSurvey Project Team\r\nAll rights reserved.',
        'license'                => 'License: GNU/GPL License v2 or later, see LICENSE.php\r\n\r\nLimeSurvey is free software. This version may have been modified pursuant to the GNU General Public License, and as distributed it includes or is derivative of works licensed under the GNU General Public License or other free or open source software licenses. See COPYRIGHT.php for copyright notices and details.',
        'version'                => '1.0',
        'api_version'            => '3.0',
        'view_folder'            => 'views',
        'files_folder'           => 'files',
        'description'            => "<strong>LimeSurvey Advanced Template</strong><br> A template extending default, to show the inheritance concept. Notice the options, differents from Default.<br><small>uses FezVrasta's Material design theme for Bootstrap 3</small>",
        'owner_id'               => '1',
        'extends_template_name' => 'default',
    ));


    // Add template configuration table
    $oDB->createCommand()->createTable('{{template_configuration}}', array(
        'id'                => 'pk',
        'templates_name'    => 'string(150) NOT NULL',
        'sid'               => 'integer DEFAULT NULL',
        'gsid'              => 'integer DEFAULT NULL',
        'uid'               => 'integer DEFAULT NULL',
        'files_css'         => 'text',
        'files_js'          => 'text',
        'files_print_css'   => 'text',
        'options'           => 'text',
        'cssframework_name' => 'string(45) DEFAULT NULL',
        'cssframework_css'  => 'text',
        'cssframework_js'   => 'text',
        'packages_to_load'  => 'text',
    ));

    // Add global configuration for Advanced Template
    $oDB->createCommand()->insert('{{template_configuration}}', array(
        'templates_name'    => 'default',
        'files_css'         => '{"add": ["css/template.css", "css/animate.css"]}',
        'files_js'          => '{"add": ["scripts/template.js"]}',
        'files_print_css'   => '{"add":"css/print_template.css"}',
        'options'           => '{"ajaxmode":"off","brandlogo":"on", "brandlogofile":"./files/logo.png", "boxcontainer":"on", "backgroundimage":"off","animatebody":"off","bodyanimation":"fadeInRight","animatequestion":"off","questionanimation":"flipInX","animatealert":"off","alertanimation":"shake"}',
        'cssframework_name' => 'bootstrap',
        'cssframework_css'  => '{"replace": [["css/bootstrap.css","css/flatly.css"]]}',
        'cssframework_js'   => '',
        'packages_to_load'  => '["pjax"]',
    ));


    // Add global configuration for Minimal Template
    $oDB->createCommand()->insert('{{template_configuration}}', array(
        'templates_name'    => 'minimal',
        'files_css'         => '{"add": ["css/template.css"]}',
        'files_js'          => '{"add": ["scripts/template.js"]}',
        'files_print_css'   => '{"add":"css/print_template.css"}',
        'options'           => '{}',
        'cssframework_name' => 'bootstrap',
        'cssframework_css'  => '{}',
        'cssframework_js'   => '',
        'packages_to_load'  => '["pjax"]',
    ));

    // Add global configuration for Material Template
    $oDB->createCommand()->insert('{{template_configuration}}', array(
        'templates_name'    => 'material',
        'files_css'         => '{"add": ["css/template.css", "css/bootstrap-material-design.css", "css/ripples.min.css"]}',
        'files_js'          => '{"add": ["scripts/template.js", "scripts/material.js", "scripts/ripples.min.js"]}',
        'files_print_css'   => '{"add":"css/print_template.css"}',
        'options'           => '{"ajaxmode":"off","brandlogo":"on", "brandlogofile":"./files/logo.png", "animatebody":"off","bodyanimation":"fadeInRight","animatequestion":"off","questionanimation":"flipInX","animatealert":"off","alertanimation":"shake"}',
        'cssframework_name' => 'bootstrap',
        'cssframework_css'  => '{"replace": [["css/bootstrap.css","css/bootstrap.css"]]}',
        'cssframework_js'   => '',
        'packages_to_load'  => '["pjax"]',
    ));
}


/**
* @param CDbConnection $oDB
* @return void
*/
function upgradeTemplateTables298($oDB)
{
    // Add global configuration for Advanced Template
    $oDB->createCommand()->update('{{boxes}}', array(
        'url' => 'admin/templateoptions',
        'title' => 'Templates',
        'desc' => 'View templates list',
        ), "id=6");
}

function upgradeTokenTables256()
{
    $aTableNames = dbGetTablesLike("tokens%");
    $oDB = Yii::app()->getDb();
    foreach ($aTableNames as $sTableName) {
        try {
            setTransactionBookmark();
            $oDB->createCommand()->dropIndex("idx_lime_{$sTableName}_efl", $sTableName);
        } catch (Exception $e) {
            rollBackToTransactionBookmark();
        }
        alterColumn($sTableName, 'email', "text");
        alterColumn($sTableName, 'firstname', "string(150)");
        alterColumn($sTableName, 'lastname', "string(150)");
    }
}


function upgradeSurveyTables255()
{
    // We delete all the old boxes, and reinsert new ones
    Yii::app()->getDb()->createCommand(
        "DELETE FROM {{boxes}}"
    )->execute();

    // Then we recreate them
    $oDB = Yii::app()->db;
    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '1',
        'url'      => 'admin/survey/sa/newsurvey',
        'title'    => 'Create survey',
        'ico'      => 'add',
        'desc'     => 'Create a new survey',
        'page'     => 'welcome',
        'usergroup' => '-2',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '2',
        'url'      =>  'admin/survey/sa/listsurveys',
        'title'    =>  'List surveys',
        'ico'      =>  'list',
        'desc'     =>  'List available surveys',
        'page'     =>  'welcome',
        'usergroup' => '-1',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '3',
        'url'      =>  'admin/globalsettings',
        'title'    =>  'Global settings',
        'ico'      =>  'global',
        'desc'     =>  'Edit global settings',
        'page'     =>  'welcome',
        'usergroup' => '-2',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '4',
        'url'      =>  'admin/update',
        'title'    =>  'ComfortUpdate',
        'ico'      =>  'shield',
        'desc'     =>  'Stay safe and up to date',
        'page'     =>  'welcome',
        'usergroup' => '-2',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '5',
        'url'      =>  'admin/labels/sa/view',
        'title'    =>  'Label sets',
        'ico'      =>  'labels',
        'desc'     =>  'Edit label sets',
        'page'     =>  'welcome',
        'usergroup' => '-2',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '6',
        'url'      =>  'admin/themes/sa/view',
        'title'    =>  'Template editor',
        'ico'      =>  'templates',
        'desc'     =>  'Edit LimeSurvey templates',
        'page'     =>  'welcome',
        'usergroup' => '-2',
    ));
}

function upgradeSurveyTables254()
{
    Yii::app()->db->createCommand()->dropColumn('{{boxes}}', 'img');
    Yii::app()->db->createCommand()->addColumn('{{boxes}}', 'usergroup', 'integer');
}

function upgradeSurveyTables253()
{
    $oSchema = Yii::app()->db->schema;
    $aTables = dbGetTablesLike("survey\_%");
    $oDB = Yii::app()->db;
    foreach ($aTables as $sTable) {
        $oTableSchema = $oSchema->getTable($sTable);
        removeMysqlZeroDate($sTable, $oTableSchema, $oDB);
        if (in_array('refurl', $oTableSchema->columnNames)) {
            alterColumn($sTable, 'refurl', "text");
        }
        if (in_array('ipaddr', $oTableSchema->columnNames)) {
            alterColumn($sTable, 'ipaddr', "text");
        }
    }
}


function upgradeBoxesTable251()
{
    Yii::app()->db->createCommand()->addColumn('{{boxes}}', 'ico', 'string');
    Yii::app()->db->createCommand()->update(
        '{{boxes}}',
        array('ico' => 'add',
        'title' => 'Create survey'),
        "id=1"
    );
    Yii::app()->db->createCommand()->update(
        '{{boxes}}',
        array('ico' => 'list'),
        "id=2"
    );
    Yii::app()->db->createCommand()->update(
        '{{boxes}}',
        array('ico' => 'settings'),
        "id=3"
    );
    Yii::app()->db->createCommand()->update(
        '{{boxes}}',
        array('ico' => 'shield'),
        "id=4"
    );
    Yii::app()->db->createCommand()->update(
        '{{boxes}}',
        array('ico' => 'label'),
        "id=5"
    );
    Yii::app()->db->createCommand()->update(
        '{{boxes}}',
        array('ico' => 'templates'),
        "id=6"
    );
}

/**
* Create boxes table
*/
function createBoxes250()
{
    $oDB = Yii::app()->db;
    $oDB->createCommand()->createTable('{{boxes}}', array(
        'id' => 'pk',
        'position' => 'integer',
        'url' => 'text',
        'title' => 'text',
        'img' => 'text',
        'desc' => 'text',
        'page' => 'text',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '1',
        'url'      => 'admin/survey/sa/newsurvey',
        'title'    => 'Create survey',
        'img'      => 'add.png',
        'desc'     => 'Create a new survey',
        'page'     => 'welcome',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '2',
        'url'      =>  'admin/survey/sa/listsurveys',
        'title'    =>  'List surveys',
        'img'      =>  'surveylist.png',
        'desc'     =>  'List available surveys',
        'page'     =>  'welcome',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '3',
        'url'      =>  'admin/globalsettings',
        'title'    =>  'Global settings',
        'img'      =>  'global.png',
        'desc'     =>  'Edit global settings',
        'page'     =>  'welcome',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '4',
        'url'      =>  'admin/update',
        'title'    =>  'ComfortUpdate',
        'img'      =>  'shield&#45;update.png',
        'desc'     =>  'Stay safe and up to date',
        'page'     =>  'welcome',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '5',
        'url'      =>  'admin/labels/sa/view',
        'title'    =>  'Label sets',
        'img'      =>  'labels.png',
        'desc'     =>  'Edit label sets',
        'page'     =>  'welcome',
    ));

    $oDB->createCommand()->insert('{{boxes}}', array(
        'position' =>  '6',
        'url'      =>  'admin/themes/sa/view',
        'title'    =>  'Template editor',
        'img'      =>  'templates.png',
        'desc'     =>  'Edit LimeSurvey templates',
        'page'     =>  'welcome',
    ));
}

function fixKCFinder184()
{
    $sThirdPartyDir = Yii::app()->getConfig('homedir') . DIRECTORY_SEPARATOR . 'third_party' . DIRECTORY_SEPARATOR;
    rmdirr($sThirdPartyDir . 'ckeditor/plugins/toolbar');
    rmdirr($sThirdPartyDir . 'ckeditor/plugins/toolbar/ls-office2003');
    $aUnlink = glob($sThirdPartyDir . 'kcfinder/cache/*.js');
    if ($aUnlink !== false) {
        array_map('unlink', $aUnlink);
    }
    $aUnlink = glob($sThirdPartyDir . 'kcfinder/cache/*.css');
    if ($aUnlink !== false) {
        array_map('unlink', $aUnlink);
    }
    rmdirr($sThirdPartyDir . 'kcfinder/upload/files');
    rmdirr($sThirdPartyDir . 'kcfinder/upload/.thumbs');
}

function upgradeSurveyTables183()
{
    $oSchema = Yii::app()->db->schema;
    $aTables = dbGetTablesLike("survey\_%");
    $oDB = Yii::app()->db;
    if (!empty($aTables)) {
        foreach ($aTables as $sTableName) {
            $oTableSchema = $oSchema->getTable($sTableName);
            removeMysqlZeroDate($sTableName, $oTableSchema, $oDB);
            if (empty($oTableSchema->primaryKey)) {
                addPrimaryKey(substr($sTableName, strlen(Yii::app()->getDb()->tablePrefix)), 'id');
            }
        }
    }
}

/**
* @param string $sMySQLCollation
*/
function upgradeSurveyTables181($sMySQLCollation)
{
    $oDB = Yii::app()->db;
    $oSchema = Yii::app()->db->schema;
    if (Yii::app()->db->driverName != 'pgsql') {
        $aTables = dbGetTablesLike("survey\_%");
        foreach ($aTables as $sTableName) {
            $oTableSchema = $oSchema->getTable($sTableName);
            removeMysqlZeroDate($sTableName, $oTableSchema, $oDB);
            if (!in_array('token', $oTableSchema->columnNames)) {
                continue;
            }
            // No token field in this table
            switch (Yii::app()->db->driverName) {
                case 'sqlsrv':
                case 'dblib':
                case 'mssql':
                    dropSecondaryKeyMSSQL('token', $sTableName);
                    alterColumn($sTableName, 'token', "string(35) COLLATE SQL_Latin1_General_CP1_CS_AS");
                    $oDB->createCommand()->createIndex("{{idx_{$sTableName}_" . rand(1, 40000) . '}}', $sTableName, 'token');
                    break;
                case 'mysql':
                case 'mysqli':
                    // Fixes 0000-00-00 00:00:00 datetime entries
                    // Startdate and datestamp field only existed in versions older that 1.90 if Datestamps were activated
                    try {
                        setTransactionBookmark();
                        $oDB->createCommand()->update($sTableName, array('startdate' => '1980-01-01 00:00:00'), "startdate=0");
                    } catch (Exception $e) {
                        rollBackToTransactionBookmark();
                    }
                    try {
                        setTransactionBookmark();
                        $oDB->createCommand()->update($sTableName, array('datestamp' => '1980-01-01 00:00:00'), "datestamp=0");
                    } catch (Exception $e) {
                        rollBackToTransactionBookmark();
                    }
                    alterColumn($sTableName, 'token', "string(35) COLLATE '{$sMySQLCollation}'");
                    break;
                default:
                    die('Unknown database driver');
            }
        }
    }
}

/**
* @param string $sMySQLCollation
*/
function upgradeTokenTables181($sMySQLCollation)
{
    $oDB = Yii::app()->db;
    if (Yii::app()->db->driverName != 'pgsql') {
        $aTables = dbGetTablesLike("tokens%");
        if (!empty($aTables)) {
            foreach ($aTables as $sTableName) {
                switch (Yii::app()->db->driverName) {
                    case 'sqlsrv':
                    case 'dblib':
                    case 'mssql':
                        dropSecondaryKeyMSSQL('token', $sTableName);
                        alterColumn($sTableName, 'token', "string(35) COLLATE SQL_Latin1_General_CP1_CS_AS");
                        $oDB->createCommand()->createIndex("{{idx_{$sTableName}_" . rand(1, 50000) . '}}', $sTableName, 'token');
                        break;
                    case 'mysql':
                        alterColumn($sTableName, 'token', "string(35) COLLATE '{$sMySQLCollation}'");
                        break;
                    default:
                        die('Unknown database driver');
                }
            }
        }
    }
}

function upgradeTokenTables179()
{
    $oDB = Yii::app()->db;
    $oSchema = Yii::app()->db->schema;
    switch (Yii::app()->db->driverName) {
        case 'pgsql':
            $sSubstringCommand = 'substr';
            break;
        default:
            $sSubstringCommand = 'substring';
    }
    $surveyidresult = dbGetTablesLike("tokens%");
    if ($surveyidresult) {
        foreach ($surveyidresult as $sTableName) {
            $oTableSchema = $oSchema->getTable($sTableName);
            foreach ($oTableSchema->columnNames as $sColumnName) {
                if (strpos($sColumnName, 'attribute_') === 0) {
                    alterColumn($sTableName, $sColumnName, "text");
                }
            }
            $oDB->createCommand("UPDATE {$sTableName} set email={$sSubstringCommand}(email,1,254)")->execute();
            try {
                setTransactionBookmark();
                $oDB->createCommand()->dropIndex("idx_{$sTableName}_efl", $sTableName);
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            try {
                setTransactionBookmark();
                alterColumn($sTableName, 'email', "string(254)");
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            try {
                setTransactionBookmark();
                alterColumn($sTableName, 'firstname', "string(150)");
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
            try {
                setTransactionBookmark();
                alterColumn($sTableName, 'lastname', "string(150)");
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            }
        }
    }
}


function upgradeSurveys177()
{
    $oDB = Yii::app()->db;
    $sSurveyQuery = "SELECT surveyls_attributecaptions,surveyls_survey_id,surveyls_language FROM {{surveys_languagesettings}}";
    $oSurveyResult = $oDB->createCommand($sSurveyQuery)->queryAll();
    $sSurveyLSUpdateQuery = "update {{surveys_languagesettings}} set surveyls_attributecaptions=:attributecaptions where surveyls_survey_id=:surveyid and surveyls_language=:language";
    foreach ($oSurveyResult as $aSurveyRow) {
        $aAttributeDescriptions = decodeTokenAttributes($aSurveyRow['surveyls_attributecaptions']);
        if (!$aAttributeDescriptions) {
            $aAttributeDescriptions = array();
        }
        $oDB->createCommand($sSurveyLSUpdateQuery)->execute(
            array(':language' => $aSurveyRow['surveyls_language'],
                ':surveyid' => $aSurveyRow['surveyls_survey_id'],
            ':attributecaptions' => json_encode($aAttributeDescriptions))
        );
    }
    $sSurveyQuery = "SELECT sid,attributedescriptions FROM {{surveys}}";
    $oSurveyResult = $oDB->createCommand($sSurveyQuery)->queryAll();
    $sSurveyUpdateQuery = "update {{surveys}} set attributedescriptions=:attributedescriptions where sid=:surveyid";
    foreach ($oSurveyResult as $aSurveyRow) {
        $aAttributeDescriptions = decodeTokenAttributes($aSurveyRow['attributedescriptions']);
        if (!$aAttributeDescriptions) {
            $aAttributeDescriptions = array();
        }
        $oDB->createCommand($sSurveyUpdateQuery)->execute(array(':attributedescriptions' => json_encode($aAttributeDescriptions),':surveyid' => $aSurveyRow['sid']));
    }
}



/**
* This function removes the old CPDB fields in token tables
* replaces them with standard attribute fields
* and records the mapping information in the attributedescription field in the survey table instead
*/
function upgradeTokens176()
{
    $oDB = Yii::app()->db;
    $arSurveys = $oDB
    ->createCommand()
    ->select('*')
    ->from('{{surveys}}')
    ->queryAll();
    // Fix any active token tables
    foreach ($arSurveys as $arSurvey) {
        $sTokenTableName = 'tokens_' . $arSurvey['sid'];
        if (tableExists($sTokenTableName)) {
            $aColumnNames = $aColumnNamesIterator = $oDB->schema->getTable('{{' . $sTokenTableName . '}}')->columnNames;
            $aAttributes = $arSurvey['attributedescriptions'];
            foreach ($aColumnNamesIterator as $sColumnName) {
                // Check if an old atttribute_cpdb column exists in that token table
                if (strpos($sColumnName, 'attribute_cpdb') !== false) {
                    $i = 1;
                    // Look for a an attribute ID that is available
                    while (in_array('attribute_' . $i, $aColumnNames)) {
                        $i++;
                    }
                    $sNewName = 'attribute_' . $i;
                    $aColumnNames[] = $sNewName;
                    $oDB->createCommand()->renameColumn('{{' . $sTokenTableName . '}}', $sColumnName, $sNewName);
                    // Update attribute descriptions with the new mapping
                    if (isset($aAttributes[$sColumnName])) {
                        $aAttributes[$sNewName]['cpdbmap'] = substr($sColumnName, 15);
                        unset($aAttributes[$sColumnName]);
                    }
                }
            }
            // Add 'cpdbmap' if missing
            foreach ($aAttributes as &$aAttribute) {
                if (!isset($aAttribute['cpdbmap'])) {
                    $aAttribute['cpdbmap'] = '';
                }
            }
            $oDB->createCommand()->update('{{surveys}}', array('attributedescriptions' => serialize($aAttributes)), "sid=" . $arSurvey['sid']);
        }
    }
    unset($arSurveys);
    // Now fix all 'old' token tables
    $aTables = dbGetTablesLike("%old_tokens%");
    foreach ($aTables as $sTable) {
        $aColumnNames = $aColumnNamesIterator = $oDB->schema->getTable($sTable)->columnNames;
        foreach ($aColumnNamesIterator as $sColumnName) {
            // Check if an old atttribute_cpdb column exists in that token table
            if (strpos($sColumnName, 'attribute_cpdb') !== false) {
                $i = 1;
                // Look for a an attribute ID that is available
                while (in_array('attribute_' . $i, $aColumnNames)) {
                    $i++;
                }
                $sNewName = 'attribute_' . $i;
                $aColumnNames[] = $sNewName;
                $oDB->createCommand()->renameColumn($sTable, $sColumnName, $sNewName);
            }
        }
    }
}

function upgradeCPDBAttributeDefaultNames173()
{
    $sQuery = "SELECT attribute_id,attribute_name,COALESCE(lang,NULL)
    FROM {{participant_attribute_names_lang}}
    group by attribute_id, attribute_name, lang
    order by attribute_id";
    $oResult = Yii::app()->db->createCommand($sQuery)->queryAll();
    foreach ($oResult as $aAttribute) {
        Yii::app()->getDb()->createCommand()->update('{{participant_attribute_names}}', array('defaultname' => substr($aAttribute['attribute_name'], 0, 50)), "attribute_id={$aAttribute['attribute_id']}");
    }
}

/**
* Converts global permissions from users table to the new permission system,
* and converts template permissions from template_rights to new permission table
*/
function upgradePermissions166()
{
    Permission::model()->refreshMetaData();  // Needed because otherwise Yii tries to use the outdate permission schema for the permission table
    $oUsers = User::model()->findAll();
    foreach ($oUsers as $oUser) {
        if ($oUser->create_survey == 1) {
            $oPermission = new Permission();
            $oPermission->entity_id = 0;
            $oPermission->entity = 'global';
            $oPermission->uid = $oUser->uid;
            $oPermission->permission = 'surveys';
            $oPermission->create_p = 1;
            $oPermission->save();
        }
        if ($oUser->create_user == 1 || $oUser->delete_user == 1) {
            $oPermission = new Permission();
            $oPermission->entity_id = 0;
            $oPermission->entity = 'global';
            $oPermission->uid = $oUser->uid;
            $oPermission->permission = 'users';
            $oPermission->create_p = $oUser->create_user;
            $oPermission->delete_p = $oUser->delete_user;
            $oPermission->update_p = 1;
            $oPermission->read_p = 1;
            $oPermission->save();
        }
        if ($oUser->superadmin == 1) {
            $oPermission = new Permission();
            $oPermission->entity_id = 0;
            $oPermission->entity = 'global';
            $oPermission->uid = $oUser->uid;
            $oPermission->permission = 'superadmin';
            $oPermission->read_p = 1;
            $oPermission->save();
        }
        if ($oUser->configurator == 1) {
            $oPermission = new Permission();
            $oPermission->entity_id = 0;
            $oPermission->entity = 'global';
            $oPermission->uid = $oUser->uid;
            $oPermission->permission = 'settings';
            $oPermission->update_p = 1;
            $oPermission->read_p = 1;
            $oPermission->save();
        }
        if ($oUser->manage_template == 1) {
            $oPermission = new Permission();
            $oPermission->entity_id = 0;
            $oPermission->entity = 'global';
            $oPermission->uid = $oUser->uid;
            $oPermission->permission = 'templates';
            $oPermission->create_p = 1;
            $oPermission->read_p = 1;
            $oPermission->update_p = 1;
            $oPermission->delete_p = 1;
            $oPermission->import_p = 1;
            $oPermission->export_p = 1;
            $oPermission->save();
        }
        if ($oUser->manage_label == 1) {
            $oPermission = new Permission();
            $oPermission->entity_id = 0;
            $oPermission->entity = 'global';
            $oPermission->uid = $oUser->uid;
            $oPermission->permission = 'labelsets';
            $oPermission->create_p = 1;
            $oPermission->read_p = 1;
            $oPermission->update_p = 1;
            $oPermission->delete_p = 1;
            $oPermission->import_p = 1;
            $oPermission->export_p = 1;
            $oPermission->save();
        }
        if ($oUser->participant_panel == 1) {
            $oPermission = new Permission();
            $oPermission->entity_id = 0;
            $oPermission->entity = 'global';
            $oPermission->uid = $oUser->uid;
            $oPermission->permission = 'participantpanel';
            $oPermission->create_p = 1;
            $oPermission->save();
        }
    }
    $sQuery = "SELECT * FROM {{templates_rights}}";
    $oResult = Yii::app()->getDb()->createCommand($sQuery)->queryAll();
    foreach ($oResult as $aRow) {
        $oPermission = new Permission();
        $oPermission->entity_id = 0;
        $oPermission->entity = 'template';
        $oPermission->uid = $aRow['uid'];
        $oPermission->permission = $aRow['folder'];
        $oPermission->read_p = 1;
        $oPermission->save();
    }
}

/**
*  Make sure all active tables have the right sized token field
*
*  During a small period in the 2.0 cycle some survey tables got no
*  token field or a token field that was too small. This patch makes
*  sure all surveys that are not anonymous have a token field with the
*  right size
*
* @return string|null
*/
function upgradeSurveyTables164()
{
    $sQuery = "SELECT sid FROM {{surveys}} WHERE active='Y' and anonymized='N'";
    $aResult = Yii::app()->getDb()->createCommand($sQuery)->queryAll();
    if (!$aResult) {
        return "Database Error";
    } else {
        foreach ($aResult as $sv) {
            $sSurveyTableName = 'survey_' . $sv['sid'];
            $aColumnNames = $aColumnNamesIterator = Yii::app()->db->schema->getTable('{{' . $sSurveyTableName . '}}')->columnNames;
            if (!in_array('token', $aColumnNames)) {
                addColumn('{{survey_' . $sv['sid'] . '}}', 'token', 'string(36)');
            } else {
                alterColumn('{{survey_' . $sv['sid'] . '}}', 'token', 'string(36)');
            }
        }
    }
}


function upgradeSurveys156()
{
    $sSurveyQuery = "SELECT * FROM {{surveys_languagesettings}}";
    $oSurveyResult = Yii::app()->getDb()->createCommand($sSurveyQuery)->queryAll();
    foreach ($oSurveyResult as $aSurveyRow) {
        $aDefaultTexts = templateDefaultTexts($aSurveyRow['surveyls_language'], 'unescaped');
        if (trim(strip_tags($aSurveyRow['surveyls_email_confirm'])) == '') {
            $sSurveyUpdateQuery = "update {{surveys}} set sendconfirmation='N' where sid=" . $aSurveyRow['surveyls_survey_id'];
            Yii::app()->getDb()->createCommand($sSurveyUpdateQuery)->execute();

            $aValues = array('surveyls_email_confirm_subj' => $aDefaultTexts['confirmation_subject'],
                'surveyls_email_confirm' => $aDefaultTexts['confirmation']);
            SurveyLanguageSetting::model()->updateAll($aValues, 'surveyls_survey_id=:sid', array(':sid' => $aSurveyRow['surveyls_survey_id']));
        }
    }
}

// Add the usesleft field to all existing token tables
function upgradeTokens148()
{
    $aTables = dbGetTablesLike("tokens%");
    foreach ($aTables as $sTable) {
        addColumn($sTable, 'participant_id', "string(50)");
        addColumn($sTable, 'blacklisted', "string(17)");
    }
}



function upgradeQuestionAttributes148()
{
    $sSurveyQuery = "SELECT sid,language,additional_languages FROM {{surveys}}";
    $oSurveyResult = dbExecuteAssoc($sSurveyQuery);
    $aAllAttributes = \LimeSurvey\Helpers\questionHelper::getAttributesDefinitions();
    foreach ($oSurveyResult->readAll() as $aSurveyRow) {
        $iSurveyID = $aSurveyRow['sid'];
        $aLanguages = array_merge(array($aSurveyRow['language']), explode(' ', $aSurveyRow['additional_languages']));
        $sAttributeQuery = "select q.qid,attribute,value from {{question_attributes}} qa , {{questions}} q where q.qid=qa.qid and sid={$iSurveyID}";
        $oAttributeResult = dbExecuteAssoc($sAttributeQuery);
        foreach ($oAttributeResult->readAll() as $aAttributeRow) {
            if (isset($aAllAttributes[$aAttributeRow['attribute']]['i18n']) && $aAllAttributes[$aAttributeRow['attribute']]['i18n']) {
                Yii::app()->getDb()->createCommand("delete from {{question_attributes}} where qid={$aAttributeRow['qid']} and attribute='{$aAttributeRow['attribute']}'")->execute();
                foreach ($aLanguages as $sLanguage) {
                    $sAttributeInsertQuery = "insert into {{question_attributes}} (qid,attribute,value,language) VALUES({$aAttributeRow['qid']},'{$aAttributeRow['attribute']}','{$aAttributeRow['value']}','{$sLanguage}' )";
                    modifyDatabase("", $sAttributeInsertQuery);
                }
            }
        }
    }
}


function upgradeSurveyTimings146()
{
    $aTables = dbGetTablesLike("%timings");
    foreach ($aTables as $sTable) {
        Yii::app()->getDb()->createCommand()->renameColumn($sTable, 'interviewTime', 'interviewtime');
    }
}


// Add the usesleft field to all existing token tables
function upgradeTokens145()
{
    $aTables = dbGetTablesLike("tokens%");
    foreach ($aTables as $sTable) {
        addColumn($sTable, 'usesleft', "integer NOT NULL default 1");
        Yii::app()->getDb()->createCommand()->update($sTable, array('usesleft' => '0'), "completed<>'N'");
    }
}


function upgradeSurveys145()
{
    $sSurveyQuery = "SELECT * FROM {{surveys}} where notification<>'0'";
    $oSurveyResult = dbExecuteAssoc($sSurveyQuery);
    foreach ($oSurveyResult->readAll() as $aSurveyRow) {
        if ($aSurveyRow['notification'] == '1' && trim($aSurveyRow['adminemail']) != '') {
            $aEmailAddresses = explode(';', $aSurveyRow['adminemail']);
            $sAdminEmailAddress = $aEmailAddresses[0];
            $sEmailnNotificationAddresses = implode(';', $aEmailAddresses);
            $sSurveyUpdateQuery = "update {{surveys}} set adminemail='{$sAdminEmailAddress}', emailnotificationto='{$sEmailnNotificationAddresses}' where sid=" . $aSurveyRow['sid'];
            Yii::app()->getDb()->createCommand($sSurveyUpdateQuery)->execute();
        } else {
            $aEmailAddresses = explode(';', $aSurveyRow['adminemail']);
            $sAdminEmailAddress = $aEmailAddresses[0];
            $sEmailDetailedNotificationAddresses = implode(';', $aEmailAddresses);
            if (trim($aSurveyRow['emailresponseto']) != '') {
                $sEmailDetailedNotificationAddresses = $sEmailDetailedNotificationAddresses . ';' . trim($aSurveyRow['emailresponseto']);
            }
            $sSurveyUpdateQuery = "update {{surveys}} set adminemail='{$sAdminEmailAddress}', emailnotificationto='{$sEmailDetailedNotificationAddresses}' where sid=" . $aSurveyRow['sid'];
            Yii::app()->getDb()->createCommand($sSurveyUpdateQuery)->execute();
        }
    }
    $sSurveyQuery = "SELECT * FROM {{surveys_languagesettings}}";
    $oSurveyResult = Yii::app()->getDb()->createCommand($sSurveyQuery)->queryAll();
    foreach ($oSurveyResult as $aSurveyRow) {
        $sLanguage = App()->language;
        $aDefaultTexts = templateDefaultTexts($sLanguage, 'unescaped');
        unset($sLanguage);
        $aDefaultTexts['admin_detailed_notification'] = $aDefaultTexts['admin_detailed_notification'] . $aDefaultTexts['admin_detailed_notification_css'];
        $sSurveyUpdateQuery = "update {{surveys_languagesettings}} set
        email_admin_responses_subj=" . $aDefaultTexts['admin_detailed_notification_subject'] . ",
        email_admin_responses=" . $aDefaultTexts['admin_detailed_notification'] . ",
        email_admin_notification_subj=" . $aDefaultTexts['admin_notification_subject'] . ",
        email_admin_notification=" . $aDefaultTexts['admin_notification'] . "
        where surveyls_survey_id=" . $aSurveyRow['surveyls_survey_id'];
        Yii::app()->getDb()->createCommand()->update('{{surveys_languagesettings}}', array('email_admin_responses_subj' => $aDefaultTexts['admin_detailed_notification_subject'],
            'email_admin_responses' => $aDefaultTexts['admin_detailed_notification'],
            'email_admin_notification_subj' => $aDefaultTexts['admin_notification_subject'],
            'email_admin_notification' => $aDefaultTexts['admin_notification']
            ), "surveyls_survey_id={$aSurveyRow['surveyls_survey_id']}");
    }
}


function upgradeSurveyPermissions145()
{
    $sPermissionQuery = "SELECT * FROM {{surveys_rights}}";
    $oPermissionResult = Yii::app()->getDb()->createCommand($sPermissionQuery)->queryAll();
    if (empty($oPermissionResult)) {
        return "Database Error";
    } else {
        $sTableName = '{{survey_permissions}}';
        foreach ($oPermissionResult as $aPermissionRow) {
            $sPermissionInsertQuery = Yii::app()->getDb()->createCommand()->insert($sTableName, array('permission' => 'assessments',
                'create_p' => $aPermissionRow['define_questions'],
                'read_p' => $aPermissionRow['define_questions'],
                'update_p' => $aPermissionRow['define_questions'],
                'delete_p' => $aPermissionRow['define_questions'],
                'sid' => $aPermissionRow['sid'],
                'uid' => $aPermissionRow['uid']));

            $sPermissionInsertQuery = Yii::app()->getDb()->createCommand()->insert($sTableName, array('permission' => 'quotas',
                'create_p' => $aPermissionRow['define_questions'],
                'read_p' => $aPermissionRow['define_questions'],
                'update_p' => $aPermissionRow['define_questions'],
                'delete_p' => $aPermissionRow['define_questions'],
                'sid' => $aPermissionRow['sid'],
                'uid' => $aPermissionRow['uid']));

            $sPermissionInsertQuery = Yii::app()->getDb()->createCommand()->insert($sTableName, array('permission' => 'responses',
                'create_p' => $aPermissionRow['browse_response'],
                'read_p' => $aPermissionRow['browse_response'],
                'update_p' => $aPermissionRow['browse_response'],
                'delete_p' => $aPermissionRow['delete_survey'],
                'export_p' => $aPermissionRow['export'],
                'import_p' => $aPermissionRow['browse_response'],
                'sid' => $aPermissionRow['sid'],
                'uid' => $aPermissionRow['uid']));

            $sPermissionInsertQuery = Yii::app()->getDb()->createCommand()->insert($sTableName, array('permission' => 'statistics',
                'read_p' => $aPermissionRow['browse_response'],
                'sid' => $aPermissionRow['sid'],
                'uid' => $aPermissionRow['uid']));

            $sPermissionInsertQuery = Yii::app()->getDb()->createCommand()->insert($sTableName, array('permission' => 'survey',
                'read_p' => 1,
                'delete_p' => $aPermissionRow['delete_survey'],
                'sid' => $aPermissionRow['sid'],
                'uid' => $aPermissionRow['uid']));

            $sPermissionInsertQuery = Yii::app()->getDb()->createCommand()->insert($sTableName, array('permission' => 'surveyactivation',
                'update_p' => $aPermissionRow['activate_survey'],
                'sid' => $aPermissionRow['sid'],
                'uid' => $aPermissionRow['uid']));

            $sPermissionInsertQuery = Yii::app()->getDb()->createCommand()->insert($sTableName, array('permission' => 'surveycontent',
                'create_p' => $aPermissionRow['define_questions'],
                'read_p' => $aPermissionRow['define_questions'],
                'update_p' => $aPermissionRow['define_questions'],
                'delete_p' => $aPermissionRow['define_questions'],
                'export_p' => $aPermissionRow['export'],
                'import_p' => $aPermissionRow['define_questions'],
                'sid' => $aPermissionRow['sid'],
                'uid' => $aPermissionRow['uid']));

            $sPermissionInsertQuery = Yii::app()->getDb()->createCommand()->insert($sTableName, array('permission' => 'surveylocale',
                'read_p' => $aPermissionRow['edit_survey_property'],
                'update_p' => $aPermissionRow['edit_survey_property'],
                'sid' => $aPermissionRow['sid'],
                'uid' => $aPermissionRow['uid']));

            $sPermissionInsertQuery = Yii::app()->getDb()->createCommand()->insert($sTableName, array('permission' => 'surveysettings',
                'read_p' => $aPermissionRow['edit_survey_property'],
                'update_p' => $aPermissionRow['edit_survey_property'],
                'sid' => $aPermissionRow['sid'],
                'uid' => $aPermissionRow['uid']));

            $sPermissionInsertQuery = Yii::app()->getDb()->createCommand()->insert($sTableName, array('permission' => 'tokens',
                'create_p' => $aPermissionRow['activate_survey'],
                'read_p' => $aPermissionRow['activate_survey'],
                'update_p' => $aPermissionRow['activate_survey'],
                'delete_p' => $aPermissionRow['activate_survey'],
                'export_p' => $aPermissionRow['export'],
                'import_p' => $aPermissionRow['activate_survey'],
                'sid' => $aPermissionRow['sid'],
                'uid' => $aPermissionRow['uid']));
        }
    }
}

function upgradeTables143()
{

    $aQIDReplacements = array();
    $answerquery = "select a.*, q.sid, q.gid from {{answers}} a,{{questions}} q where a.qid=q.qid and q.type in ('L','O','!') and a.default_value='Y'";
    $answerresult = Yii::app()->getDb()->createCommand($answerquery)->queryAll();
    foreach ($answerresult as $row) {
        modifyDatabase("", "INSERT INTO {{defaultvalues}} (qid, scale_id,language,specialtype,defaultvalue) VALUES ({$row['qid']},0," . dbQuoteAll($row['language']) . ",''," . dbQuoteAll($row['code']) . ")");
    }

    // Convert answers to subquestions

    $answerquery = "select a.*, q.sid, q.gid, q.type from {{answers}} a,{{questions}} q where a.qid=q.qid and a.language=q.language and q.type in ('1','A','B','C','E','F','H','K',';',':','M','P','Q')";
    $answerresult = Yii::app()->getDb()->createCommand($answerquery)->queryAll();
    foreach ($answerresult as $row) {
        $aInsert = array();
        if (isset($aQIDReplacements[$row['qid'] . '_' . $row['code']])) {
            $aInsert['qid'] = $aQIDReplacements[$row['qid'] . '_' . $row['code']];
        }
        $aInsert['sid'] = $row['sid'];
        $aInsert['gid'] = $row['gid'];
        $aInsert['parent_qid'] = $row['qid'];
        $aInsert['type'] = $row['type'];
        $aInsert['title'] = $row['code'];
        $aInsert['question'] = $row['answer'];
        $aInsert['question_order'] = $row['sortorder'];
        $aInsert['language'] = $row['language'];

        $iLastInsertID = Question::model()->insertRecords($aInsert);
        if (!isset($aInsert['qid'])) {
            $aQIDReplacements[$row['qid'] . '_' . $row['code']] = $iLastInsertID;
            $iSaveSQID = $aQIDReplacements[$row['qid'] . '_' . $row['code']];
        } else {
            $iSaveSQID = $aInsert['qid'];
        }
        if (($row['type'] == 'M' || $row['type'] == 'P') && $row['default_value'] == 'Y') {
            modifyDatabase("", "INSERT INTO {{defaultvalues}} (qid, sqid, scale_id,language,specialtype,defaultvalue) VALUES ({$row['qid']},{$iSaveSQID},0," . dbQuoteAll($row['language']) . ",'','Y')");
        }
    }
    // Sanitize data
    if (Yii::app()->db->driverName == 'pgsql') {
        modifyDatabase("", "delete from {{answers}} USING {{questions}} WHERE {{answers}}.qid={{questions}}.qid AND {{questions}}.type in ('1','F','H','M','P','W','Z')");
    } else {
        modifyDatabase("", "delete {{answers}} from {{answers}} LEFT join {{questions}} ON {{answers}}.qid={{questions}}.qid where {{questions}}.type in ('1','F','H','M','P','W','Z')");
    }

    // Convert labels to answers
    $answerquery = "select qid ,type ,lid ,lid1, language from {{questions}} where parent_qid=0 and type in ('1','F','H','M','P','W','Z')";
    $answerresult = Yii::app()->getDb()->createCommand($answerquery)->queryAll();
    foreach ($answerresult as $row) {
        $labelquery = "Select * from {{labels}} where lid={$row['lid']} and language=" . dbQuoteAll($row['language']);
        $labelresult = Yii::app()->getDb()->createCommand($labelquery)->queryAll();
        foreach ($labelresult as $lrow) {
            modifyDatabase("", "INSERT INTO {{answers}} (qid, code, answer, sortorder, language, assessment_value) VALUES ({$row['qid']}," . dbQuoteAll($lrow['code']) . "," . dbQuoteAll($lrow['title']) . ",{$lrow['sortorder']}," . dbQuoteAll($lrow['language']) . ",{$lrow['assessment_value']})");
            //$labelids[]
        }
        if ($row['type'] == '1') {
            $labelquery = "Select * from {{labels}} where lid={$row['lid1']} and language=" . dbQuoteAll($row['language']);
            $labelresult = Yii::app()->getDb()->createCommand($labelquery)->queryAll();
            foreach ($labelresult as $lrow) {
                modifyDatabase("", "INSERT INTO {{answers}} (qid, code, answer, sortorder, language, scale_id, assessment_value) VALUES ({$row['qid']}," . dbQuoteAll($lrow['code']) . "," . dbQuoteAll($lrow['title']) . ",{$lrow['sortorder']}," . dbQuoteAll($lrow['language']) . ",1,{$lrow['assessment_value']})");
            }
        }
    }

    // Convert labels to subquestions
    $answerquery = "select * from {{questions}} where parent_qid=0 and type in (';',':')";
    $answerresult = Yii::app()->getDb()->createCommand($answerquery)->queryAll();
    foreach ($answerresult as $row) {
        $labelquery = "Select * from {{labels}} where lid={$row['lid']} and language=" . dbQuoteAll($row['language']);
        $labelresult = Yii::app()->getDb()->createCommand($labelquery)->queryAll();
        foreach ($labelresult as $lrow) {
            $aInsert = array();
            if (isset($aQIDReplacements[$row['qid'] . '_' . $lrow['code'] . '_1'])) {
                $aInsert['qid'] = $aQIDReplacements[$row['qid'] . '_' . $lrow['code'] . '_1'];
            }
            $aInsert['sid'] = $row['sid'];
            $aInsert['gid'] = $row['gid'];
            $aInsert['parent_qid'] = $row['qid'];
            $aInsert['type'] = $row['type'];
            $aInsert['title'] = $lrow['code'];
            $aInsert['question'] = $lrow['title'];
            $aInsert['question_order'] = $lrow['sortorder'];
            $aInsert['language'] = $lrow['language'];
            $aInsert['scale_id'] = 1;
            $iLastInsertID = Question::model()->insertRecords($aInsert);

            if (isset($aInsert['qid'])) {
                $aQIDReplacements[$row['qid'] . '_' . $lrow['code'] . '_1'] = $iLastInsertID;
            }
        }
    }



    $updatequery = "update {{questions}} set type='!' where type='W'";
    modifyDatabase("", $updatequery);
    $updatequery = "update {{questions}} set type='L' where type='Z'";
    modifyDatabase("", $updatequery);
}


function upgradeQuestionAttributes142()
{
    $attributequery = "Select qid from {{question_attributes}} where attribute='exclude_all_other'  group by qid having count(qid)>1 ";
    $questionids = Yii::app()->getDb()->createCommand($attributequery)->queryRow();
    if (!is_array($questionids)) {
        return "Database Error";
    } else {
        foreach ($questionids as $questionid) {
            //Select all affected question attributes
            $attributevalues = Yii::app()->getDb()->createCommand("SELECT value from {{question_attributes}} where attribute='exclude_all_other' and qid=" . $questionid)->queryColumn();
            modifyDatabase("", "delete from {{question_attributes}} where attribute='exclude_all_other' and qid=" . $questionid);
            $record['value'] = implode(';', $attributevalues);
            $record['attribute'] = 'exclude_all_other';
            $record['qid'] = $questionid;
            Yii::app()->getDb()->createCommand()->insert('{{question_attributes}}', $record);
        }
    }
}

function upgradeSurveyTables139()
{
    $aTables = dbGetTablesLike("survey\_%");
    $oDB = Yii::app()->db;
    foreach ($aTables as $sTable) {
        $oSchema = Yii::app()->db->schema;
        $oTableSchema = $oSchema->getTable($sTable);
        removeMysqlZeroDate($sTable, $oTableSchema, $oDB);
        addColumn($sTable, 'lastpage', 'integer');
    }
}


// Add the reminders tracking fields
function upgradeTokenTables134()
{
    $aTables = dbGetTablesLike("tokens%");
    foreach ($aTables as $sTable) {
        addColumn($sTable, 'validfrom', "datetime");
        addColumn($sTable, 'validuntil', "datetime");
    }
}

/**
* @param string $sFieldType
* @param string $sColumn
*/
function alterColumn($sTable, $sColumn, $sFieldType, $bAllowNull = true, $sDefault = 'NULL')
{
    $oDB = Yii::app()->db;
    switch (Yii::app()->db->driverName) {
        case 'mysql':
            $sType = $sFieldType;
            if ($bAllowNull !== true) {
                $sType .= ' NOT NULL';
            }
            if ($sDefault != 'NULL') {
                $sType .= " DEFAULT '{$sDefault}'";
            }
            $oDB->createCommand()->alterColumn($sTable, $sColumn, $sType);
            break;
        case 'dblib':
        case 'sqlsrv':
        case 'mssql':
            dropDefaultValueMSSQL($sColumn, $sTable);
            $sType = $sFieldType;
            if ($bAllowNull != true && $sDefault != 'NULL') {
                $oDB->createCommand("UPDATE {$sTable} SET [{$sColumn}]='{$sDefault}' where [{$sColumn}] is NULL;")->execute();
            }
            if ($bAllowNull != true) {
                $sType .= ' NOT NULL';
            } else {
                $sType .= ' NULL';
            }
            $oDB->createCommand()->alterColumn($sTable, $sColumn, $sType);
            if ($sDefault != 'NULL') {
                $oDB->createCommand("ALTER TABLE {$sTable} ADD default '{$sDefault}' FOR [{$sColumn}];")->execute();
            }
            break;
        case 'pgsql':
            $sType = $sFieldType;
            $oDB->createCommand()->alterColumn($sTable, $sColumn, $sType);

            try {
                setTransactionBookmark();
                $oDB->createCommand("ALTER TABLE {$sTable} ALTER COLUMN {$sColumn} DROP DEFAULT")->execute();
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };

            try {
                setTransactionBookmark();
                $oDB->createCommand("ALTER TABLE {$sTable} ALTER COLUMN {$sColumn} DROP NOT NULL")->execute();
            } catch (Exception $e) {
                rollBackToTransactionBookmark();
            };

            if ($bAllowNull != true) {
                $oDB->createCommand("ALTER TABLE {$sTable} ALTER COLUMN {$sColumn} SET NOT NULL")->execute();
            }
            if ($sDefault != 'NULL') {
                $oDB->createCommand("ALTER TABLE {$sTable} ALTER COLUMN {$sColumn} SET DEFAULT '{$sDefault}'")->execute();
            }
            $oDB->createCommand()->alterColumn($sTable, $sColumn, $sType);
            break;
        default:
            die('Unknown database type');
    }
}

/**
* @param string $sType
*/
function addColumn($sTableName, $sColumn, $sType)
{
    Yii::app()->db->createCommand()->addColumn($sTableName, $sColumn, $sType);
}

/**
* Set a transaction bookmark - this is critical for Postgres because a transaction in Postgres cannot be continued unless you roll back to the transaction bookmark first
*
* @param mixed $sBookmark  Name of the bookmark
*/
function setTransactionBookmark($sBookmark = 'limesurvey')
{
    if (Yii::app()->db->driverName == 'pgsql') {
        Yii::app()->db->createCommand("SAVEPOINT {$sBookmark};")->execute();
    }
}

/**
* Roll back to a transaction bookmark
*
* @param mixed $sBookmark   Name of the bookmark
*/
function rollBackToTransactionBookmark($sBookmark = 'limesurvey')
{
    if (Yii::app()->db->driverName == 'pgsql') {
        Yii::app()->db->createCommand("ROLLBACK TO SAVEPOINT {$sBookmark};")->execute();
    }
}

/**
* Drop a default value in MSSQL
*
* @param string $fieldname
* @param mixed $tablename
*/
function dropDefaultValueMSSQL($fieldname, $tablename)
{
    // find out the name of the default constraint
    // Did I already mention that this is the most suckiest thing I have ever seen in MSSQL database?
    $dfquery = "SELECT c_obj.name AS constraint_name
    FROM sys.sysobjects AS c_obj INNER JOIN
    sys.sysobjects AS t_obj ON c_obj.parent_obj = t_obj.id INNER JOIN
    sys.sysconstraints AS con ON c_obj.id = con.constid INNER JOIN
    sys.syscolumns AS col ON t_obj.id = col.id AND con.colid = col.colid
    WHERE (c_obj.xtype = 'D') AND (col.name = '$fieldname') AND (t_obj.name='{$tablename}')";
    $defaultname = Yii::app()->getDb()->createCommand($dfquery)->queryRow();
    if ($defaultname != false) {
        Yii::app()->db->createCommand("ALTER TABLE {$tablename} DROP CONSTRAINT {$defaultname['constraint_name']}")->execute();
    }
}

/**
* This function drops a unique Key of an MSSQL database field by using the field name and the table name
*
* @param string $sFieldName
* @param string $sTableName
*/
function dropUniqueKeyMSSQL($sFieldName, $sTableName)
{
    $sQuery = "select TC.Constraint_Name, CC.Column_Name from information_schema.table_constraints TC
    inner join information_schema.constraint_column_usage CC on TC.Constraint_Name = CC.Constraint_Name
    where TC.constraint_type = 'Unique' and Column_name='{$sFieldName}' and TC.TABLE_NAME='{$sTableName}'";
    $aUniqueKeyName = Yii::app()->getDb()->createCommand($sQuery)->queryRow();
    if ($aUniqueKeyName != false) {
        Yii::app()->getDb()->createCommand("ALTER TABLE {$sTableName} DROP CONSTRAINT {$aUniqueKeyName['Constraint_Name']}")->execute();
    }
}

/**
* This function drops a secondary key of an MSSQL database field by using the field name and the table name
*
* @param string $sFieldName
* @param mixed $sTableName
*/
function dropSecondaryKeyMSSQL($sFieldName, $sTableName)
{
    $oDB = Yii::app()->getDb();
    $sQuery = "select
    i.name as IndexName
    from sys.indexes i
    join sys.objects o on i.object_id = o.object_id
    join sys.index_columns ic on ic.object_id = i.object_id
    and ic.index_id = i.index_id
    join sys.columns co on co.object_id = i.object_id
    and co.column_id = ic.column_id
    where i.[type] = 2
    and i.is_unique = 0
    and i.is_primary_key = 0
    and o.[type] = 'U'
    and ic.is_included_column = 0
    and o.name='{$sTableName}' and co.name='{$sFieldName}'";
    $aKeyName = Yii::app()->getDb()->createCommand($sQuery)->queryScalar();
    if ($aKeyName != false) {
        try {
            $oDB->createCommand()->dropIndex($aKeyName, $sTableName);
        } catch (Exception $e) {
        }
    }
}

/**
* Drops the primary key of a table
*
* @param string $sTablename
* @param string $oldPrimaryKeyColumn
*/
function dropPrimaryKey($sTablename, $oldPrimaryKeyColumn = null)
{
    switch (Yii::app()->db->driverName) {
        case 'mysql':
            if ($oldPrimaryKeyColumn !== null) {
                $sQuery = "ALTER TABLE {{" . $sTablename . "}} MODIFY {$oldPrimaryKeyColumn} INT NOT NULL";
                Yii::app()->db->createCommand($sQuery)->execute();
            }
            $sQuery = "ALTER TABLE {{" . $sTablename . "}} DROP PRIMARY KEY";
            Yii::app()->db->createCommand($sQuery)->execute();
            break;
        case 'pgsql':
        case 'sqlsrv':
        case 'dblib':
        case 'mssql':
            $pkquery = "SELECT CONSTRAINT_NAME "
            . "FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS "
            . "WHERE (TABLE_NAME = '{{{$sTablename}}}') AND (CONSTRAINT_TYPE = 'PRIMARY KEY')";

            $primarykey = Yii::app()->db->createCommand($pkquery)->queryRow(false);
            if ($primarykey !== false) {
                $sQuery = "ALTER TABLE {{" . $sTablename . "}} DROP CONSTRAINT " . $primarykey[0];
                Yii::app()->db->createCommand($sQuery)->execute();
            }
            break;
        default:
            die('Unknown database type');
    }
}

/**
* @param string $sTablename
*/
function addPrimaryKey($sTablename, $aColumns)
{
    return Yii::app()->db->createCommand()->addPrimaryKey('PK_' . $sTablename . '_' . randomChars(12, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), '{{' . $sTablename . '}}', $aColumns);
}

/**
* Modifies a primary key in one command  - this is only tested on MySQL
*
* @param string $sTablename The table name
* @param string[] $aColumns Column names to be in the new key
*/
function modifyPrimaryKey($sTablename, $aColumns)
{
    switch (Yii::app()->db->driverName) {
        case 'mysql':
            Yii::app()->db->createCommand("ALTER TABLE {{" . $sTablename . "}} DROP PRIMARY KEY, ADD PRIMARY KEY (" . implode(',', $aColumns) . ")")->execute();
            break;
        case 'pgsql':
        case 'sqlsrv':
        case 'dblib':
        case 'mssql':
            $pkquery = "SELECT CONSTRAINT_NAME "
            . "FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS "
            . "WHERE (TABLE_NAME = '{{{$sTablename}}}') AND (CONSTRAINT_TYPE = 'PRIMARY KEY')";

            $primarykey = Yii::app()->db->createCommand($pkquery)->queryRow(false);
            if ($primarykey !== false) {
                Yii::app()->db->createCommand("ALTER TABLE {{" . $sTablename . "}} DROP CONSTRAINT " . $primarykey[0])->execute();
                Yii::app()->db->createCommand("ALTER TABLE {{" . $sTablename . "}} ADD PRIMARY KEY (" . implode(',', $aColumns) . ")")->execute();
            }
            break;
        default:
            die('Unknown database type');
    }
}



/**
* @param string $sEncoding
* @param string $sCollation
*/
function fixMySQLCollations($sEncoding, $sCollation)
{
    $surveyidresult = dbGetTablesLike("%");
    foreach ($surveyidresult as $sTableName) {
        try {
            Yii::app()->getDb()->createCommand("ALTER TABLE {$sTableName} CONVERT TO CHARACTER SET {$sEncoding} COLLATE {$sCollation};")->execute();
        } catch (Exception $e) {
            // There are some big survey response tables that cannot be converted because the new charset probably uses
            // more bytes per character than the old one - we just leave them as they are for now.
        };
    }
    $sDatabaseName = getDBConnectionStringProperty('dbname');
    Yii::app()->getDb()->createCommand("ALTER DATABASE `$sDatabaseName` DEFAULT CHARACTER SET {$sEncoding} COLLATE {$sCollation};");
}

/**
*  Drops a column, automatically removes blocking default value on MSSQL
 * @param string $sTableName
 * @param string $sColumnName
 */
function dropColumn($sTableName, $sColumnName)
{
    if (Yii::app()->db->getDriverName() == 'mssql' || Yii::app()->db->getDriverName() == 'sqlsrv' || Yii::app()->db->getDriverName() == 'dblib') {
        dropDefaultValueMSSQL($sColumnName, $sTableName);
    }
    try {
        Yii::app()->db->createCommand()->dropColumn($sTableName, $sColumnName);
    } catch (Exception $e) {
       // If it cannot be dropped we assume it is already gone
    };
}


/**
*  Renames a language code in the whole LimeSurvey database
 * @param string $sOldLanguageCode
 * @param string $sNewLanguageCode
 */
function alterLanguageCode($sOldLanguageCode, $sNewLanguageCode)
{
    $oDB = Yii::app()->db;
    $oDB->createCommand()->update('{{answers}}', array('language' => $sNewLanguageCode), 'language=:lang', array(':lang' => $sOldLanguageCode));
    $oDB->createCommand()->update('{{questions}}', array('language' => $sNewLanguageCode), 'language=:lang', array(':lang' => $sOldLanguageCode));
    $oDB->createCommand()->update('{{groups}}', array('language' => $sNewLanguageCode), 'language=:lang', array(':lang' => $sOldLanguageCode));
    $oDB->createCommand()->update('{{labels}}', array('language' => $sNewLanguageCode), 'language=:lang', array(':lang' => $sOldLanguageCode));
    $oDB->createCommand()->update('{{surveys}}', array('language' => $sNewLanguageCode), 'language=:lang', array(':lang' => $sOldLanguageCode));
    $oDB->createCommand()->update('{{surveys_languagesettings}}', array('surveyls_language' => $sNewLanguageCode), 'surveyls_language=:lang', array(':lang' => $sOldLanguageCode));
    $oDB->createCommand()->update('{{users}}', array('lang' => $sNewLanguageCode), 'lang=:language', array(':language' => $sOldLanguageCode));

    $resultdata = $oDB->createCommand("select * from {{labelsets}}");
    foreach ($resultdata->queryAll() as $datarow) {
        $aLanguages = explode(' ', $datarow['languages']);
        foreach ($aLanguages as &$sLanguage) {
            if ($sLanguage == $sOldLanguageCode) {
                $sLanguage = $sNewLanguageCode;
            }
        }
        $toreplace = implode(' ', $aLanguages);
        $oDB->createCommand()->update('{{labelsets}}', array('languages' => $toreplace), 'lid=:lid', array(':lid' => $datarow['lid']));
    }

    $resultdata = $oDB->createCommand("select * from {{surveys}}");
    foreach ($resultdata->queryAll() as $datarow) {
        $aLanguages = explode(' ', $datarow['additional_languages']);
        foreach ($aLanguages as &$sLanguage) {
            if ($sLanguage == $sOldLanguageCode) {
                $sLanguage = $sNewLanguageCode;
            }
        }
        $toreplace = implode(' ', $aLanguages);
        $oDB->createCommand()->update('{{surveys}}', array('additional_languages' => $toreplace), 'sid=:sid', array(':sid' => $datarow['sid']));
    }
}


function fixLanguageConsistencyAllSurveys()
{
    $surveyidquery = "SELECT sid,additional_languages FROM " . App()->db->quoteColumnName('{{surveys}}');
    $surveyidresult = Yii::app()->db->createCommand($surveyidquery)->queryAll();
    foreach ($surveyidresult as $sv) {
        fixLanguageConsistency($sv['sid'], $sv['additional_languages']);
    }
}

/**
 * This function fixes Postgres sequences for one/all tables in a database
 * This is necessary if a table is renamed. If tablename is given then only that table is fixed
 * @param string $tableName Table name without prefix
 * @return void
 */
function fixPostgresSequence($tableName = null)
{
    $oDB = Yii::app()->getDb();
    $query = "SELECT 'SELECT SETVAL(' ||
                quote_literal(quote_ident(PGT.schemaname) || '.' || quote_ident(S.relname)) ||
                ', COALESCE(MAX(' ||quote_ident(C.attname)|| '), 1) ) FROM ' ||
                quote_ident(PGT.schemaname)|| '.'||quote_ident(T.relname)|| ';'
            FROM pg_class AS S,
                pg_depend AS D,
                pg_class AS T,
                pg_attribute AS C,
                pg_tables AS PGT
            WHERE S.relkind = 'S'
                AND S.oid = D.objid
                AND D.refobjid = T.oid
                AND D.refobjid = C.attrelid
                AND D.refobjsubid = C.attnum
                AND T.relname = PGT.tablename";
    if ($tableName != null) {
        $query .= " AND PGT.tablename= '{{" . $tableName . "}}' ";
    }
    $query .= "ORDER BY S.relname;";
    $FixingQueries = Yii::app()->db->createCommand($query)->queryColumn();
    foreach ($FixingQueries as $fixingQuery) {
        $oDB->createCommand($fixingQuery)->execute();
    }
}

function runAddPrimaryKeyonAnswersTable400(&$oDB)
{
    if (!in_array($oDB->getDriverName(), array('mssql', 'sqlsrv', 'dblib'))) {
        dropPrimaryKey('answers');
        addColumn('{{answers}}', 'aid', 'pk');
        modifyPrimaryKey('answers', array('aid'));
        $oDB->createCommand()->createIndex('answer_idx_10', '{{answers}}', ['qid', 'code', 'scale_id']);
        $dataReader = $oDB->createCommand("SELECT qid, code, scale_id FROM {{answers}} group by qid, code, scale_id")->query();
        $iCounter = 1;
        while (($row = $dataReader->read()) !== false) {
            $oDB->createCommand("UPDATE {{answers}} SET aid={$iCounter} WHERE qid={$row['qid']} AND code='{$row['code']}' AND scale_id={$row['scale_id']}")->execute();
            $iCounter++;
        }
        $oDB->createCommand()->dropindex('answer_idx_10', '{{answers}}');
    } else {
        $oDB->createCommand()->renameTable('{{answers}}', 'answertemp');
        $oDB->createCommand()->createIndex('answer_idx_10', 'answertemp', ['qid', 'code', 'scale_id']);

        $dataReader = $oDB->createCommand("SELECT qid, code, scale_id FROM answertemp group by qid, code, scale_id")->query();

        $oDB->createCommand()->createTable('{{answers}}', [
            'aid' =>  "pk",
            'qid' => 'integer NOT NULL',
            'code' => 'string(5) NOT NULL',
            'sortorder' => 'integer NOT NULL',
            'assessment_value' => 'integer NOT NULL DEFAULT 0',
            'scale_id' => 'integer NOT NULL DEFAULT 0',
            'answer' => 'text NOT NULL',
            'language' =>  "string(20) NOT NULL DEFAULT 'en'"
        ]);

        $dataReader = $oDB->createCommand("SELECT qid, code, scale_id FROM answertemp group by qid, code, scale_id")->query();
        $iCounter = 1;
        while (($row = $dataReader->read()) !== false) {
            $dataBlock = $oDB->createCommand("SELECT * FROM answertemp WHERE qid={$row['qid']} AND code='{$row['code']}' AND scale_id={$row['scale_id']}")->queryRow();
            $oDB->createCommand()->insert('{{answers}}', $dataBlock);
        }
        $oDB->createCommand()->dropindex('answer_idx_10', 'answertemp');
        $oDB->createCommand()->dropTable('answertemp');
    }
}

/**
 * Regenerate codes for problematic label sets
 * Helper function (TODO: Put in separate class)
 * Fails silently
 *
 * @param int $lid Label set id
 * @param bool $hasLanguageColumn Should be true before dbversion 400 is finished, false after
 * @return void
 */
function regenerateLabelCodes400(int $lid, $hasLanguageColumn = true)
{
    $oDB = Yii::app()->getDb();

    $labelSet = $oDB->createCommand(
        sprintf("SELECT * FROM {{labelsets}} WHERE lid = %d", (int) $lid)
    )->queryRow();
    if (empty($labelSet)) {
        // No belonging label set, remove orphan labels.
        // @see https://bugs.limesurvey.org/view.php?id=17608
        $oDB->createCommand(
            sprintf(
                'DELETE FROM {{labels}} WHERE lid = %d',
                (int) $lid
            )
        )->execute();
        return;
    }

    foreach (explode(' ', $labelSet['languages']) as $lang) {
        if ($hasLanguageColumn) {
            $query = sprintf(
                "SELECT * FROM {{labels}} WHERE lid = %d AND language = %s",
                (int) $lid,
                $oDB->quoteValue($lang)
            );
        } else {
            // When this function is used in update 475, the language column is already moved.
            $query = sprintf("SELECT * FROM {{labels}} WHERE lid = %d", (int) $lid);
        }
        $labels = $oDB->createCommand($query)->queryAll();
        if (empty($labels)) {
            continue;
        }
        foreach ($labels as $key => $label) {
            $oDB->createCommand(
                sprintf(
                    "UPDATE {{labels}} SET code = %s WHERE id = %d",
                    $oDB->quoteValue("L" . (string) ($key + 1)),
                    $label['id']
                )
            )->execute();
        }
    }
}

/**
 * Remove all zero-dates in $tableName by checking datetime columns from $tableSchema
 * Zero-dates are replaced with null where possible; otherwise 1970-01-01
 *
 * @param string $tableName
 * @param CDbTableSchema $tableSchema
 * @param CDbConnection $oDB
 * @return void
 */
function removeMysqlZeroDate($tableName, CDbTableSchema $tableSchema, CDbConnection $oDB)
{
    // Do nothing if we're not using MySQL
    if (Yii::app()->db->driverName !== 'mysql') {
        return;
    }

    foreach ($tableSchema->columns as $columnName => $info) {
        if ($info->dbType === 'datetime') {
            try {
                $oDB->createCommand()->update($tableName, [$columnName => null], "$columnName = 0");
            } catch (Exception $e) {
                // $columnName might not be allowed to be null, then try with 1970-01-01 Unix 0 date instead.
                $oDB->createCommand()->update($tableName, [$columnName => '1970-01-01 00:00:00'], "$columnName = 0");
            }
        }
    }
}
