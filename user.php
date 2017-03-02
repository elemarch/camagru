<?php include 'includes/header.php' ?>

<?php
	if ($connected) {
		if (isset($_GET['id'])) {
			$uid = quoteText($_GET['id'], $G_PDO);
			$table = mysql_getTable('SELECT * FROM cmg_users WHERE id =' . $uid, $G_PDO);
			$user = new User($table[0]);
		}
		else { $user = $G_CNX; }
		//counting photos
		$query = 'SELECT COUNT(*) AS total FROM cmg_photos WHERE creator_id = ' . $user->getId() ;
		$table = mysql_getTable($query, $G_PDO);
		$total = $table[0]['total'];
		
		//page number calc
		$nbr_photos = 6;
		$total_pages=ceil($total/$nbr_photos);

		//get actual page
		if(isset($_GET['page'])) {
	    	$page = quoteText($_GET['page'], $G_PDO);
	    	if($page > $total_pages) { $page = $total_pages; }
		}
		else { $page = 1; }

		//first photo id
		$first_photo = ($page - 1) * $nbr_photos;

		//get all photos in a table
		$photos = mysql_getTable('SELECT * FROM cmg_photos WHERE creator_id = ' . $user->getId() . ' ORDER BY id DESC LIMIT ' . $first_photo . ', ' . $nbr_photos, $G_PDO);

		echo '<h1>Photos by ' . $user->getUsername() . '</h1>';
		foreach ($photos as $key => $value) {
			$photo = new Photo ($photos[$key]);
			$user = mysql_getTable('SELECT * FROM cmg_users WHERE id = ' . $photo->getCreatorId(), $G_PDO) ;
			$user = new User ($user[0]);
		   	echo '<div class="photo_block">' ;
		   	echo '<h2>#' . $photo->getId() . '</h2>' ;
		   	echo $photo->getPhotoLink() . '<br>' ;
		   	echo '<a class="button"><i class="heart"></i> ' . $photo->getLikes() . ' likes</a><br>' ;
		   	echo '<span class="com_count"><i class="comments"></i> ' . $photo->getComments() . ' comments</span>' ;
		   	echo '</div>' ;
		}
		echo '<div id="pagination">' ;
		if ($page > 4) {
			//display 1 .. , -2 et -3
			echo '<a href="user.php?id=' . $user->getId() . '&amp;page=1">1</a> .. ' ;
			echo '<a href="user.php?id=' . $user->getId() . '&amp;page=' . $page-2 . '">' . $page-2 . '</a> ' ;
			echo '<a href="user.php?id=' . $user->getId() . '&amp;page=' . $page-1 . '">' . $page-1 . '</a> ' ;
		}
		else {
			$i = 1;
			while ($i < $page) {
				echo '<a href="user.php?id=' . $user->getId() . '&amp;page=' . $i . '">' . $i . '</a> ' ;
				$i++;
			}
		}
		echo '[' . $page . '] ' ; 
		if ($page < $total_pages - 3) {
			echo '<a href="user.php?id=' . $user->getId() . '&amp;page=' . $page+1 . '">' . $page+1 . '</a> ' ;
			echo '<a href="user.php?id=' . $user->getId() . '&amp;page=' . $page+2 . '">' . $page+2 . '</a> ' ;
			echo '.. <a href="user.php?id=' . $user->getId() . '&amp;page=' . $total_pages . '">' . $total_pages . '</a> ' ;
		}
		else {
			$i = $page+1;
			while ($i <= $total_pages) {
				echo '<a href="user.php?id=' . $user->getId() . '&amp;page=' . $i . '">' . $i . '</a> ' ;
				$i++;
			}
		}
		echo "</div>";
	}
	else {
		echo "<h1>You're not connected</h1>" ;
		echo "<p>This page allows you to see a creator's gallery.</p>" ;
		echo '<p><a class="button" href="index.php">Join us !</a></p>' ;
	}
?>

<?php include 'includes/footer.php' ?>