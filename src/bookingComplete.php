<?php
require_once '../vendor/autoload.php';
include 'db.php';
include 'rooms.php';
$loader = new \Twig\Loader\FilesystemLoader('../templates'); 
$twig = new \Twig\Environment($loader);

    session_start();
    $confirmationNumber = $_SESSION['id'];
    $booking = getSpecificBooking($confirmationNumber);
    $firstName = $booking['firstName'];
    $lastName = $booking['lastName'];
    $emailAddress = $booking['email'];
    $phoneNumber = $booking['phoneNumber'];
    $check_in = $booking['check_in'];
    $check_out = $booking['check_out'];
    $location = $booking['location'];
    $roomNumber = $booking['roomNumber'];
    $adults = $booking['adults'];
    $children = $booking['children'];
    $rate = $booking['rate'];
    $room = getRoomByLocationRoomNumber($location, $roomNumber);
    $roomType = $room['type'];
    $smoking = $room['smokingAllowed'];

    $response = getWeatherDetails();

    echo $twig->render('bookingComplete.twig', ['confirmationNumber' => $confirmationNumber, 'firstName' =>  $firstName, 'lastName' =>  $lastName, 'emailAddress' => $emailAddress, 'phoneNumber' => $phoneNumber, 'check_in' => $check_in, 'check_out' => $check_out, 'roomType' =>  ucwords($roomType), 'smoking' => $smoking, 'adults' => $adults, 'children' => $children, 'location' => ucwords($location), 'rate' => $rate, 'weather' => $response]);

    function getWeatherDetails() {
        global $location;
        $apiKey = 'c480b8a9648bb7c45d2b70f5c330b966';
        $cityName = $location;
        $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . 
                    $cityName . 
                    '&appid=' . 
                    $apiKey;
            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
            
        $response = json_decode($result,true);
            
        if($response['cod'] != 200){
            echo 'Error API returned status code' . $response['cod'] . "<br>";
            echo 'Message: ' . $response['message'] . "<br>";
        }
        return $response;             
    }