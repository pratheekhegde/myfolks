<?php
	require_once '../Core.fnc.php';
	session_start();
	//redirect to home if manually loaded
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
	//connect database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
		
 	//If there are input validations, redirect back to
		if($_POST['oldpass']==NULL || $_POST['newpass']==NULL || $_POST['rnewpass']==NULL) {
		$_SESSION['UpdatePassFlag']=1;//OldPass or NewPass is missing.
		session_write_close();
		header('location: changepassword.php');
		header('target:mainiframe');
		exit();
	} 
	
	//Filter the POST values
	$oldpass =clean($_POST['oldpass']);
	$newpass =clean($_POST['newpass']);
	$rnewpass =clean($_POST['rnewpass']);
	$usn=$_SESSION['SESS_USN'];
	echo $_SESSION['SESS_USN'];
	//echo $oldpass;echo "<br>";
	//echo $newpass;echo "<br>";
	if($newpass!=$rnewpass){
		$_SESSION['UpdatePassFlag']=7;//New Passwords didnt match.
		session_write_close();
		header('location: changepassword.php');
		header('target:mainiframe');
		exit();
	}
	//Check if Old Password is correct or not
	$qry="SELECT * FROM users WHERE usn='$usn'";
	$result=mysql_query($qry);
	$user = mysql_fetch_assoc($result);
	echo Actualpass;
	echo "<br>";echo $user['password'];
	if($oldpass!=$user['password']){
		$_SESSION['UpdatePassFlag']=2;//OldPass is incorrect.
		session_write_close();
		header('location: changepassword.php');
		header('target:mainiframe');
		exit();
	}else if($user['password']==$newpass){
		$_SESSION['UpdatePassFlag']=3;//OldPass and NewPass is same.
		session_write_close();
		header('location: changepassword.php');
		header('target:mainiframe');
		exit();  
	 }else if(strlen($newpass)<8){
		$_SESSION['UpdatePassFlag']=4;//NewPass length is less than 8.
		session_write_close();
		header('location: changepassword.php');
		header('target:mainiframe');
		exit(); 
	}else if(strlen($newpass)>15){
		$_SESSION['UpdatePassFlag']=5;//NewPass length is greater than 15.
		session_write_close();
		header('location: changepassword.php');
		header('target:mainiframe');
		exit(); 
	}else{
		//Password Updation and AccountStatus Updation
		$_SESSION['UpdatePassFlag']=6;
		$query="UPDATE `users` SET password='".$newpass."' WHERE usn='".$usn."'";
		if(!mysql_query($query,$bd)){
			die ("An unexpected error occured while saving the record, Please try again!");
		}
		if($_SESSION['SESS_ACS']==1){
			$query="UPDATE `users` SET acs=2 WHERE usn='".$usn."'";
			if(!mysql_query($query,$bd)){
				die ("An unexpected error occured while saving the record, Please try again!");
			}
			$_SESSION['SESS_ACS']=2;
			header('location: editprofile.php');
			header('target:mainiframe');
			exit();
		}
		header('location: changepassword.php');
		header('target:mainiframe');
		exit();
	}
	session_write_close();
?>	