<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

        // Check if Browser is IE
		$isIE = $this->detectIEBrowser();
		$this->set('isIE', $isIE);

        // Check App Mode
        $evalAppMode = $this->getEvalAppMode();
		$this->set('evalAppMode', $evalAppMode);

        // Check If App Is Running in Production
        $prodMode = $this->getEnvironment();
		$this->set('prodMode', $prodMode);
    }

    protected $actionKey = "doStuff";

    public function checkAccess($key)
    {
        if($key != $this->actionKey) {
            return $this->redirect(['controller' => 'Ypois', 'action' => 'setScenario']);
        }
    }

    public function detectIEBrowser()
	{
		$isIE = false;
		$ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
		if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0; rv:11.0') !== false) || (strpos($ua, 'Edge') !== false)) {
			$isIE = true;
		}
		return $isIE;
	}

    public function getEvalAppMode()
	{
		$evalAppMode = false;
		return $evalAppMode;
	}

    public function getEnvironment()
	{
		$isProd = false;
        if( str_contains($_SERVER['REQUEST_URI'], 'forschung') ) {
            $isProd = true;
        }

		return $isProd;
	}
}
