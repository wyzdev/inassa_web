<?php $test = json_decode($result); ?>

<style>
    .card{
        display: inline-block;
        width: 50%;
        background: #fff;
        box-shadow: 3px 3px 3px #afafaf;
        font-size: 3em;
        border: 1px solid #ddd;
        color: <?php echo ($test->error) ? '#d9534f' : '#5cb85c'?>;
        margin-top: 50px;
    }

    .card .icon{
        font-size: 4.5em;
    }

    .card .text {
        font-weight: bold;
    }
</style>



<div class="container text-center">
    <div class="card">
        <p class="icon"><i class="fa <?php echo ($test->error) ? 'fa-close' : 'fa-check' ?>"></i></p>
        <p class="text"><?php echo ($test->error) ? 'Test échoué.' : 'Test réussi.' ?></p>
    </div>
</div>
