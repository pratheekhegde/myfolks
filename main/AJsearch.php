<?php
	require_once '../Core.fnc.php';
	session_start();
	
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
	if(substr($_POST['profsearch'],0,3)==" "){ echo "";exit();}
	if($_POST['profsearch']!=NULL){
		$searchquery=clean($_POST['profsearch']);
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		$res=mysql_query("SELECT * FROM `users` WHERE name LIKE '%".$searchquery."%' OR usn LIKE '%".$searchquery."%'");
		$result="<table border=0 width=791>";
		if(mysql_num_rows($res)==0){
				$result.= "<tr><td align=center><b><big>You Searched for :</b><font size=8 color=green>\"".$searchquery."\"</font></big>";
				$result.= "<br><font size=10 color=red>There are no results!</font><br>";
				$result.= "<img src=../assets/noresults.png></td></tr>";
		}else{
				$result.= "<tr><td align=center colspan=2><b><big>You Searched for :</b><font size=8 color=green>\"".$searchquery."\"</font> <b>(Results: ".mysql_num_rows($res).")</b></big></td></tr>";
				$num=1;
				while($results=mysql_fetch_array($res)){
					$resusn=GetProperUSN($results['usn']);
					$num%2?$trbgcolor=lightgrey:$trbgcolor=white;
					$result.= "<tr bgcolor=".$trbgcolor."><td>".$num++."</td>";
					$result.= "<td align=left>".$results['name']."<small> (".GetYear($resusn)." ".GetBranch($resusn).")</small></td></tr>";
			}
		}
		$result.="</table>";
		print $result;
	}
	
?>

 