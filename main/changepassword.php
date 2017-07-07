<?php
	require_once '../Core.fnc.php';
	session_start();
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
?>
<head><script type="text/javascript">
		if(frameElement == null){
			window.location=window.close();
		}
		</script>
</head>
<DIV STYLE="font-family: 'Lucida Sans';">
<center>
<?php if($_SESSION['SESS_ACS']==1) echo "<img src=../assets/changepass.png><table border=1 rules=cols><tr bgcolor=#FFFF33><td align=center><b>Please Change your Password since you have logged in using the temporary Password!<br>Your temporary Password is your Old Password.</b></td></tr></table>";?>
<img src=../assets/main.changepass.jpg>
<table border=1 rules=cols ><tr><td>
	<form name="changepasswordform" action="updatepassword.php" method="post">
    <table border=0>
	<tr><td align=right>Old Password:</td>
		<td><input name="oldpass" type="password" placeholder="Old Password"></td>
	</tr>
	<tr><td align=right>New Password:</td>
		<td><input name="newpass" type="password" placeholder="New Password"></td>
	</tr>
	<tr><td align=right>Retype New Password:</td>
		<td><input name="rnewpass" type="password" placeholder="Retype New Password"></td>
	</tr>
	<tr><td colspan=2 align=center><input type="submit" value="Update Password"></td>
	</tr>
	<?php if($_SESSION['UpdatePassFlag']>0) echo "<tr bgcolor=#FFFF33><td colspan=2 align=center><b>".DecodeUpdatePassFlag($_SESSION['UpdatePassFlag'])."</b></td></tr>";?>
	</table>
    </form>
</td></tr></table>
</center>