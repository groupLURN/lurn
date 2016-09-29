<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Utility\Inflector;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    protected $userId;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'authorize' => 'Controller',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => ['controller' => 'Users', 'action' => 'login'],
            'unauthorizedRedirect' => $this->referer()
        ]);

        $this->userId = $this->Auth->user('id');
    }

    public function beforeFilter(Event $event)
    {
        if($this->request->params['_ext'] === 'json')
        {
            $this->Auth->config('authenticate', ['Basic' => ['userModel' => 'Users']]);
            $this->Auth->config('storage', 'Memory');
            $this->Auth->config('unauthorizedRedirect', false);
        }

        return parent::beforeFilter($event);
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function paginate($object = null, array $settings = [])
    {
        if(!empty($this->paginate['finder']) && is_array($this->paginate['finder']))
        {
            foreach($this->paginate['finder'] as $finder => $options)
            {
                if(!isset($query))
                    $query = $object->find($finder, $options);
                else
                    $query = $query->find($finder, $options);
            }
            $object = $query;
            unset($this->paginate['finder']);
        }
        return parent::paginate($object);
    }

    public function createFinders(array $filters, $modelClass = null)
    {
        $modelClass = $modelClass === null? $this->modelClass: $modelClass;
        $model = $this->loadModel($modelClass);

        $finder = [];
        foreach($filters as $filter => $query)
        {
            $findMethod = 'By' . Inflector::camelize($filter);
            if(method_exists($model, 'Find' . $findMethod))
                $finder[$findMethod] = [$filter => $query];
        }
        return compact('finder');
    }

    public function isAuthorized($user)
    {
        // Initially, permit all access.
        return true;
    }

    protected function transpose(&$data, $key)
    {
        // Subject consists of N parallel arrays where its keys are the properties of the entity.
        $subject = isset($data[$key])?$data[$key]: null;
        $data[$key] = [];

        if($subject === null)
            return;

        $index = 0;
        foreach($subject as $property => $parallelArrays)
        {
            foreach($parallelArrays as $value)
            {
                $data[$key][$index][$property] = $value;
                $index++;
            }
            $index = 0;
        }
    }
}
