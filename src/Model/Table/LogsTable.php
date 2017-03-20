<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Logs Model
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

        $this->table('logs');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->requirePresence('global_number', 'create')
            ->notEmpty('global_number');

        $validator
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->date('datetime')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->decimal('latitude')
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->decimal('longitude')
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

        return $validator;
    }
    public function validationPassword(Validator $validator ) {
        $validator
            ->add(
                'old_password',
                'custom',
                [
                    'rule'=> function($value, $context){
                    $user = $this->get($context['data']['id']);
                        if ($user) {
                            if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                                return true;
                            }
                        }
                        return false;
                }, 'message'=>'The old password does not match the current password!',
                ]) ->notEmpty('old_password');
        $validator
            ->add(
                'password1',
                [
                    'length' => [
                        'rule' => ['minLength', 6],
                        'message' => 'The password have to be at least 6 characters!',
                    ]
                ])
            ->add(
                'password1',
                [
                    'match'=>[
                        'rule'=> ['compareWith','password2'],
                        'message'=>'The passwords does not match!',
                    ] ]) ->notEmpty('password1'); $validator ->add('password2', [ 'length' => [ 'rule' => ['minLength', 6], 'message' => 'The password have to be at least 6 characters!', ] ]) ->add('password2',[ 'match'=>[ 'rule'=> ['compareWith','password1'], 'message'=>'The passwords does not match!', ] ]) ->notEmpty('password2'); return $validator; }
}
