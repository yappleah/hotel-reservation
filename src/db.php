<?php
require_once '../vendor/autoload.php';
include 'rooms.php';
use Carbon\Carbon;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$log = new Logger('my_logger');
$log->pushHandler(new StreamHandler(__DIR__.'/app.log',
    Logger::DEBUG));

    $hostname = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $database = "hotel"; 
    // Create a new mysqli object 
    $conn = new mysqli($hostname, $username, $password, $database); 
    // or use this: //$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName); 
    // Check the connection 
    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error); 
    }

    if (!function_exists('getRooms')) {
    function getRooms($location, $check_in, $check_out, $smoking, $adults, $children) {
        $rooms = getLocationRooms($location);
        global $conn;
        $today = Carbon::today()->toDateString();
        $availableRooms = array();
        foreach($rooms as $room) {
            if ($room['capacity'] >= ($adults + $children) && (trim($room['smokingAllowed']) == $smoking)){
                $roomNumber = $room['roomNumber'];
                array_push($availableRooms, $room);
                $sql = "SELECT * FROM bookings WHERE 
                    roomNumber = '$roomNumber' AND location = '$location' AND
                    check_out > '$today' AND 
                    (check_out > '$check_in' AND check_in < '$check_out')";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    array_pop($availableRooms);
                }
            }
        }     
        return $availableRooms;
    }
}

if (!function_exists('getSpecificRoom')) {
    function getSpecificRoom($location, $check_in, $check_out, $smoking, $adults, $children, $roomType) {
        $rooms = getLocationRooms($location);
        global $conn;
        $today = Carbon::today()->toDateString();
        $availableRooms = array();
        foreach($rooms as $room) {
            if ($room['capacity'] >= ($adults + $children) && (trim($room['smokingAllowed']) == $smoking)){
                $roomNumber = trim($room['roomNumber']);
                array_push($availableRooms, $room);
                $sql = "SELECT * FROM bookings WHERE 
                    roomNumber = '$roomNumber' AND location = '$location' AND 
                    check_out > '$today' AND 
                    (check_out > '$check_in' AND check_in < '$check_out')";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    array_pop($availableRooms);
                }
            }
        }

        foreach($availableRooms as $room) {
            if (trim($room['type']) === $roomType && $room['capacity'] >= ($adults + $children) && (trim($room['smokingAllowed']) == $smoking)) {
                $specificRoom = array('roomNumber' => trim($room['roomNumber']), 'rate' => $room['rate']);
                break;
            }
        }
        return $specificRoom;
        
    }
}
if (!function_exists('inputBooking')) {
    function inputBooking($id, $firstName, $lastName, $emailAddress, $phoneNumber, $check_in, $check_out, $adults, $children, $roomNumber, $rate, $location) {
        global $conn;
        $log = new Logger('my_logger');
        $stmt = $conn->prepare("INSERT INTO bookings (id, firstname, lastname, email, phoneNumber, check_in, check_out, adults, children, roomNumber, rate, location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // Bind parameters
        $stmt->bind_param("sssssssiisis", $id, $firstName, $lastName, $emailAddress, $phoneNumber, $check_in, $check_out, $adults, $children, $roomNumber, $rate, $location);

        // Execute the statement
        if ($stmt->execute()) {
            $success = 'true';
            $log->pushHandler(new StreamHandler(__DIR__.'/app.log', Logger::INFO));
            $log->info('New booking has been inserted and saved in the database.');
        } else {
            $success = 'false';
            $log->pushHandler(new StreamHandler(__DIR__.'/app.log', Logger::WARNING)); 
            $log->error('There was an error in inserting booking in the database');
        } 
        return $success;
    }
}

if (!function_exists('getSpecificBooking')) {
    function getSpecificBooking($id) {
        global $conn;
        $sql = "SELECT * FROM bookings where id = '$id'"; 
        $result = $conn->query($sql); 
        $row = $result->fetch_assoc();
        return $row;
    }
}

?>