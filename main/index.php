<?php
	require_once '../Core.fnc.php';
	session_start();
	$usn=$_SESSION['SESS_USN'];
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
	
	//connect to database to load nickname
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `users` WHERE usn='".$usn."'";
	$res=mysql_query($qry);
	$user=mysql_fetch_assoc($res);
	// 	echo $user['nickname'];
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<link rel="stylesheet" type="text/css" href="../assets/main.navbar.css" />
<title>Hi Fellas!</title>
<script language="JavaScript">
<!--
function calcHeight()
{
  //find the height of the internal page
  var the_height=document.getElementById('mainiframe').contentWindow.document.body.scrollHeight;

  //change the height of the iframe
  document.getElementById('mainiframe').height=the_height;
}
//-->
</script>
</head>
<body>
<center>
<img src=../assets/main.logo.jpg>
<DIV STYLE="font-family: 'Lucida Sans';"> 
<hr width=1034>
<table width=1034 rules=cols border=0>
<tr><td width=200 valign=top>
		<big><font color=#5500ff>Hi! </big></font><small><?php 
																if($user['nickname']!=NULL){
																	echo $user['nickname'];
																}else{
																	echo $_SESSION['SESS_NAME'];
																}
															?></small>
		<hr color=black><form action=logout.php><button><font>Logout</font></button></form>
		
		<div class="menu_simple">
		<ul>
			<li><a href="rating.php" target=mainiframe>Home</a></li>
			<li><a href="myprofile.php" target=mainiframe>View my Profile</a></li>
			<li><a href="editprofile.php" target=mainiframe>Edit my Profile</a></li>
			<li><a href="ranking.php" target=mainiframe>View Ranking</a></li>
			<li><a href="changepassword.php" target=mainiframe>Change Password</a></li>
			<li><a href="search.php" target=mainiframe>Search a Profile<sup><font color=red><b>NEW</b></font></sup></a></li>
			<li><a href="../faq.html" target=_blank>F.A.Q. & About Us</a></li><hr>
		</ul>
		</div>
		<table width=190 border=0><tr bgcolor=yellow><Td align=center><b>If you find any incorrect details please let us know by messaging our facebook page.<hr color=black>
																		Our Search Page is half done. It'll be done ASAP. It has been <font color=green>AJAXified</font> now!</b></td></tr></table>
		<hr><center><b>Total Acctounts Activated : <?php echo GetActNo();?></b></center>									
		</td>
	<td align=center valign=top><iframe width=832 height=340 src=<?php echo GetMainIframesrc();?> name=mainiframe id=mainiframe frameborder=0 scrolling=no onLoad="calcHeight();" ></iframe></td>
</tr>
</table>
</div></center>