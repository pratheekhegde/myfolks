<?php
	require_once './Core.fnc.php';
	//connect database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	//Start sessions
	session_start();
	
	if($_SESSION['LoginFlag']==3){
		header("location: index.php");
		exit();
	}	
	//If there are input validations, redirect back to the login form
	if($_POST['usn']==NULL || $_POST['password']==NULL) {
		$_SESSION['LoginFlag']=1;//Usn or Pass is missing.
		session_write_close();
		header("location: index.php");
		exit();
	}	
 
	//Sanitize the POST values
	$usn =strtolower(clean($_POST['usn']));
	$password =clean($_POST['password']);
 
 
 	//Create query
	$qry="SELECT * FROM users WHERE usn='$usn' AND password='$password'";
	$result=mysql_query($qry);
	 
	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) > 0) {
			//Login Successful
			//session_regenerate_id();
			$user = mysql_fetch_assoc($result);
			$_SESSION['SESS_USER_ID'] = $user['id'];
			$_SESSION['SESS_USN'] = GetProperUSN($user['usn']);
			$_SESSION['SESS_ACS'] = $user['acs'];
			$_SESSION['SESS_NAME'] = $user['name'];
			$_SESSION['SESS_CRS_SNT']= $user['crushsent'];
			$_SESSION['SESS_CRS_RCD']=$user['crushrcd'];
			$_SESSION['SESS_CRS_CNT']=$user['crushcnt'];
			$_SESSION['LoginFlag']=3;
			if($_SESSION['SESS_ACS']==0){
				header("location: main/logout.php");
				exit();
			}
			header("location: ./main");
			exit();
		}else{
			//Login failed
			$_SESSION['LoginFlag']=2;//USN and Password not found
			session_write_close();
			header("location: index.php");
			exit();
		}
	}else {
		die("Query failed");
	}
?>