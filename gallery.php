<?php include 'includes/header.php' ?>

<?php
	//counting photos
	$query = 'SELECT COUNT(*) AS total FROM cmg_photos' ;
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
	$photos = mysql_getTable('SELECT * FROM cmg_photos ORDER BY id DESC LIMIT ' . $first_photo . ', ' . $nbr_photos, $G_PDO);

	foreach ($photos as $key => $value) {
		$photo = new Photo ($photos[$key]);
		$user = mysql_getTable('SELECT * FROM cmg_users WHERE id = ' . $photo->getCreatorId(), $G_PDO) ;
		$user = new User ($user[0]);
	   	echo '<div class="photo_block">' ;
	   	echo '<h1>#' . $photo->getId() . ' by ' . $user->getUserLink() . '</h1>' ;
	   	echo $photo->getPhotoLink() . '<br>' ;
	   	if ($connected) {
	   		echo '<a class="button" href="like.php?photo=' . $photo->getId() . '&amp;user=' . $G_CNX->getId() . '"><i class="heart"></i> ' . $photo->getLikes() . ' likes</a><br>' ;
	   	} else {
	   	echo '<span class="com_count"><i class="heart"></i> ' . $photo->getLikes() . ' likes</span><br>' ;
	   	}
	   	echo '<span class="com_count"><i class="comments"></i> ' . $photo->getComments() . ' comments</span>' ;
	   	echo '</div>' ;
	}
	echo '<div id="pagination">' ;
	if ($page > 4) {
		//display 1 .. , -2 et -3
		echo '<a href="gallery.php?page=1">1</a> .. ' ;
		echo '<a href="gallery.php?page=' . $page-2 . '">' . $page-2 . '</a> ' ;
		echo '<a href="gallery.php?page=' . $page-1 . '">' . $page-1 . '</a> ' ;
	}
	else {
		$i = 1;
		while ($i < $page) {
			echo '<a href="gallery.php?page=' . $i . '">' . $i . '</a> ' ;
			$i++;
		}
	}
	echo '[' . $page . '] ' ; 
	if ($page < $total_pages - 3) {
		echo '<a href="gallery.php?page=' . $page+1 . '">' . $page+1 . '</a> ' ;
		echo '<a href="gallery.php?page=' . $page+2 . '">' . $page+2 . '</a> ' ;
		echo '.. <a href="gallery.php?page=' . $total_pages . '">' . $total_pages . '</a> ' ;
	}
	else {
		$i = $page+1;
		while ($i <= $total_pages) {
			echo '<a href="gallery.php?page=' . $i . '">' . $i . '</a> ' ;
			$i++;
		}
	}
	echo "</div>";
?>

<?php include 'includes/footer.php' ?>