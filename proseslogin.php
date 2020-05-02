<?php
   session_start();
   $timeout = 1;
   $logout_redirect_url = "login.php";

   require_once("connect.php");
   $username = $_POST['username'];
   $password = md5($_POST['password']);
   $sql = "SELECT * FROM user WHERE username = '$username'";
   $query = $db->query($sql);
   $hasil = $query->fetch_assoc();
   if($query->num_rows == 0) {
     echo "<div align='center'>Username Belum Terdaftar! <a href='login.php'>Back</a></div>";
   } else {
     if($password <> $hasil['password']) {
       echo "<div align='center'>Password salah! <a href='login.php'>Back</a></div>";
     } else {
     		$_SESSION['username'] = $hasil['username'];
        $_SESSION['status'] = "login";
        header('location:home.php');
     	}
   header('login.php');}
?>