<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $log->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $log->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Logs'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="logs form large-9 medium-8 columns content">
    <?= $this->Form->create($log) ?>
    <fieldset>
        <legend><?= __('Edit Log') ?></legend>
        <?php
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('dob');
            echo $this->Form->control('status');
            echo $this->Form->control('doctor_name');
            echo $this->Form->control('institution');
            echo $this->Form->control('date');
            echo $this->Form->control('employee_id');
            echo $this->Form->control('is_dependant');
            echo $this->Form->control('primary_name');
            echo $this->Form->control('hero');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
