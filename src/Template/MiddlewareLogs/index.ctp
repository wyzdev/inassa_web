<?= $this->assign('title', 'INASSA - Logs Middleware'); ?>


<?= $this->Html->css('middleware_logs'); ?>
<?= $this->Html->script('middleware_logs', ['block' => true]) ?>

<style>
    td {

        width: 50px;
    }

    select {
        height: 30px;
        padding: 5px 10px;
        font-size: 12px;
        line-height: 1.5;
        border-radius: 3px;
        border: 1px #eee solid;
    }

    td, th {
        display: inline-block;
        width: 200px;
    }

    .sorting select, .sorting_desc select, .sorting_asc select {
        display: inline-block;
        width: 150px;
    }

    .sorting, .sorting_desc, .sorting_asc {
        margin: 0 5px;
    }

    tbody, thead, tfoot {
        /*text-align: center !important;*/
    }

    .table {
        width: 1020px !important;
        text-align: center !important;
    }

</style>


<div class='container text-center table-responsive' style='margin-top: 50px'>
    <center>
        <table id='example1' class='table table-striped table-hover table-condensed dataTable'>
            <thead>
            <tr>
                <td class="text-center">Date</td>
                <td class="text-center">Heure</td>
                <td class="text-center">Message</td>
                <td class="text-center">Source</td>
                <td class="text-center">Institution</td>
            </tr>
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Heure</th>
                <th class="text-center">Message</th>
                <th class="text-center">Source</th>
                <th class="text-center">Institution</th>
            </tr>
            </thead>


            <tbody>
            <?php foreach ($middlewareLogs as $middleware_log): ?>
                <tr>
                    <td class="text-center"><?= date('d/m/Y', strtotime($middleware_log->date)); ?></td>
                    <td class="text-center"><?= date('H:i:s', strtotime($middleware_log->date)); ?></td>
                    <td class="text-center message_cell">
                        <?php if (!empty($middleware_log->message) and $middleware_log->message != NULL) {
                            if ($middleware_log->message == "null")
                                echo '';
                            else
                                echo $middleware_log->message;
                            /* if (json_decode($middleware_log->message->error))
                                 echo $middleware_log->message;
                             else
                                 echo json_encode(json_decode($middleware_log->message)[0]->Response);*/
                        } ?>
                        <?php


                        ?>
                    </td>
                    <td class="text-center"><?= $middleware_log->user->first_name . ' ' . $middleware_log->user->first_name ?></td>
                    <td class="text-center"><?= $middleware_log->user->institution ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>

            <tfoot>
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Heure</th>
                <th class="text-center">Message</th>
                <th class="text-center">Source</th>
                <th class="text-center">Institution</th>
            </tr>
            </tfoot>
        </table>

    </center>
</div>


