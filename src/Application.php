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

        $userInfo = $auth0->getUser();

        if (!$userInfo) {
            // We have no user info
            $this->renderLogin($config->get('redirect_uri'));
            die;
        }

        if (isset($_POST['project'])) {
            # Save new project /?project=sample&content=Kickoff+Meeting&link-title[]=View notes&link-url[]=http://www.google.com
            $result = $this->saveNote($_POST);
        }else if (isset($_POST['note'])) {
            # save new note

        }else if (isset($_GET['project'])) {
            $result = $this->one($_GET['project']);
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
            $project = array_pop($projectList);
            $this->renderProject($project, 1);
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
        $file = 'data/'.$data['project'].'.yml';
        try {
            $value = Yaml::parse(file_get_contents($file));
            $note = array(
                'stamp' => $data['stamp'],
                'content' => $data['content'],
            );
            if (isset($data['link-title']) && !empty($data['link-title'])) {
                $noteLinks = [];
                for ($i=0; $i < count($data['link-title']); $i++) {
                    $note['links'][$data['link-title'][$i]] = $data['link-url'][$i];
                }
            }

            array_unshift($value['timeline'], $note);
            $yaml = Yaml::dump($value);
            file_put_contents($file, $yaml);
            return $this->one($data['project']);
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
    }



    /* PROTECTED METHODS
     *************************************************************************/
    public function renderProject($project, $projectCount)
    {
        $this->render('project', array('project'=> $project, 'projectCount'=> $projectCount));
    }

    public function renderProjectList($projectList)
    {
        $this->render('home', array('projectList'=> $projectList));
    }

    public function renderTutorial()
    {
        $this->render('welcome');
    }

    public function render404()
    {
        $this->render('404');
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
        require(ROOT_PATH.'/template/'.$page.'.php');

        $html = ob_get_contents();
        ob_end_clean();

        echo $html;
    }

}
