<?php

include('auth.php');
require_once('include/include-head.php');
require_once('include/include-main.php');
require_once('proc/config.php');

?>



<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <span style="font-size:x-large;font-weight:bold;">REPORTS SECTION</span>
            </div>
        </div>

        <?php require_once('message.php'); ?>

        <div class="panel-body">

             <div class="col-lg-4 col-lg-offset-2">
                <div class="bs-component counter-div text-center">

                    <a href="biometrics_logs.php" style="text-decoration:none;">
                        <div class="alert alert-info counter-div pnelHover" id="panel_1">
                            <span class="counter-number"> Attendance</span><br>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bs-component counter-div text-center">

                    <a href="biometrics_detailed_logs.php" style="text-decoration:none;">
                        <div class="alert alert-info counter-div pnelHover" id="panel_1">
                            <span class="counter-number"> Data Logs</span><br>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/script_Reports.js"></script>
