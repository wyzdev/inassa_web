<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Locals Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Addresses
 * @property \Cake\ORM\Association\HasMany $Logs
 *
 * @method \App\Model\Entity\Local get($primaryKey, $options = [])
 * @method \App\Model\Entity\Local newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Local[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Local|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Local patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Local[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Local findOrCreate($search, callable $callback = null, $options = [])
 */
class LocalsTable extends Table
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

        $this->table('locals');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Addresses', [
            'foreignKey' => 'address_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Logs', [
            'foreignKey' => 'local_id'
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
            ->integer('local_code')
            ->requirePresence('local_code', 'create')
            ->notEmpty('local_code');

        $validator
            ->requirePresence('local_name', 'create')
            ->notEmpty('local_name');

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
        $rules->add($rules->existsIn(['address_id'], 'Addresses'));

        return $rules;
    }
}
