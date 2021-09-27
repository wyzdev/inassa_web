<?php
/**
 * Copyright (c) INASSA
 *
 * @copyright     Copyright (c) INASSA 2017
 * @link          http://nassagroup.com
 */
?>

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
<?php $belongsTo = $this->Bake->aliasExtractor($modelObj, 'BelongsTo'); ?>
<?php if ($belongsTo): ?>
        $this->paginate = [
            'contain' => [<?= $this->Bake->stringifyList($belongsTo, ['indent' => false]) ?>]
        ];
<?php endif; ?>
        $<?= $pluralName ?> = $this->paginate($this-><?= $currentModelName ?>);

        $this->set(compact('<?= $pluralName ?>'));
        $this->set('_serialize', ['<?= $pluralName ?>']);
    }
