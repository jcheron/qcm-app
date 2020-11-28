<?php
namespace controllers;
use Ubiquity\utils\http\USession;
use Ubiquity\utils\http\URequest;
use Ubiquity\orm\DAO;
use models\User;

/**
 * Auth Controller BaseAuthController
 */
class BaseAuthController extends \Ubiquity\controllers\auth\AuthController{   
    protected $headerView = "@activeTheme/main/vHeader.html";
    protected $footerView = "@activeTheme/main/vFooter.html";
    
    public function initialize() {
        if (! URequest::isAjax ()) {
            $this->loadView ( $this->headerView );
        }
    }
    
    public function finalize() {
        if (! URequest::isAjax ()) {
            $this->loadView ( $this->footerView );
        }
    }
    
    /**
     * @get("/login","name"=>"login")
     */
    public function index(){
      $this->loadDefaultView();
    }
    
    /**
     * @post("/login")
     */
    public function loginPost(){
        if(gettype($this->_connect())!=="string"){
            $this->onConnect($this->_connect());
            $info="You are logged";
            $process="success";
        }
        else{
            $info=$this->_connect();
            $process="error";
        }
        $this->loadView("BaseAuthController/index.html",compact("info","process"));
    }
    
    /**
     * @get("/register","name"=>"register")
     */
    public function register(){
        $this->loadDefaultView();
    }
    
    /**
     * @post("/register")
     */
    public function registerPost(){
        if(URequest::isPost()){
            if(DAO::getOne(User::class,"email = ?",true,[URequest::post("email")])===null){
                $instance=new User();
                URequest::setValuesToObject($instance);
                $instance->setPassword(password_hash(URequest::post('password'), PASSWORD_ARGON2I));
                DAO::insert($instance);
                header('location:/');
                exit();
            }
        }
    }
    
    protected function onConnect($connected) {
        $urlParts=$this->getOriginalURL();
        USession::set($this->_getUserSessionKey(), $connected);
        if(isset($urlParts)){
            $this->_forward(implode("/",$urlParts));
        }
    }
    
    protected function _connect() {
        USession::terminate();
        if(URequest::isPost()){
            $user=DAO::getOne(User::class,"email = ?",true,[URequest::post('email')]);
            if($user!==null){
                if(password_verify(URequest::post('password'),$user->getPassword())){
                    return $user;
                }
                else{
                    return "Wrong password !";
                }
            }
            return "Wrong email !";
        }
        return "Error !";
    }
    
    /**
     * {@inheritDoc}
     * @see \Ubiquity\controllers\auth\AuthController::isValidUser()
     */
    public function _isValidUser($action=null) {
        return USession::exists($this->_getUserSessionKey());
    }
    
    public function _getBaseRoute() {
        return 'BaseAuthController';
    }
}