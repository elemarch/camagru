<?php include 'includes/header.php' ?>

<?php
	$query = $G_PDO->query("SELECT * FROM cmg_photos LIMIT 1");
	
	if (!$query->rowCount()){
		//if ther is no photo at all
		echo "<h1>What ?</h1>There is no photos yet... Please, be the first one to do so !";
		include 'includes/footer.php';
		return 0;
	}
	
	if (!isset($_GET["id"])) { //if no id is provided, load a random photo
		$table = mysql_getTable('SELECT * FROM cmg_photos ORDER BY RAND() LIMIT 1', $G_PDO);
		$photo = new Photo ($table[0]);
	}
	else { //else, load the desired photo
        if (!($photo = createPhoto(quoteText(intval($_GET["id"]), $G_PDO), $G_PDO))) {
            echo "<h1>Error</h1>";
            echo "The photo you're looking for doesn't exist." ;
            include 'includes/footer.php';
            return 0;
        }
	}
?>

<div id="single-left" class="col-2">
	<?php
		$table = mysql_getTable("SELECT * FROM cmg_users WHERE id = " . $photo->getCreatorId(), $G_PDO);
		$user = new User($table[0]);
		echo '<h1>#<span id="photo_id">' . $photo->getId() . '</span> by <a href="user.php?id=' . $user->getId() . '">' . $user->getUsername() . '</a></h1>';
		echo '<img src="medias/photos/pht_' . $photo->getId() . '.png">' ;
	?>
	<div id="social">
		<?php
		if ($connected) {
	   		echo '<a class="button" href="like.php?photo=' . $photo->getId() . '&amp;user=' . $G_CNX->getId() . '"><i class="heart"></i> ' . $photo->getLikes() . ' likes</a><br>' ;
	   	} else {
	   		echo '<span class="com_count"><i class="heart"></i> ' . $photo->getLikes() . ' likes</span><br>' ;
	   	}?>
		<span class="com_count"><i class="comments"></i> <?php echo $photo->getComments() ; ?> comments</span><br>
		<?php
		if ($connected && ($G_CNX->getId() == $photo->getCreatorId())) {
	   		echo '<a class="button button_delete" href="javascript:Delete();"><i class="trash"></i> Delete Photo</a><br>' ;
	   	}?>
	</div>
</div>
<div id="single-right" class="col-2">
	<?php if ($connected) { ?>
	<div class="comment"><form method="post" action="post_comment.php" name="commentform" id="commentform">
		<div class="com_head">
			<a class="name">Write a comment</a><input class="num_count" disabled  maxlength="3" size="3" value="255" id="counter">
			<input type="submit" name="post_comment" class="arrow button">
		</div>	
			<?php echo '<input type="hidden" name="photo_id" id="photo_id" value="' . $photo->getId() . '"/>' ; ?>
			<textarea onkeyup="textCounter(this,'counter',255);" id="message" name="message"></textarea>
		</form>
		
	</div>
	
	<?php }
		echo '<h1>Comments</h1>';
		    $comments = mysql_getTable('SELECT * FROM cmg_comments WHERE photo_id = ' . $photo->getId() . ' ORDER BY creation DESC', $G_PDO);
		    foreach ($comments as $key => $value) {
		    	$query = "SELECT * FROM cmg_comments C INNER JOIN cmg_users U WHERE C.creator_id=U.id AND C.id = '" . $value['id'] . "'";
		    	$u_table = mysql_getTable($query, $G_PDO); 
		    	echo '<div class="comment">';
		    	echo '<div class="com_head"><a class="name">' . $u_table[0]['username'] . '</a><span class="num_count">' . $u_table[0]['photos'] . '</span></div>';
		    	echo '<div class="com_body">' . $value['content'] . '</div></div>';
		    }
		?>
</div>

<script type="text/javascript">
    function textCounter(field,field2,maxlimit)
    {
        var countfield = document.getElementById(field2);
        if ( field.value.length > maxlimit ) {
            field.value = field.value.substring( 0, maxlimit );
            return false;
        } else {
            countfield.value = maxlimit - field.value.length;
        }
    }
</script>
<script type="text/javascript">
	function Delete() {
		var answer = confirm ("You will permanently delete the photo, as well as likes and comments associated to it. Are you sure you want to continue ?")
		if (answer) {
			var span = document.getElementById("photo_id");
			var url = "delete_photo.php?id=";
			url = url.concat(span.textContent);
			window.location=url;
		}
	}
</script>

<?php include 'includes/footer.php' ?>