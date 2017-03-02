<?php
	$connected = 0;
	if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {
    	$connected = 1;
    	$table = mysql_getTable("SELECT * FROM cmg_users WHERE username = " . $G_PDO->quote($_SESSION['Username']), $G_PDO);
    	$G_CNX = new User ($table[0]);
	}
?>