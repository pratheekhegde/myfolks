<?php
	require_once '../Core.fnc.php';
	session_start();
	$usn=$_SESSION['SESS_USN'];
	if($_SESSION['LoginFlag']!=3){
		unset($_SESSION['LoginErrorFlag']);
		header("location: ../");
		exit();
	}
	
	if($_FILES["file"]["size"]==0){
		echo "No File Selected";
		$_SESSION["PPIC_UPLOAD_FLG"]="No File Selected or File is greater than 1MB";
		header('location: editprofile.php');
		header('target:mainiframe');
		exit(); 
	}else if($_FILES["file"]["size"] > 1048576){
		echo "File Size greater than 1 MB";
		$_SESSION["PPIC_UPLOAD_FLG"]="File Size Must be lesser than 1 MB";
		header('location: editprofile.php');
		header('target:mainiframe');
		exit(); 
	}
	$checkimage=getimagesize($_FILES["file"]["tmp_name"]);
	if($checkimage[0]==0) {
		//echo "not image";
		$_SESSION["PPIC_UPLOAD_FLG"]="File is not an image!";
		header('location: editprofile.php');
		header('target:mainiframe');
		exit();
	}
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = strtolower(end($temp));

	if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
				|| ($_FILES["file"]["type"] == "image/pjpeg")
					|| ($_FILES["file"]["type"] == "image/x-png")
						|| ($_FILES["file"]["type"] == "image/png"))
							&& ($_FILES["file"]["size"] < 1048576)
								&& in_array($extension, $allowedExts)) {
		if ($_FILES["file"]["error"] > 0) {
			echo "Error: " . $_FILES["file"]["error"] . "<br>Something Isn't fine. Let us know by sending us the starting code of this message. ";
		}else{
		
			$properusn=GetProperUSN($usn);
			$profilepic= '../profilepics/'.$properusn.'.jpg';
			//process the image and upload the image to the profile pic directory.
			smart_resize_image($_FILES["file"]["tmp_name"],null,300,300,//width and height default, null for file not a string
								true,//keep it proportional 
                              $profilepic,//destination punch it with the usn.
                              false,//delete the original file
                              false,//no linux commands to delete the file
                              100);//quality of the image file
			/* echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			echo "Type: " . $_FILES["file"]["type"] . "<br>";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";*/
			$_SESSION["PPIC_UPLOAD_FLG"]="<font color=green>Profile Pic Updated. Refresh the page if you don't see it. </font>";
			header('location: editprofile.php');
			header('target:mainiframe');
			exit(); 
		}
	}else{
	  echo "Invalid file";
	  $_SESSION["PPIC_UPLOAD_FLG"]="Invalid File Selected";
	  header('location: editprofile.php');
	  header('target:mainiframe');
		exit(); 
	}
	
?>
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