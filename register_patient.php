<?php
if (isset($_POST['register'])){     
    require 'conn.php';
    $full_name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $service = $_POST['service'];
    $comment = $_POST['comments'];
    $sql = "INSERT INTO `tbl_patient`( `full_name`,`dob`, `gender`,`service`,`comment`) VALUES ('$full_name','$dob',$gender,$service,'$comment') ;";  
    if ($conn->query($sql)===TRUE){

        echo  json_encode(['success' => true , 'message' => 'Registered Successfully']);       
    } else{

        echo  json_encode(['success' => false , 'message' => 'Not Successful']);
    }
    exit(0);
    
} 
?>