<?php
    require_once '../vendor/autoload.php';
    use Carbon\Carbon;
    include 'db.php';
    $today = Carbon::today()->toDateString();
    $loader = new \Twig\Loader\FilesystemLoader('../templates'); 
    $twig = new \Twig\Environment($loader);
    if (isset($_POST['submit'])) {
        $location = $_POST['location'];
        $check_in = $_POST['check-in'];
        $check_out = $_POST['check-out'];
        $adults = $_POST['adults'];
        $children = $_POST['children'];
        if (isset($_POST['smoking'])) {
            $smoking = 'true';
        } else {
            $smoking = 'false';
        }
        getRoomsToDisplay();
    }
    function getRoomsToDisplay() {
        global $location, $check_in, $check_out, $smoking, $twig, $today, $adults, $children;
        $availableRooms = getRooms($location, $check_in, $check_out, $smoking, $adults, $children);
        $roomTypes = [];
        $roomsToShow = [];
        foreach ($availableRooms as $room) {
            $type = trim($room['type']);
            $rate = $room['rate'];
        
            if (!in_array($type, array_column($roomTypes, 'type'))) {
                $roomTypes[] = ['type' => $type, 'rate' => $rate];
            }
        }
        foreach ($roomTypes as $type) {
            switch (trim($type['type'])) {
                case 'Single Queen':
                    $room = ["type" => $type['type'], "rate" => $type['rate'], "image" => "../public/images/single-queen.png", "alt" => "Image of a single queen hotel room"];
                    break;
                case 'Double Queen':
                    $room = ["type" => $type['type'], "rate" => $type['rate'], "image" => "../public/images/double-queen.png", "alt" => "Image of a double queen hotel room"];
                    break;
                case 'King':
                    $room = ["type" => $type['type'], "rate" => $type['rate'], "image" => "../public/images/king-bed.png", "alt" => "Image of a king hotel room"];
                    break;
                default:
                    $room = ["type" => $type['type'], "rate" => $type['rate'], "image" => "../public/images/suite.png", "alt" => "Image of a suite hotel room"];
                    break;
            }
            $roomsToShow[] = $room;
        }
        echo $twig->render('availabilities.twig', ['todayDate' => $today, 'location' => $location, 'checkInDate' => $check_in, 'checkOutDate' => $check_out, 'rooms' => $roomsToShow, 'smoking' => $smoking, 'adults' => $adults, 'children' => $children]);
    }
?>
