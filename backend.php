<?php 
    include 'connect.php';
    
    $class_name = "";
    $class_description = "";
    $class_id = "";
    $update_row = "false";
    //add new class
    if(isset($_POST['add-class'])){
        try
            {
                $class_name = $_POST['classname'];
                $class_description = $_POST['classdescription'];
                $start_date = $_POST['startdate'];
                $end_date = $_POST["enddate"];
                $start_time = $_POST['starttime'];
                $end_time = $_POST['endtime'];
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //This will help to show errors when using PDO.
                $sql="INSERT INTO classes (class_name, class_description, start_date,end_date,start_time,end_time)
                VALUES ('$class_name', '$class_description','$start_date','$end_date','$start_time','$end_time') "; 
                //run sql query
                if($conn->query($sql)){
                    echo "Class created successfully!";
                    $class_id = $conn->lastInsertId();
                    header("Location: track-attendance.php?class_id={$class_id}");
                }else {
                    echo "Failed to create class!";
                }
                //end connection
                $conn = null;
           }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }

    }
    //add new class-attendee
    if(isset($_POST['add-class-attendee'])){
        //try insert attendee row
        try
            {
                $attendee_id = '';
                $class_id= $_POST['classid'];
                $first_name = $_POST['firstname'];
                $last_name = $_POST['lastname'];
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //This will help to show errors when using PDO.
                $sql="INSERT INTO class_attendees (first_name, last_name)
                VALUES ('$first_name', '$last_name') "; 
                //run sql query
                if($conn->query($sql)){
                    echo "Class attendee created successfully!";
                    $attendee_id = $conn->lastInsertId();
                    try{
                        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
                        $sql="INSERT INTO attendance_table (class_id, attendee_id,attendee_required,attended,communicated) VALUES ('$class_id', '$attendee_id',0,0,0) "; 
                        echo $sql;
                        if($conn->query($sql)){
                            echo "Attendance created successfully!";
                            $attendance_id = $conn->lastInsertId();
                            try{
                                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
                                $sql = "INSERT INTO fines (attendance_id, amount) VALUES ('$attendance_id',0)";
                                if($conn->query($sql)){
                                    echo "Fines created successfully!";
                                }else {
                                    echo "Failed to create fines!";
                                }
                            }catch(PDOException $e)
                            {
                                echo $e->getMessage();
                            }
                        }else {
                            echo "Failed to create attendance!";
                        }
                    }catch(PDOException $e)
                    {
                        echo $e->getMessage();
                    }      
                }else {
                    echo "Failed to create class!";
                }
           
                header("Location: track-attendance.php?class_id={$class_id}");
                $conn = null;
           }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }

    }
    //delete or cancel class
    else if( isset($_GET['delete-class']) )
    {
        if( isset( $_GET['delete-class'] ) && is_numeric( $_GET['delete-class'] ) && $_GET['delete-class'] > 0 )
        {
            $id = $_GET['delete-class'];
            $stmt = $conn->prepare( "DELETE FROM classes WHERE class_id ='$id'" );
            $stmt->bindValue('class_id', $id);
            $stmt->execute();
            if( ! $stmt->rowCount() ) echo "Failed to delete class, try again!";
        }
        else
        {
            echo "ID must be a positive integer";
        }
        //delete attendee list
        header('location: index.php');
        $conn = null;
    }
 
    //edit class
    if(isset($_POST["edit-class"])){ 
        $class_id = $_POST['classid'];
        $class_name = $_POST['classname'];
        $class_description = $_POST['classdescription'];
        $start_date = $_POST['startdate'];
        $end_date = $_POST['enddate'];
        $start_time = $_POST['starttime'];
        $end_time = $_POST['endtime'];  
        try{         
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE classes SET class_name = '$class_name', class_description = '$class_description', start_date = '$start_date', end_date = '$end_date', start_time = '$start_time', end_time = '$end_time' WHERE class_id = '$class_id'";
            echo $sql;
            if($conn->query($sql)){
                echo "Class updated successfully!";
            }else {
                echo "Failed to create class!";
            }
            header("Location: track-attendance.php?class_id={$class_id}");
            $conn = null;
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }     
    }
    
?>
