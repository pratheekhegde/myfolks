<?php
	require_once '../Core.fnc.php';
	session_start();
	$usn=$_SESSION['SESS_USN'];
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
	
	//connect to database to load the existing values
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `users` WHERE usn='".$usn."'";
	$res=mysql_query($qry);
	$user=mysql_fetch_assoc($res);
	//echo $user['1'];
	$i=1;	
	while($i<=5){
	
		$rate[]=explode("|",$user[$i]);
		$i++;
	}
	
	$properusn=GetProperUSN($_SESSION['SESS_USN']);
	$profilepic= '../profilepics/'.$properusn.'.jpg';
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="stylesheet" href="../assets/myprof.prog.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  	<script type="text/javascript">
		if(frameElement == null){
			window.location=window.close();
		}
	</script>
</head>
<DIV STYLE="font-family: 'Lucida Sans';"> 
<fieldset><legend>My Profile</legend>
<table border=0 width=791>
	<tr><td height="300" width="300" align=center><?php
									 if (file_exists($profilepic)){
										echo ('<img src="../profilepics/'.$properusn.'.jpg" />');
									}else {
										echo '<img src="../profilepics/noimg.jpg" />';
									} 
								?><br><br><b><big>YOU</big></b>
	    </td>
	    <td>
			<table border=0 width=479 height=300>
				<tr><td align=center colspan=3><strong>Here's what you are according to others!</strong><hr color=lightblue>
					</td>
				</tr>
				<tr><td colspan=3><small><p align = right><u>Times Rated</u></p></small>
					</td>
				</tr>
				<tr><td width=20 align=right><br>
	Attitude:<br><br>
    Funny:<br><br>
	Cool:<br><br>
	Flirt:<br><br>
	Dumb:<br><br>	
					</td>
				<td>
	<section class="container">
    <div class="progress">
    <span style="width: <?php echo round($rate['0']['2'],1);?>%;"><span><?php echo round($rate['0']['2'],1);?>%</span></span>
    </div>
	<br>
    <div class="progress">
      <span class="green" style="width: <?php echo round($rate['1']['2'],1);?>%;"><span><?php echo round($rate['1']['2'],1);?>%</span></span> 
    </div>
	<br>
    <div class="progress">
      <span class="orange" style="width: <?php echo round($rate['2']['2'],1);?>%;"><span><?php echo round($rate['2']['2'],1);?>%</span></span>
    </div>
	<br>
    <div class="progress">
      <span class="red" style="width: <?php echo round($rate['3']['2'],1);?>%;"><span><?php echo round($rate['3']['2'],1);?>%</span></span>
    </div>
	<br>
    <div class="progress">
      <span class="blue" style="width: <?php echo round($rate['4']['2'],1);?>%;"><span><?php echo round($rate['4']['2'],1);?>%</span></span>
    </div>
  </section>
		</td>
	<td width=10 align=right><br>
	<?php echo $rate['0']['0'];?><br><br>
   <?php echo $rate['1']['0'];?><br><br>
	<?php echo $rate['2']['0'];?><br><br>
	<?php echo $rate['3']['0'];?><br><br>
	<?php echo $rate['4']['0'];?><br><br>	
	</td>
</tr></table></tr>
<tr><td colspan=2><hr></td></tr>
<tr><td colspan=2 align=center bgcolor=#FFFF33><b>Don't worry. This page can be seen only by you provided others don't know your password.</b></td></tr>
<tr><td colspan=2><hr></td></tr>
<tr><td colspan=2>
		<table width=787 rules=cols>
		<tr height=50 valign=top><td><u><center><big><strong>Your Crushes</strong></big></center></u></td>
			<td><u><center><strong><big>Your Crushes who also have Crush on you</big></strong></center></u></td>
		</tr>
		
		<tr><td width=375 align=center valign=top>
	<?php 
		//connect to database to load the crushsent values
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		$qry="SELECT * FROM `users` WHERE usn='".$usn."'";
		$res=mysql_query($qry);
		$loggedinuser=mysql_fetch_assoc($res);
		$s=0;$e=10;
		if($loggedinuser['crushcnt']>0){
			for($i=1;$i<=$loggedinuser['crushcnt'];$i++){
				$crushusn[]=substr($loggedinuser['crushsent'],$s,$e);
				$s=$s+10;

			}
			for($i=0;$i<=($loggedinuser['crushcnt']-1);$i++){
				$res=mysql_query("SELECT * FROM `users` WHERE usn LIKE '%".$crushusn[$i]."'");
				$crushuser=mysql_fetch_assoc($res);
				$crushname[]=$crushuser['name'];
			}
			for($i=0;$i<=($loggedinuser['crushcnt']-1);$i++){
				echo "<img src=../assets/sent.png height=15>";
				echo $crushname[$i]."<br><small>";
				echo GetYear($crushusn[$i]);echo " ";
				echo GetBranch($crushusn[$i]);
				echo "</small><hr width=250>";
			}
		}else{
			echo "<img src=../assets/nosent.png height=80><br><big>You <font color=red>Don't have</font> crush on anyone!</big><br>";
		}
		
?>
</td>
<td align=center valign=top><?php
			$norcd=1;
			for($i=0;$i<=($loggedinuser['crushcnt']-1);$i++){
				if(strpos($loggedinuser['crushrcd'],$crushusn[$i])!==FALSE){
					$crushrcdFLAG[]=1;
				}else $crushrcdFLAG[]=0;
			}
			for($i=0;$i<=($loggedinuser['crushcnt']-1);$i++){
				if($crushrcdFLAG[$i]==1){
					$norcd=0;
					echo "<img src=../assets/rcd.png height=15>";
					echo $crushname[$i]."<br><small>";
					echo GetYear($crushusn[$i]);echo " ";
					echo GetBranch($crushusn[$i]);
					echo "</small><hr width=250>";
				}
			}
			if($norcd==1){
				echo "<img src=../assets/wait.png height=80><br><big>Looks like You gotta wait.<br> There is none for now!</big><br>";
			}
		?>
</td>
</tr>
</table>
</td>
</tr>
</table>
<center>
</center>
</fieldset>
</DIV>