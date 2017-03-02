<?php 	include 'includes/header.php'; ?>

<?php
	if (isset($_GET['photo']) && isset($_GET['user'])) {
		echo '<T1>' ;
		$pid = intval($_GET['photo']);
		$uid = intval($_GET['user']);
		if ($pid && $uid) {
			$photo = createPhoto($pid, $G_PDO);
			$user = createUser($uid, $G_PDO);
			$query = 'SELECT * FROM cmg_likes WHERE photo_id = ' . $photo->getId() . ' AND creator_id = ' . $user->getId();
			$query = $G_PDO->query($query);
			if ($query->rowCount()) { //if already liked
				//decrease photo likes
				$query = $G_PDO->query(("UPDATE cmg_photos SET likes = " . ($photo->getLikes() - 1) . " WHERE id = " . $photo->getId()));
				//delete like from photo
				$query = $G_PDO->query("DELETE FROM cmg_likes WHERE photo_id = " . $photo->getId() . " AND creator_id = " . $user->getId());
			}
			else {
			//if not likes
				//increase photo likes
				$query = $G_PDO->query(("UPDATE cmg_photos SET likes = " . ($photo->getLikes() + 1) . " WHERE id = " . $photo->getId()));
				//add one like to photo
				$query = $G_PDO->query("INSERT INTO cmg_likes (creator_id, photo_id) VALUES(" . $user->getId(). ", " . $photo->getId() . ")");
			}
			echo "<a href='single.php?id=" . $photo->getId() . "''>See the photo !</a>";
		}
	}
	else {
        echo '<h1>Error</h1>';
        echo '<p>There was an error. Please try again.</p>';
    }
    include 'includes/footer.php';
?>