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
 * MaterialsProjectInventoryReport Controller
 *
 * @property \App\Model\Table\MaterialsProjectInventoriesTable $MaterialsProjectInventories
 */
class MaterialsProjectInventoryReportController extends AppController
{
    private $_projectId = null;

    public function beforeFilter(Event $event)
    {
        if(empty($this->request->params['pass'])) {
            return $this->redirect(['controller' => 'dashboard']);
        }

        $this->loadModel('Projects');
        $this->viewBuilder()->layout('project_management');
        $projectId = (int) $this->request->params['pass'][0];
        
        $this->set('projectId', $projectId);
        
        $project = $this->Projects->find('byId', ['project_id' => $projectId])->first();

        $this->set('isFinished', $project->is_finished );

        $this->set('projectId', $projectId);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($id = null)
    {
        $this->paginate += $this->createFinders($this->request->query, 'Materials');
        
        if(!isset($this->request->query['milestone_id'])) {
            $this->request->query['milestone_id'] = 0;
        }

        if (isset($this->request->query['start_date']) && isset($this->request->query['end_date']))
            $this->paginate['finder']['projectInventorySummary'] = [
                'project_id' => $id,
                'milestone_id' => $this->request->query['milestone_id'],
                'start_date' => $this->request->query['start_date'], 
                'end_date' => $this->request->query['end_date']];
        else 
            $this->paginate['finder']['projectInventorySummary'] = [
                'project_id' => $id,
                'milestone_id' => $this->request->query['milestone_id']
            ];
        $materials = $this->paginate(TableRegistry::get('Materials'));

        $this->paginate += $this->createFinders($this->request->query, 'Projects');
        $this->paginate['finder']['ById'] = ['project_id' => $id];
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
        $this->set(compact('materials', 'projects'));
        $this->set($this->request->query);
        $this->set('_serialize', ['materials', 'projects']);
    }

    public function view($id = null, $download = null)
    {
        $this->viewBuilder()->layout('project');

        $this->paginate += $this->createFinders($this->request->query, 'Materials');
        
        if(!isset($this->request->query['milestone_id'])) {
            $this->request->query['milestone_id'] = 0;
        }

        if (isset($this->request->query['start_date']) && isset($this->request->query['end_date']))
            $this->paginate['finder']['projectInventorySummary'] = [
                'project_id' => $id,
                'milestone_id' => $this->request->query['milestone_id'],
                'start_date' => $this->request->query['start_date'], 
                'end_date' => $this->request->query['end_date']];
        else 
            $this->paginate['finder']['projectInventorySummary'] = [
                'project_id' => $id,
                'milestone_id' => $this->request->query['milestone_id']
            ];
        $materials = $this->paginate(TableRegistry::get('Materials'));

        $this->paginate += $this->createFinders($this->request->query, 'Projects');
        $this->paginate['finder']['ById'] = ['project_id' => $id];
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
        $this->set(compact('materials', 'projects'));
        $this->set($this->request->query);
        $this->set('_serialize', ['materials', 'projects']);

        if ($download == 1)
            $download = true;
        else
            $download = false;

        $this->viewBuilder()->options([
            'pdfConfig' => [
                'orientation' => 'landscape',
                'filename' => 'Project_Materials_Inventory_Report_' . $currentDate . '.pdf',
                'download' => $download
            ]           
        ]); 
    }
}
