<?php
    include 'connect.php';

    if(isset($_POST['postData'])) {
        try{
            $postData = $_POST["postData"];
            $fine_id = $postData[0]['fine_id'];
            $attendance_id = $postData[0]['attendance_id'];
            $selected = $postData[0]['selected'];

            switch($selected) {
                case "attended":
                    $sql_fine = "UPDATE fines SET amount=0 WHERE fine_id='$fine_id'";
                    $sql_attendance = "UPDATE attendance_table SET attendee_required = 0, attended = 1, communicated = 0 WHERE attendance_id=$attendance_id";
                    // $sql = "UPDATE fines, attendance_table SET fines.amount = 0 WHERE fine_id='$fine_id' AND SET
                    // attendance_table.attendee_required = 0 AND attendance_table.attended = 1 AND attendance_table.communicated = 0 WHERE attendance_id=$attendance_id";
                    break;
                case "required":
                    $sql_fine = "UPDATE fines SET amount=50 WHERE fine_id='$fine_id'";
                    $sql_attendance = "UPDATE attendance_table SET attendee_required = 1, attended = 0, communicated = 0 WHERE attendance_id=$attendance_id";
                    // $sql = "UPDATE fines, attendance_table SET fines.amount = 0 WHERE fine_id='$fine_id'AND SET
                    // attendance_table.attendee_required = 1 AND attendance_table.attended = 0 AND attendance_table.communicated = 0 WHERE attendance_id=$attendance_id";
                    break;
                case "communicated":
                    $sql_fine = "UPDATE fines SET amount=20 WHERE fine_id='$fine_id'";
                    $sql_attendance = "UPDATE attendance_table SET attendee_required = 0,attended = 0, communicated = 1 WHERE attendance_id=$attendance_id";
                    // $sql = "UPDATE fines, attendance_table SET fines.amount = 20 WHERE fine_id='$fine_id' AND SET
                    // attendance_table.attendee_required = 0 AND attendance_table.attended = 0 AND attendance_table.communicated = 1 WHERE attendance_id=$attendance_id";
                    break;
            }
            if($conn->query($sql_attendance)){
                echo $sql_attendance;
                echo "   Fine updated successfully!";
                if($conn->query($sql_fine)){
                    echo $sql_fine;
                    echo "Attendance updated successfully!";
                    
                }else {
                    echo "Failed to update attendance!";
                }
            }else {
                echo "Failed to update fine!";
            }
            echo "done";
        }catch(PDOException $e)
		{
			echo $sql;
            echo $e;
		}
    }
?>