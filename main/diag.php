<?php
require_once '../Core.fnc.php';
session_start();
$usn=$_SESSION['SESS_USN'];
//connect database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM users WHERE usn='$usn'";
	$result=mysql_query($qry);
	$user = mysql_fetch_assoc($result);
?>
<title>Diag Page - myFolks</title>
<DIV STYLE="font-family: 'Lucida Sans';">
<center><h1>Diagnostics - myFolks</h1>
<table border=0>
<tr><td>Client IP</td><td>-</td></td><td align=right><?php echo $_SERVER['REMOTE_ADDR'];?></td></tr>
<tr><td><b>SESS Values<hr></b></td></tr>
<tr><td>SESS USN</td><td>-</td><td align=right><?php echo $_SESSION['SESS_USN'];?></td></tr>
<tr><td>SESS ACS</td><td>-</td><td align=right><?php echo $_SESSION['SESS_ACS'];?></td></tr>
<tr bgcolor=lightgrey><td>SESS Rate_Filt_Y</td><td>-</td><td align=right><?php echo $_SESSION['SESS_RATE_FILT_Y'];?></td></tr>
<tr bgcolor=lightgrey><td>SESS Rate_Filt_B</td><td>-</td><td align=right><?php echo $_SESSION['SESS_RATE_FILT_B'];?></td></tr>
<tr bgcolor=lightblue><td>SESS Rank_Filt_C</td><td>-</td><td align=right><?php echo $_SESSION['SESS_RANK_FILT_C'];?></td></tr>
<tr bgcolor=lightblue><td>SESS Rank_Filt_Y</td><td>-</td><td align=right><?php echo $_SESSION['SESS_RANK_FILT_Y'];?></td></tr>
<tr bgcolor=lightblue><td>SESS Rank_Filt_B</td><td>-</td><td align=right><?php echo $_SESSION['SESS_RANK_FILT_B'];?></td></tr>
<tr><td>SESS USR_CRUSH_STAT(On Rand Usr)</td><td>-</td><td align=right><?php echo $_SESSION['USR_CRUSH_STAT'];?></td></tr>
<tr><td>SESS USR_CRUSH_SENT</td><td>-</td><td align=right><?php echo $_SESSION['SESS_CRS_SNT'];?></td></tr>
<tr><td>SESS USR_CRUSH_RCD</td><td>-</td><td align=right><?php echo $_SESSION['SESS_CRS_RCD'];?></td></tr>
<tr><td>SESS USR_CRUSH_CNT</td><td>-</td><td align=right><?php echo $_SESSION['SESS_CRS_CNT'];?></td></tr>
<tr><td><b>DB Values(LogUsr)<hr></b></td></tr>
<tr><td>DB USR_CRUSH_SENT</td><td>-</td><td align=right><?php echo $user['crushsent'];?></td></tr>
<tr><td>DB USR_CRUSH_RCD</td><td>-</td><td align=right><?php echo $user['crushrcd'];?></td></tr>
<tr><td>DB USR_1_COl</td><td>-</td><td align=right><?php echo 	$user['1'];?></td></tr>
<tr><td>DB USR_2_COl</td><td>-</td><td align=right><?php echo 	$user['2'];?></td></tr>
<tr><td>DB USR_3_COl</td><td>-</td><td align=right><?php echo 	$user['3'];?></td></tr>
<tr><td>DB USR_4_COl</td><td>-</td><td align=right><?php echo 	$user['4'];?></td></tr>
<tr><td>DB USR_5_COl</td><td>-</td><td align=right><?php echo 	$user['5'];?></td></tr>
</table>
</div>