<?php
 session_start();
 
 //Alternative Database connection.
 $host = "localhost";
 $user = "root";
 $password = "kookies172001";
 $db = "dts_db";

 $data = mysqli_connect($host, $user, $password, $db);

 if($data === false){
    die("connection error: ". mysqli_connect_error());
}