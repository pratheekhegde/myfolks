<?php
	require_once '../Core.fnc.php';
	session_start();
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
	
	//If there are input validations, redirect back
	if($_POST['year']==NULL || $_POST['branch']==NULL || $_POST['cat']==NULL) {
		header('location: index.php');
		exit();
	} 
	$_SESSION['SESS_RANK_FILT_Y']=$_POST['year'];
	$_SESSION['SESS_RANK_FILT_B']=$_POST['branch'];
	$_SESSION['SESS_RANK_FILT_C']=$_POST['cat'];
	header('location: ranking.php');
	header('target:mainiframe');
	exit();
?>