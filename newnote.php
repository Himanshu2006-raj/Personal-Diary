<?php
require 'connect.php';
session_start();
if($_SESSION['status']=='loggedin')
{
	$email = $_SESSION['user_email'];    
	$fname = 'there';
	$sql="SELECT FirstName FROM user WHERE Email='".$email."'";
	$fnameResult = mysqli_query($conn,$sql);
	while ($row=$fnameResult->fetch_assoc()) {
		$fname = $row['FirstName'];
	}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Diary - Pour Your Heart Out!</title>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="images/logo.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="db app-page" onload="enableEditMode()">
<div class="app-layout">
	<aside class="right sidebar">
		<div class="sidebar-brand">
			<img src="images/logo.png" alt="Diary logo">
			<span>Diary</span>
		</div>
		<div class="profile-chip">
			<span>Hi,</span>
			<strong><?php echo htmlspecialchars($fname); ?></strong>
		</div>
		<a class="logoutBtn" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
	</aside>

	<main class="left workspace">
		<header class="workspace-header">
			<div>
				<p class="eyebrow">New Entry</p>
				<h1>Add A New Note</h1>
			</div>
			<a href="dashboard.php" class="secondary-action"><i class="fas fa-arrow-left"></i><span>Back</span></a>
		</header>

		<form action="#" method="POST" class="newNote editor-panel" id="mainForm">
			<div class="form-group topMenu">
				<input type="text" name="textTitle" id="titleBtn" placeholder="Enter title" class="form-control">
				<button type="button" onclick="iImage()" class="icon-button" id="addImgBtn" title="Add image"><i class="fas fa-image"></i></button>
			</div>

			<textarea style="display:none;" name="TextArea" id="TextArea" cols="100" rows="14"></textarea>
			<iframe src="" name="richTextField" class="iframe form-control"></iframe>
			

			<div class="form-group bottomBtns">
				<a href="dashboard.php" class="btn cancelBtn">Cancel</a>
				<input type="submit" name="createNote" id="createNote" class="btn btn-primary" value="Save Note" onclick="getText()">
			</div>
		</form>
	</main>
</div>

</body>
<script type="text/javascript">
	function enableEditMode()
	{
		richTextField.document.designMode="On";
		richTextField.document.body.style.fontFamily="'Open Sans', Arial, sans-serif";
		richTextField.document.body.style.fontSize="16px";
		richTextField.document.body.style.color="#2f3542";
		richTextField.document.body.style.lineHeight="1.7";
		richTextField.document.body.style.padding="18px";
		richTextField.document.body.style.margin="0";
	}
	function iImage(){
	var imgSrc = prompt('Enter image url', '');
    if(imgSrc != null){
        richTextField.document.execCommand('insertimage', false, imgSrc); 
    }
}
function getText(){
	var theForm = document.getElementById("mainForm");
	theForm.elements["TextArea"].value = window.frames['richTextField'].document.body.innerHTML;
	theForm.submit();
}
</script>
</html>

<?php
}
else
{
  header("location:index.php"); 
}
if(isset($_POST["createNote"]))
{
	$title = $_POST["textTitle"];
	$txt = $_POST["TextArea"];
	$date = date("Y/m/d H:i");
	$sqlquery = "INSERT INTO userNote (email,uploadDate,title,noteBody) VALUES ('".$email."','".$date."','".$title."','".$txt."')";
	if ($conn->query($sqlquery) === TRUE) 
    {
        echo "<script type='text/javascript'>alert('Note Saved!'); window.location='dashboard.php'</script>";
    } 
    else 
    {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
mysqli_close($conn);
?>
