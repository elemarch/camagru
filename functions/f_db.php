<?php
	function mysql_getTable($query, $pdo) {
		//returns a table wih the content of the query. ICE : returns NULL
		$statement = $pdo->query($query);
		if (!$pdo || !$statement) { 
			echo 'function <strong>mysql_getTable</strong> : query failed.<br>';
			return NULL;
		}
		$table = [];
		while ($t = $statement->fetch(PDO::FETCH_ASSOC)) {
			$table[] = $t;
		}
		return $table;
	}

	function createUser($id, $pdo) {
		$table = mysql_getTable('SELECT * FROM cmg_users WHERE id =' . $id, $pdo);
		$user = new User ($table[0]);
		return $user;
	}

	function createPhoto($id, $pdo) {
	    $query = $pdo->query("SELECT * FROM cmg_photos WHERE id =" .$id) ;
	    if ($query->rowCount()) {
            $table = mysql_getTable('SELECT * FROM cmg_photos WHERE id =' . $id, $pdo);
            $user = new Photo ($table[0]);
            return $user;
        }
        else
            return NULL;
	}
?>