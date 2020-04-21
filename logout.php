<?php
	session_start();
    
    if (isset($_SESSION['login']))
        unset($_SESSION['login']);
    if(isset($_SESSION['cargo']))
   	   unset($_SESSION['cargo']);
    header("Location: login.php");
?>
