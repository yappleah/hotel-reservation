<?php
include 'db.php';
require_once '../vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('../templates'); 
$twig = new \Twig\Environment($loader);
    if (isset($_POST['submit'])) {
        $roomType = $_POST['selectedRoomType'];
        $check_in = $_POST['check-in'];
        $check_out = $_POST['check-out'];
        $adults = $_POST['adults'];
        $children = $_POST['children'];
        $location = $_POST['location'];
        $smoking = isset($_POST['smoking']) && $_POST['smoking'] === 'on' ? "true" : "false";
        $specificRoom = getSpecificRoom($location, $check_in, $check_out, $smoking, $adults, $children, $roomType);

        session_start();
        $_SESSION['check_in'] = $check_in;
        $_SESSION['check_out'] = $check_out;
        $_SESSION['adults'] = $adults;
        $_SESSION['children'] = $children;
        $_SESSION['specificRoom'] = $specificRoom;
        $_SESSION['location'] = $location;
        $_SESSION['roomType'] = $roomType;
        $_SESSION['smoking'] = $smoking;

        echo $twig->render('customerForm.twig', ['location' =>  ucwords($location), 'checkInDate' => $check_in, 'checkOutDate' => $check_out, 'roomType' =>  ucwords($roomType), 'smoking' => $smoking, 'adults' => $adults, 'children' => $children, 'specificRoom' => $specificRoom]);
    }

?>