<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Local'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Logs'), ['controller' => 'Logs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Log'), ['controller' => 'Logs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="locals index large-9 medium-8 columns content">
    <h3><?= __('Locals') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('local_code') ?></th>
                <th scope="col"><?= $this->Paginator->sort('address_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('local_name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($locals as $local): ?>
            <tr>
                <td><?= $this->Number->format($local->id) ?></td>
                <td><?= $this->Number->format($local->local_code) ?></td>
                <td><?= $local->has('address') ? $this->Html->link($local->address->id, ['controller' => 'Addresses', 'action' => 'view', $local->address->id]) : '' ?></td>
                <td><?= h($local->local_name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $local->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $local->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $local->id], ['confirm' => __('Are you sure you want to delete # {0}?', $local->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
