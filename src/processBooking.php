<?php
    include 'validation.php';
    include 'customerForm.php';

    if (isset($_POST['book'])) { 
        $randomNumber = generateRandomNumberString();
        session_start();
        $location = $_SESSION['location'];
        $check_in = $_SESSION['check_in'];
        $check_out = $_SESSION['check_out'];
        $adults = $_SESSION['adults'];
        $children = $_SESSION['children'];
        $specificRoom = $_SESSION['specificRoom'];
        $rate = trim($specificRoom['rate']);
        $roomNumber = trim($specificRoom['roomNumber']);
        $roomType = $_SESSION['roomType'];
        $smoking = $_SESSION['smoking'];
        $_SESSION['id'] = $randomNumber;
        $success = inputBooking($randomNumber, $firstName, $lastName, $emailAddress, $phoneNumber, $check_in, $check_out, $adults, $children, $roomNumber, $rate, $location);

        if ($success) {
            header('Location: bookingComplete.php');
            exit;
            
        } else {
            header('Location: db-error.php');
            exit;
        }
    } else {
        header('Location: db-error.php');
    }

    function generateRandomNumberString($length = 10) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

?>