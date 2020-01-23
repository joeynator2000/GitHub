<?php
    $DBConnect = mysqli_connect('localhost', 'root', '');

    $DBName = 'infox';

    header('Cache-Control: max-age=999');

    if (!mysqli_select_db($DBConnect, $DBName))
    {
        $CreateDB = 'CREATE DATABASE ' . $DBName;

        if ($stmt = mysqli_prepare($DBConnect, $CreateDB))
        {
            $Queryresult = mysqli_stmt_execute($stmt);

            if (!$Queryresult)
            {
                $feedback = 'Error: ' . mysqli_errno($DBConnect) . ': ' . mysqli_error($DBConnect);
            }
            else
            {
                $feedback = 'Database created';
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_select_db($DBConnect, $DBName);

    //-------------------------------------------------------------------------------(Create Users Table)
    $Userstable = 'users';
    $Checktable = 'SHOW TABLES LIKE \'' . $Userstable . '\' ';
    
    if ($stmt = mysqli_prepare($DBConnect, $Checktable))
    {
        $Queryresult = mysqli_stmt_execute($stmt);

        if (!$Queryresult)
        {
            echo 'Error: ' . mysqli_errno($DBConnect) . ': ' . mysqli_error($DBConnect);
        }
        else
        {
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) == 0)
            {
                mysqli_stmt_close($stmt);

                $CreateTable = 'CREATE TABLE `' . $Userstable . 
                '`(
                    user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    username VARCHAR(255),
                    password VARCHAR(255),
                    userlevel INT NOT NULL
                )';

                if ($stmt = mysqli_prepare($DBConnect, $CreateTable))
                {
                    $Queryresult = mysqli_stmt_execute($stmt);

                    if (!$Queryresult)
                    {
                        echo 'Error: ' . mysqli_error($DBConnect) . ': ' . mysqli_error($DBConnect);
                    }
                    else
                    {
                        $feedback = $Userstable . ' table created';
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }

    //-------------------------------------------------------------------------------(Create Reservations Table)
    $Reservationtable = 'reservations';
    $Checktable1 = 'SHOW TABLES LIKE \'' . $Reservationtable . '\' ';
    
    if ($stmt = mysqli_prepare($DBConnect, $Checktable1))
    {
        $Queryresult = mysqli_stmt_execute($stmt);

        if (!$Queryresult)
        {
            echo 'Error: ' . mysqli_errno($DBConnect) . ': ' . mysqli_error($DBConnect);
        }
        else
        {
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) == 0)
            {
                mysqli_stmt_close($stmt);

                $CreateTable = 'CREATE TABLE `' . $Reservationtable . 
                '`(
                    reservation_no INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    user_id INT,
                    room_no DOUBLE,
                    reservation_start VARCHAR(255),
                    reservation_end VARCHAR(255),
                    reservation_date DATE,
                    INDEX (user_Id),
                    INDEX (room_no),
                    FOREIGN KEY (user_id) REFERENCES users (user_id)
                )';

                if ($stmt = mysqli_prepare($DBConnect, $CreateTable))
                {
                    $Queryresult = mysqli_stmt_execute($stmt);

                    if (!$Queryresult)
                    {
                        echo 'Error: ' . mysqli_error($DBConnect) . ': ' . mysqli_error($DBConnect);
                    }
                    else
                    {
                        $feedback = $Reservationtable . ' table created';
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }

    //-------------------------------------------------------------------------------(Create Tickets Table)
    $Tickettable = 'tickets';
    $Checktable2 = 'SHOW TABLES LIKE \'' . $Tickettable . '\' ';
    
    if ($stmt = mysqli_prepare($DBConnect, $Checktable2))
    {
        $Queryresult = mysqli_stmt_execute($stmt);

        if (!$Queryresult)
        {
            echo 'Error: ' . mysqli_errno($DBConnect) . ': ' . mysqli_error($DBConnect);
        }
        else
        {
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) == 0)
            {
                mysqli_stmt_close($stmt);

                $CreateTable = 'CREATE TABLE `' . $Tickettable . 
                '`(
                    ticket_no INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    user_id INT,
                    room_no DOUBLE,
                    category_no INT,
                    submission_date DATE,
                    description VARCHAR(255),
                    file_path VARCHAR(255),
                    solved ENUM("Y", "N", "P"),
                    FOREIGN KEY (user_id) REFERENCES users (user_id)
                )';

                if ($stmt = mysqli_prepare($DBConnect, $CreateTable))
                {
                    $Queryresult = mysqli_stmt_execute($stmt);

                    if (!$Queryresult)
                    {
                        echo 'Error: ' . mysqli_error($DBConnect) . ': ' . mysqli_error($DBConnect);
                    }
                    else
                    {
                        $feedback = $Tickettable . ' table created';
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }

    //-------------------------------------------------------------------------------(Create Ticket Categories Table)
    $Categorytable = 'ticket_categories';
    $Checktable3 = 'SHOW TABLES LIKE \'' . $Categorytable . '\' ';
    
    if ($stmt = mysqli_prepare($DBConnect, $Checktable3))
    {
        $Queryresult = mysqli_stmt_execute($stmt);

        if (!$Queryresult)
        {
            echo 'Error: ' . mysqli_errno($DBConnect) . ': ' . mysqli_error($DBConnect);
        }
        else
        {
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) == 0)
            {
                mysqli_stmt_close($stmt);

                $CreateTable = 'CREATE TABLE `' . $Categorytable . 
                '`(
                    category_no INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    category_name VARCHAR(255),
                    category_description VARCHAR(255)
                )';

                if ($stmt = mysqli_prepare($DBConnect, $CreateTable))
                {
                    $Queryresult = mysqli_stmt_execute($stmt);

                    if (!$Queryresult)
                    {
                        echo 'Error: ' . mysqli_error($DBConnect) . ': ' . mysqli_error($DBConnect);
                    }
                    else
                    {
                        $feedback = $Categorytable . ' table created';
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }

    //-------------------------------------------------------------------------------(Create Orders Table)
    $Orderstable = 'Orders';
    $Checktable5 = 'SHOW TABLES LIKE \'' . $Orderstable . '\' ';
    
    if ($stmt = mysqli_prepare($DBConnect, $Checktable5))
    {
        $Queryresult = mysqli_stmt_execute($stmt);

        if (!$Queryresult)
        {
            echo 'Error: ' . mysqli_errno($DBConnect) . ': ' . mysqli_error($DBConnect);
        }
        else
        {
            mysqli_stmt_store_result($stmt);
            
            if (mysqli_stmt_num_rows($stmt) == 0)
            {
                mysqli_stmt_close($stmt);

                $CreateTable = 'CREATE TABLE `' . $Orderstable . 
                '`(
                    order_no INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    user_id INT,
                    item VARCHAR(255),
                    purpose VARCHAR(255),
                    link VARCHAR(255),
                    solved ENUM("Y", "N", "P"),
                    FOREIGN KEY (user_id) REFERENCES users (user_id)
                )';

                if ($stmt = mysqli_prepare($DBConnect, $CreateTable))
                {
                    $Queryresult = mysqli_stmt_execute($stmt);

                    if (!$Queryresult)
                    {
                        echo 'Error: ' . mysqli_error($DBConnect) . ': ' . mysqli_error($DBConnect);
                    }
                    else
                    {
                        $feedback = $Orderstable . ' table created';
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        }
    }
?>