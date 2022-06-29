<?php
namespace App\Model\Table;

use App\Model\Entity\Task;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tasks Model
 *
 * @property (UsersTable & BelongsTo) $author
 * @property (UsersTable & BelongsTo) $executor
 *
 * @method Task get($primaryKey, $options = [])
 * @method Task newEntity($data = null, array $options = [])
 * @method Task[] newEntities(array $data, array $options = [])
 * @method Task|false save(EntityInterface $entity, $options = [])
 * @method Task saveOrFail(EntityInterface $entity, $options = [])
 * @method Task patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Task[] patchEntities($entities, array $data, array $options = [])
 * @method Task findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin TimestampBehavior
 */
class TasksTable extends Table
{
    /**
     * @inheritDoc
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('tasks');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior(TimestampBehavior::class);

        $this->belongsTo('author', [
            'className' => UsersTable::class,
            'foreignKey' => 'author_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('executor', [
            'className' => UsersTable::class,
            'foreignKey' => 'executor_id',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmptyString('type')
            ->inList('type', array_keys(Task::TYPE_TO_LABEL_MAP));

        $validator
            ->scalar('status')
            ->notEmptyString('status')
            ->inList('status', array_keys(Task::STATUS_TO_LABEL_MAP));

        $validator
            ->scalar('executor_comment')
            ->allowEmptyString('executor_comment');

        return $validator;
    }

    /**
     * @inheritDoc
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['author_id'], 'author'));
        $rules->add($rules->existsIn(['executor_id'], 'executor'));

        return $rules;
    }
}
