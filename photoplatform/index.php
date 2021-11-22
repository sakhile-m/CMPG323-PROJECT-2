<?php
session_start();
include 'functions.php';
//include 'signup.php';
//include 'login.php';
//echo $_SESSION['success'];
//echo $_SESSION['email'];
echo $_SESSION['message'];
$_SESSION['message']='';
//echo $_SESSION['userid'];
$email = $_SESSION['email'];
$db = mysqli_connect('127.0.0.1', 'root', 'C4!uh>oL7', 'photogallerydb');
$query = "SELECT * from users WHERE email = '$email' ";
$result = mysqli_query($db, $query);
//$_SESSION['userid'] = $id;
while($row = mysqli_fetch_array($result)){
//echo $row['userid'];
$userid = $row['userid'];
$_SESSION['userid']= $userid;
}// Connect to MySQL
$pdo = pdo_connect_mysql();
// MySQL query that selects all the images
//$stmt = $pdo->query("SELECT * FROM images ORDER BY uploaded_date DESC");
//$_SESSION['userid'] = $row['userid'];
//$_SESSION['userid']=1;
$userid = $_SESSION['userid'] ;

$stmt = $pdo->query("SELECT * FROM images WHERE userid = '$userid' ORDER BY uploaded_date DESC");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Photo Gallery')?>

<div class="content home">
	<h2>Photo Gallery</h2>
	<p>Welcome to the gallery page! You can view the list of uploaded images below.</p>
	<a href="upload.php" class="upload-image">Upload Image</a>
	<div class="images">
		<?php foreach ($images as $image): ?>
		<?php if (file_exists($image['filepath'])): ?>
		<a href="#">
			<img src="<?=$image['filepath']?>" alt="<?=$image['tags']?>" data-id="<?=$image['id']?>" data-title="<?=$image['title']?>" width="300" height="200">
			<span><?=$image['title']?></span>
		</a>
		<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>
<div class="image-popup"></div>

<script>

let image_popup = document.querySelector('.image-popup');

document.querySelectorAll('.images a').forEach(img_link => {
	img_link.onclick = e => {
		e.preventDefault();
		let img_meta = img_link.querySelector('img');
		let img = new Image();
		img.onload = () => {
			// Create the pop out image
			image_popup.innerHTML = `
				<div class="con">
					<h3>${img_meta.dataset.title}</h3>
					<p>${img_meta.alt}</p>
					<img src="${img.src}" width="${img.width}" height="${img.height}">
					<a href="delete.php?id=${img_meta.dataset.id}" class="trash" title="Delete Image"><i class="fas fa-trash fa-xs"></i></a>
					<a href="edit.php?id=${img_meta.dataset.id}" class="edit" title="Edit Image"><i class='fas fa-edit'></i></a>
				</div>
			`;
			image_popup.style.display = 'flex';
		};
		img.src = img_meta.src;
	};
});
// Hide the image popup container, but only if the user clicks outside the image
image_popup.onclick = e => {
	if (e.target.className == 'image-popup') {
		image_popup.style.display = "none";
	}
};
</script>

<?=template_footer()?>