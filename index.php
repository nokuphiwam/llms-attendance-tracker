<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS-Attendence Tracker</title>
    <link rel="icon" type="image/png" href="images/lms-logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function(){
            var calendar = $('#calendar').fullCalendar({
                editable:true,
                header:{
                    left:'prev,next today',
                    center:'title',
                    right:'month,agendaWeek,agendaDay'
                }, 
                events: 'load.php',
                selectable:true,     //allow highlight multiple days/class time slots
                selectHelper:true,
                select: function(start, end, allDay){
                    openAddClassForm();
                    
                },
                eventClick: function (event) {
                    window.location.href = "track-attendance.php?class_id="+event.id;
                }
            });
        });
        function openAddClassForm() {
        document.getElementById("add-class-form").style.display = "block";
        }

        function closeAddClassForm() {
        document.getElementById("add-class-form").style.display = "none";
        }
        function openViewFines() {
        document.getElementById("view-fines-table").style.display = "block";
        }

        function closeViewFines() {
        document.getElementById("view-fines-table").style.display = "none";
        }
    </script>
</head>
<body style="background-color: #DCDCDC"> 
    <div style="background-color: darkslategray; padding-left:300px;padding-left:300px;">
        <h1 style="color:white; "> <img src="images/lms-logo.png" alt="some keyword" style="width:60px; height:50px"/> LMS - Attendence Tracker</h1>
    </div>
    <?php include 'backend.php'; //Include backend file ?>
    <div id="content">
        <!--to add the calendar-->
        <button id="show-class-form" onclick="openAddClassForm()" style="margin-left:400px;background-color:#1A237E;color:white">Create new class</button><br><br>
        <div id="class-form" style="margin-left:400px;background-color:#B0BEC5">
            <form method="POST" action="backend.php" id="add-class-form" style="display:none">
            <table class="new-class-form">
                <thead>
                    <th></th><th></th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                        <label for="classname">Class Name: </label>
                        </td>
                        <td>
                        <input id="classname" name="classname" type="text" required>
                        </td><br>
                    </tr>
                    <tr>
                        <td>
                        <label for="classdescription">Class Description: </label>
                        </td>
                        <td>
                        <input id="classdescription" name="classdescription" type="text" style="height:120px">
                        </td><br>
                    </tr>
                    <tr>
                        <td>
                        <label for="startdate">Start date: </label>
                        </td>
                        <td>
                        <input id="startdate" name="startdate" type="date" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <label for="enddate">End Date: </label>
                        </td>
                        <td>
                        <input id="enddate" name="enddate" type="date" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <label for="starttime">Start Time: </label>
                        </td>
                        <td>
                        <input id="starttime" name="starttime" type="time" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <label for="endtime">End Time: </label>
                        </td>
                        <td>
                        <input id="endtime" name="endtime" type="time" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <input type="hidden" name="class_id">
                        <input type="submit" id="submit-form" name="add-class" value="Submit" style="background-color:#8C9EFF;color:white">
                        <input type="button" id="hide-class-form" onclick="closeAddClassForm()" value="Cancel" style="background-color:red;color:white">
                        </td>
                    </tr>
                </tbody>
            </table>  
            </form>
            </div>
            <div class="container" style="background-color:white">
                <div id = "calendar"></div>
            </div><br><br>
            <div id="wrapperDiv">
                <div>
                    <!--The Fines List-->
                    <table class="table table-bordered" style="background-color:#C5CAE9;width:50%">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name </th>
                                <th>Total Fines Amount</th>
                                <th>View Fines</th>
                            </tr>
                        </thead>
                        <tbody class="body">
                            <?php
                                $sql_fine = " SELECT * FROM fines WHERE amount <> 0";
                                foreach($conn->query($sql_fine) as $fines_row){ 
                                    $attendance = $fines_row['attendance_id'];
                                    $sql_attandance = "SELECT * FROM attendance_table WHERE attendance_id LIKE $attendance";
                                    foreach($conn->query($sql_attandance) as $attendance_row){
                                        $attendee_id = $attendance_row['attendee_id'];
                                        $sql_attendee = "SELECT * FROM class_attendees WHERE attendee_id LIKE $attendee_id";
                                        foreach($conn->query($sql_attendee) as $attendee_row){
                                    ?>
                                    <tr class = "table-row">
                                        <td id="lastname">
                                            <?php echo $attendee_row['last_name']; ?>
                                        </td>
                                        <td id="first_name">
                                            <?php echo $attendee_row["first_name"]; ?>
                                        </td>
                                        <td id="fine">
                                            <?php echo $fines_row['amount']; ?>
                                        </td>
                                        <td class="to-move" onclick="openAddClassForm()">
                                            <!-- view fines per attendee required class -->
                                            <a style = "background-color:white; color:red" href="?view-attendee-fines=<?php echo $attendee_id; ?>" >
                                                <input type="button" value="view">
                                            </a>
                                            &nbsp
                                        </td>
                                    </tr>
                            <?php 
                                        }
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    </div> 

                <div style="width:50%">
                <?php
                    //view fines per required class
                    if(isset($_GET["view-attendee-fines"])){ 
                        $attendee_id = $_GET['view-attendee-fines'];
                        //SELECT fines.amount, attendance_table.attendance_id FROM-- (SELECT class_name FROM classes WHERE class_id = (SELECT class_id FROM attendance_table WHERE attendance_id = 3))
                        $sql="SELECT amount,attendance_id, fine_date FROM fines WHERE amount > 0 AND attendance_id = (SELECT attendance_id FROM attendance_table WHERE attendee_id = $attendee_id)";
                        foreach($conn->query($sql) as $fines_row){
                            $attendance_id = $fines_row['attendance_id'];
                            $sql_class_id= "SELECT class_id FROM attendance_table WHERE class_id = (SELECT class_id FROM attendance_table WHERE attendance_id = $attendance_id)";
                            foreach($conn->query($sql_class_id) as $attendance){
                                $class_id = $attendance['class_id'];
                                $sql_classname = "SELECT class_name FROM classes WHERE class_id = $class_id";
                                foreach($conn->query($sql_classname) as $classname){?>
                                    <table class="table table-bordered" style="background-color:#C5CAE9">
                                    <thead>
                                        <tr>
                                            <th>
                                                Class Name
                                            </th>
                                            <th>
                                                Fine Amount
                                            </th>
                                            <th>
                                                Fine Date
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $classname['class_name']; ?></td>
                                            <td><?php echo $fines_row['amount']; ?></td>
                                            <td><?php echo $fines_row['fine_date']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <?php
                                    }
                            }
                        }
                        ?>
                <?php
                    }  
                ?>
                </div>
            
            </div>
        </div>
    </body>
</html>