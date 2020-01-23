<!DOCTYPE html>

<html>
    <head>
        <title>Login to Stenden Support Desk</title>
        <meta charset='UTF-8';>
        <link rel='stylesheet' type='text/css' href='../styles/styles.css'>
    </head>
    <body>
        <?php
            include('../scripts/Loginscripts.php');
        ?>
        <div id='bodybox'>
            <div id='loginbox'>
                <div id='inputs'>
                    <form action='' method='POST'>
                        <input class='Linput' type='text' name='Lusername' placeholder='E-mail'>
                        <input class='Linput' type='password' name='Lpassword' placeholder='Password'>
                        <input id='loginbutton' class='Linput' type='submit' name='login' value='Login'>
                    </form>
                </div>
                <div id='feedback'>
                    <?php
                        if (!empty($feedback))
                        {
                            echo $feedback;
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>