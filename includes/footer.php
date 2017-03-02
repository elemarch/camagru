</div>
<div id="footer">
<?php if ($connected) {?>
	Connected as <?php echo $G_CNX->getUsername(); ?><br>
	<a class="button" href="logout.php">Log out</a>
<?php	} else { ?>
	Not connected.<br>
	<a class="button" href="index.php">Log in</a>
<?php	} ?>
</div><!-- footer -->
</div><!--  body  -->
</div><!--  html  -->