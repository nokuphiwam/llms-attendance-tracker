<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS-Attendence Tracker</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script>
        function changeAttendanceOption(ch,attendance_id,fine_id){
            var selected = ch.value;
            var required;
            var communicated;
            var attended;
            var postData =[
                {"fine_id": fine_id, "attendance_id":attendance_id,"selected":selected}
            ]
            $.ajax({
                url:"edit-attendance-fine.php",
                type:"POST",
                data:{
                    "postData":postData
                },
                success: function(res){
                    window.location.reload();
                }

            });
        }
        function openAttendeeForm() {
        document.getElementById("attendee-form").style.display = "block";
        }
        function closeAttendeeForm() {
        document.getElementById("attendee-form").style.display = "none";
        }
    </script>
</head>

<body style="background-color: #DCDCDC">
    <div style="background-color: darkslategray; padding-left:300px;padding-left:300px;">
        <h1 style="color:white; "> <img src="images/lms-logo.png" alt="some keyword" style="width:60px; height:50px"/> LMS - Attendence Tracker</h1>
    </div>
    <a href="index.php"><h4><--Back to Calender</h4></a><br>
    <!-- FORM WITH CLASS INFORMATION -->
    <div id="edit-class-form" style="border-width:2px;background-color:#B0BEC5;width:25%;margin-left:50px">
        <?php
            $class_id = $_GET['class_id'];
            $i=1;
            //get class row id
            include 'connect.php';
            $sql = " SELECT * FROM classes WHERE class_id LIKE $class_id";
            foreach($conn->query($sql) as $row){
        ?>
                <form method="POST" action="backend.php">
                    <h3>Class Details</h3>
                    <?php
                        $date = new DateTime();
                        //echo $date->format("Y");
                    ?>
                    <table class="edit-class">
                        <thead>
                            <th></th><th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                <label for="classname">Class Name: </label>
                                </td>
                                <td>
                                <input id="classname" name="classname" type="text" value="<?php echo $row['class_name']?>" required>
                                </td><br>
                            </tr>
                            <tr>
                                <td>
                                <label for="classdescription">Class Description: </label>
                                </td>
                                <td>
                                <input id="classdescription" name="classdescription" value="<?php echo $row['class_description']?>" type="text" style="height:120px">
                                </td><br>
                            </tr>
                            <tr>
                                <td>
                                <label for="startdate">Start date: </label>
                                </td>
                                <td>
                                <input id="startdate" name="startdate" value="<?php echo $row['start_date']?>" type="date" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <label for="enddate">End Date: </label>
                                </td>
                                <td>
                                <input id="enddate" name="enddate" value="<?php echo $row['end_date']?>" type="date" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <label for="starttime">Start Time: </label>
                                </td>
                                <td>
                                <input id="starttime" name="starttime" value="<?php echo $row['start_time']?>" type="time" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <label for="endtime">End Time: </label>
                                </td>
                                <td>
                                <input id="endtime" name="endtime" value="<?php echo $row['end_time']?>" type="time" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <input type="hidden" name="classid" value="<?php echo $row['class_id'] ?>">
                                </td>
                                <td>
                                <input type="submit" id="submit-form" name="edit-class" value="Update Details">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
        <?php
            $i++;
            }
        ?>
    </div>
    <!-- END FORM -->

    <div id="content" >
        <h2 style="background-color:#C5CAE9;width:70%;margin-bottom:0px">Attendance Tracker List</h2>

        <!--The Attendance Tracker Register-->
        <table class="table table-bordered" style="background-color:#C5CAE9;width:70%;align-content:center;margin-top:0px">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name </th>
                    <th>Attendance</th>
                    <th>Fine Amount</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <form action="backend.php" method="POST">
            <tbody class="body">
                <?php
                    $i = 1;
                    $sql = " SELECT * FROM class_attendees ORDER BY last_name ASC";
                    foreach($conn->query($sql) as $attendee_row){
                        $attendee_id = $attendee_row['attendee_id'];
                        $sql_attendee = "SELECT * FROM attendance_table WHERE attendee_id LIKE '$attendee_id' AND class_id LIKE '$class_id'";
                        foreach($conn->query($sql_attendee) as $attendance_row){
                            $attendance_id = $attendance_row['attendance_id'];
                            $sql_fine = "SELECT * FROM fines WHERE attendance_id LIKE '$attendance_id'";
                            foreach($conn->query($sql_fine) as $fine_row){
                                $default_value='null';
                                $attended = $attendance_row['attended'];
                                $required = $attendance_row['attendee_required'];
                                $communicated = $attendance_row['communicated'];
                                if($attended == 1){
                                    $default_value = "Attended";
                                }
                                elseif($communicated == 1){
                                    $default_value = "Communicated";
                                }
                                elseif($required == 1){
                                    $default_value = "Required";
                                }
                        ?>
                        <tr class = "table-row">
                            <td id="lastname">
                                <?php echo $attendee_row["last_name"]; ?>
                            </td>
                            <td id="first_name">
                                <?php echo $attendee_row["first_name"]; ?>
                            </td>
                            <td>
                                <select name="attendance-options" id="attendance-options" onchange="changeAttendanceOption(this,<?php echo $attendance_row['attendance_id']; ?>,<?php echo $fine_row['fine_id']; ?>)">
                                    <option value="" selected disabled hidden><?php echo $default_value?></option>
                                    <option value="null"> </option>
                                    <option value="required">Required</option>
                                    <option value="attended">Attended</option>
                                    <option value="communicated">
                                        <a href="?attendance_id=<?php echo $row['class_id']; ?>?selected=communicated">Communicated</a>
                                    </option>
                                </select>
                            </td>
                            <td id="fine">
                                <?php echo $fine_row['amount'];
                                ?>
                            </td>
                            <td class="to-move">
                                <!-- delete icon -->
                                <a class="delete-attendee" style = "background-color:white; color: red" href="?delete-class=<?php echo $row['class_id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </a>
                                &nbsp
                            </td>
                        </tr>
                <?php
                        }
                        $i++;  }}
                ?>
            </tbody>
        </table>
        <!-- <a href="?finish-attandance-tracker=<?php echo $row['class_id']; ?>">
            <input type="submit" id="finish-attandance-tracker" name="finish-attandance-tracker" value="Finish Tracking Attendance">
        </a> -->
        </form>
        <button class="open-attendee-form" onclick="openAttendeeForm()" style="background-color:#1A237E;color:white;">Add Attendees</button>
        <br><br>

        <!-- Attendee Form -->
        <div id="attendee-form" style="display:none">
            <form action="backend.php" method="POST" class="attendee-form-container">
                <label for="firstname"><b>First Name</b></label>
                <input type="text" placeholder="Enter First Name" name="firstname" required><br><br>
                <label for="lastname"><b>Last Name</b></label>
                <input type="lastname" placeholder="Enter Last Name" name="lastname" required><br><br>
                <input type="hidden" name="classid" value="<?php echo $class_id ?>">
                <input type="submit" name="add-class-attendee" value="Submit" style="background-color:#8C9EFF;color:white">
                <input type="button" name="btn cancel" onclick="closeAttendeeForm()" style="background-color:red;color:white" value="Cancel">
            </form>
        </div>
    </div>
</body>
</html>