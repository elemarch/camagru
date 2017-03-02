<?php include 'includes/header.php' ?>

<?php
 
function error_msg() {
		echo "<h1>Error</h1>No photo has been deleted.";
		include 'includes/footer.php';
}

// 0 - Protect GET vars
if (isset($_GET['id'])) { 
	$pid = intval($_GET['id']);
	if ($pid == 0) {
		error_msg();
		return 0;
	}
} else {
	error_msg();
	return 0;
}

$photo = createPhoto($pid, $G_PDO);

// 1 - Check if user is as well the owner
if ($photo->getCreatorId() == $G_CNX->getId()) {

	// 2 - Delete relative file
	unlink('medias/photos/pht_' . $pid . '.png');

	// 3 - Delete relative comments rows in the DB
	$G_PDO->query("DELETE FROM cmg_comments WHERE photo_id = " . $pid);

	// 4 - Delete relative likes rows in the DB
	$G_PDO->query("DELETE FROM cmg_likes WHERE photo_id = " . $pid);

	// 5 - Delete the photo row in the DB
	$G_PDO->query("DELETE FROM cmg_photos WHERE id = " . $pid);

	// 6 - Decrease user photo count
	$G_PDO->query("UPDATE cmg_users SET photos = photos - 1 WHERE id = " . $photo->getCreatorId());

	echo "<h1>Success</h1>Your photo has been deleted.";
} else {
	error_msg();
}
?>

<?php include 'includes/footer.php' ?>