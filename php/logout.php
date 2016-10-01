<?php
    session_start();
//setcookie("user",$_SESSION['user'],strtotime("-1 day"));
    session_destroy();
    header("location:../index.html");
	exit;
?>