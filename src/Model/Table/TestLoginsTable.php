<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TestLogins Model
 *
 * @method \App\Model\Entity\TestLogin get($primaryKey, $options = [])
 * @method \App\Model\Entity\TestLogin newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TestLogin[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TestLogin|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TestLogin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TestLogin[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TestLogin findOrCreate($search, callable $callback = null, $options = [])
 */class TestLoginsTable extends Table
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

        $this->setTable('test_logins');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->integer('id')            ->allowEmpty('id', 'create');
        $validator
            ->boolean('canLogin')            ->requirePresence('canLogin', 'create')            ->notEmpty('canLogin');
        return $validator;
    }
}
