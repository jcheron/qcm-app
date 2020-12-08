<?php
namespace controllers;

use Ajax\semantic\html\collections\HtmlMessage;
use Ubiquity\controllers\Router;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;
use models\Answer;
use models\Question;
use models\User;
use services\DashboardDAOLoader;

 /**
  * Controller DashboardController
  * @route('dashboard','automated'=>true)
  * @property \Ajax\php\ubiquity\JsUtils $jquery
  */

class DashboardController extends ControllerBase{
    
    /**
     *
     * @autowired
     * @var DashboardDAOLoader
     */
    private $loader;
    
    /**
     *
     * @param \services\DashboardDAOLoader $loader
     */
    public function setLoader($loader) {
        $this->loader = $loader;
    }
    
	public function index(){
		$this->loadView("DashboardController/index.html");
	}
}
