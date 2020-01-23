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

    $Currentpage = '<div class=\'currentpage\'>Orders <i class=\'fa fa-calendar buttonimg\'></i></div>';
        
    //-------------------------------------------------------------------(Userlevel 1 || Admin)
    if (isset($_GET['NewOrder']))
    {
        $Level1display = 
            "<div id='bigtextbox'>
                <div id='usertitle'>
                    Orders
                </div>
                <div id='inputbox'>
                    <form id='formbox' action='' method='POST'>
                        <div class='newuserinput'>
                            <input class='Linput' type='text' name='OItem' placeholder='Item'>
                        </div>
                        <div class='newuserinput'>
                            <input class='Linput' type='text' name='OPurpose' placeholder='Purpose'>
                        </div>
                        <div class='newuserinput'>
                            <input class='Linput' type='text' name='OLink' placeholder='Link'>
                        </div>
                        <div class='newuserinput'>
                            <input id='loginbutton' class='Linput' type='Submit' name='OSub' value='Request Order'>
                        </div>
                    </form>
                </div>
                <div id='userfeedback'>
                    $createorder
                </div>
            </div>";
    }
    else
    {
        $Level1display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                Order List
            </div>
            <div id='displaybox'>";
                $DisplayOrder = "select orders.order_no, orders.user_id, orders.item, orders.purpose, orders.link, orders.solved, users.username from orders JOIN users ON users.user_id=orders.user_id";
                
                if (!$stmt = mysqli_prepare($DBConnect, $DisplayOrder))
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
                        mysqli_stmt_bind_result($stmt, $order_noDB, $user_idDB, $itemDB, $purposeDB, $linkDB, $statusDB, $username);
                        mysqli_stmt_store_result($stmt);

           $Level1display .= "<table>
                              <tr><th>Order No.</th>
                              <th>User</th>
                              <th>Item</th>
                              <th>Purpose</th>
                              <th>Link</th>
                              <th>Status</th>
                              <th>Delete</th></tr>";
                        while(mysqli_stmt_fetch($stmt))
                        {
                            switch ($statusDB) 
                            {
                                case 'Y': 
                                    $OrderStatus = 'Approved';
                                    $Ordersolved = 'Y';
                                    $OtherStatus = 'Denied';
                                    $Ordersolved1 = 'N';
                                    $OtherStatus1 = 'Under Review';
                                    $Ordersolved2 = 'P';
                                break;

                                case 'N': 
                                    $OrderStatus = 'Denied';
                                    $Ordersolved = 'N';
                                    $OtherStatus = 'Approved';
                                    $Ordersolved1 = 'Y';
                                    $OtherStatus1 = 'Under Review';
                                    $Ordersolved2 = 'P';
                                break; 

                                default: 
                                    $OrderStatus = 'Under Review';
                                    $Ordersolved = 'P';
                                    $OtherStatus = 'Approved';
                                    $Ordersolved1 = 'Y';
                                    $OtherStatus1 = 'Denied';
                                    $Ordersolved2 = 'N';
                                break;
                            }

           $Level1display .= "<tr><td>$order_noDB</td>
                              <td>$username</td>
                              <td>$itemDB</td>
                              <td>$purposeDB</td>
                              <td class='tddelete'><a href='$linkDB'>Link</a></td>
                              <td>
                                <form action='' method='POST'>
                                    <select class='inputoption' name='orderstatus' onchange='this.form.submit()'>
                                        <option value='$Ordersolved'>$OrderStatus</option>
                                        <option value='$Ordersolved1'>$OtherStatus</option>";
                    if (isset($OtherStatus1))
                    {
                        $Level1display .= "<option value='$Ordersolved2'>$OtherStatus1</option>";
                    }

                    $Level1display .= "</select>
                                    <input type='text' name='orderno' value='$order_noDB' hidden>
                                </form>
                              </td>
                              <td class='tddelete'><a href='?Odelete=$order_noDB'>Delete</a></td></tr>";
                        }
                        echo "</table>";
                        mysqli_stmt_close($stmt);           
                    }
                }
        $Level1display .= "</div>
        </div>";
    }

    //-------------------------------------------------------------------(Userlevel 2 || Employee)
    if (isset($_GET['NewOrder']))
    {
        $Level2display = 
            "<div id='bigtextbox'>
                <div id='usertitle'>
                    Orders
                </div>
                <div id='inputbox'>
                    <form id='formbox' action='' method='POST'>
                        <div class='newuserinput'>
                            <input class='Linput' type='text' name='OItem' placeholder='Item'>
                        </div>
                        <div class='newuserinput'>
                            <input class='Linput' type='text' name='OPurpose' placeholder='Purpose'>
                        </div>
                        <div class='newuserinput'>
                            <input class='Linput' type='text' name='OLink' placeholder='Link'>
                        </div>
                        <div class='newuserinput'>
                            <input id='loginbutton' class='Linput' type='Submit' name='OSub' value='Request Order'>
                        </div>
                    </form>
                </div>
                <div id='userfeedback'>
                    $createorder
                </div>
            </div>";
    }
    else
    {
        $Level2display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                Order List
            </div>
            <div id='displaybox'>";
                $DisplayOrder = "select orders.order_no, orders.user_id, orders.item, orders.purpose, orders.link, orders.solved, users.username from orders JOIN users ON users.user_id=orders.user_id";
                
                if (!$stmt = mysqli_prepare($DBConnect, $DisplayOrder))
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
                        mysqli_stmt_bind_result($stmt, $order_noDB, $user_idDB, $itemDB, $purposeDB, $linkDB, $statusDB, $username);
                        mysqli_stmt_store_result($stmt);

           $Level2display .= "<table>
                              <tr><th>Order No.</th>
                              <th>User</th>
                              <th>Item</th>
                              <th>Purpose</th>
                              <th>Link</th>
                              <th>Status</th>
                              <th>Delete</th></tr>";
                        while(mysqli_stmt_fetch($stmt))
                        {
                            switch ($statusDB) 
                            {
                                case 'Y': 
                                    $OrderStatus = 'Approved';
                                    $Ordersolved = 'Y';
                                    $OtherStatus = 'Denied';
                                    $Ordersolved1 = 'N';
                                    $OtherStatus1 = 'Under Review';
                                    $Ordersolved2 = 'P';
                                break;

                                case 'N': 
                                    $OrderStatus = 'Denied';
                                    $Ordersolved = 'N';
                                    $OtherStatus = 'Approved';
                                    $Ordersolved1 = 'Y';
                                    $OtherStatus1 = 'Under Review';
                                    $Ordersolved2 = 'P';
                                break; 

                                default: 
                                    $OrderStatus = 'Under Review';
                                    $Ordersolved = 'P';
                                    $OtherStatus = 'Approved';
                                    $Ordersolved1 = 'Y';
                                    $OtherStatus1 = 'Denied';
                                    $Ordersolved2 = 'N';
                                break;
                            }

           $Level2display .= "<tr><td>$order_noDB</td>
                              <td>$username</td>
                              <td>$itemDB</td>
                              <td>$purposeDB</td>
                              <td class='tablelink'><a href='$linkDB'>Link</a></td>
                              <td>
                                <form action='' method='POST'>
                                    <select class='inputoption' name='orderstatus' onchange='this.form.submit()'>
                                        <option value='$Ordersolved'>$OrderStatus</option>
                                        <option value='$Ordersolved1'>$OtherStatus</option>";
                    if (isset($OtherStatus1))
                    {
                        $Level2display .= "<option value='$Ordersolved2'>$OtherStatus1</option>";
                    }

                    $Level2display .= "</select>
                                    <input type='text' name='orderno' value='$order_noDB' hidden>
                                </form>
                              </td>
                              <td class='tddelete'><a href='?Odelete=$order_noDB'>Delete</a></td></tr>";
                        }
                        echo "</table>";
                        mysqli_stmt_close($stmt);           
                    }
                }
        $Level2display .= "</div>
        </div>";
    }

    //-------------------------------------------------------------------(Userlevel 3 || Teacher)

    $Level3display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                Orders
            </div>
            <div id='inputbox'>
                <form id='formbox' action='' method='POST'>
                    <div class='newuserinput'>
                        <input class='Linput' type='text' name='OItem' placeholder='Item'>
                    </div>
                    <div class='newuserinput'>
                        <input class='Linput' type='text' name='OPurpose' placeholder='Purpose'>
                    </div>
                    <div class='newuserinput'>
                        <input class='Linput' type='text' name='OLink' placeholder='Link'>
                    </div>
                    <div class='newuserinput'>
                        <input id='loginbutton' class='Linput' type='Submit' name='OSub' value='Request Order'>
                    </div>
                </form>
            </div>
            <div id='userfeedback'>
                $createorder
            </div>
        </div>";
    
?>