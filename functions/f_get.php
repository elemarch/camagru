<?php
	function getPageName() {
		$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$name = substr($url, strpos($url, '/') + 1, -4);
		return $name;
	}

	function quoteText($string, $pdo) {
		$nstr = $pdo->quote($string);
		$nstr = substr($nstr, 1, -1);
		return $nstr;
	}
?>