
<div class="container-fluid">

    <div class="row">
        <div class="">
            <p class="text-right">
                [<u>
                    <a href="#myModal_confirmation" data-toggle="modal" style="cursor: pointer;" id="clear_logs">Effacer les logs</a>
                </u>]
            </p>
        </div>
    </div>

    <center><h3 style="display: inline-block;">LOGS</h3></center>






    <p id="content_logs" style="
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
</div>


<!--/////////////////////////////// LOADER /////////////////////////////////////////-->
<div id="content_loader" style="background: #fff; height: 100vh;  top:0px; left: 0px; right: 0px; position: absolute; z-index: 2;">
    <div id="loader"></div>
</div>

<!-- Modal HTML -->
<div id="myModal_confirmation" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Confirmation</h3>
            </div>
            <div class="modal-body" id="reset-user_modal-body">

            </div>
            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">NON</button>
                <button type="button" class="btn btn-danger confirmation_clear" data-dismiss="modal">OUI</button>
            </div>
        </div>
    </div>
</div>