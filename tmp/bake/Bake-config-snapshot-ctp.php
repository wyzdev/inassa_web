<?php
/**
 * Copyright (c) INASSA
 *
 * @copyright     Copyright (c) INASSA 2017
 * @link          http://nassagroup.com
 */

use Cake\Database\Schema\Table;

$constraints = $foreignKeys = $dropForeignKeys = [];
$hasUnsignedPk = $this->Migration->hasUnsignedPrimaryKey($tables);

if ($autoId && $hasUnsignedPk) {
    $autoId = false;
}
?>
<CakePHPBakeOpenTagphp
use Migrations\AbstractMigration;

class <?= $name ?> extends AbstractMigration
{
<?php if (!$autoId): ?>

    public $autoId = false;

<?php endif; ?>
    public function up()
    {
<?php echo $this->element('Migrations.create-tables', ['tables' => $tables, 'autoId' => $autoId, 'useSchema' => false]) ?>
    }

    public function down()
    {
<?php if (!empty($this->Migration->returnedData['dropForeignKeys'])):
            foreach ($this->Migration->returnedData['dropForeignKeys'] as $table => $columnsList):
                $maxKey = count($columnsList) - 1;
        ?>
        $this->table('<?= $table ?>')
<?php foreach ($columnsList as $key => $columns): ?>
            ->dropForeignKey(
                <?= $columns ?>

            )<?= ($key === $maxKey) ? ';' : '' ?>

<?php endforeach; ?>

<?php endforeach;
            endif;
        ?>
<?php foreach ($tables as $table): ?>
        $this->dropTable('<?= $table?>');
<?php endforeach; ?>
    }
}
