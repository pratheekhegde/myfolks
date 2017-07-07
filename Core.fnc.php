
<?php 
/* All the core functions and configurations are listed here.
Author:garbage69,pTk,abest0s
============================================================
*/

require_once 'fn.smart_resize_image.php';
//to include the smart_resize script thanks to Nimrod007,github

//Database connections
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "myfolks";
$prefix = "";

//Studying year configurations
$year1st=14;
$year2nd=13;
$year3rd=12;
$year4th=11;

//Total Users
$totalvictims=944;

//Function to return the Category Name
function GetCatName($code){
	if($code==1){
		return("Attitude <img src=../assets/att.png height=55>");
	}elseif($code==2){
		return("<font color=green>Funny </font><img src=../assets/funny.png height=55>");
	}elseif($code==3){
		return("<font color=blue>Cool </font><img src=../assets/cool.png height=55>");
	}elseif($code==4){
		return("<font color=red>Flirt </font><img src=../assets/flrt.png height=55>");
	}elseif($code==5){
		return("<font color=brown>Dumb </font><img src=../assets/dumb.png height=55>");
	}
}
//This function return the query USN with wildcards based on the filters
function GetWildcardUSNQuery($year,$branch){
	global $year1st,$year2nd,$year3rd,$year4th;
	if($year=="ALL"){
		if($branch=="ALL"){
			return("%4mw%");
		}else if($branch=="C.S.E"){
			return("%4mw__cs%");
		}else if($branch=="E.C.E"){
			return('%4mw__ec%');
		}else if($branch=="Civ.E"){
			return('%4mw__cv%');
		}else if($branch=="M.E"){
			return('%4mw__me%');
		}
	}else if($year==1){
		if($branch=="ALL"){
			return('%4mw'.$year1st.'%');
		}else if($branch=="C.S.E"){
			return('%4mw'.$year1st.'cs%');
		}else if($branch=="E.C.E"){
			return('%4mw'.$year1st.'ec%');
		}else if($branch=="Civ.E"){
			return('%4mw'.$year1st.'cv%');
		}else if($branch=="M.E"){
			return('%4mw'.$year1st.'me%');
		}
	}else if($year==2){
		if($branch=="ALL"){
			return('%4mw'.$year2nd.'%');
		}else if($branch=="C.S.E"){
			return('%4mw'.$year2nd.'cs%');
		}else if($branch=="E.C.E"){
			return('%4mw'.$year2nd.'ec%');
		}else if($branch=="Civ.E"){
			return('%4mw'.$year2nd.'cv%');
		}else if($branch=="M.E"){
			return('%4mw'.$year2nd.'me%');
		}
	}else if($year==3){
		if($branch=="ALL"){
			return('%4mw'.$year3rd.'%');
		}else if($branch=="C.S.E"){
			return('%4mw'.$year3rd.'cs%');
		}else if($branch=="E.C.E"){
			return('%4mw'.$year3rd.'ec%');
		}else if($branch=="Civ.E"){
			return('%4mw'.$year3rd.'cv%');
		}else if($branch=="M.E"){
			return('%4mw'.$year3rd.'me%');
		}
	}else if($year==4){
		if($branch=="ALL"){
			return('%4mw'.$year4th.'%');
		}else if($branch=="C.S.E"){
			return('%4mw'.$year4th.'cs%');
		}else if($branch=="E.C.E"){
			return('%4mw'.$year4th.'ec%');
		}else if($branch=="Civ.E"){
			return('%4mw'.$year4th.'cv%');
		}else if($branch=="M.E"){
			return('%4mw'.$year4th.'me%');
		}
	}
}
//Get Relationship status from the code
function GetRelStat($code){
	if($code==FA){
		return("<font color=#3B170B>Forever Alone.</font>");
	}else if($code==LFS){
		return("<font color=#5FB404>Looking For Someone!</font>");
	}else if($code==C){
		return("<font color=#FF0000>Committed.</font>");
	}else if($code==WFS){
		return("<font color=#5882FA>Waiting For Someone!</font>");
	}else{
		return("Not Set Yet.");
	}
}

//Function to Display the interests
function ShowInterests($interests){
	if($interests==NULL){
		return("<Big>Maybe this profile has not been activated yet,<br>
					or maybe this user is not interested in anything.<br>Could be a Weirdo!<big>");
	}
	$IntStr="";
	if(strpos($interests,"MU")!==FALSE){
		$IntStr.="Music<br>";
	}
	if(strpos($interests,"MO")!==FALSE){
		$IntStr.="Movies<br>";
	}
	if(strpos($interests,"SP")!==FALSE){
		$IntStr.="Sports<br>";
	}
	if(strpos($interests,"NO")!==FALSE){
		$IntStr.="Reading Novels<br>";
	}
	if(strpos($interests,"TS")!==FALSE){
		$IntStr.="TV Shows<br>";
	}
	if(strpos($interests,"CG")!==FALSE){
		$IntStr.="Computer Gaming<br>";
	}
	if(strpos($interests,"DIT")!==FALSE){
		$IntStr.="Digging The Internet<br>";
	}if(strpos($interests,"SL")!==FALSE){
		$IntStr.="Sleeping<br>";
	}
	if(strpos($interests,"CO")!==FALSE){
		$IntStr.="Cooking<br>";
	}
	if(strpos($interests,"TR")!==FALSE){
		$IntStr.="Travelling<br>";
	}
	return($IntStr);
}
	
//Function to get the main Frame source
function GetMainIframesrc(){
	if ($_SESSION['SESS_ACS']==1){
		return("changepassword.php");
	}else if ($_SESSION['SESS_ACS']==2){
		return("editprofile.php");
	}else{
		return("rating.php");
	}
}
//Function to sanitize values received from the form. Prevents SQL injection
function clean($str){
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
}

//Function to Get Activated Account number
function GetActNo(){
	global $mysql_hostname,$mysql_user,$mysql_password,$mysql_database;
	
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	
	$qry="SELECT * FROM users WHERE acs>0";
	$result=mysql_query($qry);
	return(mysql_num_rows($result));
}

//Function to Decode Update Password Flag
function DecodeUpdatePassFlag($Code){
	if($Code == 1){
		return("Old Password or New Password is <font color=red>Missing!</font>");
	}else if($Code == 2){
		return("Old Password is <font color=red>Incorrect!</font>");
	}else if($Code == 3){
		return("Old Password and New Password <font color=red>Can't be same!</font>");
	}else if($Code == 4){
		return("Length of the <br>New Passwords must be <font color=red>greater than 8!</font>");
	}else if($Code == 5){
		return("Length of the <br>New Passwords must not be <font color=red>greater than 15!</font>");
	}else if($Code == 6){
		return("Your New Password has been <font color=darkgreen>Saved!</font>");
	}else if($Code == 7){
		return("Your New Passwords <font color=red>Didn't match!</font>");
	}
}
//Function to Decode Login Error Flag
function DecodeLoginFlag($Code){
	if($Code == 1){
		return("USN or Password is <font color=red>Missing!</font>");
	}else if($Code == 2){
		return("USN or Password <font color=red>Not Found!</font>");
	}
}
//Function to display the logo
function GetMainLogo(){
	echo '<a href=index.php><img src="images/logo.jpg"/ width=844 height=192 alt=RankThem></a>';
}

//Function to format usn
function GetProperUSN($usn){
	$formattedusn = preg_replace('/\s+/', '', $usn);
	$formattedusn = strtolower($formattedusn);
	return $formattedusn;
}
//Functions to fetch branchcode from usn eg; ec,cs,me
function GetBranch($usn){
	$formattedusn = preg_replace('/\s+/', '', $usn);
	$properusn = strtolower($formattedusn);
	$branch = ($properusn[5].$properusn[6]);
	if($branch==cs) {
        $branch="C.S.E.";
    }elseif ($branch==ec){
        $branch="E.C.E.";
	}elseif ($branch==me) {
        $branch="Mech Eng.";
    }elseif ($branch==cv){
        $branch="Civil Eng.";
    }else{
		$branch="No Branch set.";
	}
	return $branch;
}

//function to get year from the usn
function GetYear($usn){
	//to use the global variables
	global $year1st,$year2nd,$year3rd,$year4th;
	$formattedusn = preg_replace('/\s+/', '', $usn);
	$properusn = strtolower($formattedusn);
	$year = $properusn[3].$properusn[4];
	if($properusn[7] == 4){
		$year=$year-1;
	}
	if ($year == $year1st){
       return "1st Year.";
    }elseif($year == $year2nd){
        return "2nd Year.";
    }elseif($year == $year3rd){
        return "3rd Year.";
	}elseif($year == $year4th){
		return "4th Year.";
	}else return "No year set";
	
}
//function to count number of images uploaded
function GetPhotoUploadCount(){
	$directory = "./images/";
	$filecount = 0;
	$files = glob($directory . "4mw*.jpg");
	if ($files){
 		$filecount = count($files);
	}
	echo $filecount;
}
?>