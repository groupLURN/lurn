<?php
namespace App\Model\Table;

use App\Model\Entity\ManpowerTask;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ManpowerTasks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Manpower
 * @property \Cake\ORM\Association\BelongsTo $Tasks
 */
class ManpowerTasksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('manpower_tasks');
        $this->displayField('manpower_id');
        $this->primaryKey(['manpower_id', 'task_id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Manpower', [
            'foreignKey' => 'manpower_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['manpower_id'], 'Manpower'));
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));
        return $rules;
    }
}
