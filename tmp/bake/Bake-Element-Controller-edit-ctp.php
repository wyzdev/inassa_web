<?php
/**
 * Copyright (c) INASSA
 *
 * @copyright     Copyright (c) INASSA 2017
 * @link          http://nassagroup.com
 */

$belongsTo = $this->Bake->aliasExtractor($modelObj, 'BelongsTo');
$belongsToMany = $this->Bake->aliasExtractor($modelObj, 'BelongsToMany');
$compact = ["'" . $singularName . "'"];
?>

    /**
     * Edit method
     *
     * @param string|null $id <?= $singularHumanName ?> id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $<?= $singularName ?> = $this-><?= $currentModelName ?>->get($id, [
            'contain' => [<?= $this->Bake->stringifyList($belongsToMany, ['indent' => false]) ?>]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $<?= $singularName ?> = $this-><?= $currentModelName ?>->patchEntity($<?= $singularName ?>, $this->request->getData());
            if ($this-><?= $currentModelName; ?>->save($<?= $singularName ?>)) {
                $this->Flash->success(__('The <?= strtolower($singularHumanName) ?> has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The <?= strtolower($singularHumanName) ?> could not be saved. Please, try again.'));
        }
<?php
        foreach (array_merge($belongsTo, $belongsToMany) as $assoc):
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
