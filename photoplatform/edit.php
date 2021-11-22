<?php
include 'functions.php';
session_start();
//echo $_SESSION['id'];
$userid = $_SESSION['userid'];
//$id = $_GET['id'];
//echo $_GET['id'];

//$pdo = pdo_connect_mysql();
$db = mysqli_connect('localhost', 'root', 'C4!uh>oL7', 'photogallerydb');
if(count($_POST)>0 ) 
{
	mysqli_query($db,"UPDATE images set title='" . $_POST['title'] . "', tags='" . $_POST['tags'] . "', geolocation='" . $_POST['geolocation'] . "', captured_by='" . $_POST['captured_by'] . "' ,captured_date='" . $_POST['captured_date'] . "' WHERE id='" . $_SESSION['id'] . "'");
	$message = "Record Modified Successfully";
	$_SESSION['message']= $message;
	
	header('Location: index.php');
	
	}
	//if (isset($_GET['id'])) 
	{
		$_SESSION['id'] = $_GET['id'];
	$result = mysqli_query($db,"SELECT * FROM images WHERE id='" . $_SESSION['id'] . "'"); 
	$row= mysqli_fetch_array($result);
	}
$msg = '';
// Check that the image ID exists


?>

<?=template_header('Update Image')?>

<div class="content update">
	<h2>Update Image</h2>
	<form action="edit.php" method="post" enctype="multipart/form-data">

		<label for="title">Title</label>
		<input type="text" name="title" id="title" value="<?php   echo $row['title']; ?>">
		<label for="tags">Tags</label>
		<input type="text" name="tags" id="tags" value="<?php echo $row['tags']; ?>">
        <label for="geolocation">Geolocation</label>
		<input type="text" name="geolocation" id="geolocation"value="<?php echo $row['geolocation']; ?>">
        <label for="captured_by">Captured By</label>
		<input type="text" name="captured_by" id="captured_by" value="<?php echo $row['captured_by']; ?>">
        <label for="captured_date">Captured Date</label>
		<input type="date" name="captured_date" id="captured_date" value="2021-10-08">
	    <input type="submit" value="Update Image" name="submit">
	</form>
	<p><?=$msg?></p>
</div>

<?=template_footer()?>