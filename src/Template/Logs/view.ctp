<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Log'), ['action' => 'edit', $log->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Log'), ['action' => 'delete', $log->id], ['confirm' => __('Are you sure you want to delete # {0}?', $log->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Logs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Log'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Locals'), ['controller' => 'Locals', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Local'), ['controller' => 'Locals', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="logs view large-9 medium-8 columns content">
    <h3><?= h($log->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Global Number') ?></th>
            <td><?= h($log->global_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('First Name') ?></th>
            <td><?= h($log->first_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Last Name') ?></th>
            <td><?= h($log->last_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Local') ?></th>
            <td><?= $log->has('local') ? $this->Html->link($log->local->id, ['controller' => 'Locals', 'action' => 'view', $log->local->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($log->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($log->date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $log->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
