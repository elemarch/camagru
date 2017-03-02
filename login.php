<?php include 'includes/header.php' ?>

<?php
// This page processes the login.

if(!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $G_PDO->quote($_POST['username']);
    $password = hash('sha256', $username . $G_PDO->quote($_POST['password']));

    $query = "SELECT * FROM cmg_users WHERE username = " . $username . " AND password = '" . $password . "'";
    $checklogin = $G_PDO->query($query);
     
    if($checklogin->rowCount()) { 
        $row = mysql_getTable('SELECT * FROM cmg_users WHERE username = ' . $username, $G_PDO);
        $user = new User($row[0]);
        //enter info in session
        $_SESSION['Username'] = $user->getUsername();
        $_SESSION['EmailAdress'] = $user->getMail();
        $_SESSION['ID'] = $user->getId();
        $_SESSION['LoggedIn'] = 1;
         
        echo "<h1>Success</h1>";
        echo "<p>Click on the menu to navigate through CamaGru!</p>";
    }
    else {
        echo "<h1>Error</h1>";
        echo '<p>Wrong password or username.<br>';
        echo '<a class="button" href="index.php">Back to main page</a>' ;
    }
}
?>

<?php include 'includes/footer.php' ?>