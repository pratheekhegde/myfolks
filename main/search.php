<?php
	require_once '../Core.fnc.php';
	session_start();
	
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
?>

<head>
 <title>Search Profile</title>
 <!--[if lt IE 9]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
<script type="text/javascript" src ="../jquery-1.11.1.min.js"></script>
<script type="text/javascript">
		if(frameElement == null){window.location=window.close();}
		var AJreq=null;
		function submit(){query=$("#query").val();
							
							query=query.replace(/^\s+|[_|%|\"|\;|\,|.]|\s+$/gm,'');
							$("#res").html("<center><img src=../assets/progress.gif><br><b>Please Wait..</b></center>");
							 AJreq = $.ajax({
								type:"POST",
								url:"AJsearch.php",
								data:{"profsearch":query},
								beforeSend:function(){if(AJreq!=null){AJreq.abort();}},
								success:function(data,textStatus){$("#res").hide().html(data).slideDown('500','swing');}
							});
								
		}
		$(function(){
				$(document).keydown(function(e){if(!e){e=windows.event;}if(e.keyCode==13){submit();}});
				$("#query").keyup(function (){
									query=$("#query").val();
									if($("#query").val().length >=6){submit();}
								});	
				$("#butt").click(function(){submit();});	
		});
</script>
<style>
input[type=text]{
	background-color: #CEEEFA;
	border: 1px solid #006;
	font-family: 'Lucida Sans'; 
	font-size: 20px;
	Height: 35px;
	Width: 400px;
}
input[type=button]{
	font-family: 'Lucida Sans';
    border: 3px solid #006;
    background: lightgreen;
	Height: 35px;
	font-size: 20px;
	
}
</style>
</head>
<body>
<DIV STYLE="font-family: 'Lucida Sans';">
<fieldset><legend>Search Profile Page</legend>
<center><input type=text id=query name=profsearch placeholder="Type a Name or USN and hit Search!">
<input type=button value=Search id=butt><hr color=lightgreen>
<div id=res></div>
</center>
</body>