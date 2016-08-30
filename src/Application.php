<?php

namespace ProjectHub;

define('ROOT_PATH', dirname(__DIR__));

require_once __DIR__ . '/../vendor/autoload.php';

use Elephant418\Model418\Core\Factory;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Auth0\SDK\Auth0;
use Noodlehaus\Config;

class Application extends Factory
{

    /* ATTRIBUTES
     *************************************************************************/
    public $publicBaseUri = '/public';
    public $userInfo = '';
    private $client = 'sandbox';
    public $role = '';
    public $picture = '';
    public $name = '';
    public $advertiser = '';

    /* PUBLIC ACTION METHODS
     *************************************************************************/
    public function index()
    {

        $config = new Config(__DIR__ . '/../config/config.php');
        $this->publicBaseUri = $config->get('publicBaseUri');
        $auth0 = new Auth0(array(
            'domain'        => $config->get('domain'),
            'client_id'     => $config->get('client_id'),
            'client_secret' => $config->get('client_secret'),
            'redirect_uri'  => $config->get('redirect_uri')
        ));

        $this->userInfo = $auth0->getUser();

        $picture = $this->userInfo['picture'];
        $name = $this->userInfo['name'];

        $this->role = print_r($this->userInfo['role'], 1);

        if (!$this->userInfo) {
            // We have no user info
            $this->renderLogin($config->get('redirect_uri'));
            die;
        }

        if (isset($_SESSION['auth0__user']['app_metadata']['current_client'])) {
            $this->client = $_SESSION['auth0__user']['app_metadata']['current_client'];
        } else if (isset($this->userInfo['app_metadata']['client'])) {
            //$this->client = $this->userInfo['app_metadata']['client'];
            $this->client = is_array($this->userInfo['app_metadata']['client']) ? $this->userInfo['app_metadata']['client'][0] : $this->userInfo['app_metadata']['client'];
        }

        // Routs
        if (isset($_POST['action'])) {
            if ($_POST['action'] == 'create-project') {
                $result = $this->saveProject($_POST);
            } else if ($_POST['action'] == 'create-note') {
                $result = $this->saveNote($_POST);
            } else if ($_POST['action'] == 'delete-project') {
                $result = $this->deleteProject($_POST, $config->get('redirect_uri'));
            } else if ($_POST['action'] == 'delete-note') {
                $result = $this->deleteNote($_POST);
            }
        } else if (isset($_GET['action'])) {
            if ($_GET['action'] == 'view-project') {
                $result = $this->one($_GET['project']);
            } else if ($_GET['action'] == 'switch') {
                $result = $this->switchAdvertiser($_GET, $config->get('redirect_uri'));
            } else if ($_GET['action'] == 'logout') {
                $auth0->logout();
                session_destroy();
                header("Location: " . $config->get('redirect_uri'));
            }
        } else {
            $result = $this->all();
        }

        if (!$result) {
            $this->render404();
        }
        die;
    }

    public function all()
    {
        $projectList = $this->newInstance('Project')->query()->fetchAll();
        if (count($projectList) == 0) {
            $this->renderTutorial();
        } else if (count($projectList) == 1) {
            /*
            foreach ($projectList as $key => $value) {
                $this->renderProject($value, 1);
            }
            */
            $this->renderProjectList($projectList);
        } else {
            $this->renderProjectList($projectList);
        }
        return true;
    }

    public function one($projectId)
    {
        $projectList = $this->newInstance('Project')->query()->fetchAll();
        if (!isset($projectList[$projectId])) {
            return false;
        }
        $project = $projectList[$projectId];
        $this->renderProject($project, count($projectList));
        return true;
    }

    public function saveNote($data){
        $status = $this->newInstance('Project')->saveNote($data, $this->client, $data['project']);
        //echo 'Data: ' . print_r($data, 1) . "<br>";
        //echo 'Client: ' . $this->client . "<br>";
        if ($status) {
            return $this->one($data['project']);
        } else {
            return false;
        }
    }

    public function saveProject($data){
        $status = $this->newInstance('Project')->saveProject($data, $this->client);
        //echo 'Data: ' . print_r($data, 1) . "<br>";
        //echo 'Client: ' . $this->client . "<br>";
        if ($status) {
            return $this->all();
        } else {
            return false;
        }
    }

    public function deleteProject($data, $goto){
        $status = $this->newInstance('Project')->deleteProject($data['project'], $this->client);
        header("Location: " . $goto);
    }

    public function deleteNote($data){
        $status = $this->newInstance('Project')->deleteNote($data['id'], $this->client, $data['project']);
        if ($status) {
            return $this->one($data['project']);
        }else {
            return false;
        }
    }

    public function switchAdvertiser($data, $goto){
        if (in_array($_GET['advertiser'], $_SESSION['auth0__user']['app_metadata']['client'])) {
          $_SESSION['auth0__user']['app_metadata']['current_client'] = $_GET['advertiser'];
          if (file_exists('data/' . $_SESSION['auth0__user']['app_metadata']['current_client'])) {} else {
            mkdir('data/' . $_SESSION['auth0__user']['app_metadata']['current_client']);
            //$this->saveProject(array('title' => 'First project'));
            //$this->saveNote(array('project' => $_SESSION['auth0__user']['app_metadata']['client']));
          }
          //session_destroy();
          //echo '<pre>' . print_r($_SESSION, 1) . '</pre>';
        }
        header("Location: " . $goto);
        //echo ("" . $goto);
    }

    /* PROTECTED METHODS
     *************************************************************************/
    public function renderProject($project, $projectCount)
    {
        $this->render('project', array('project' => $project, 'projectCount' => $projectCount, 'role' => $this->role));
    }

    public function renderProjectList($projectList)
    {
        $this->render('home', array('projectList' => $projectList, 'role' => $this->role));
    }

    public function renderTutorial()
    {
        $this->render('welcome', array('role' => $this->role));
        //$this->render('home', array('role' => $this->role));
    }

    public function render404()
    {
        $this->render('404');
        //$this->render('home', array('projectList' => $projectList, 'role' => $this->role));
    }

    public function renderLogin($redirectUri)
    {
        $this->render('login', array('redirectUri' => $redirectUri));
    }

    public function render($page, $vars = array())
    {
        extract($vars);
        ob_start();

        $application = $this;
        require(ROOT_PATH . '/template/' . $page . '.php');

        $html = ob_get_contents();
        ob_end_clean();

        echo $html;
    }
}
