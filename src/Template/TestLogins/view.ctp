<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Test Login'), ['action' => 'edit', $testLogin->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Test Login'), ['action' => 'delete', $testLogin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $testLogin->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Test Logins'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Test Login'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="testLogins view large-9 medium-8 columns content">
    <h3><?= h($testLogin->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($testLogin->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('CanLogin') ?></th>
            <td><?= $testLogin->canLogin ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
