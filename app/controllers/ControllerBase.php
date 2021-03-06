<?php
namespace controllers;

use Ubiquity\controllers\Controller;
use Ubiquity\translation\TranslatorManager;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;

/**
 * ControllerBase.
 **/
abstract class ControllerBase extends Controller{
	protected $headerView = "@activeTheme/main/vHeader.html";
	protected $footerView = "@activeTheme/main/vFooter.html";

	public function initialize() {
	    if(USession::get('activeUser',false)){
	        TranslatorManager::setLocale(USession::get('activeUser')['language']);
	    }
		if (! URequest::isAjax ()) {
		    $user = USession::get('activeUser');
		    $this->loadView ( $this->headerView ,[
		        'user' => $user
		    ] );
		    $this->loadView('/main/UI/Navbar.html');
		    $this->loadView('/main/UI/AuthModal.html');
		}
	}

	public function finalize() {
		if (! URequest::isAjax ()) {
			$this->loadView ( $this->footerView );
		}
	}
	
	public function _getRole(){
		if(isset(USession::get('activeUser')['id'])){
			return '@USER';
		}
		return '@GUEST';
	}
	
	public function onInvalidControl() {
	    header('location:/');
	}
	
}

