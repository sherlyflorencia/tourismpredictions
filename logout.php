<?php
	 $logout_redirect_url = "login.php";
     session_start();

     unset($_SESSION["username"]);

     session_destroy();
     echo "<script>alert('Thank you!'); window.location = '$logout_redirect_url'</script>";
     exit();

?>