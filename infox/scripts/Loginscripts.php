<?php
    include ('inputs.php');

    if (isset($_POST['login']) && !empty(htmlentities($_POST['Lusername'])) && !empty(htmlentities($_POST['Lusername'])))
    {
        $username = htmlentities($_POST['Lusername']);
        $password = htmlentities($_POST['Lpassword']);

        $GetUserData = 'SELECT * FROM ' . $Userstable . ' WHERE username = ?';

        if ($stmt = mysqli_prepare($DBConnect, $GetUserData))
        {
            mysqli_stmt_bind_param($stmt, 's', $username);

            $Queryresult = mysqli_stmt_execute($stmt);

            if (!$Queryresult)
            {
                echo 'Error: ' . mysqli_stmt_errno($stmt) . ': ' . mysqli_stmt_error($stmt);
            }
            else
            {
                mysqli_stmt_bind_result($stmt, $DBuserid, $DBusername, $DBpassword, $DBuserlevel);
                mysqli_stmt_store_result($stmt);
                mysqli_stmt_fetch($stmt);

                $VerifyPassword = password_verify($password, $DBpassword);
                echo $VerifyPassword;
                if (!$VerifyPassword)
                {
                    $feedback = 'Username or Password incorrect';
                }
                else
                {
                    session_start();
                    $_SESSION['userid'] = $DBuserid;
                    $_SESSION['username'] = $DBusername;
                    $_SESSION['permission'] = $DBuserlevel;

                    header('location: Home.php');
                }
            }
        }
    }
    elseif (isset($_POST['login']))
    {
        $feedback = 'Please enter your username and password';
    }
?>