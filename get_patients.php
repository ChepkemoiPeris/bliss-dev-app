<?php
require 'conn.php';

if (isset($_GET['get_patients'])){
    // sql statement to get data 
    $sql = "SELECT p.*, g.gender AS gender_name, s.service AS service_name FROM `tbl_patient`  p
    INNER JOIN gender g ON g.id = p.gender  INNER JOIN tbl_service s ON s.id = p.service;";    
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);  

     if(count($data) > 0){      
        
        echo json_encode(['msg' => 'Patients  Found', 'success'=> true, 'patients'=> $data]);
     }else{
         echo json_encode(['msg' => 'Patients Not Registered', 'success'=> true]);
     }  
    
}
?>