<?php

use G28\WoocommerceMemberkit\Logger;

$log = Logger::getInstance()->getLogContent();

?>

<div class="wrap">
    <h1>Memberkit</h1>
    <p>Log:</p>
    <div id="logFileContent" style="margin: 0;
    padding: 2rem;
    height: 400px;
    background-color: white;
    border: 1px solid #DCDCDE;
    overflow-y: auto;">
        <?php echo $log ?>
    </div>


</div>