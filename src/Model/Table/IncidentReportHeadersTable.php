<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IncidentReportHeaders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Projects
 * @property \Cake\ORM\Association\HasMany $IncidentReportDetails
 *
 * @method \App\Model\Entity\IncidentReportHeader get($primaryKey, $options = [])
 * @method \App\Model\Entity\IncidentReportHeader newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IncidentReportHeader[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IncidentReportHeader|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IncidentReportHeader patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IncidentReportHeader[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IncidentReportHeader findOrCreate($search, callable $callback = null)
 */
class IncidentReportHeadersTable extends Table
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

        $this->table('incident_report_headers');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);        
        $this->belongsTo('Employees', [
            'foreignKey' => 'project_engineer'
        ]);
        $this->hasMany('IncidentReportDetails', [
            'foreignKey' => 'incident_report_header_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->integer('project_engineer')
            ->requirePresence('project_engineer', 'create')
            ->notEmpty('project_engineer');

        $validator
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        return $validator;
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
        $rules->add($rules->existsIn(['project_id'], 'Projects'));

        return $rules;
    }
}
