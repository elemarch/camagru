<?php include 'includes/header.php' ?>

<?php 
// This page processes the account creation.

    // check if the POST datas are not empty.
    if (!empty($_POST['username']) && !empty($_POST['password1']) && !empty($_POST['password2']) && !empty($_POST['email'])) {
        // protection of datas, by "quoting" them.
        $username = $G_PDO->quote($_POST['username']);
        $password1 = hash('sha256', $username . $G_PDO->quote($_POST['password1'])); // hash the 
        $password2 = hash('sha256', $username . $G_PDO->quote($_POST['password2'])); // passwords
        $email = $G_PDO->quote($_POST['email']);

        // preparation of the queries for checking
        $checkUsername = $G_PDO->query("SELECT * FROM cmg_users WHERE username = " . $username);
        $checkMail = $G_PDO->query("SELECT * FROM cmg_users WHERE mail = " . $email);

        // some basic checkings :
        if (strlen($username) > 20) {
            echo '<h1>Error</h1>';
            echo '<p>Sorry, that username is too long. Please go back and try again.</p>';
            echo '<a class="button" href="index.php">Back to main page</a>' ;
        }
        elseif ($checkUsername->rowCount()) { // if the username is not already taken 
            echo '<h1>Error</h1>';
            echo '<p>Sorry, that username is taken. Please go back and try again.</p>';
            echo '<a class="button" href="index.php">Back to main page</a>' ;
        }
        elseif ($checkMail->rowCount()) { // if the mail is not alreadytaken 
            echo '<h1>Error</h1>';
            echo '<p>Sorry, that mail is already in use. Please go back and try again.</p>';
            echo '<a class="button" href="index.php">Back to main page</a>';
        }
        elseif (strcmp($password1, $password2)) { // if the two passwords do match 
            echo '<h1>Error</h1>';
            echo '<p>Sorry, the passwords you entered do not match.</p>';
            echo '<a class="button" href="index.php">Back to main page</a>';
        }
        elseif (!checkPassword($_POST['password1'])) { // if the password is "secure" enough
            echo '<h1>Error</h1>';
            echo '<p>Your password does not match standard security condition. Check that :</p>';
            echo '<ul>';
            echo '<li>It is at least 8 characters long</li>';
            echo '<li>It contains at least an uppercase letter</li>';
            echo '<li>It contains at least a lowercase letter</li>';
            echo '<li>It contains at least a number</li>';
            echo '</ul>';
            echo '<a class="button" href="index.php">Back to main page</a>';
        }
        else // if all test passed, the user is created
        {
            $registerquery = $G_PDO->query("INSERT INTO cmg_users (username, password, mail) VALUES(" . $username . ", '" . $password1 . "', " . $email . ")");
            if($registerquery) { // check if the query went well
                echo '<h1>Success</h1>';
                echo '<p>Your account was successfully created. Please <a href="index.php">click here to login</a>.</p>';
            
                // sending confirmation mail...
                $message = 'You are now successfully registered to CamaGru!\n\nRemember, your username is ' . $username . '.';
                mail ( $_POST['email'] , 'Welcome to CamaGru!' , $message );
            }
            else { // ICE - In case of error
                echo '<h1>Error</h1>';
                echo '<p>Sorry, your registration failed. Please go back and try again.</p>';
                echo '<a class="button" href="index.php">Back to main page</a>';
            }   
        }
    }
    else  // ICE - In case of error
    {     
        echo '<h1>Error</h1>';
        echo '<p>Sorry, your registration failed. Please go back and try again.</p> ';
        echo '<a class="button" href="index.php">Back to main page</a>';
    }
?>

<?php include 'includes/footer.php' ?>