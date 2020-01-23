<?php
    include ('inputs.php');
    include ('display.php');


    if (empty($_SESSION['userid']))
    {
        header('location: login.php');
        die;
    }

    if (isset($_GET['logout']))
    {
        session_unset();
        session_destroy();
        header('location: Login.php');
    }

    //-------------------------------------------------------------------(Userlevel 1 || Admin)

    if (isset($_GET['AddTicket']))
    {
        $Currentpage = '<div class=\'currentpage\'>Tickets <i class=\'fa fa-ticket buttonimg\'></i></div>';

        $Level1display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                Submit a Ticket
            </div>
            <div id='inputbox'>
                <form id='formbox' action='' method='POST' enctype='multipart/form-data'>
                    <div class='newuserinput'>
                        <select name='TCat' class='Linput'>
                            <option value='' disabled selected>Category</option>
                            <option value='1'>Technical Malfunction</option>
                            <option value='2'>Sanitary Report</option>
                            <option value='3'>Course Error</option>
                        </select>
                    </div>
                    <div class='newuserinput'>
                        <select name='TRoom' class='Linput'>
                            <option value='' disabled selected>Room Number</option>
                            <option value='1.012'>1.012</option>
                            <option value='1.013'>1.013</option>
                            <option value='1.018'>1.018</option>
                            <option value='1.019'>1.019</option>
                            <option value='1.020'>1.020</option>
                            <option value='1.021'>1.021</option>
                            <option value='1.022'>1.022</option>
                        </select>
                    </div>
                    <div class='newuserinput'>
                        <input class='Linput' type='file' name='TFile' placeholder='Link'>
                    </div>
                    <div class='newuserinput'>
                        <textarea id='description' type='text' name='TDesc' placeholder='Description'></textarea>
                    </div>
                    <div class='newuserinput'>
                        <input id='loginbutton' class='Linput' type='Submit' name='TSub' value='Submit Ticket'>
                    </div>
                </form>
            </div>
            <div id='userfeedback'>
                $createticket
            </div>
        </div>";
    }
    elseif (isset($_GET['Tickets']))
    {
        $Currentpage = '<div class=\'currentpage\'>Tickets <i class=\'fa fa-ticket buttonimg\'></i></div>';
        
        $Level1display = 
            "<div id='bigtextbox'>
                <div id='usertitle'>
                    Tickets
                </div>
                <div id='displaybox'>";
                    $DisplayTik = "select tickets.ticket_no, tickets.user_id, tickets.room_no, ticket_categories.category_description, tickets.submission_date, tickets.description, tickets.solved, users.username, file_path FROM tickets JOIN users ON users.user_id=tickets.user_id JOIN ticket_categories on tickets.category_no = ticket_categories.category_no";
 
                    if ($stmt = mysqli_prepare($DBConnect, $DisplayTik))
                    {
                        $Queryresult = mysqli_stmt_execute($stmt);

                        if(!$Queryresult)
                        {
                            echo "Error: " . mysqli_errno($DBConnect) . ": " . mysqli_stmt_error($stmt);
                        } 
                        else 
                        {

                            mysqli_stmt_bind_result($stmt, $ticket_noDB, $user_idDB, $room_noDB, $categoryDB, $submission_dateDB, $descriptionDB, $solvedDB, $username , $filepath);
                            mysqli_stmt_store_result($stmt);

                  $Level1display .= "<table>
                                    <tr><th>Ticket No.</th>
                                    <th>User</th><th>Room</th>
                                    <th>Category</th>
                                    <th>Sub. Date</th>
                                    <th>Desc</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Delete</th></tr>";

                            while(mysqli_stmt_fetch($stmt))
                                {
                                    switch ($solvedDB) 
                                    {
                                        case 'Y': 
                                            $ticketStatus = 'Complete';
                                            $OtherStatus = 'Unsolved';
                                            $OtherSolved = 'N';
                                        break;

                                        case 'N': 
                                            $ticketStatus = 'Unsolved';
                                            $OtherStatus = 'Complete';
                                            $OtherSolved = 'Y';
                                        break; 

                                        default: 
                                            $ticketStatus = 'Pending';
                                            $OtherStatus = 'Complete';
                                            $OtherSolved = 'Y';
                                            $OtherStatus1 = 'Unsolved';
                                            $OtherSolved1 = 'N';
                                        break;
                                    }
                  $Level1display .= "<tr><td>$ticket_noDB</td>
                                    <td>$username</td>
                                    <td>$room_noDB</td>
                                    <td>$categoryDB</td>
                                    <td>$submission_dateDB</td>
                                    <td>$descriptionDB</td>";
                                    if (!empty($filepath))
                                    {
                  $Level1display .= "<td class='tddelete'><a href='$filepath' target='_blank' rel='noopener norefferer'>View Image</a></td>";
                                    }
                                    else
                                    {
                  $Level1display .= "<td class='tddelete'>No Image</td>";
                                    }
                  $Level1display .= "<td class='tddelete'>
                                    <form action='' method='POST'>
                                        <select class='inputoption' name='ticketstatus' onchange='this.form.submit()'>
                                            <option value='$solvedDB'>$ticketStatus</option>
                                            <option value='$OtherSolved'>$OtherStatus</option>";
                     if (isset($OtherStatus1))
                     {
                         $Level1display .= "<option value='$OtherSolved1'>$OtherStatus1</option>";
                     }

                     $Level1display .= "</select>
                                        <input type='text' name='ticketno' value='$ticket_noDB' hidden>
                                    </form>
                                    </td>
                                    <td class='tddelete'><a onclick='echo 123;' href='?Tdelete=$ticket_noDB'>Delete</a></td></tr>";
                                }
                            echo "</table>";
                            mysqli_stmt_close($stmt);    
                        }
                    }
        $Level1display .= "</div>
                <div id='userfeedback'>
                    $createticket
                </div>
            </div>";
    }

    //-------------------------------------------------------------------(Userlevel 2 || Employee)
    if (isset($_GET['AddTicket']))
    {
        $Currentpage = '<div class=\'currentpage\'>Tickets <i class=\'fa fa-ticket buttonimg\'></i></div>';

        $Level2display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                Submit a Ticket
            </div>
            <div id='inputbox'>
                <form id='formbox' action='' method='POST' enctype='multipart/form-data'>
                    <div class='newuserinput'>
                        <select name='TCat' class='Linput'>
                            <option value='' disabled selected>Category</option>
                            <option value='1'>Technical Malfunction</option>
                            <option value='2'>Sanitary Report</option>
                            <option value='3'>Course Error</option>
                        </select>
                    </div>
                    <div class='newuserinput'>
                        <select name='TRoom' class='Linput'>
                            <option value='' disabled selected>Room Number</option>
                            <option value='1.012'>1.012</option>
                            <option value='1.013'>1.013</option>
                            <option value='1.018'>1.018</option>
                            <option value='1.019'>1.019</option>
                            <option value='1.020'>1.020</option>
                            <option value='1.021'>1.021</option>
                            <option value='1.022'>1.022</option>
                        </select>
                    </div>
                    <div class='newuserinput'>
                        <input class='Linput' type='file' name='TFile' placeholder='Link'>
                    </div>
                    <div class='newuserinput'>
                        <textarea id='description' type='text' name='TDesc' placeholder='Description'></textarea>
                    </div>
                    <div class='newuserinput'>
                        <input id='loginbutton' class='Linput' type='Submit' name='TSub' value='Submit Ticket'>
                    </div>
                </form>
            </div>
            <div id='userfeedback'>
                $createticket
            </div>
        </div>";
    }
    elseif (isset($_GET['Tickets']))
    {
        $Currentpage = '<div class=\'currentpage\'>Tickets <i class=\'fa fa-ticket buttonimg\'></i></div>';
        
        $Level2display = 
            "<div id='bigtextbox'>
                <div id='usertitle'>
                    Tickets
                </div>
                <div id='displaybox'>";
                    $DisplayTik = "select tickets.ticket_no, tickets.user_id, tickets.room_no, ticket_categories.category_description, tickets.submission_date, tickets.description, tickets.solved, users.username, file_path FROM tickets JOIN users ON users.user_id=tickets.user_id JOIN ticket_categories on tickets.category_no = ticket_categories.category_no";
 
                    if ($stmt = mysqli_prepare($DBConnect, $DisplayTik))
                    {
                        $Queryresult = mysqli_stmt_execute($stmt);

                        if(!$Queryresult)
                        {
                            echo "Error: " . mysqli_errno($DBConnect) . ": " . mysqli_stmt_error($stmt);
                        } 
                        else 
                        {

                            mysqli_stmt_bind_result($stmt, $ticket_noDB, $user_idDB, $room_noDB, $categoryDB, $submission_dateDB, $descriptionDB, $solvedDB, $username , $filepath);
                            mysqli_stmt_store_result($stmt);

                  $Level2display .= "<table>
                                    <tr><th>Ticket No.</th>
                                    <th>User</th><th>Room</th>
                                    <th>Category</th>
                                    <th>Sub. Date</th>
                                    <th>Desc</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Delete</th></tr>";

                            while(mysqli_stmt_fetch($stmt))
                                {
                                    switch ($solvedDB) 
                                    {
                                        case 'Y': 
                                            $ticketStatus = 'Complete';
                                            $OtherStatus = 'Unsolved';
                                            $OtherSolved = 'N';
                                        break;

                                        case 'N': 
                                            $ticketStatus = 'Unsolved';
                                            $OtherStatus = 'Complete';
                                            $OtherSolved = 'Y';
                                        break; 

                                        default: 
                                            $ticketStatus = 'Pending';
                                            $OtherStatus = 'Complete';
                                            $OtherSolved = 'Y';
                                            $OtherStatus1 = 'Unsolved';
                                            $OtherSolved1 = 'N';
                                        break;
                                    }
                  $Level2display .= "<tr><td>$ticket_noDB</td>
                                    <td>$username</td>
                                    <td>$room_noDB</td>
                                    <td>$categoryDB</td>
                                    <td>$submission_dateDB</td>
                                    <td>$descriptionDB</td>";
                                    if (!empty($filepath))
                                    {
                  $Level2display .= "<td class='tddelete'><a href='$filepath' target='_blank' rel='noopener norefferer'>View Image</a></td>";
                                    }
                                    else
                                    {
                  $Level2display .= "<td class='tddelete'>No Image</td>";
                                    }
                  $Level2display .= "<td class='tddelete'>
                                    <form action='' method='POST'>
                                        <select class='inputoption' name='ticketstatus' onchange='this.form.submit()'>
                                            <option value='$solvedDB'>$ticketStatus</option>
                                            <option value='$OtherSolved'>$OtherStatus</option>";
                     if (isset($OtherStatus1))
                     {
                         $Level2display .= "<option value='$OtherSolved1'>$OtherStatus1</option>";
                     }

                     $Level2display .= "</select>
                                        <input type='text' name='ticketno' value='$ticket_noDB' hidden>
                                    </form>
                                    </td>
                                    <td class='tddelete'><a onclick='echo 123;' href='?Tdelete=$ticket_noDB'>Delete</a></td></tr>";
                                }
                            echo "</table>";
                            mysqli_stmt_close($stmt);    
                        }
                    }
        $Level2display .= "</div>
                <div id='userfeedback'>
                    $createticket
                </div>
            </div>";
    }
        
    //-------------------------------------------------------------------(Userlevel 3 || Teacher)
    if (isset($_GET['AddTicket']))
    {
        $Currentpage = '<div class=\'currentpage\'>Tickets <i class=\'fa fa-ticket buttonimg\'></i></div>';

        $Level3display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                Submit a Ticket
            </div>
            <div id='inputbox'>
                <form id='formbox' action='' method='POST' enctype='multipart/form-data'>
                    <div class='newuserinput'>
                        <select name='TCat' class='Linput'>
                            <option value='' disabled selected>Category</option>
                            <option value='1'>Technical Malfunction</option>
                            <option value='2'>Sanitary Report</option>
                            <option value='3'>Course Error</option>
                        </select>
                    </div>
                    <div class='newuserinput'>
                        <select name='TRoom' class='Linput'>
                            <option value='' disabled selected>Room Number</option>
                            <option value='1.012'>1.012</option>
                            <option value='1.013'>1.013</option>
                            <option value='1.018'>1.018</option>
                            <option value='1.019'>1.019</option>
                            <option value='1.020'>1.020</option>
                            <option value='1.021'>1.021</option>
                            <option value='1.022'>1.022</option>
                        </select>
                    </div>
                    <div class='newuserinput'>
                        <input class='Linput' type='file' name='TFile' placeholder='Link'>
                    </div>
                    <div class='newuserinput'>
                        <textarea id='description' type='text' name='TDesc' placeholder='Description'></textarea>
                    </div>
                    <div class='newuserinput'>
                        <input id='loginbutton' class='Linput' type='Submit' name='TSub' value='Submit Ticket'>
                    </div>
                </form>
            </div>
            <div id='userfeedback'>
                $createticket
            </div>
        </div>";
    }
    //-------------------------------------------------------------------(Userlevel 4 || Student)
    if (isset($_GET['AddTicket']))
    {
        $Currentpage = '<div class=\'currentpage\'>Tickets <i class=\'fa fa-ticket buttonimg\'></i></div>';

        $Level4display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                Submit a Ticket
            </div>
            <div id='inputbox'>
                <form id='formbox' action='' method='POST' enctype='multipart/form-data'>
                    <div class='newuserinput'>
                        <select name='TCat' class='Linput'>
                            <option value='' disabled selected>Category</option>
                            <option value='1'>Technical Malfunction</option>
                            <option value='2'>Sanitary Report</option>
                            <option value='3'>Course Error</option>
                        </select>
                    </div>
                    <div class='newuserinput'>
                        <select name='TRoom' class='Linput'>
                            <option value='' disabled selected>Room Number</option>
                            <option value='1.012'>1.012</option>
                            <option value='1.013'>1.013</option>
                            <option value='1.018'>1.018</option>
                            <option value='1.019'>1.019</option>
                            <option value='1.020'>1.020</option>
                            <option value='1.021'>1.021</option>
                            <option value='1.022'>1.022</option>
                        </select>
                    </div>
                    <div class='newuserinput'>
                        <input class='Linput' type='file' name='TFile' placeholder='Link'>
                    </div>
                    <div class='newuserinput'>
                        <textarea id='description' type='text' name='TDesc' placeholder='Description'></textarea>
                    </div>
                    <div class='newuserinput'>
                        <input id='loginbutton' class='Linput' type='Submit' name='TSub' value='Submit Ticket'>
                    </div>
                </form>
            </div>
            <div id='userfeedback'>
                $createticket
            </div>
        </div>";
    }
?>