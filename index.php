<?php
	require_once './Core.fnc.php';
	session_start();
	 if($_SESSION['LoginFlag']==3){
		header("location: ./main");
			exit();
	}
	/* echo "LoginFlag#";
	echo $_SESSION['LoginFlag'];
	echo "USER#";
	echo($_SESSION['SESS_USER_ID']);
	echo($_SESSION['SESS_USN']);
	echo($_SESSION['SESS_ACS']); */
?>
<head>
<link rel="icon" 
      type="image/png" 
      href=favicon.ico">
<style>
input[type=text]{
	background-color: #CEEEFA;
	border: 1px solid #006;
	font-family: 'Lucida Sans'; 
	font-size: 15px;
	Height: 30px;
}
input[type=password]{
	background-color: #CEEEFA;
	border: 1px solid #006;
	font-family: 'Lucida Sans'; 
	font-size: 15px;
	Height: 30px;
}
input[type=submit]{
	font-family: 'Lucida Sans';
    border: 2px solid #006;
    background: lightgreen;
	Height: 30px;
	font-size: 20px;
	
}
</style>
</head>
<DIV STYLE="font-family: 'Lucida Sans';"> 
<center><img src=assets/logo.jpg>
<hr width=990>
<table border=1 width=1000>
<tr>
	<td width=300>
	<fieldset><legend>User Login</legend>
	<form name="loginform" action="login_exec.php" method="post">
    <table border=0>
	<tr><td align=right>USN:</td>
		<td><input name="usn" type="text" placeholder="USN"></td>
	</tr>
	<tr><td align=right>Password:</td>
		<td><input name="password" type="password" placeholder="Password"></td>
	</tr>
	<tr><td colspan=2 align=center><input type="submit" value="Sign in"></td>
	</tr>
	<?php if($_SESSION['LoginFlag']>0) echo "<tr bgcolor=#FFFF33><td colspan=2 align=center><b>".DecodeLoginFlag($_SESSION['LoginFlag'])."</b></td></tr>";?>
	</table>
    </form>
	</fieldset>
	<br>
	<center>Forgot password!</center>
	</td>
	<td><img src=assets/main.vert.line.jpg></td>
	<td><img src=assets/home.fb.msg.jpg><center><a href=http://facebook.com/myfolksmyfriends target=blank>My Folks - Facebook</a></center></td>
</tr>
</table>
</form>
<hr width=990>
<b>&copy;2014 None. Free to Copy.</b><br>
Total Accounts Activated : <?php echo GetActNo();?><br><a href=http://myfolks.at.lv/faq.html target=_blank>F.A.Q. | About Us</a>
</center>
</div>