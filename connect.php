<?php
   $hostname  = "localhost";
   $username  = "root";
   $password  = "";
   $dbname  = "tourism";
   $db = new mysqli($hostname, $username, $password, $dbname);
   $pdo = new PDO('mysql:host='.$hostname.';dbname='.$dbname, $username, $password);
?>