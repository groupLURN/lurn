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
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Log\Log;
use Psy\Shell as PsyShell;

/**
 * Simple console wrapper around Psy\Shell.
 */
class NotificationsShell extends Shell
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Notifications');
        $this->loadModel('Projects');
    }

    public function main()
    {
        $this->updateNotifications();
    }   

    private function updateNotifications()
    {

        // $notification = $this->Notifications->newEntity();
        // $link =  'This is just a test';
        // $notification->link = $link;
        // $notification->message = 'test message';
        // $notification->user_id = 2;
        // $notification->project_id = 1;
        // $this->Notifications->save($notification);
        $projects = $this->Projects->find('allWithEmployees')->toArray();

        debug($projects);

    }
}
