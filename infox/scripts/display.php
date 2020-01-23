<?php
    include 'connection.php';

    //---------------------------------------------------------------------------(Delete ticket)
    if(isset($_GET['Tdelete']))
    {
        $DeleteNO = $_GET['Tdelete'];
        $displayDelete = "DELETE from " . $Tickettable . " where ticket_no = ?";
        $stmt = mysqli_prepare($DBConnect, $displayDelete);
        if(!$stmt)
        {
            echo "Error: " . mysqli_stmt_error($DBConnect) . ": " . mysqli_stmt_errno($DBConnect);
        } 
        else 
        {
            mysqli_stmt_bind_param($stmt, "i", $DeleteNO);
            $Queryresult = mysqli_stmt_execute($stmt);
            if(!$Queryresult)
            {
                echo "Error: " . mysqli_stmt_error($DBConnect) . ": " . mysqli_stmt_errno($DBConnect);
            } 
            else 
            {
                echo "<p class='goodfeedback'>Delete successful</p>";
                header ('location: Tickets.php?Tickets');
            }
            mysqli_stmt_close($stmt);
        }
    }
    //---------------------------------------------------------------------(Reservation delete)
    if(isset($_GET['Rdelete']))
    {
        $DeleteNO = $_GET['Rdelete'];
        $displayDelete = "DELETE from " . $Reservationtable . " where reservation_no = ?";
        $stmt = mysqli_prepare($DBConnect, $displayDelete);
        if(!$stmt)
        {
            echo "Error: " . mysqli_stmt_error($DBConnect) . ": " . mysqli_stmt_errno($DBConnect);
        } 
        else 
        {
            mysqli_stmt_bind_param($stmt, "i", $DeleteNO);
            $Queryresult = mysqli_stmt_execute($stmt);
            if(!$Queryresult)
            {
                echo "Error: " . mysqli_stmt_error($DBConnect) . ": " . mysqli_stmt_errno($DBConnect);
            } 
            else 
            {
                echo "<p class='goodfeedback'>Delete successful</p>";
                header ('location: Reservations.php?EditReservation');
            }
            mysqli_stmt_close($stmt);
        }
    }
    //---------------------------------------------------------------------(Order delete)
    if(isset($_GET['Odelete']))
    {
        $DeleteNO = $_GET['Odelete'];
        $displayDelete = "DELETE from " . $Orderstable . " where order_no = ?";
        $stmt = mysqli_prepare($DBConnect, $displayDelete);
        if(!$stmt)
        {
            echo "Error: " . mysqli_stmt_error($DBConnect) . ": " . mysqli_stmt_errno($DBConnect);
        } 
        else 
        {
            mysqli_stmt_bind_param($stmt, "i", $DeleteNO);
            $Queryresult = mysqli_stmt_execute($stmt);
            if(!$Queryresult)
            {
                echo "Error: " . mysqli_stmt_error($DBConnect) . ": " . mysqli_stmt_errno($DBConnect);
            } 
            else 
            {
                echo "<p class='goodfeedback'>Delete successful</p>";
                header ('location: Orders.php?CurrentOrders');
            }
            mysqli_stmt_close($stmt);
        }
    }
    //---------------------------------------------------------------------(Users delete)
    if(isset($_GET['Udelete']))
    {
        $DeleteNO = $_GET['Udelete'];
        $displayDelete = "DELETE from " . $Userstable . " where user_Id = ?";
        $stmt = mysqli_prepare($DBConnect, $displayDelete);
        if(!$stmt)
        {
            echo "Error: " . mysqli_stmt_error($stmt) . ": " . mysqli_stmt_errno($stmt);
        } 
        else 
        {
            mysqli_stmt_bind_param($stmt, "i", $DeleteNO);
            $Queryresult = mysqli_stmt_execute($stmt);
            if(!$Queryresult)
            {
                echo "Error: " . mysqli_stmt_error($stmt) . ": " . mysqli_stmt_errno($stmt);
            } 
            else 
            {
                header ('location: Users.php?Users');
                echo "<p class='goodfeedback'>Delete successful</p>";
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    //---------------------------------------------------------------------(Update Ticket)
    if (isset($_POST['ticketstatus']))
    {
        $TStatus = htmlentities($_POST['ticketstatus']);
        $Ticketno = htmlentities($_POST['ticketno']);

        $Query = 'UPDATE ' . $Tickettable . ' SET solved = ?  WHERE ticket_no = ?';

        if ($stmt = mysqli_prepare($DBConnect, $Query))
        {
            mysqli_stmt_bind_param($stmt, 'si', $TStatus, $Ticketno);
            $Queryresult = mysqli_stmt_execute($stmt);

            if (!$Queryresult)
            {
                echo 'Error: ' . mysqli_stmt_errno($stmt) . ': ' . mysqli_stmt_error($stmt);
            }
            else
            {
                $createticket = '<p class=\'goodfeedback\'>Ticket status updated</p>';
            }
        }
    } 

    //---------------------------------------------------------------------(Update Order)
    if (isset($_POST['orderstatus']))
    {
        $OStatus = htmlentities($_POST['orderstatus']);
        $Orderno = htmlentities($_POST['orderno']);
        
        $Query = 'UPDATE ' . $Orderstable . ' SET solved = ?  WHERE order_no = ?';

        if ($stmt = mysqli_prepare($DBConnect, $Query))
        {
            mysqli_stmt_bind_param($stmt, 'si', $OStatus, $Orderno);
            $Queryresult = mysqli_stmt_execute($stmt);

            if (!$Queryresult)
            {
                echo 'Error: ' . mysqli_stmt_errno($stmt) . ': ' . mysqli_stmt_error($stmt);
            }
            else
            {
                $createticket = '<p class=\'goodfeedback\'>Order status updated</p>';
            }
        }
    }
?>