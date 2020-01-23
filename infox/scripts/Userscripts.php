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
    if (isset($_GET['NewUser']))
    {
        $Level1display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                New User
            </div>
            <div id='inputbox'>
                <form id='formbox' action='?NewUser' method='POST'>
                    <div class='newuserinput'>
                        <input class='Linput' type='text' name='NewUser' placeholder='Username'>
                    </div>
                    <div class='newuserinput'>
                        <input class='Linput' type='password' name='NewPass' placeholder='Password'>
                    </div>
                    <div class='newuserinput'>
                        <select name='NewLevel' class='Linput'>
                            <option value='' disabled selected>User Type</option>
                            <option value='2'>Employee</option>
                            <option value='3'>Teacher</option>
                            <option value='4'>Student</option>
                        </select>
                    </div>
                    <div class='newuserinput'>
                        <input id='loginbutton' class='Linput' type='Submit' name='NewSub' value='Create User'>
                    </div>
                </form>
            </div>
            <div id='userfeedback'>
                $createuser
            </div>
        </div>";
    }else
    {
        $Level1display = 
        "<div id='bigtextbox'>
            <div id='usertitle'>
                User List
            </div>
            <div id='displaybox'>";
                $DisplayUser = "select user_id, username, userlevel from " . $Userstable;
                
                if (!$stmt = mysqli_prepare($DBConnect, $DisplayUser))
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
                        mysqli_stmt_bind_result($stmt, $user_idDB, $username, $userlevel);
                        mysqli_stmt_store_result($stmt);

           $Level1display .= "<table>
                              <tr><th>User ID</th>
                              <th>Username</th>
                              <th>User Level</th>
                              <th>Delete</th>";
                        while(mysqli_stmt_fetch($stmt))
                        {
           $Level1display .= "<tr><td>$user_idDB</td>
                              <td>$username</td>
                              <td>$userlevel</td>
                              <td class='tddelete'><a href='?Udelete=$user_idDB'>Delete</a></td></tr>";
                        }
                        echo "</table>";
                        mysqli_stmt_close($stmt);           
                    }
                }
        $Level1display .= "</div>
        </div>";
    }


    //-------------------------------------------------------------------(Userlevel 2 || Employee)
    $Level2display = null;
        
    //-------------------------------------------------------------------(Userlevel 3 || Teacher)
    $Level3display = null;
        
    //-------------------------------------------------------------------(Userlevel 4 || Student)
    $Level4display = null;
       
?>

<script>
    $("a").click(function(){
    $("table").each(function() {
        var $this = $(this);
        var newrows = [];
        $this.find("tr").each(function(){
            var i = 0;
            $(this).find("td").each(function(){
                i++;
                if(newrows[i] === undefined) { newrows[i] = $("<tr></tr>"); }
                newrows[i].append($(this));
            });
        });
        $this.find("tr").remove();
        $.each(newrows, function(){
            $this.append(this);
        });
    });

    return false;
    });
</script>