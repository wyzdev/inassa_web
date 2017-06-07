<center><h3>LOGS</h3></center>

<p style="
    margin: auto;
    padding: 25px;
    width: 70%;
    text-align: left;
    border: 1px solid grey;
    border-radius: 5px;
    line-height: 1.8;">
    <?php
    echo $log;
    ?>
</p>

<p style="left: 0px;float: right; top: 0px; position: relative; display: inline-block; padding: 20px;">[<u><?= $this->Html->link('Effacer les logs',
            [
                'controller' => 'logs',
                'action' => 'eraselogs'
            ]); ?>
    </u>]</p>