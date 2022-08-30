
<?php
    include 'connect.php';

    $data = array();

    $query = "SELECT * FROM classes ORDER BY class_id";

    $stmt = $conn->prepare($query);

    $stmt->execute();

    $result = $stmt->fetchAll();

    foreach($result as $row)
    {
    $data[] = array(
    'id'=> $row['class_id'],
    'title'=>$row['class_name'],
    'start'=>$row['start_date']." ".$row['start_time'],
    'end'=> $row['end_date']." ".$row['end_time']
    );
    }
    echo json_encode($data); //display on callendar plugin

?>

