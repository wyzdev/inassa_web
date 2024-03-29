<?php
/**
 * Copyright (c) INASSA
 *
 * @copyright     Copyright (c) INASSA 2017
 * @link          http://nassagroup.com
 */
$compact = ["'" . $singularName . "'"];
?>

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $<?= $singularName ?> = $this-><?= $currentModelName ?>->newEntity();
        if ($this->request->is('post')) {
            $<?= $singularName ?> = $this-><?= $currentModelName ?>->patchEntity($<?= $singularName ?>, $this->request->getData());
            if ($this-><?= $currentModelName; ?>->save($<?= $singularName ?>)) {
                $this->Flash->success(__('The <?= strtolower($singularHumanName) ?> has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The <?= strtolower($singularHumanName) ?> could not be saved. Please, try again.'));
        }
<?php
        $associations = array_merge(
            $this->Bake->aliasExtractor($modelObj, 'BelongsTo'),
            $this->Bake->aliasExtractor($modelObj, 'BelongsToMany')
        );
        foreach ($associations as $assoc):
            $association = $modelObj->association($assoc);
            $otherName = $association->getTarget()->getAlias();
            $otherPlural = $this->_variableName($otherName);
?>
        $<?= $otherPlural ?> = $this-><?= $currentModelName ?>-><?= $otherName ?>->find('list', ['limit' => 200]);
<?php
            $compact[] = "'$otherPlural'";
        endforeach;
?>
        $this->set(compact(<?= join(', ', $compact) ?>));
        $this->set('_serialize', ['<?=$singularName?>']);
    }
