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
<body class="db app-page">
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
		<?php
		if(isset($_GET["viewBtn"]))
		{
			$postid = $_GET["noteID"];
			$sqlquery = "SELECT * FROM usernote WHERE noteId =".$postid;
			$res = mysqli_query($conn,$sqlquery);         
			$data = mysqli_fetch_assoc($res); 
			$originalDate = $data['uploadDate'];
			$newDate = date("d-m-Y h:i a", strtotime($originalDate));  
			$title = $data['title'];	
			$txt = $data['noteBody'];
			echo '<header class="workspace-header note-header">
					<div>
						<p class="eyebrow">Diary Entry</p>
						<h1>'.htmlspecialchars($title).'</h1>
						<p class="subtitle">Created on '.$newDate.'</p>
					</div>
					<a href="dashboard.php" class="secondary-action"><i class="fas fa-arrow-left"></i><span>Back</span></a>
				</header>';
			echo '<article class="form-control viewtab"><div class="viewtabContent"><div class="viewText">'.$txt.'</div></div></article>';
			echo '<form action="#" method="GET" class="delete-form">
					<input type="hidden" name="deletenoteID" value="'.$postid.'">
					<button type="submit" name="deleteBtn" value="Delete" class="deleteBtn" id="delBtn"><i class="fas fa-trash-alt"></i><span>Delete this note</span></button>
					</form>';
		}
		if(isset($_GET["deleteBtn"]))
		{
			$post = $_GET["deletenoteID"];
			$sqlquery = "DELETE FROM usernote WHERE noteID =".$post;
			$res = mysqli_query($conn,$sqlquery);  
			if($res)
			{
				 echo "<script type='text/javascript'>alert('Note Deleted Succesfully!'); window.location='dashboard.php'</script>";
			}
		}
		?>
	</main>
</div>

</body>
</html>

<?php
}
else
{
  header("location:index.php"); 
}

mysqli_close($conn);
?>
