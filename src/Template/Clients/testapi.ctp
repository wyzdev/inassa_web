<?php $test = json_decode($result); ?>

<style>
    .card {
        padding: 20px;
        display: inline-block;
        width: 50%;
        background: #fff;
        box-shadow: 3px 3px 3px #afafaf;
        border: 1px solid #ddd;
        color: <?php echo ($test->error) ? '#d9534f' : '#5cb85c'?>;
        margin-top: 50px;
    }

    .card .icon {
        font-size: 5em;
    }

    .card .text {
        font-size: 3em;
        font-weight: bold;
    }
    .error_api{
        padding: 10px;
        border: solid 1px #bbb;
        color: #000;
        margin-left: 10%;
        margin-right: 10%;
    }
</style>


<div class="container text-center">
    <div class="card">
        <p class="icon"><i class="fa <?php echo ($test->error) ? 'fa-close' : 'fa-check' ?>"></i></p>
        <p class="text"><?php echo ($test->error) ? 'Test échoué' : 'Test réussi' ?></p>

        <?php if ($test->error): ?>

        <p class="error_api text-left">
            <?= $test->api_response ?>
        </p>

        <?= $this->Html->link(
            '<i class="fa fa-cog"></i>' . ' Envoyez un mail avec la reponse de l\'API', [
            'controller' => 'clients',
            'action' => 'sendresponseapi'
        ],
            [
                'class' => 'btn btn-primary',
                'escape' => false
            ]); ?>

        <?php endif; ?>

    </div>
</div>
