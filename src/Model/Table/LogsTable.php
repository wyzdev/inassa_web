<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Logs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Employees
 * @property \Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Log get($primaryKey, $options = [])
 * @method \App\Model\Entity\Log newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Log[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Log|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Log patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Log[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Log findOrCreate($search, callable $callback = null, $options = [])
 */
class LogsTable extends Table
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

        $this->setTable('logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

//        $this->belongsTo('Employees', [
//            'foreignKey' => 'employee_id',
//            'joinType' => 'INNER'
//        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
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
            //->requirePresence('first_name', 'create')
            ->allowEmpty('first_name');
        $validator
            //->requirePresence('last_name', 'create')
            ->allowEmpty('last_name');
        $validator
            ->date('dob')
            //->requirePresence('dob', 'create')
            ->allowEmpty('dob');
        $validator
            ->boolean('status')
            //->requirePresence('status', 'create')
            ->allowEmpty('status');
        $validator
            //->requirePresence('doctor_name', 'create')
            ->allowEmpty('doctor_name');
        $validator
            //->requirePresence('institution', 'create')
            ->allowEmpty('institution');
        $validator
            ->dateTime('date')
            //->requirePresence('date', 'create')
            ->allowEmpty('date');
        $validator
            ->boolean('is_dependant')
            //->requirePresence('is_dependant', 'create')
            ->allowEmpty('is_dependant');
        $validator
            //->requirePresence('primary_name', 'create')
            ->allowEmpty('primary_name');
        $validator
            //->requirePresence('hero', 'create')
            ->allowEmpty('hero');
        $validator
            //->requirePresence('user_id', 'create')
            ->allowEmpty('user_id');
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
        //$rules->add($rules->existsIn(['employee_id'], 'Employees'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
