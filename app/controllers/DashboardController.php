<?php
namespace controllers;

use Ajax\semantic\html\collections\HtmlMessage;
use Ubiquity\controllers\Router;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;
use models\Answer;
use models\Question;
use models\User;
use services\QuestionDAOLoader;

 /**
  * Controller DashboardController
  * @route('dashboard','automated'=>true)
  * @property \Ajax\php\ubiquity\JsUtils $jquery
  */

class DashboardController extends ControllerBase{
    
    /**
     *
     * @autowired
     * @var QuestionDAOLoader
     */
    private $loader;
    
	public function index(){
		$this->loadView("DashboardController/index.html");
	}
}
