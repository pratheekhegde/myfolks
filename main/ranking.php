<?php
	require_once '../Core.fnc.php';
	session_start();
	unset($_SESSION['PPIC_UPLOAD_FLG']);
	
		if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
?>
<head>
<link rel="stylesheet" href="../assets/myprof.prog.css">
<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<script type="text/javascript">
		if(frameElement == null){
			window.location=window.close();
		}
	</script>
</head>
<body>
<DIV STYLE="font-family: 'Lucida Sans';">
<fieldset><legend>Ranking Page</legend>
<table border=0 width=791>
<tr><td align=center colspan=4><form name=rankpage action=rankpagefilters.php method=post><b>Filters:&nbsp;</b>
				<select name=cat>
					<option value=6<?php if($_SESSION['SESS_RANK_FILT_C']==6) echo ' selected';?>>Crushes</option>
					<option value=1<?php if($_SESSION['SESS_RANK_FILT_C']==1) echo ' selected';?>>Attitude</option>
					<option value=2<?php if($_SESSION['SESS_RANK_FILT_C']==2) echo ' selected';?>>Funny</option>
					<option value=3<?php if($_SESSION['SESS_RANK_FILT_C']==3) echo ' selected';?>>Cool</option>
					<option value=4<?php if($_SESSION['SESS_RANK_FILT_C']==4) echo ' selected';?>>Flirt</option>
					<option value=5<?php if($_SESSION['SESS_RANK_FILT_C']==5) echo ' selected';?>>Dumb</option>
										
				</select>&nbsp;
				<select name=year>
					<option value=ALL<?php if($_SESSION['SESS_RANK_FILT_Y']==ALL) echo ' selected';?>>All Years</option>
					<option value=1<?php if($_SESSION['SESS_RANK_FILT_Y']==1) echo ' selected';?>>1st Year</option>
					<option value=2<?php if($_SESSION['SESS_RANK_FILT_Y']==2) echo ' selected';?>>2nd Year</option>
					<option value=3<?php if($_SESSION['SESS_RANK_FILT_Y']==3) echo ' selected';?>>3rd Year</option>
					<option value=4<?php if($_SESSION['SESS_RANK_FILT_Y']==4) echo ' selected';?>>4th Year</option>
				</select>&nbsp;
				<select name=branch>
					<option value=ALL<?php if($_SESSION['SESS_RANK_FILT_B']==ALL) echo ' selected';?>>All Branches</option>
					<option value=C.S.E<?php if($_SESSION['SESS_RANK_FILT_B']=="C.S.E") echo ' selected';?>>C.S.E</option>
					<option value=E.C.E<?php if($_SESSION['SESS_RANK_FILT_B']=="E.C.E") echo ' selected';?>>E.C.E</option>
					<option value=Civ.E<?php if($_SESSION['SESS_RANK_FILT_B']=="Civ.E") echo ' selected';?>>Civ.E</option>
					<option value=M.E<?php if($_SESSION['SESS_RANK_FILT_B']=="M.E") echo ' selected';?>>M.E</option>
				</select>&nbsp;
				<input type=submit value="Show">
				<br><small><font color=red>(Only first 20 ranks based on the filters will be shown)</font></small></form></td></tr>
<tr><td colspan=4><hr color=black></td></tr>

<?php if($_SESSION['SESS_RANK_FILT_Y']==NULL || $_SESSION['SESS_RANK_FILT_B']==NULL || $_SESSION['SESS_RANK_FILT_C']==NULL){
//////////// Tell them to choose the filters when the page is loaded for the first time
		echo "<tr align=center><td colspan=4><Font size=5 color=crimson>Choose the filters and click on show to display the ranklist.</font><hr color=green></td></tr>";
		goto end;
		}
?>
<tr align=center><td width=5><u>Rank</u></td><td><U>User</u></td><td
				
<?php 
		//This function return the query variable with the wildcards
		$queryusn=GetWildcardUSNQuery($_SESSION['SESS_RANK_FILT_Y'],$_SESSION['SESS_RANK_FILT_B']);
				
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		
		switch($_SESSION['SESS_RANK_FILT_C']){
			case '2' :$ratebarbg="green";break;
			case '3' :$ratebarbg="orange";break;
			case '4' :$ratebarbg="red";break;
			case '5' :$ratebarbg="blue";break;
			default :$ratebarbg="";
		}
		if($_SESSION['SESS_RANK_FILT_C']!=6){// if category other than crush was selected
			echo "><u>Rating</u></td><td width=15><u>People Rated</u></td></tr>";
			//This statement troubled me a lot, took almost a day to find out the correct syntax; thanks to stackoverflow
			$qry="SELECT * FROM `users` WHERE usn LIKE '$queryusn' ORDER BY (SUBSTRING_INDEX(`".$_SESSION['SESS_RANK_FILT_C']."`,'|',-1))+0 DESC LIMIT 20";
			$res=mysql_query($qry);
			$rank=1;
			$trbgcolor="lightgreen";
			while($user=mysql_fetch_array($res)){
				//echo"<pre>";print_r($user);echo"</pre>";
				if($user[$_SESSION['SESS_RANK_FILT_C']]==NULL) continue;
				$ratingfield=explode("|",$user[$_SESSION['SESS_RANK_FILT_C']]);
				echo "<tr bgcolor=".$trbgcolor."><td align=center>".$rank++."</td>";
				echo "<td>".$user['name']."<small> (".GetYear($user['usn'])." ".GetBranch($user['usn']).")</small></td>";
				echo "<td width=300 bgcolor=white><section class=\"container\">
							<div class=\"progress\">
							<span class=\"".$ratebarbg."\"style=\"width:".$ratingfield[2]."%;\"><span>".round($ratingfield[2],1)."%</span></span>
							</div></section></td>";
				echo "<td align=center>".$ratingfield[0]."</td></tr>";
				$rank==2?$trbgcolor="lightblue":NULL;
				$rank>3?$trbgcolor="white":NULL;
				($rank>=3&&$rank%2)?$trbgcolor="lightgrey":NULL;
			}
			if($rank==1) echo "<tr align=center><td colspan=4><hr color=red>Nobody has been rated yet.</td></tr>";
		}else{//if crush was selected
			echo " colspan=2><u>Crush Count</u><small> (Others have on this person)</small></td></tr>";
			$qry="SELECT * FROM `users` WHERE usn LIKE '$queryusn' ORDER BY length(crushrcd) DESC LIMIT 20";
			$res=mysql_query($qry);
			$rank=1;$noranklist=0;
			$trbgcolor="lightgreen";
			while($user=mysql_fetch_array($res)){
				if(strlen($user['crushrcd'])/10==0){$noranklist++;continue;}
				echo "<tr bgcolor=".$trbgcolor."><td align=center>".$rank++."</td>";
				echo "<td>".$user['name']."<small> (".GetYear($user['usn'])." ".GetBranch($user['usn']).")</small></td>";
				echo "<td  colspan=2 width=395 align=center>".(strlen($user['crushrcd'])/10)."</td>";
				$rank==2?$trbgcolor="lightblue":NULL;
				$rank>3?$trbgcolor="white":NULL;
				($rank>=3&&$rank%2)?$trbgcolor="lightgrey":NULL;
			}
			if($noranklist==20 || $noranklist==0) echo "<tr align=center><td colspan=4><hr color=red>Nobody has been rated yet.</td></tr>";
		}
	end:
?>
</table>
</fieldset>							
</body>