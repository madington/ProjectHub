<?php

namespace ProjectHub;

define('ROOT_PATH', dirname(__DIR__));

require_once __DIR__ . '/../vendor/autoload.php';

use Elephant418\Model418\Core\Factory;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Application extends Factory
{


    /* ATTRIBUTES
     *************************************************************************/
    public $publicBaseUri = '/public';



    /* PUBLIC ACTION METHODS
     *************************************************************************/
    public function index()
    {
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
                'content' => $data['content']
            );
            array_unshift($value['timeline'], $note);
            $yaml = Yaml::dump($value);
            file_put_contents($file, $yaml);
            return $this->one($data['project']);
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
        /*
        $project = $this->newInstance('Project')->query()->fetchById($data['project']);
        echo "<pre>";
        print_r($project);
        */
        //print_r(array('View Notes' => '#', 'View Demo' => '#'));
        /*
        $note = $this->newInstance('Note')
            ->set('stamp', 'August 9th, 2016')
            ->set('content', 'Super awesome note');
        */

        /*
        $project->setNote();
        */
        /*
        $yaml = Yaml::dump($array);
        print_r($yaml);

        try {
            $value = Yaml::parse(file_get_contents('data/sample.yml'));
            print_r($value);
            $note = array(
                'stamp' => 'August 9th, 2016',
                'content' => 'Super awesome note'
            );
            array_unshift($value['timeline'], $note);
            $yaml = Yaml::dump($value);
            print_r($yaml);
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }

        */
        //$project->save();
        /*
            ->set('date', 'August 9th, 2016')
            ->set('content', 'Super awesome note')
            ->save();
        */
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
