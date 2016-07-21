<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Equipment;
use Cake\Collection\Collection;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * EquipmentProjectInventoryReport Controller
 *
 * @property \App\Model\Table\EquipmentProjectInventoriesTable $EquipmentProjectInventories
 */
class EquipmentProjectInventoryReportController extends AppController
{
    private $_projectId = null;

    public function beforeFilter(Event $event)
    {
        if(!isset($this->request->query['project_id']))
            return $this->redirect(['controller' => 'dashboard']);

        $this->viewBuilder()->layout('project_management');
        $this->_projectId = (int) $this->request->query['project_id'];

        $this->set('projectId', $this->_projectId);
        return parent::beforeFilter($event);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate += $this->createFinders($this->request->query, 'EquipmentInventories');
        $this->paginate['finder']['projectInventorySummary'] = [
            'project_id' => $this->_projectId, 
            'start_date' => $this->request->query['start_date'], 
            'end_date' => $this->request->query['end_date']];
        $equipmentInventories = $this->paginate(TableRegistry::get('EquipmentInventories'));

        $this->paginate += $this->createFinders($this->request->query, 'Projects');
        $this->paginate['finder']['ByProjectId'] = ['project_id' => $this->_projectId];
        $projects = $this->paginate(TableRegistry::get('Projects'));

        if (isset($this->request->query['start_date']) && isset($this->request->query['end_date'])):
            $start_date = Time::parse($this->request->query['start_date']);
            $end_date = Time::parse($this->request->query['end_date']);
            $currentDate = $start_date->month . "/" . $start_date->day . "/" . $start_date->year . " - " . $end_date->month . "/" . $end_date->day . "/" . $end_date->year;
        else:
            $currentDate = Time::now();
            $currentDate = $currentDate->month . "/" . $currentDate->day . "/" . $currentDate->year;
        endif;
        
        $this->set('currentDate', $currentDate);
        $this->set(compact('equipmentInventories', 'projects'));
        $this->set($this->request->query);
        $this->set('_serialize', ['equipmentInventories', 'projects']);
    }
}
