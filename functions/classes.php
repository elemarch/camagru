<?php
/*
// =================================== GENERIC DOCUMENTATION =================================== \\

 *   The present classes represent a row         |  Each class dispose of one variable per 		 *
 *   of a mysql table, named as cmg_Xs,          |  mysql colomns, plus a "loaded" bool set 	 *
 *   where X is also the name of the class.      |  to fals if the object couldn't be load, 	 *
 * 												 |  true otherwise. 							 *
 * 																								 *
 *   Each class dispose of one getter per        |  Each class dispose of one printer, that 	 *
 *   variable, named getVariable, excepted for   |  uses echo() to display each variable  		 *
 *   isLoaded function, which returns loaded.    |  followed by an htm break <br>.	 			 *
 * 																								 *
 *	 Each class dispose of one special getter	 |  											 *
 *	 named getClassLink, that provide a valid 	 |  											 *
 *	 html string linking to the object page.	 |  											 *
*/

// ======================================= CLASS :: USER ======================================= \\
	class User {
		//variables
		private $id;
		private $username;
		private $mail;
		private $creation;
		private $photos;
		private $loaded = true;

		//create user
		function __construct($row) {
			if (!$row['id'] || !$row['username'] || !$row['mail'] || !$row['creation'] || !isset($row['photos'])) {
				$this->loaded = false;
				return NULL;
			}
			$this->id = $row['id'];
			$this->username = $row['username'];
			$this->mail = $row['mail'];
			$this->creation = $row['creation'];
		}

		//getters
		function 	   getId() { return $this->id;		 }
		function getUsername() { return $this->username; }
		function 	 getMail() { return $this->mail;	 }
		function getCreation() { return $this->creation; }
		function   getPhotos() { return $this->photos;	 }
		function 	isLoaded() { return $this->loaded;	 }

		function getUserLink() {
			$string = '<a href="user.php?id=' . $this->id . '">' . $this->username . '</a>' ;
			return $string;
		}

		//printer
		function display() {
			echo 'id = ' . $this->id . '<br>' ;
			echo 'username = ' . $this->username . '<br>' ;
			echo 'mail = ' . $this->mail . '<br>' ;
			echo 'creation = ' . $this->creation . '<br>' ;
			echo 'creation = ' . $this->photos . '<br>' ;
		}

		//static functions
		static function makeUserLink($id) {
			return '<a href="user.php?id=' . $id . '">' . $id . '</a>' ;
		}
	}

// ======================================= CLASS :: PHOTO ====================================== \\
	class Photo {
		//variables
		private $id;
		private $creator_id;
		private $likes;
		private $comments;
		private $creation;
		private $loaded = true;

		//create photo
		function __construct($row) {
			if (!$row['id'] || !$row['creator_id'] || !isset($row['likes']) || !isset($row['comments']) || !$row['creation']) {
				$this->loaded = false;
				return NULL;
			}
			$this->id = $row['id'];
			$this->creator_id = $row['creator_id'];
			$this->likes = $row['likes'];
			$this->comments = $row['comments'];
			$this->creation = $row['creation'];
		}

		//getters
		function 		getId() { return $this->id;			}
		function getCreatorId() { return $this->creator_id; }
		function 	 getLikes() { return $this->likes;		}
		function  getComments() { return $this->comments;	}
		function  getCreation() { return $this->creation;	}
		function 	 isLoaded() { return $this->loaded;		}

		function getPhotoLink() {
			$string = '<a href="single.php?id=' . $this->id . '"><img src="medias/photos/pht_' . $this->id . '.png"></a>' ;
			return $string;
		}

		//printer
		function display() {
			echo 'id = ' . $this->id . '<br>' ;
			echo 'creator_id = ' . $this->creator_id . '<br>' ;
			echo 'likes = ' . $this->likes . '<br>' ;
			echo 'creation = ' . $this->creation . '<br>' ;
		}

		//static functions
		static function makePhotoLink($id) {
			return '<a href="single.php?id=' . $id . '"><img src="medias/photos/pht_' . $id . '.png"></a>' ;
		}

		static function resize($file, $w, $h) {
			$new = imagecreatetruecolor(300, 225);
			$src = imagecreatefrompng($file);
			imagecopyresized($new, $src, 0, 0, 0, 0, 300, 225, $h, $h);
			imagepng($new, $file);
		}
	}

?>