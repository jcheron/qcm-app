<?php
namespace controllers;

use Ajax\semantic\html\collections\HtmlMessage;
use Ubiquity\controllers\Router;
use Ubiquity\utils\http\URequest;
use Ubiquity\utils\http\USession;
use models\Answer;
use models\Question;
use models\User;
use Ubiquity\translation\TranslatorManager;
use services\DashboardDAOLoader;
use services\UserDAOLoader;
use Exception;
use PDO;
 /**
  * Controller DashboardController
  * @route('dashboard','automated'=>true)
  * @property \Ajax\php\ubiquity\JsUtils $jquery
  */

class DashboardController extends ControllerBase{
    
    /**
     *
     * @autowired
     * @var UserDAOLoader
     */
    private $loader;
    
    /**
     *
     * @param \services\UserDAOLoader $loader
     */
    public function setLoader($loader) {
        $this->loader = $loader;
    }
    
    private function pdo($session) {
        try {
            $bdd = new PDO("mysql:host=localhost;dbname=qcm;charset=utf8", "root", "");
        }
        
        catch (Exception $e) {
            die("Erreur : ".$e->get_Message());
        }
        
        $sql = "SELECT caption FROM question WHERE idUser = " . $session['id'];
        $req = $bdd->query($sql);
        
        $caption = array();
        while ($donnees = $req->fetch()) {
            array_push($caption, $donnees['caption']);
        }
        return $caption;
    }
    
    public function index() {
        $session = USession::get('activeUser');
        $caption = $this->pdo($session);
        $this->loadView("DashboardController/index.html", ['caption' => $caption]) ;
    }
}
