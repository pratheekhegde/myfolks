<head>
<script type="text/javascript" language="javascript">
 function rate(rating) {
    document.rating.stars.value = rating;
    document.rating.submit();
    return true;
 }
	if(frameElement == null){
		window.location=window.close();
	}
 </script>
</head>
<?php
	require_once '../Core.fnc.php';
	session_start();
	$usn=$_SESSION['SESS_USN'];
	unset($_SESSION['PPIC_UPLOAD_FLG']);
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
	//echo $_POST['crush'];
	//Crush updation code
	if($_POST['crush']==y){//Goto the logged in user's row and remove usn from his crush sent.
		//connect to database to load the existing values
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		$qry="SELECT * FROM `users` WHERE usn='".$usn."'";
		$res=mysql_query($qry);
		$loggedinuser=mysql_fetch_assoc($res);
		$loggedinuser['crushcnt']--;
		$_SESSION['SESS_CRS_CNT']=$loggedinuser['crushcnt'];
		$newcrushsent=str_replace(GetProperUSN($_POST['loadedprofusn']),"",$loggedinuser['crushsent']);
		//echo $newcrushsent;
		$_SESSION['SESS_CRS_SNT']=$newcrushsent;
		$query="UPDATE `users` SET crushsent='".$newcrushsent."', crushcnt='".$loggedinuser['crushcnt']."' WHERE usn='".$usn."'";
		
		//update the crushsent in the database
		if(!mysql_query($query,$bd)){
			die ("<h3>Looks like something went wrong while saving the SESS_CRS_SNT, Please Let us know about it!</h3>");
		}
		
		//-------------------------------Now update the crushrcd of the random user-----------------
		$qry="SELECT * FROM `users` WHERE usn='".$_POST['loadedprofusn']."'";
		$res=mysql_query($qry);
		$randuser=mysql_fetch_assoc($res);
		$newcrushrcd=str_replace($usn,"",$randuser['crushrcd']);
		$query="UPDATE `users` SET crushrcd='".$newcrushrcd."' WHERE usn='".$_POST['loadedprofusn']."'";
		
		//update the crushrcd in the database
		if(!mysql_query($query,$bd)){
			die ("<h3>Looks like something went wrong while saving the SESS_CRS_RCD, Please Let us know about it!</h3>");
		}
		if($_SESSION['SESS_RATE_FILT_Y']==NULL || $_SESSION['SESS_RATE_FILT_B']==NULL){
			$num=$totalvictims;
		}else{		
			//This function return the query variable with the wildcards again after updating crushes
			$queryusn=GetWildcardUSNQuery($_SESSION['SESS_RATE_FILT_Y'],$_SESSION['SESS_RATE_FILT_B']);
		
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
		
			//To find number of profiles based on the wildcards
			$num=mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE usn LIKE '$queryusn'"));
		}
		//choose old loaded profile
		$qry="SELECT * FROM `users` WHERE usn='".$_POST['loadedprofusn']."'";
		$res=mysql_query($qry);
		$user=mysql_fetch_assoc($res);
		
		//update session crushsent
		$_SESSION['USR_CRUSH_STAT']=n;
		goto cont;
		
	}else if($_POST['crush']==n){//update the crushsent value in the database
		//connect to database to load the existing values
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		$qry="SELECT * FROM `users` WHERE usn='".$usn."'";
		$res=mysql_query($qry);
		$loggedinuser=mysql_fetch_assoc($res);
		$loggedinuser['crushsent']=$loggedinuser['crushsent'].GetProperUSN($_POST['loadedprofusn']);
		$loggedinuser['crushcnt']++;//Increment crushcount
		$_SESSION['SESS_CRS_CNT']=$loggedinuser['crushcnt'];
		$_SESSION['SESS_CRS_SNT']=$loggedinuser['crushsent'];
		$query="UPDATE `users` SET crushsent='".$loggedinuser['crushsent']."', crushcnt='".$loggedinuser['crushcnt']."' WHERE usn='".$usn."'";
		//update the crushsnt in the database
		if(!mysql_query($query,$bd)){
			die ("<h3>Looks like something went wrong while saving the SESS_CRS_SNT, Please Let us know about it!</h3>");
		}
		//-------------------------------Now update the crushrcd of the random user-----------------
		$qry="SELECT * FROM `users` WHERE usn='".$_POST['loadedprofusn']."'";
		$res=mysql_query($qry);
		$randuser=mysql_fetch_assoc($res);
		$randuser['crushrcd']=$randuser['crushrcd'].$usn;
		$query="UPDATE `users` SET crushrcd='".$randuser['crushrcd']."' WHERE usn='".$_POST['loadedprofusn']."'";
		//update the crushrcd in the database
		if(!mysql_query($query,$bd)){
			die ("<h3>Looks like something went wrong while saving the SESS_CRS_RCD, Please Let us know about it!</h3>");
		}
				
		if($_SESSION['SESS_RATE_FILT_Y']==NULL || $_SESSION['SESS_RATE_FILT_B']==NULL){
			$num=$totalvictims;
		}else{		
			//This function return the query variable with the wildcards again after updating crushes
			$queryusn=GetWildcardUSNQuery($_SESSION['SESS_RATE_FILT_Y'],$_SESSION['SESS_RATE_FILT_B']);
		
			$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
			mysql_select_db($mysql_database, $bd) or die("Could not select database");
		
			//To find number of profiles based on the wildcards
			$num=mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE usn LIKE '$queryusn'"));
		}
		//choose old loaded profile
		$qry="SELECT * FROM `users` WHERE usn='".$_POST['loadedprofusn']."'";
		$res=mysql_query($qry);
		$user=mysql_fetch_assoc($res);
		
		//update session crushsent
		$_SESSION['USR_CRUSH_STAT']=y;
		goto cont;
	}
	 
	//To fetch profiles based on the filters when loaded first time
	randomagain:
	 if($_SESSION['SESS_RATE_FILT_Y']==NULL || $_SESSION['SESS_RATE_FILT_B']==NULL && $_POST['crush']==NULL){
		
		//load a random profile if filters are not set
		$genid=(mt_rand(1,$totalvictims));
		$num=$totalvictims;
		//$genid=64;
		
		//connect to database and load the existing values of the random user
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		$qry="SELECT * FROM `users` WHERE id='$genid'";
		$res=mysql_query($qry);
		$user = mysql_fetch_assoc($res);
		
	}else{ 
		//This function return the query variable with the wildcards
		$queryusn=GetWildcardUSNQuery($_SESSION['SESS_RATE_FILT_Y'],$_SESSION['SESS_RATE_FILT_B']);
		
		
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		
		//To find number of profiles based on the wildcards
		$num=mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE usn LIKE '$queryusn'"));
		
		//choose a random profiles out of it
		$qry="SELECT * FROM `users` WHERE usn LIKE '$queryusn' order by rand()limit 1";
		$res=mysql_query($qry);
		$user=mysql_fetch_assoc($res);
	}
	if($user['usn']==$usn) goto randomagain;
	$properusn=GetProperUSN($user['usn']);
	if(strpos($_SESSION['SESS_CRS_SNT'],$properusn)!==False){
		$_SESSION['USR_CRUSH_STAT']=y;
	}else $_SESSION['USR_CRUSH_STAT']=n;	
	cont:
	$interests=$user['interests'];
	$properusn=GetProperUSN($user['usn']);
	$profilepic= '../profilepics/'.$properusn.'.jpg';
	//echo $_SESSION['SESS_CRS_SNT'];
	//echo $properusn;

?>
<body>
<DIV STYLE="font-family: 'Lucida Sans';">
<fieldset><legend>Rate Page</legend>
<table border=0 width=791>
<tr><td align=center colspan=2><form name=ratepagefilters method=post action=ratepagefilters.php><b>Filters:&nbsp;</b>
				<select name=year>
					<option value=ALL<?php if($_SESSION['SESS_RATE_FILT_Y']==ALL) echo ' selected';?>>All Years</option>
					<option value=1<?php if($_SESSION['SESS_RATE_FILT_Y']==1) echo ' selected';?>>1st Year</option>
					<option value=2<?php if($_SESSION['SESS_RATE_FILT_Y']==2) echo ' selected';?>>2nd Year</option>
					<option value=3<?php if($_SESSION['SESS_RATE_FILT_Y']==3) echo ' selected';?>>3rd Year</option>
					<option value=4<?php if($_SESSION['SESS_RATE_FILT_Y']==4) echo ' selected';?>>4th Year</option>
				</select>&nbsp;
				<select name=branch>
					<option value=ALL<?php if($_SESSION['SESS_RATE_FILT_B']==ALL) echo ' selected';?>>All Branches</option>
					<option value=C.S.E<?php if($_SESSION['SESS_RATE_FILT_B']=="C.S.E") echo ' selected';?>>C.S.E</option>
					<option value=E.C.E<?php if($_SESSION['SESS_RATE_FILT_B']=="E.C.E") echo ' selected';?>>E.C.E</option>
					<option value=Civ.E<?php if($_SESSION['SESS_RATE_FILT_B']=="Civ.E") echo ' selected';?>>Civ.E</option>
					<option value=M.E<?php if($_SESSION['SESS_RATE_FILT_B']=="M.E") echo ' selected';?>>M.E</option>
				</select>&nbsp;
				<input type=submit value="Show">
				<br><small><font color=red>(Profiles based on the filters will be shown)</font><br>
											Total profiles with current filters:<b><?php echo $num;?></b></small></form></td></tr>
								
<tr><td colspan=2><hr color=green></td></tr>
<?php if ($num==0){
								  goto end;
								  }
								  ?>
<tr><td height="300" width=300 align=center><?php
									 if (file_exists($profilepic)){
										echo ('<img src="../profilepics/'.$properusn.'.jpg" />');
									}else {
										echo '<img src="../profilepics/noimg.jpg" />';
									} 
								?>
								<br><br><form name=crush action="<?php $_SERVER['PHP_SELF'];?>" method=post>
																<input type=hidden name=crush value="<?php echo $_SESSION['USR_CRUSH_STAT'];?>">
																<input type=hidden name=loadedprofusn value="<?php echo $properusn;?>">
																<input type=submit value="<?php if($_SESSION['USR_CRUSH_STAT']==n){
																			echo "Click If You Have A Crush On This Person";
																		}else echo "No, Undo My Click";?>" 
																<?php if(($_SESSION['SESS_CRS_CNT']==5) && strpos($_SESSION['SESS_CRS_SNT'],$properusn)===FALSE) echo disabled;?>
																></form><font size=5><font color=red><?php echo (5-$_SESSION['SESS_CRS_CNT']);?></font> Crush Clicks Left</font><br>
								<small>(<font color=green><b>Don't worry</b></font>, <font color=blue>It Won't be notified to Him/Her.</font>)</small>
	</td>
	<td><table border=0 width=479 height=300>
	<tr height=100>
	<td align=center><font size=8 face="Segoe UI"><?php echo $user['name'];
							if($user['nickname']!=NULL) echo '('.$user['nickname'].')';
							?>
												<br><?php echo GetYear($user['usn']);?> <?php echo GetBranch($user['usn']);?></font></td>
							<?php if($_SESSION['USR_CRUSH_STAT']==y) echo "<td width=100 align=center><b><font color=red>Your Crush!</b></font><img src=../assets/crush.png height=100></td>";?></font></tr>
							<tr><td colspan=2 align=center><hr>
	<font size=11 face="Segoe UI Symbol"><?php $category=(mt_rand(1,5));
												echo GetCatName($category);?></font><form name="rating" action=rate.php method=post>						
	<img src="../assets/1.png" onclick="rate(1);" height=60> 
	<img src="../assets/2.png" onclick="rate(2);" height=60> 
     <img src="../assets/3.png" onclick="rate(3);" height=60>
	 <img src="../assets/4.png" onclick="rate(4);" height=60>
	 <img src="../assets/5.png" onclick="rate(5);" height=60>
	 <input type=hidden name=stars value=0><input type="hidden" name="cat" value="<?php echo $category; ?>" />
     <input type="hidden" name="randuser" value="<?php echo $properusn; ?>" /></form>
	 <font size=5 face="Segoe UI">Click on any of the star to rate this person.</font>
	</td></tr>
			</table>
</tr>
<tr><td colspan=2><hr></td></tr>
<tr><td align=right valign=top><b><img src="../assets/rel.png" width=12 height=12>&nbsp;Relationship Status:</b></td><td valign=top><font size=10><?php echo GetRelStat($user['relstat']);?></font></td></tr>
<tr height=60><td align=right valign=top><b>Bio:</b></td><td valign=top><font color=#585858 size=5><?php
																										if($user['aboutme']==NULL){
																												echo "Looks like this section was not filled by the User.";
																										}else echo $user['aboutme'];
																								?></font></td></tr>
<tr height=50><td align=right valign=top><b>Interests:</b></td><td><font color=#FF8000><?php echo ShowInterests($interests);?></font></td></tr>
</table>

<?php end:?> 
</fieldset></div></body>