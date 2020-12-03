<?php
namespace controllers;
 /**
  * Controller DashboardController
  * @route('dashboard','automated'=>true)
  * @property \Ajax\php\ubiquity\JsUtils $jquery
  */

class DashboardController extends ControllerBase{

	public function index(){
		$this->loadView("DashboardController/index.html");
	}
}
