<?php
    function getSecVars($secPath) {
        if (file_exists($secPath . 'foodm_var.xml')) {
            $secKeys = simplexml_load_file($secPath . 'foodm_var.xml');
            return $secKeys;
        } else {
            exit('Konnte foodm_var.xml nicht öffnen!');
        }
    }
?>