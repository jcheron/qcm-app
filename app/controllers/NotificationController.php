<?php
namespace controllers;

use Ubiquity\controllers\Router;
use services\NotificationDAOLoader;
use Ubiquity\security\acl\controllers\AclControllerTrait;
use Ubiquity\utils\http\USession;

/**
 * Controller NotificationController
 * @allow('role'=>'@USER')
 * @route('notification','inherited'=>true,'automated'=>true)
 * @property \Ajax\php\ubiquity\JsUtils $jquery
 */
class NotificationController extends ControllerBase{
    use AclControllerTrait;
    
    /**
     *
     * @autowired
     * @var NotificationDAOLoader
     */
    private $loader;
    
    /**
     *
     * @param \services\GroupDAOLoader $loader
     */
    public function setLoader($loader) {
        $this->loader = $loader;
    }
    
    /**
     * @route('/','name'=>'notification')
     */
    public function index(){
        $exam=$this->loader->getExamNotification();
        $groupDemand=$this->loader->getGroupNotification();
        $notifJson=[];
        foreach($exam as $value){
            array_push($notifJson,['id'=>'Exam open','link'=>Router::path('')]);
        }
        foreach($groupDemand as $value){
            array_push($notifJson,['id'=>'New joining demand for this group','link'=>Router::path('groupDemand',[$value])]);
        }
        $this->jquery->renderView('NotificationController/index.html',[
            'notifications'=>$notifJson
        ]);
    }
}

