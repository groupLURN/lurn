<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Suppliers Controller
 *
 * @property \App\Model\Table\SuppliersTable $Suppliers
 */
class SuppliersController extends AppController
{
    public function isAuthorized($user)
    {        
        $employeeTypeId = isset($user['employee']['employee_type_id'])
            ? $user['employee']['employee_type_id'] : '';
        return in_array($employeeTypeId, [0, 4], true);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $paginate = [
            'fields' => ['Suppliers.id', 'Suppliers.name', 'Suppliers.contact_number', 'Suppliers.email', 'Suppliers.address'],
            'limit' => 25,
            'order' => [
                'Supplier.name' => 'asc'
            ]
        ];

        $this->paginate += $this->createFinders($this->request->query);

        $this->set($this->request->query);
        $this->set('suppliers', $this->paginate($this->Suppliers));
        $this->set('_serialize', ['suppliers']);
    }

    /**
     * View method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('MaterialsSuppliers');
        $this->loadModel('EquipmentSuppliers');

        $supplier = $this->Suppliers->get($id);
        $materials = $this->MaterialsSuppliers->find('bySupplier',['supplier_id' => $id])->toArray();
        $equipment = $this->EquipmentSuppliers->find('bySupplier',['supplier_id' => $id])->toArray();

        $this->set('supplier', $supplier);
        $this->set('materials', $materials);
        $this->set('equipment', $equipment);
        $this->set('_serialize', ['supplier']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $supplier = $this->Suppliers->newEntity();
        if ($this->request->is('post')) {
            $postData = $this->request->data;
            $supplier = $this->Suppliers->patchEntity($supplier, $postData);

            if ($this->Suppliers->save($supplier)) {
            
                $this->loadModel('MaterialsSuppliers');

                $materialList = isset($postData['materials']) ? $postData['materials'] : [];
                foreach ($materialList as $material) {
                    $materialsSuppliers = $this->MaterialsSuppliers->newEntity();
                    $materialsSuppliers->supplier_id = $supplier->id;
                    $materialsSuppliers->material_id = $material;

                    $this->MaterialsSuppliers->save($materialsSuppliers);
                }

                $this->loadModel('EquipmentSuppliers');

                $equipmentList = isset($postData['equipment']) ? $postData['equipment'] : [];
                foreach ($equipmentList as $equipment) {
                    $equipmentSuppliers = $this->EquipmentSuppliers->newEntity();
                    $equipmentSuppliers->supplier_id    = $supplier->id;
                    $equipmentSuppliers->equipment_id   = $equipment;

                    $this->EquipmentSuppliers->save($equipmentSuppliers);
                }

                $this->Flash->success(__('The supplier has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
            }
        }

        $this->loadModel('Materials');
        $this->loadModel('Equipment');

        $materials = $this->Materials->find('list')->toArray();
        $equipment = $this->Equipment->find('list')->toArray();

        $this->set(compact('supplier', 'materials', 'equipment'));
        $this->set('_serialize', ['supplier', 'materials', 'equipment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Supplier id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $supplier = $this->Suppliers->get($id, [
            'contain' => ['Materials', 'Equipment']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $postData = $this->request->data;
            $supplier = $this->Suppliers->patchEntity($supplier, $this->request->data);

            if ($this->Suppliers->save($supplier)) {
            
                $this->loadModel('MaterialsSuppliers');
                
                $this->MaterialsSuppliers->deleteAll([
                    'supplier_id' => $supplier->id
                ]);

                $materialList = isset($postData['materials']) ? $postData['materials'] : [];
                foreach ($materialList as $material) {
                    $materialsSuppliers = $this->MaterialsSuppliers->newEntity();
                    $materialsSuppliers->supplier_id = $supplier->id;
                    $materialsSuppliers->material_id = $material;

                    $this->MaterialsSuppliers->save($materialsSuppliers);
                }

                $this->loadModel('EquipmentSuppliers');
                
                $this->EquipmentSuppliers->deleteAll([
                    'supplier_id' => $supplier->id
                ]);


                $equipmentList = isset($postData['equipment']) ? $postData['equipment'] : [];
                foreach ($equipmentList as $equipment) {
                    $equipmentSuppliers = $this->EquipmentSuppliers->newEntity();
                    $equipmentSuppliers->supplier_id    = $supplier->id;
                    $equipmentSuppliers->equipment_id   = $equipment;

                    $this->EquipmentSuppliers->save($equipmentSuppliers);
                }      

                $this->Flash->success(__('The supplier has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The supplier could not be saved. Please, try again.'));
            }
        }

        $materialsId = [];
        foreach ($supplier->materials as $material) {
            array_push($materialsId, $material->id);
        }

        $supplier->materials = $materialsId;

        $equipmentId = [];
        foreach ($supplier->equipment as $equipment) {
            array_push($equipmentId, $equipment->id);
        }

        $supplier->equipment = $equipmentId;

        $this->loadModel('Materials');
        $this->loadModel('Equipment');

        $materials = $this->Materials->find('list')->toArray();
        $equipment = $this->Equipment->find('list')->toArray();

        $this->set(compact('supplier', 'materials', 'equipment'));
        $this->set('_serialize', ['supplier', 'materials', 'equipment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Supplier id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $supplier = $this->Suppliers->get($id);
        if ($this->Suppliers->delete($supplier)) {
            $this->Flash->success(__('The supplier has been deleted.'));
        } else {
            $this->Flash->error(__('The supplier could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
