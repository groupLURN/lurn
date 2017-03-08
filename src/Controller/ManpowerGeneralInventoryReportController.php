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
 * ManpowerGeneralInventoryReport Controller
 *
 */
class ManpowerGeneralInventoryReportController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate += $this->createFinders($this->request->query, 'Manpower');
        $this->paginate['finder']['generalInventorySummary'] = [];
        $manpower = $this->paginate(TableRegistry::get('Manpower'));
        $this->set(compact('manpower'));

        $currentDate = Time::now();
        $currentDate = $currentDate->month . "/" . $currentDate->day . "/" . $currentDate->year;
        $this->set('currentDate', $currentDate);
    }

    public function view($download = null)
    {
        $this->viewBuilder()->layout('general');

        $this->paginate += $this->createFinders($this->request->query, 'Manpower');
        $this->paginate['finder']['generalInventorySummary'] = [];
        $manpower = $this->paginate(TableRegistry::get('Manpower'));
        $this->set(compact('manpower'));

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
                'pageSize' => 'Letter',
                'filename' => 'General_Manpower_Inventory_Report_' . $currentDate . '.pdf',
                'download' => $download
            ]           
        ]); 
    }
}
