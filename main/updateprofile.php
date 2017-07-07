<?php
	require_once '../Core.fnc.php';
	session_start();
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
	if($_POST['relstat']==NULL){
		header("location: ../");
		exit();
	}
	$gender=$_POST['gender'];
	$nickname=mysql_real_escape_string($_POST['nickname']);
	$aboutme=mysql_real_escape_string($_POST['aboutme']);
	$relstat=$_POST['relstat'];
	$interest=implode(",",$_POST['Interest']);
	$usn=$_SESSION['SESS_USN'];
	
	//connect database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$query="UPDATE `users` SET gender='".$gender."', nickname='".$nickname."', aboutme='".$aboutme."', relstat='".$relstat."', interests='".$interest."' WHERE usn='".$usn."'";
	if(!mysql_query($query,$bd)){
		die ("<h3>Looks like something went wrong while saving, Please Try again!</h3>");
	}
	//Update ACS if acs=2
	if($_SESSION['SESS_ACS']==2){
			$query="UPDATE `users` SET acs=3 WHERE usn='".$usn."'";
			if(!mysql_query($query,$bd)){
				die ("An unexpected error occured while saving the record, Please try again!");
			}
			$_SESSION['SESS_ACS']=3;
			header('location: rating.php');
			header('target:mainiframe');
			exit();
	}
	header('location: editprofile.php');
	header('target:mainiframe');
	exit();
	
	?>

