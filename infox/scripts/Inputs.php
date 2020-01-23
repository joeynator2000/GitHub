<?php
    include ('connection.php');

    session_start();

    if (isset($_SESSION['userid']))
    {
        $UserID = $_SESSION['userid'];
    }


    $stmterror = 'Error: ' . mysqli_stmt_errno($stmt) . ': ' . mysqli_stmt_error($stmt);
    //-------------------------------------------------------------------------------------------(User)
    $createuser = null;

    if (isset($_POST['NewSub']) && (!empty(trim(htmlentitieS($_POST['NewUser']))) && !empty(trim(htmlentities($_POST['NewPass']))) && !empty($_POST['NewLevel'])))
    {
        $NewUser = htmlentities($_POST['NewUser']);
        $NewPass = htmlentities($_POST['NewPass']);
        $NewLevel = htmlentities($_POST['NewLevel']);
        $NewHash = password_hash($NewPass, PASSWORD_DEFAULT);

        if ($NewLevel == 1)
        {
            die;
        }
        elseif ($NewLevel == 2)
        {
            $NewUser = $NewUser . '@stenden.com';
        }
        elseif ($NewLevel == 3)
        {
            $NewUser = $NewUser . '@nhlstenden.com';
        }
        else
        {
            $NewUser = $NewUser . '@student.nhlstenden.com';
        }

        $Query = 'SELECT * FROM ' . $Userstable . ' WHERE username = ?';

        if ($stmt = mysqli_prepare($DBConnect, $Query))
        {
            mysqli_stmt_bind_param($stmt, 's', $NewUser);
            $Queryresult = mysqli_stmt_execute($stmt);
            
            mysqli_stmt_store_result($stmt);
            
            if (!$Queryresult)
            {
                echo $stmterror;
            }            
            elseif (mysqli_stmt_num_rows($stmt) == 0)
            {
                mysqli_stmt_close($stmt);

                $Query = 'INSERT INTO ' . $Userstable . ' VALUES(NULL, ?, ?, ?)';

                if ($stmt = mysqli_prepare($DBConnect, $Query))
                {
                    mysqli_stmt_bind_param($stmt, 'ssi', $NewUser, $NewHash, $NewLevel);
                    $Queryresult = mysqli_stmt_execute($stmt);

                    if (!$Queryresult)
                    {
                        echo $stmterror;
                    }
                    else
                    {
                        $createuser = '<p class=\'goodfeedback\'>User successfully created</p>';
                        //mail($NewUser, 'New Account!', 'Congratulations you\'re account has been successfully created!');
                    }
                }
            }
            else
            {
                $createuser = '<p class=\'badfeedback\'>That user already exists</p>';
            }
        }
    }
    elseif (isset($_POST['NewSub']))
    {
        $createuser = '<p class=\'badfeedback\'>Please fill in all fields</p>';
    }

    //-------------------------------------------------------------------------------------------(Ticket)
    $createticket = null;

    if (isset($_POST['TSub']) && !empty(trim($_POST['TDesc'])) && isset($_POST['TCat']) && isset($_POST['TRoom']))
    {
        $TRoom = htmlentities($_POST['TRoom']);
        $TCat = htmlentitieS($_POST['TCat']);
        $TDesc = htmlentitieS($_POST['TDesc']);
        $TDate = date('Y-m-d');
        $TStatus = 'P';
        $TFile = 0;
        $Filepath = '../files/';

        
        if (!empty($_FILES['TFile']['name']))
        {
            if ($_FILES['TFile']['error'] > 0)
            {
                echo 'Error uploading img <br> Return code: ' . $_FILES['TFile']['error'];
            }
            else
            {
                $mimetype = mime_content_type($_FILES['TFile']['tmp_name']);

                if ($_FILES['TFile']['size'] > 3 * 1000 * 1000)
                {
                    $createticket = '<p class=\'badfeedback\'>Please choose a smaller file size (<3MB)</p>';
                }
                elseif ($_FILES['TFile']['type'] && !in_array($mimetype, array('image/jpeg', 'image/png')))
                {
                    $createticket = '<p class=\'badfeedback\'>We only accept JPEG or PNG files</p>';
                }
                else
                {
                    move_uploaded_file($_FILES['TFile']['tmp_name'], $Filepath . $_FILES['TFile']['name']);

                    $TFile = $Filepath . $_FILES['TFile']['name'];
                    
                    $Query = 'INSERT INTO ' . $Tickettable . ' VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)';

                    if ($stmt = mysqli_prepare($DBConnect, $Query))
                    {
                        mysqli_stmt_bind_param($stmt, 'idissss', $UserID, $TRoom, $TCat, $TDate, $TDesc, $TFile, $TStatus);
                        $Queryresult = mysqli_stmt_execute($stmt);

                        if (!$Queryresult)
                        {
                            echo $stmterror;
                        }
                        else
                        {
                            $createticket = '<p class=\'goodfeedback\'>Ticket successfully created</p>';
                            //add mail function;
                        }
                    }
                }
            }
        }
        else
        {
            $Query = 'INSERT INTO ' . $Tickettable . ' VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)';

            if ($stmt = mysqli_prepare($DBConnect, $Query))
            {
                mysqli_stmt_bind_param($stmt, 'idissss', $UserID, $TRoom, $TCat, $TDate, $TDesc, $TFile, $TStatus);
                $Queryresult = mysqli_stmt_execute($stmt);

                if (!$Queryresult)
                {
                    echo $stmterror;
                }
                else
                {
                    $createticket = '<p class=\'goodfeedback\'>Ticket successfully created</p>';
                    //add mail function;
                }
            }
        }
    }
    elseif (isset($_POST['TSub']))
    {
        $createticket = '<p class=\'badfeedback\'>Please fill in all fields</p>';
    }

    //-------------------------------------------------------------------------------------------(Order)
    $createorder = null;

    if (isset($_POST['OSub']) && (!empty(trim(htmlentities($_POST['OLink']))) && !empty(trim(htmlentities($_POST['OPurpose'])))  && !empty(trim(htmlentities($_POST['OItem'])))))
    {
        $OItem = htmlentities($_POST['OItem']);
        $OPurpose = htmlentitieS($_POST['OPurpose']);
        $OLink = htmlentitieS($_POST['OLink']);
        $TStatus = 'P';


        $Query = 'INSERT INTO ' . $Orderstable . ' VALUES(NULL, ?, ?, ?, ?, ?)';

        echo 1;
        if ($stmt = mysqli_prepare($DBConnect, $Query))
        {
            mysqli_stmt_bind_param($stmt, 'issss', $UserID, $OItem, $OPurpose, $OLink, $TStatus);
            $Queryresult = mysqli_stmt_execute($stmt);

            if (!$Queryresult)
            {
                echo $stmterror;
            }
            else
            {
                $createorder = '<p class=\'goodfeedback\'>Order successfully requested</p>';
            }
        }
    }
    elseif (isset($_POST['OSub']))
    {
        $createorder = '<p class=\'badfeedback\'>Please fill in all fields</p>';
    }

    //-------------------------------------------------------------------------------------------(Reservation)

    //----------------------------------------(Set the start, interval, and end times that can be selected)
    //Start and end times for $_POST['RStart']
    $start    = new DateTime('08:30:00');
    $end      = new DateTime('17:30:00');
    //Start and end times for $_POST['REnd']
    $start1    = new DateTime('09:15:00');
    $end1      = new DateTime('17:30:01');
    //Interval Amount (45 mins)
    $interval = new DateInterval('PT45M');
    //Set the times based on start interval and end times
    $period   = new DatePeriod($start, $interval, $end);
    $period1   = new DatePeriod($start1, $interval, $end1);
            
    //Limit the maximum reservation time per user based on user level
    if (isset($_SESSION['permission']))
    {
        switch($_SESSION['permission'])
        {
            case 1:
                $LevelLimit = 999;
            break;

            case 2:
                $LevelLimit = 3;
            break;

            case 3:
                $LevelLimit = 3;
            break;

            default:
                $LevelLimit = 1 . ' ' . 31;
            break;
        }
    }

    $createreservation = null;
    
    if (isset($_POST['RSub']) && !empty($_POST['RDate']) && !empty($_POST['REnd']) && !empty($_POST['RStart'])  && !empty($_POST['RRoom']))
    {
        $RRoom = htmlentities($_POST['RRoom']);
        $RDate = htmlentities($_POST['RDate']);

        
        if (isset($_POST['RStart']) && isset($_POST['REnd']))
        {
            $RStart = new DateTime($_POST['RStart']);
            $REnd = new DateTime ($_POST['REnd']);
            //Get the date difference between selected start and end times in an object
            $diff = date_diff($RStart, $REnd);
            //Change the selected start and end times from objects into arrays
            $diff = get_object_vars($diff);
            //Get the hour and minute differences between the selected start and end times
            $diff = htmlentities($diff['h']) . ' ' . htmlentities($diff['i']);
            
            $RStart = get_object_vars($RStart);
            $RStart = explode(' ', $RStart['date']);
            $RStart = substr($RStart[1], 0, 5);

            $REnd = get_object_vars($REnd);
            $REnd = explode(' ', $REnd['date']);
            $REnd = substr($REnd[1], 0, 5);
        }

        
        $Query = 'SELECT room_no, reservation_start, reservation_end, reservation_date FROM reservations WHERE room_no = ? AND reservation_date = ? AND reservation_start BETWEEN ? AND ? OR room_no = ? AND reservation_date = ? AND reservation_end BETWEEN ? AND ?';

        if ($stmt = mysqli_prepare($DBConnect, $Query))
        {
            mysqli_stmt_bind_param($stmt, 'ssssssss', $RRoom, $RDate, $RStart, $REnd, $RRoom, $RDate, $RStart, $REnd);
            $Queryresult = mysqli_stmt_execute($stmt);
            
            if (!$Queryresult)
            {
                echo $stmterror;
            }
            else
            {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) > 0)
                {
                    $createreservation = '<p class=\'badfeedback\'>That time slot is already taken please choose another one</p>';
                }
                else
                {
                    if ($diff < $LevelLimit)
                    {
                        mysqli_stmt_close($stmt);
                        $Query = 'INSERT INTO ' . $Reservationtable . ' VALUES(NULL, ?, ?, ?, ?, ?)';

                        if ($stmt = mysqli_prepare($DBConnect, $Query))
                        {
                            mysqli_stmt_bind_param($stmt, 'issss', $UserID, $RRoom, $RStart, $REnd, $RDate);
                            $Queryresult = mysqli_stmt_execute($stmt);

                            if (!$Queryresult)
                            {
                                echo $stmterror;
                            }
                            else
                            {
                                $createreservation = '<p class=\'goodfeedback\'>Reservation successful</p>';
                                //mail($_SESSION['username'], 'Your Reservation:', 'You have reserved the room '. $RRoom . ' For the time periods ' . $RStart . ' to ' . $REnd . ' //If received, please disregard this email as it was part of a php coding project');
                            }
                        }
                    }
                    elseif ($diff > $LevelLimit)
                    {
                        $createreservation = '<p class=\'badfeedback\'>You\'re maximum reservation time is ' . $LevelLimit . ' hours</p>';
                    }
                }
            }
        }
    }
    elseif (isset($_POST['RSub']))
    {
        $createreservation = '<p class=\'badfeedback\'>Please fill in all fields</p>';
    }
?>  