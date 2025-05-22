<?php

session_start();

include_once("connect.php");
require 'send_email.php';
require '../log/log_helper.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $action = $_GET['action'];
    
   
if ($action == "timkiemtheotype") {
      
        $query = "SELECT 
                    tour.id AS tourid, 
                    tour.Name, 
                    tour.Price, 
                    tour.discount, 
                    tour.vehicle, 
                    tour.timetour, 
                    tour_images.Image, 
                    GROUP_CONCAT(DISTINCT departure_time.ngaykhoihanh ORDER BY departure_time.ngaykhoihanh ASC SEPARATOR ', ') AS ngaykhoihanh
                FROM tour 
                INNER JOIN tour_images ON tour.id = tour_images.id_tour 
                LEFT JOIN departure_time ON tour.id = departure_time.id_tour  
               WHERE Orders < Max_participant AND tour.type = 'Gia đình' AND  departure_time.ngaykhoihanh >= NOW()
                GROUP BY tour.id
                ORDER BY MIN(departure_time.ngaykhoihanh) ASC";

       
        $result = $conn->query($query);

        $res = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $res[] = $row; // Lưu từng bản ghi vào mảng
            }
        }

        echo json_encode($res); // Trả về JSON
        exit;
    }
}
?>