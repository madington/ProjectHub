<?php

namespace ProjectHub\Model;

use ProjectHub\Application;
use Elephant418\Model418\FileProvider as Provider;
use Elephant418\Model418\ModelQuery;
use Auth0\SDK\Store\SessionStore;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class ProjectModel extends ModelQuery
{


    /* MODEL METHODS
     *************************************************************************/
    protected function initSchema()
    {
        return array(
            'date',
            'stamp',
            'name',
            'timeline' => array()
        );
    }

    protected function initialize()
    {
        $this->initializeTimeline();
        $this->initializeStamp();
    }

    protected function initializeTimeline()
    {
        $timeline = array();
        if (is_array($this->timeline)) {
            foreach ($this->timeline as $index => $noteData) {
                $noteModel = (new Application)
                    ->newInstance('Note')
                    ->initByData($noteData);
                $timeline[] = $noteModel;
            }
        }
        $this->timeline = $timeline;
    }

    protected function initializeStamp()
    {
        $dateList = array();
        foreach ($this->timeline as $note) {
            if (is_object($note->date)) {
                $dateList[] = $note->date;
            }
        }
        if (count($dateList)) {
            $this->date = max($dateList);
            $this->stamp = $this->date->format("F j, Y");
        }
    }


    /* QUERY METHODS
     *************************************************************************/
    protected function initProvider()
    {
        $store = new SessionStore();
        $user = $store->get('user');
        $client = (isset($user['app_metadata']['client'])) ? $user['app_metadata']['client'] : 'sandbox';
        $provider = (new Provider)
            ->setFolder(__DIR__ . '/../../data/'.$client)
            ->setIdField('name');
        return $provider;
    }

    public function fetchAll($limit = null, $offset = null, &$count = false)
    {
        $projectList = parent::fetchAll($limit, $offset, $count);
        $projectList->uasort(array($this, 'compareDate'));
        return $projectList;
    }

    public function compareDate($a, $b)
    {
        if ($a->date == $b->date) {
            return 0;
        }
        return ($a->date > $b->date) ? -1 : 1;
    }

    public function saveNote($data, $client, $project){
        $file = __DIR__ . '/../../data/'.$client.'/'.$project.'.yml';
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
            return true;
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
            return false;
        }
    }

    public function saveProject($data, $client){
        $file = __DIR__ . '/../../data/'.$client.'/'.$client. '-'. md5(microtime(true)) . '.yml';
        $content = array('name' => $data['title'], 'timeline' => array(array('stamp' => date('r'), 'content' => 'Project start')));

        try {
            $yaml = Yaml::dump($content);
            file_put_contents($file, $yaml);
            return true;
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
            return false;
        }
    }

    public function deleteProject($p, $client){
        $file = __DIR__ . '/../../data/'.$client.'/'. $p . '.yml';

        try {
            unlink($file);
            return true;
        } catch (ParseException $e) {
            printf("Unable to delete YAML file: %s", $e->getMessage());
            return false;
        }
    }

}
