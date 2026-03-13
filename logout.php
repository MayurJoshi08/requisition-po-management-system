<?php session_start(); 
$_SESSION['dcname']='';
$cmpny=$_SESSION['dccmpny'];
	header('Location:login.php');
?>