<?php
	require_once '../Core.fnc.php';
	session_start();
	$usn=$_SESSION['SESS_USN'];
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
	if($_POST['stars']==NULL || $_POST['cat']==NULL || $_POST['randuser']==NULL){
		header("location: ../");
		exit();
	}
	if($_SESSION['prevranduser']==$_POST['randuser']) goto end;
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	
	//Update the rate count,percent,rating
	$qry="SELECT * FROM `users` WHERE usn='".$_POST['randuser']."'";
	$res=mysql_query($qry);
	$randuser=mysql_fetch_assoc($res);
	if($randuser[$_POST['cat']]==NULL) $randuser[$_POST['cat']]="0|0|0";
	$userrate=explode("|",$randuser[$_POST['cat']]);
	$userrate[0]++;//increment total count
	$userrate[1]+=$_POST['stars'];//add rated stars
	$userrate[2]=($userrate[1]/($userrate[0]*5))*100;//calculate percent
	$userrate[2]=round($userrate[2],4);
	$newuserrate=implode("|",$userrate);
	
	//update the rating
	$query="UPDATE `users` SET `".$_POST['cat']."`='".$newuserrate."' WHERE usn='".$_POST['randuser']."'";
	if(!mysql_query($query,$bd)){
			die ("An unexpected error occured! USR_RAT_SAV, Please Let us know!");
	}
	end:
	$_SESSION['prevranduser']=$_POST['randuser'];
	header('location: rating.php');
	header('target:mainiframe');
?>