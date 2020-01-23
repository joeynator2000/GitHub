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


    if (isset($_GET))
    {
        $Currentpage = '<div class=\'currentpage\'>Reservations  <i class=\'fas fa-door-open buttonimg\'></i></div>';
    } 
    //-------------------------------------------------------------------(Userlevel 1 || Admin)
    if (isset($_GET['AddReservation']))
    {
        $Level1display = 
            "<div id='bigtextbox'>
                <div id='usertitle'>
                    New Reservation
                </div>
                <div id='inputbox'>
                    <form id='formbox' action='' method='POST'>
                        <div class='newuserinput'>
                            <select name='RRoom' class='Linput' placeholder='User Level'>
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
                            <select name='RStart' class='Linput' placeholder='User Level'>
                                <option value='' selected>Start Time</option>";
                                foreach ($period as $dt) 
                                {
            $Level1display .= "<option value=" . $dt->format('H:i') . ">" . $dt->format('H:i') . "</option>";
                                }
        $Level1display .= "</select>
                        </div>
                        <div class='newuserinput'>
                            <select name='REnd' class='Linput' placeholder='User Level'>
                                <option value='' selected>End Time</option>";
                                foreach ($period1 as $dt) 
                                {
            $Level1display .= "<option value=" . $dt->format('H:i') . ">" . $dt->format('H:i') . "</option>";
                                }
        $Level1display .= "</select>
                        </div>
                        <div class='newuserinput'>
                            <input class='Linput' type='date' name='RDate' placeholder='Date'>
                        </div>
                        <div class='newuserinput'>
                            <input id='loginbutton' class='Linput' type='Submit' name='RSub' value='Reserve Room'>
                        </div>
                    </form>
                </div>
                <div id='userfeedback'>
                    $createreservation
                </div>
            </div>";
    }
    else
    {
        $Level1display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                Reservation List
            </div>
            <div id='displaybox'>";
                $DisplayRes = "SELECT reservation_no, reservations.user_id, room_no, reservation_start, reservation_end, reservation_date, users.username FROM reservations JOIN users ON users.user_id=reservations.user_id ORDER BY reservation_date DESC";
                
                if (!$stmt = mysqli_prepare($DBConnect, $DisplayRes))
                {
                    echo "Error: " . mysqli_errno($DBConnect) . ": " . mysqli_stmt_error($stmt);
                } 
                else 
                {
                    $Queryresult = mysqli_stmt_execute($stmt);
                    
                    if(!$Queryresult)
                    {
                        echo "Error: " . mysqli_errno($DBConnect) . ": " . mysqli_stmt_error($stmt);
                    } 
                    else 
                    {
                        mysqli_stmt_bind_result($stmt, $reservation_noDB, $RUser_idDB, $RRoom_noDB, $RStartDB, $REndDB, $RDateDB, $RUsernameDB);
                        mysqli_stmt_store_result($stmt);

           $Level1display .= "<table>
                              <tr><th>Reservation No.</th>
                              <th>User</th><th>Room</th>
                              <th>Start time</th>
                              <th>End time</th>
                              <th>Date</th>
                              <th>Delete</th></tr>";
                        while(mysqli_stmt_fetch($stmt))
                        {
           $Level1display .= "<tr><td>$reservation_noDB</td>
                              <td>$RUsernameDB</td>
                              <td>$RRoom_noDB</td>
                              <td>$RStartDB</td>
                              <td>$REndDB</td>
                              <td>$RDateDB</td>
                              <td class='tddelete'><a href='?Rdelete=$reservation_noDB'>Delete</a></td></tr>";
                        }
                        echo "</table>";
                        mysqli_stmt_close($stmt);           
                    }
                }
        $Level1display .= "</div>
        </div>";
    }

    //-------------------------------------------------------------------(Userlevel 2 || Employee)
    if (isset($_GET['AddReservation']))
    {
        $Level2display = 
            "<div id='bigtextbox'>
                <div id='usertitle'>
                    New Reservation
                </div>
                <div id='inputbox'>
                    <form id='formbox' action='' method='POST'>
                        <div class='newuserinput'>
                            <select name='RRoom' class='Linput' placeholder='User Level'>
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
                            <select name='RStart' class='Linput' placeholder='User Level'>
                                <option value='' selected>Start Time</option>";
                                foreach ($period as $dt) 
                                {
            $Level2display .= "<option value=" . $dt->format('H:i') . ">" . $dt->format('H:i') . "</option>";
                                }
        $Level2display .= "</select>
                        </div>
                        <div class='newuserinput'>
                            <select name='REnd' class='Linput' placeholder='User Level'>
                                <option value='' selected>End Time</option>";
                                foreach ($period1 as $dt) 
                                {
            $Level2display .= "<option value=" . $dt->format('H:i') . ">" . $dt->format('H:i') . "</option>";
                                }
        $Level2display .= "</select>
                        </div>
                        <div class='newuserinput'>
                            <input class='Linput' type='date' name='RDate' placeholder='Date'>
                        </div>
                        <div class='newuserinput'>
                            <input id='loginbutton' class='Linput' type='Submit' name='RSub' value='Reserve Room'>
                        </div>
                    </form>
                </div>
                <div id='userfeedback'>
                    $createreservation
                </div>
            </div>";
    }
    else
    {
        $Level2display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                Reservation List
            </div>
            <div id='displaybox'>";
                $DisplayRes = "SELECT reservation_no, reservations.user_id, room_no, reservation_start, reservation_end, reservation_date, users.username FROM reservations JOIN users ON users.user_id=reservations.user_id ORDER BY reservation_date DESC";
                
                if (!$stmt = mysqli_prepare($DBConnect, $DisplayRes))
                {
                    echo "Error: " . mysqli_errno($DBConnect) . ": " . mysqli_stmt_error($stmt);
                } 
                else 
                {
                    $Queryresult = mysqli_stmt_execute($stmt);
                    
                    if(!$Queryresult)
                    {
                        echo "Error: " . mysqli_errno($DBConnect) . ": " . mysqli_stmt_error($stmt);
                    } 
                    else 
                    {
                        mysqli_stmt_bind_result($stmt, $reservation_noDB, $RUser_idDB, $RRoom_noDB, $RStartDB, $REndDB, $RDateDB, $RUsernameDB);
                        mysqli_stmt_store_result($stmt);

           $Level2display .= "<table>
                              <tr><th>Reservation No.</th>
                              <th>User</th><th>Room</th>
                              <th>Start time</th>
                              <th>End time</th>
                              <th>Date</th>
                              <th>Delete</th></tr>";
                        while(mysqli_stmt_fetch($stmt))
                        {
           $Level2display .= "<tr><td>$reservation_noDB</td>
                              <td>$RUsernameDB</td>
                              <td>$RRoom_noDB</td>
                              <td>$RStartDB</td>
                              <td>$REndDB</td>
                              <td>$RDateDB</td>
                              <td class='tddelete'><a href='?Rdelete=$reservation_noDB'>Delete</a></td></tr>";
                        }
                        echo "</table>";
                        mysqli_stmt_close($stmt);           
                    }
                }
        $Level2display .= "</div>
        </div>";
    }
            
    //-------------------------------------------------------------------(Userlevel 3 || Teacher)
    if (isset($_GET['AddReservation']))
    {
        $Level3display = 
            "<div id='bigtextbox'>
                <div id='usertitle'>
                    New Reservation
                </div>
                <div id='inputbox'>
                    <form id='formbox' action='' method='POST'>
                        <div class='newuserinput'>
                            <select name='RRoom' class='Linput' placeholder='User Level'>
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
                            <select name='RStart' class='Linput' placeholder='User Level'>
                                <option value='' selected>Start Time</option>";
                                foreach ($period as $dt) 
                                {
            $Level3display .= "<option value=" . $dt->format('H:i') . ">" . $dt->format('H:i') . "</option>";
                                }
        $Level3display .= "</select>
                        </div>
                        <div class='newuserinput'>
                            <select name='REnd' class='Linput' placeholder='User Level'>
                                <option value='' selected>End Time</option>";
                                foreach ($period1 as $dt) 
                                {
            $Level3display .= "<option value=" . $dt->format('H:i') . ">" . $dt->format('H:i') . "</option>";
                                }
        $Level3display .= "</select>
                        </div>
                        <div class='newuserinput'>
                            <input class='Linput' type='date' name='RDate' placeholder='Date'>
                        </div>
                        <div class='newuserinput'>
                            <input id='loginbutton' class='Linput' type='Submit' name='RSub' value='Reserve Room'>
                        </div>
                    </form>
                </div>
                <div id='userfeedback'>
                    $createreservation
                </div>
            </div>";
    }
    else
    {
        $Level3display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                Reservation List
            </div>
            <div id='displaybox'>";
                $DisplayRes = "SELECT reservation_no, reservations.user_id, room_no, reservation_start, reservation_end, reservation_date, users.username FROM reservations JOIN users ON users.user_id=reservations.user_id ORDER BY reservation_date DESC";
                
                if (!$stmt = mysqli_prepare($DBConnect, $DisplayRes))
                {
                    echo "Error: " . mysqli_errno($DBConnect) . ": " . mysqli_stmt_error($stmt);
                } 
                else 
                {
                    $Queryresult = mysqli_stmt_execute($stmt);
                    
                    if(!$Queryresult)
                    {
                        echo "Error: " . mysqli_errno($DBConnect) . ": " . mysqli_stmt_error($stmt);
                    } 
                    else 
                    {
                        mysqli_stmt_bind_result($stmt, $reservation_noDB, $RUser_idDB, $RRoom_noDB, $RStartDB, $REndDB, $RDateDB, $RUsernameDB);
                        mysqli_stmt_store_result($stmt);

           $Level3display .= "<table>
                              <tr><th>Reservation No.</th>
                              <th>User</th><th>Room</th>
                              <th>Start time</th>
                              <th>End time</th>
                              <th>Date</th>";
                        while(mysqli_stmt_fetch($stmt))
                        {
           $Level3display .= "<tr><td>$reservation_noDB</td>
                              <td>$RUsernameDB</td>
                              <td>$RRoom_noDB</td>
                              <td>$RStartDB</td>
                              <td>$REndDB</td>
                              <td>$RDateDB</td>";
                        }
                        echo "</table>";
                        mysqli_stmt_close($stmt);           
                    }
                }
        $Level3display .= "</div>
        </div>";
    }
?>