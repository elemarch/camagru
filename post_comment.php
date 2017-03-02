<?php include 'includes/header.php' ?>

<?php
if (!isset($_POST["message"]) || !isset($_POST["photo_id"])) { 
	echo 'Sorry, an error occurred.';
}
else {
	$message = htmlspecialchars(quoteText($_POST["message"], $G_PDO));
	$pid = quoteText($_POST["photo_id"], $G_PDO);
	if ($_SESSION['Username']) {
		$username = quoteText($_SESSION['Username'], $G_PDO);
		$table = mysql_getTable("SELECT * FROM cmg_users WHERE username = '" . $username . "'", $G_PDO);
		$user = new User($table[0]);
	} else { 
		echo 'Sorry, an error occurred.';
		include 'includes/footer.php' ;
		return 0;
	}
	$G_PDO->query("INSERT INTO cmg_comments (content, creator_id, photo_id) VALUES('" . $message . "'," . $user->getId() . "," . $pid . ")") ;
	$G_PDO->query('UPDATE cmg_photos SET comments = comments + 1 WHERE id = ' . $pid) ;
	$table = mysql_getTable("SELECT * FROM cmg_users U INNER JOIN cmg_photos P ON U.id = P.creator_id WHERE P.id = " . $pid, $G_PDO);
	$mail = 'The user ' . $user->getUsername() . ' commented on your photo.<br>' ;
	$mail .= '"' . $message . '"<br>' ;
	$mail .= '<a href="http://localhost/camagru/single.php?id=' . $pid . '">Click here to see the comment</a>' ;
	mail ( $table[0]['mail'] , '[CamaGru!]' . $user->getUsername() . ' commented on your photo !' , $mail );
	echo '<h1>Done</h1>';
	echo '<a class="button" href="single.php?id=' . $pid . '">See your comment !</a>';
}

?>

<?php include 'includes/footer.php' ?>