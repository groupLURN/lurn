<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Notifications Controller
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 */
class NotificationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {        
        $this->paginate = [
            'limit' => 15,
            'finder' =>
                array_merge( 
                    [
                        'ByUserId' => [
                                'user_id' => $this->Auth->user('id'),
                            ]
                    ]
                )
        ];

        $this->set('notifications', $this->paginate($this->Notifications));
        $this->set('_serialize', ['notifications']);
    }      

    /**
    * Method for getting new unread notifications from the database
    *
    * @return json response
    */
    public function getUnreadNotificationsCount() {
       
        $notifications = $this->Notifications->find('unreadNotifications', ['user_id' => $this->request->session()->read('Auth.User.id')])->toArray();

        $response = [];

        $response['status'] = 'success';
        $response['data']   = ['count' => count($notifications)];

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }  
}
