<?php
	require_once '../Core.fnc.php';
	session_start();
	$usn=$_SESSION['SESS_USN'];
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		header("target:_top");
		exit();
	}
	//connect to database to load the existing values
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `users` WHERE usn='".$usn."'";
	$res=mysql_query($qry);
	$user=mysql_fetch_assoc($res);
	$interests=$user['interests'];
	//echo $interests;
	//echo $user['aboutme'];
	$properusn=GetProperUSN($_SESSION['SESS_USN']);
	$profilepic= '../profilepics/'.$properusn.'.jpg';
?>
<style>
textarea{
	resize:none;
}
</style>
<script type="text/javascript">
		if(frameElement == null){
			window.location=window.close();
		}
		</script>
<DIV STYLE="font-family: 'Lucida Sans';"> 
<center><?php if($_SESSION['SESS_ACS']==2) echo "<img src=../assets/updateprofile.png><table border=1 rules=cols><tr bgcolor=#FFFF33><td align=center><b>Your Password was saved! Fill your Profile details and click Update Profile.<br>And Your In!</b></td></tr></table><br>";?>
</center>
<fieldset><legend>Edit Your Profile</legend>
<center>
<table border=0 width="625">
<tr><td colspan=2 align=left><b>Profile Picture:</b></td></tr>
<tr><td height="300" colspan=2><center><?php
									 if (file_exists($profilepic)){
										echo ('<img src="../profilepics/'.$properusn.'.jpg" />');
									}else {
										echo '<img src="../profilepics/noimg.jpg" />';
									} 
								?>		
								</center> <hr></td>
</tr>
<tr><td colspan=2 align=center><form name=uploadprofpic method=post action=uploadpic.php enctype="multipart/form-data" target=mainiframe>
						<b>Profile Pic Upload:</b>
														<input type=hidden name="MAX_FILE_SIZE" value="1048576">
														<input type=file name=file id=file>  <input type=submit value="Upload My Picture"></form>
																																					
														
													
<?php if($_SESSION['PPIC_UPLOAD_FLG']!=NULL) echo "<table border=1 rules=cols><tr bgcolor=#FFFF33><td align=center><b>".$_SESSION['PPIC_UPLOAD_FLG']."</b></td></tr></table>";?></td></tr>													
<tr><td align=center colspan=2><font color=red size=2><b>(Please note that the size of the pic uploaded should be less than 1MB and will be automatically resized to 300x300 pixels if its more than 300x300 pixels.)</b></font>
												</td></tr>												
<tr><td colspan=2><hr></td></tr>
<form name=updateprofile action=updateprofile.php method=post target=mainiframe>
<tr><td align=right><b>Gender:</b></td><td><input type=radio name=gender value=M<?php if($user['gender']==M) echo ' Checked';?>>Male <input type=radio name=gender value=F<?php if($user['gender']==F) echo ' Checked';?>>Female&nbsp;<small>(Mark it ,<font color=red><b>Honestly</b></font>!)<small></td></tr>
<tr><td align=right><b>Nickname:</b></td><td><input type=text name=nickname maxlength=10 size=8 value="<?php echo $user['nickname'];?>">&nbsp;<small>(Max 10 Characters) (<font color=green>Optional</font>)<small></td></tr>
<tr><td align=right><b>About me:</b></td><td><textarea type="text" name="aboutme" placeholder="(Describe yourself in 100 characters)" maxlength="100" style="margin: 2px; width: 391px; height: 60px;" noresize><?php echo $user['aboutme'];?></textarea></td></tr>
<tr><td align=right><b><img src="../assets/rel.png" width=12 height=12>&nbsp;Relationship Status:</b></td>
			<td><select name=relstat>
					<option value=FA<?php if($user['relstat']==FA) echo ' selected';?>>Forever Alone</option>
					<option value=LFS<?php if($user['relstat']==LFS) echo ' selected';?>>Looking For Someone</option>
					<option value=C<?php if($user['relstat']==C) echo ' selected';?>>Committed</option>
					<option value=WFS<?php if($user['relstat']==WFS) echo ' selected';?>>Waiting For Someone</option>
				</select>&nbsp;<small>(Be Frank)<small></td></tr>
<tr><td align=right><b>Interests:</b></td><td><input type=checkbox name="Interest[]" value="MU"<?php if(strpos($interests,"MU")!==FALSE) echo ' checked';?>>Music
												<input type=checkbox name="Interest[]" value="MO"<?php if(strpos($interests,"MO")!==FALSE) echo ' checked';?>>Movies
												<input type=checkbox name="Interest[]" value="SP"<?php if(strpos($interests,"SP")!==FALSE) echo ' checked';?>>Sports
												<input type=checkbox name="Interest[]" value="NO"<?php if(strpos($interests,"NO")!==FALSE) echo ' checked';?>>Novels
												<input type=checkbox name="Interest[]" value="TS"<?php if(strpos($interests,"TS")!==FALSE) echo ' checked';?>>TV Shows<br>
												<input type=checkbox name="Interest[]" value="CG"<?php if(strpos($interests,"CG")!==FALSE) echo ' checked';?>>Computer Games
												<input type=checkbox name="Interest[]" value="DIT"<?php if(strpos($interests,"DIT")!==FALSE) echo ' checked';?>>Digging the Internet<br>
												<input type=checkbox name="Interest[]" value="SL"<?php if(strpos($interests,"SL")!==FALSE) echo ' checked';?>>Sleeping
												<input type=checkbox name="Interest[]" value="CO"<?php if(strpos($interests,"CO")!==FALSE) echo ' checked';?>>Cooking
												<input type=checkbox name="Interest[]" value="TR"<?php if(strpos($interests,"TR")!==FALSE) echo ' checked';?>>Travelling
				</td></tr>
<tr><td colspan=2><hr></td></tr>
<tr><td colspan=2 align=center><small><b><font color=green>Your Profile will be updated once you click the Update Profile button.</font></b></small></td></tr>
<tr><td colspan=2 align=center><input type=submit value="Update Profile"></td></tr>
</table>
</form>
<small><b>Refresh the page if you have updated your nickname to see it in the top left part of the page.</b></small>
</center>
</div>
