<center><h3>LOGS</h3></center>



<p style="right: 0px; top: 50px; position: absolute; display: inline-block; padding: 20px;">
    [<u>
        <?= $this->Html->link('Effacer les logs',
            [
                'action' => 'eraselogs'
            ]); ?>
    </u>]
</p>

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


<!--/////////////////////////////// LOADER /////////////////////////////////////////-->
<div id="content_loader" style="background: #fff; height: 100vh;  top:0px; left: 0px; right: 0px; position: absolute; z-index: 2;">
    <div id="loader"></div>
</div>