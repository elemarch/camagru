<?php
$G_PDO = new PDO("mysql:host=localhost", "root", "root");

$query = "CREATE DATABASE IF NOT EXISTS camagru";
if ($G_PDO->query($query))
{
    include '../functions/f_db.php' ;

    $G_PDO = new PDO("mysql:host=localhost;dbname=camagru", "root", "root");

    /*
    cmg_users		id		username		password	mail		photos 		creation
    cmg_tokens 		id 		value			user_id		creation
    cmg_photos		id		creator_id		likes 		comments 	creation
    cmg_comments	id 		content 		photo_id	creator_id	creation
    cmg_likes		id 		user_id			photo_id
    */

//empty database
    $to_drop = 'DROP TABLE IF EXISTS cmg_users, cmg_tokens, cmg_photos, cmg_comments, cmg_likes' ;
    $G_PDO->query($to_drop);

//create table

    echo 'Creating USERS table...<br>';

    $query = "CREATE TABLE cmg_users
(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	username VARCHAR(20) NOT NULL, 
	password VARCHAR(64) NOT NULL, 
	mail VARCHAR(300) NOT NULL, 
	photos INT DEFAULT 0, 
	creation DATETIME DEFAULT CURRENT_TIMESTAMP
)" ;
    $G_PDO->query($query);

    echo 'Creating TOKENS table...<br>';

    $query = 'CREATE TABLE cmg_tokens (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	value VARCHAR(64) NOT NULL,
	user_id INT NOT NULL,
	creation DATETIME DEFAULT CURRENT_TIMESTAMP
)' ;
    $G_PDO->query($query);

    echo 'Creating PHOTOS table...<br>';

    $query = 'CREATE TABLE cmg_photos (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	creator_id INT NOT NULL,
	likes INT DEFAULT 0,
	comments INT DEFAULT 0,
	creation DATETIME DEFAULT CURRENT_TIMESTAMP
)' ;
    $G_PDO->query($query);

    echo 'Creating COMMENTS table...<br>';

    $query = 'CREATE TABLE cmg_comments (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	content TEXT NOT NULL,
	photo_id INT NOT NULL,
	creator_id INT NOT NULL,
	creation DATETIME DEFAULT CURRENT_TIMESTAMP
)' ;
    $G_PDO->query($query);

    echo 'Creating LIKES table...<br>';

    $query = 'CREATE TABLE cmg_likes (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	photo_id INT NOT NULL,
	creator_id INT NOT NULL
)' ;
    $G_PDO->query($query);

    echo 'Done ! You can now navigate through my <a href="../index.php">Camagru!</a><br>';

}


?>