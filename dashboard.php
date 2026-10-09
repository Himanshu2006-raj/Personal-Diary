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
		<a class="newBtn" href="newnote.php"><i class="fas fa-plus"></i><span>New Note</span></a>
		<a class="logoutBtn" href="logout.php"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
	</aside>

	<main class="left workspace">
		<header class="workspace-header">
			<div>
				<p class="eyebrow">Notebook</p>
				<h1>Your Notes</h1>
			</div>
			<a class="primary-action" href="newnote.php"><i class="fas fa-plus"></i><span>New Note</span></a>
		</header>

		<div class="toolbar">
			<input type="text" id="searchBox" class="form-control header" onkeyup="search()" placeholder="Search by title...">
		</div>

		<div class="table-wrap">
			<table class="recentNotes table" id="recentNotes">
				<thead class="thead-pink">
					<tr>
						<th scope="col" onclick="sortTable(0)">Date <i class="fas fa-sort"></i></th>
						<th scope="col" onclick="sortTable(1)">Note <i class="fas fa-sort"></i></th>
						<th scope="col"></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sqlquery = "SELECT * FROM usernote WHERE email ='".$email."' ORDER BY uploadDate DESC;";
					$res = mysqli_query($conn,$sqlquery);   
					$rows = mysqli_num_rows($res);
					if($rows == 0)
					{
						echo '<tr class="empty-row"><td colspan="3">No notes yet.</td></tr>';
					}
					for($i=0;$i<$rows;$i++) 
					{        
						$tablerow = mysqli_fetch_assoc($res); 
						$originalDate = $tablerow['uploadDate'];
						$newDate = date("d-m-Y h:i a", strtotime($originalDate));                   	
						echo '<tr>
								<td>'.$newDate.'</td>
								<td>'.htmlspecialchars($tablerow["title"]).'</td>
								<td width="120"><form action="view.php" method="GET">
									<input type="hidden" name="noteID" value="'.$tablerow["noteID"].'">
									<button type="submit" name="viewBtn" value="View" class="viewBtn">View</button>
									</form></td></tr>';
					} 
					?>
				</tbody>
			</table>
		</div>
	</main>
</div>

</body>
<script type="text/javascript">
var table = document.getElementById("recentNotes");
function search() 
{
	var input, filter, tr, td, i, txtValue;
	input = document.getElementById("searchBox");
	filter = input.value.toUpperCase();
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) 
	{
		td = tr[i].getElementsByTagName("td")[1];
		if(td) 
		{
				txtValue = td.textContent || td.innerText;
				if (txtValue.toUpperCase().indexOf(filter) > -1) 
				{
					tr[i].style.display = "";
				} 
				else 
				{
					tr[i].style.display = "none";
				}
		}       
	}
}

function sortTable(n)
{
	var rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  	switching = true;
  	dir = "asc"; 
  	while (switching)
  	{
  		switching = false;
    	rows = table.rows;
    	for (i = 1; i < (rows.length - 1); i++) 
    	{
      		shouldSwitch = false;
      		x = rows[i].getElementsByTagName("TD")[n];
      		y = rows[i + 1].getElementsByTagName("TD")[n];
      		if (dir == "asc") 
      		{
        		if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) 
        		{
          			shouldSwitch= true;
          			break;
        		}
      		}
      		else if (dir == "desc") 
      		{
        		if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) 
        		{
          			shouldSwitch = true;
          			break;
        		}
      		}
    	}
    	if (shouldSwitch) 
    	{
      		rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      		switching = true;
      		switchcount ++;      
    	} 
    	else 
    	{
      		if (switchcount == 0 && dir == "asc") 
      		{
        		dir = "desc";
        		switching = true;
      		}
    	}
  	}
}

         
</script>
</html>

<?php
}
else
{
  header("location:index.php"); 
}
mysqli_close($conn);
?>
