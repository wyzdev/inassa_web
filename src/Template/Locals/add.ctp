<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Locals'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Logs'), ['controller' => 'Logs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Log'), ['controller' => 'Logs', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="locals form large-9 medium-8 columns content">
    <?= $this->Form->create($local) ?>
    <fieldset>
        <legend><?= __('Add Local') ?></legend>
        <?php
            echo $this->Form->input('local_code');
            echo $this->Form->input('address_id', ['options' => $addresses]);
            echo $this->Form->input('local_name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
