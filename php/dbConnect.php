<?php
    require("errorHandling.php");
    $con=mysqli_connect("localhost","root","","rotomark");
    if(!$con || $con->connect_error)
    {
        throw new Exception(mysqli_connect_error());
    }
?>