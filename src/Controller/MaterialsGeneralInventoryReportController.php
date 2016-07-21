<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Equipment;
use Cake\Collection\Collection;
use Cake\Core\Exception\Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

/**
 * MaterialsGeneralInventoryReport Controller
 *
 */
class MaterialsGeneralInventoryReportController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate += $this->createFinders($this->request->query, 'Materials');

        if(!empty($this->request->query['project_id']))
            $this->paginate['finder']['generalInventorySummary'] = ['project_id' => $this->request->query['project_id']];
        else
            $this->paginate['finder']['generalInventorySummary'] = [];

        $materials = $this->paginate(TableRegistry::get('Materials'));
        $this->set(compact('materials'));

        $currentDate = Time::now();
        $currentDate = $currentDate->month . "/" . $currentDate->day . "/" . $currentDate->year;
        $this->set('currentDate', $currentDate);
    }

    public function view($download = null)
    {
        $this->viewBuilder()->layout('general');

        $this->paginate += $this->createFinders($this->request->query, 'Materials');

        if(!empty($this->request->query['project_id']))
            $this->paginate['finder']['generalInventorySummary'] = ['project_id' => $this->request->query['project_id']];
        else
            $this->paginate['finder']['generalInventorySummary'] = [];

        $materials = $this->paginate(TableRegistry::get('Materials'));
        $this->set(compact('materials'));
        
        $currentDate = Time::now();
        $currentDate = $currentDate->month . "/" . $currentDate->day . "/" . $currentDate->year;
        $this->set('currentDate', $currentDate);

        if ($download == 1)
            $download = true;
        else
            $download = false;

        $this->viewBuilder()->options([
            'pdfConfig' => [
                'orientation' => 'landscape',
                'filename' => 'General_Materials_Inventory_Report_' . $currentDate . '.pdf',
                'download' => $download
            ]           
        ]); 
    }
}
