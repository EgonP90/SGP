<?php
    session_start(["session_sgp"]);
    $date = date('ymdhis');
    header("Content-type: application/vnd.ms-excel");
    header("Content-type: application/force-download");
    header("Content-Disposition: attachment; filename=".$date.".xls");
    header("Pragma: no-cache");
    if(isset($_SESSION["sgp_result_rel"])){
        echo $_SESSION["sgp_result_rel"];
    }
?>