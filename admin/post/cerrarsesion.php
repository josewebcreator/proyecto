<?php

    if(isset($_GET['destroy'])){
        session_start();
        session_destroy();
        header("location:../index.php");
    }
    

?>