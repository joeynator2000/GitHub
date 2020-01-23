<?php
    include ('inputs.php');

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
    $Level1display = 
        "<div class='box'>
            <div class='details'>
                <a href='?Reservations'>
                    <div class='content'>
                        <i class='fas fa-door-open buttonimg'></i>
                        <h2>Reservations</h2>
                        <div class='buttontext'>Manage Reservations</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='?Orders'>
                    <div class='content'>
                        <i class='fa fa-calendar buttonimg'></i>
                        <h2>Orders</h2>
                        <div class='buttontext'>Manage orders</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='?Tickets'>
                    <div class='content'>
                        <i class='fas fa-ticket-alt buttonimg'></i>
                        <h2>Tickets</h2>
                        <div class='buttontext'>Manage Tickets</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='?Users'>
                    <div class='content'>
                        <i class='fas fa-users-cog buttonimg'></i>
                        <h2>Users</h2>
                        <div class='buttontext'>Manage Users</div>
                    </div>
                </a>
            </div>
        </div>";
        


        if (isset($_GET['Users']))
        {
            $Currentpage = '<div class=\'currentpage\'>Users <i class=\'fas fa-users-cog buttonimg\'></i></div>';
            $Level1display = 
                "<div class='box'>
                    <div class='details'>
                        <a href='Users.php?NewUser'>
                            <div class='content'>
                                <i class='fas fa-user-plus buttonimg'></i>
                                <h2>New User</h2>
                                <div class='buttontext'>Add a user</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class='box'>
                    <div class='details'>
                        <a href='Users.php?Users'>
                            <div class='content'>
                                <i class='fas fa-user-cog buttonimg'></i>
                                <h2>Current Users</h2>
                                <div class='buttontext'>See / Delete Current Users</div>
                            </div>
                        </a>
                    </div>
                </div>";
        }
        elseif (isset($_GET['Reservations']))
        {
            $Currentpage = '<div class=\'currentpage\'>Rooms <i class=\'fas fa-door-open buttonimg\'></i></div>';
            $Level1display = 
                "<div class='box'>
                    <div class='details'>
                        <a href='Reservations.php?AddReservation'>
                            <div class='content'>
                                <i class='fas fa-door-open buttonimg'></i>
                                <h2>New Reservation</h2>
                                <div class='buttontext'>Add a reservation</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class='box'>
                    <div class='details'>
                        <a href='Reservations.php?EditReservation'>
                            <div class='content'>
                                <i class='fas fa-door-closed buttonimg'></i>
                                <h2>Current Reservations</h2>
                                <div class='buttontext'>Edit reservation</div>
                            </div>
                        </a>
                    </div>
                </div>";
        }
        elseif (isset($_GET['Tickets']))
        {
            $Currentpage = '<div class=\'currentpage\'>Tickets <i class=\'fas fa-ticket-alt buttonimg\'></i></div>';
            $Level1display = 
                "<div class='box'>
                    <div class='details'>
                        <a href='Tickets.php?AddTicket'>
                            <div class='content'>
                                <i class='fa fa-ticket buttonimg'></i>
                                <h2>New Ticket</h2>
                                <div class='buttontext'>Add a ticket</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class='box'>
                    <div class='details'>
                        <a href='Tickets.php?Tickets'>
                            <div class='content'>
                                <i class='fas fa-ticket-alt buttonimg'></i>
                                <h2>Current Tickets</h2>
                                <div class='buttontext'>See current tickets</div>
                            </div>
                        </a>
                    </div>
                </div>";
        }
        elseif (isset($_GET['Orders']))
        {
            $Currentpage = '<div class=\'currentpage\'>Orders <i class=\'fas fa-calendar-alt buttonimg\'></i></div>';
            $Level1display = 
                "<div class='box'>
                    <div class='details'>
                        <a href='Orders.php?NewOrder'>
                            <div class='content'>
                                <i class='fas fa-calendar-plus buttonimg'></i>
                                <h2>New Order</h2>
                                <div class='buttontext'>Add a reservation</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class='box'>
                    <div class='details'>
                        <a href='Orders.php?CurrentOrders'>
                            <div class='content'>
                                <i class='fas fa-list-ul buttonimg'></i>
                                <h2>Current Orders</h2>
                                <div class='buttontext'>Edit reservation</div>
                            </div>
                        </a>
                    </div>
                </div>";
        }
    //-------------------------------------------------------------------(Userlevel 2 || Employee)
    $Level2display = 
        "<div class='box'>
            <div class='details'>
                <a href='?Tickets'>
                    <div class='content'>
                        <i class='fas fa-ticket-alt buttonimg'></i>
                        <h2>Tickets</h2>
                        <div class='buttontext'>Manage Tickets</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='?Orders'>
                    <div class='content'>
                        <i class='fa fa-calendar buttonimg'></i>
                        <h2>Orders</h2>
                        <div class='buttontext'>Manage orders</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='?Reservations'>
                    <div class='content'>
                        <i class='fas fa-door-open buttonimg'></i>
                        <h2>Reservations</h2>
                        <div class='buttontext'>Manage Reservations</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='mailto:steffen.tourbier@student.nhlstenden.com'>
                    <div class='content'>
                        <i class='fa fa-exclamation buttonimg'></i>
                        <h2>Complaints</h2>
                        <div class='buttontext'>Send a complaint</div>
                    </div>
                </a>
            </div>
        </div>";
        if (isset($_GET['Tickets']))
        {
            $Currentpage = '<div class=\'currentpage\'>Tickets <i class=\'fas fa-ticket-alt buttonimg\'></i></div>';
            $Level2display = 
                "<div class='box'>
                    <div class='details'>
                        <a href='Tickets.php?AddTicket'>
                            <div class='content'>
                                <i class='fa fa-ticket buttonimg'></i>
                                <h2>New Ticket</h2>
                                <div class='buttontext'>Add a ticket</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class='box'>
                    <div class='details'>
                        <a href='Tickets.php?Tickets'>
                            <div class='content'>
                                <i class='fas fa-ticket-alt buttonimg'></i>
                                <h2>Current Tickets</h2>
                                <div class='buttontext'>See current tickets</div>
                            </div>
                        </a>
                    </div>
                </div>";
        }
        elseif (isset($_GET['Reservations']))
        {
            $Currentpage = '<div class=\'currentpage\'>Rooms <i class=\'fas fa-door-open buttonimg\'></i></div>';
            $Level2display = 
                "<div class='box'>
                    <div class='details'>
                        <a href='Reservations.php?AddReservation'>
                            <div class='content'>
                                <i class='fas fa-door-open buttonimg'></i>
                                <h2>New Reservation</h2>
                                <div class='buttontext'>Add a reservation</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class='box'>
                    <div class='details'>
                        <a href='Reservations.php?EditReservation'>
                            <div class='content'>
                                <i class='fas fa-door-closed buttonimg'></i>
                                <h2>Current Reservations</h2>
                                <div class='buttontext'>Edit reservation</div>
                            </div>
                        </a>
                    </div>
                </div>";
        }
        elseif (isset($_GET['Orders']))
        {
            $Currentpage = '<div class=\'currentpage\'>Orders <i class=\'fas fa-calendar-alt buttonimg\'></i></div>';
            $Level2display = 
                "<div class='box'>
                    <div class='details'>
                        <a href='Orders.php?NewOrder'>
                            <div class='content'>
                                <i class='fas fa-calendar-plus buttonimg'></i>
                                <h2>New Order</h2>
                                <div class='buttontext'>Add a reservation</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class='box'>
                    <div class='details'>
                        <a href='Orders.php?CurrentOrders'>
                            <div class='content'>
                                <i class='fas fa-list-ul buttonimg'></i>
                                <h2>Current Orders</h2>
                                <div class='buttontext'>Edit reservation</div>
                            </div>
                        </a>
                    </div>
                </div>";
        }
    //-------------------------------------------------------------------(Userlevel 3 || Teacher)
    $Level3display = 
        "<div class='box'>
            <div class='details'>
                <a href='?Support'>
                    <div class='content'>
                        <i class='fa fa-headphones buttonimg'></i>
                        <h2>Support desk</h2>
                        <div class='buttontext'>Get Assistance</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='Home.php?Reservations'>
                    <div class='content'>
                        <i class='fas fa-door-open buttonimg'></i>
                        <h2>Rooms</h2>
                        <div class='buttontext'>Reserve a room</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='Orders.php?Orders'>
                    <div class='content'>
                        <i class='fa fa-calendar buttonimg'></i>
                        <h2>Order system</h2>
                        <div class='buttontext'>Submit an order</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='Hrm.php?HRM'>
                    <div class='content'>
                        <i class='fa fa-comments buttonimg'></i>
                        <h2>HRM</h2>
                        <div class='buttontext'>Hotel and Restaurant Management</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='mailto:steffen.tourbier@student.nhlstenden.com'>
                    <div class='content'>
                        <i class='fa fa-exclamation buttonimg'></i>
                        <h2>Complaints</h2>
                        <div class='buttontext'>Send a complaint</div>
                    </div>
                </a>
            </div>
        </div>";

        if (isset($_GET['Support']))
        {
            $Level3display = 
                "<div class='box'>
                    <div class='details'>
                        <a href='Tickets.php?AddTicket'>
                            <div class='content'>
                                <i class=' 	fa fa-ticket buttonimg'></i>
                                <h2>Report a Problem</h2>
                                <div class='buttontext'>Submit a ticket</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class='box'>
                    <div class='details'>
                        <a href='tel:+31629338600'>
                            <div class='content'>
                                <i class='fas fa-phone buttonimg'></i>
                                <h2>Urgent Call</h2>
                                <div class='buttontext'>Call +31629338600</div>
                            </div>
                        </a>
                    </div>
                </div>";
        }
        elseif (isset($_GET['HRM']))
        {
            $Level3display = 
            "<div id='bigtextbox'>
                <div id='usertitle'>
                    HRM
                </div>
                <div id='content-box'>
                    <p>
                        HRM improves its services to you.
                        InfoX gives a high priority to
                        the sustainable employability and the
                        satisfaction of its employees. This is
                        why we are constantly looking for ways
                        to improve this. In the section below
                        we lay out are our various communication
                        channels.
                    </p>
                    <p>
                        1. There is an InfoX main page where more useful information can be found.
                    </p>
                    <p>
                        2. It is possible to ask a question through the email below on this page.
                    </p>
                    <p>
                        3.  There are 6 HRM advisors, that is the Groupß
                        members and that support various branches within
                        the organisation, to whom you can pose individual
                        questions.
                    </p>
                    
                    <p>
                        Digital portal
                        The digital portal within the InfoX is also used by
                        the University of Applied Sciences. HRM also uses
                        this, but in a protected environment.
                        Questions can be posed to HRM through this digital portal.
                        An automatic reply is then sent with a report number, to
                        ascertain that the request has been received.
                    </p>
                    <p>
                        To contact us, please email the follow address:
                    </p>
                    <p>
                        <a class='email' href='mailto:hrm@nhlstenden.com'> 
                            hrm@nhlstenden.com
                        </a>
                    </p>
                    <p>
                        We have considered the content of such questions or requests
                        may be privacy sensitive so all questions that are posed to
                        HRM will only be visible to InfoX staff.
                    </p>
                </div>
            </div>";
        }
        elseif (isset($_GET['Reservations']))
        {
            $Currentpage = '<div class=\'currentpage\'>Rooms <i class=\'fas fa-door-open buttonimg\'></i></div>';
            $Level3display = 
                "<div class='box'>
                    <div class='details'>
                        <a href='Reservations.php?AddReservation'>
                            <div class='content'>
                                <i class='fas fa-door-open buttonimg'></i>
                                <h2>New Reservation</h2>
                                <div class='buttontext'>Add a reservation</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class='box'>
                    <div class='details'>
                        <a href='Reservations.php?EditReservation'>
                            <div class='content'>
                                <i class='fas fa-door-closed buttonimg'></i>
                                <h2>Current Reservations</h2>
                                <div class='buttontext'>See Reservations</div>
                            </div>
                        </a>
                    </div>
                </div>";
        }
    //-------------------------------------------------------------------(Userlevel 4 || Student)
    $Level4display = 
        "<div class='box'>
            <div class='details'>
                <a href='?Support'>
                    <div class='content'>
                        <i class='fa fa-headphones buttonimg'></i>
                        <h2>Support desk</h2>
                        <div class='buttontext'>Get Assistance</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='Hrm.php?HRM'>
                    <div class='content'>
                        <i class='fa fa-comments buttonimg'></i>
                        <h2>HRM</h2>
                        <div class='buttontext'>Hotel and Restaurant Management</div>
                    </div>
                </a>
            </div>
        </div>
        <div class='box'>
            <div class='details'>
                <a href='mailto:steffen.tourbier@student.nhlstenden.com'>
                    <div class='content'>
                        <i class='fa fa-exclamation buttonimg'></i>
                        <h2>Complaints</h2>
                        <div class='buttontext'>Send a complaint</div>
                    </div>
                </a>
            </div>
        </div>";
        
        if (isset($_GET['Support']))
        {
            $Level4display = 
                "<div class='box'>
                    <div class='details'>
                        <a href='Tickets.php?AddTicket'>
                            <div class='content'>
                                <i class=' 	fa fa-ticket buttonimg'></i>
                                <h2>Report a Problem</h2>
                                <div class='buttontext'>Submit a ticket</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class='box'>
                    <div class='details'>
                        <a href='tel:+31629338600'>
                            <div class='content'>
                                <i class='fas fa-phone buttonimg'></i>
                                <h2>Urgent Call</h2>
                                <div class='buttontext'>Call +31629338600</div>
                            </div>
                        </a>
                    </div>
                </div>";
        }
        elseif (isset($_GET['HRM']))
        {
            $Level4display = 
            "<div id='bigtextbox'>
                <div id='usertitle'>
                    HRM
                </div>
                <div id='content-box'>
                    <p>
                        HRM improves its services to you.
                        InfoX gives a high priority to
                        the sustainable employability and the
                        satisfaction of its employees. This is
                        why we are constantly looking for ways
                        to improve this. In the section below
                        we lay out are our various communication
                        channels.
                    </p>
                    <p>
                        1. There is an InfoX main page where more useful information can be found.
                    </p>
                    <p>
                        2. It is possible to ask a question through the email below on this page.
                    </p>
                    <p>
                        3.  There are 6 HRM advisors, that is the Groupß
                        members and that support various branches within
                        the organisation, to whom you can pose individual
                        questions.
                    </p>
                    
                    <p>
                        Digital portal
                        The digital portal within the InfoX is also used by
                        the University of Applied Sciences. HRM also uses
                        this, but in a protected environment.
                        Questions can be posed to HRM through this digital portal.
                        An automatic reply is then sent with a report number, to
                        ascertain that the request has been received.
                    </p>
                    <p>
                        To contact us, please email the follow address:
                    </p>
                    <p>
                        <a class='email' href='mailto:hrm@nhlstenden.com'> 
                            hrm@nhlstenden.com
                        </a>
                    </p>
                    <p>
                        We have considered the content of such questions or requests
                        may be privacy sensitive so all questions that are posed to
                        HRM will only be visible to InfoX staff.
                    </p>
                </div>
            </div>";
        }
?>