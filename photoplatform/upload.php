<?php
include 'functions.php';
session_start();
//echo $_SESSION['userid'];
$id = $_SESSION['userid'];
// The output message
$msg = '';
$image_extensions = array("png","jpg","jpeg","gif","ico","bmp","tiff");
// Check if user has uploaded new image
if (isset($_FILES['image'], $_POST['title'], $_POST['tags'])) {
	// The folder where the images will be stored
	$target_dir = 'images/';
	// The path of the new uploaded image
	$image_path = $target_dir . basename($_FILES['image']['name']);
	// Check to make sure the image is valid
	if (!empty($_FILES['image']['tmp_name']) && getimagesize($_FILES['image']['tmp_name'])) {
		if (file_exists($image_path)) {
			$msg = 'Image already exists, please choose another or rename that image.';
		} else if ($_FILES['image']['size'] > 500000) {
			$msg = 'Image file size too large, please choose an image less than 500kb.';
		} else {
			// Everything checks out now we can move the uploaded image
			move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
			// Connect to MySQL
			$pdo = pdo_connect_mysql();
			// Insert image info into the database (title, description, image path, and date added)
			$stmt = $pdo->prepare('INSERT INTO images ( userid, title, tags, geolocation, captured_by, captured_date, filepath, uploaded_date) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)');
	        $stmt->execute([$id, $_POST['title'], $_POST['tags'], $_POST['geolocation'], $_POST['captured_by'], $_POST['captured_date'], $image_path ]);
			//$stmt = $pdo->prepare('INSERT INTO images (title, tags, filepath, uploaded_date) VALUES (?, ?, ?, CURRENT_TIMESTAMP)');
	       // $stmt->execute([ $_POST['title'], $_POST['tags'], $image_path ]);
            $msg = 'Image uploaded successfully!';
		}
	} else {
		$msg = 'Please upload an image!';
	}
}
?>

<?=template_header('Upload Image')?>

<div class="content upload">
	<h2>Upload Image</h2>
	<form action="upload.php" method="post" enctype="multipart/form-data">
		<label for="image">Choose Image</label>
		<input type="file" name="image" accept="image/*" id="image">
		<label for="title">Title</label>
		<input type="text" name="title" id="title">
		<label for="tags">Tags</label>
		<textarea name="tags" id="tags"></textarea>
        <label for="geolocation">Geolocation</label>
		<input type="text" name="geolocation" id="geolocation">
        <label for="captured_by">Captured By</label>
		<input type="text" name="captured_by" id="captured_by">
        <label for="captured_date">Captured Date</label>
		<input type="date" name="captured_date" id="captured_date">
	    <input type="submit" value="Upload Image" name="submit">
	</form>
	<p><?=$msg?></p>
</div>

<?=template_footer()?>