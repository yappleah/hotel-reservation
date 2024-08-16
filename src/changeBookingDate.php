<?php 
include 'db.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);
        $location = $data['location'];
        $newCheckInDate = $data['newCheckInDate'];
        $newCheckOutDate = $data['newCheckOutDate'];
        $smoking = $data['smoking'];
        $adults = $data['adults'];
        $children = $data['children'];
        
        $availableRooms = getRooms($location, $newCheckInDate, $newCheckOutDate, $smoking, $adults, $children);
        $roomTypes = [];
        $roomsToShow = [];
        foreach ($availableRooms as $room) {
            $type = trim($room['type']);
            $rate = $room['rate'];
        
            if (!in_array($type, array_column($roomTypes, 'type'))) {
                array_push($roomTypes, ['type' => $type, 'rate' => $rate]);
            }
        }
        foreach ($roomTypes as $type) {
            switch (trim($type['type'])) {
                case 'Single Queen':
                    $room = ["type" => trim($type['type']), "rate" => trim($type['rate']), "image" => "../public/images/single-queen.png", "alt" => "Image of a single queen hotel room"];
                    break;
                case 'Double Queen':
                    $room = ["type" => trim($type['type']), "rate" => trim($type['rate']), "image" => "../public/images/double-queen.png", "alt" => "Image of a double queen hotel room"];
                    break;
                case 'King':
                    $room = ["type" => trim($type['type']), "rate" => trim($type['rate']), "image" => "../public/images/king-bed.png", "alt" => "Image of a king hotel room"];
                    break;
                default:
                    $room = ["type" => trim($type['type']), "rate" => trim($type['rate']), "image" => "../public/images/suite.png", "alt" => "Image of a suite hotel room"];
                    break;
            }
            array_push($roomsToShow, $room);
        }
        $response = [
            "message" => "Received POST request",
            "rooms" => $roomsToShow
        ];
    }
    
    header("Content-Type: application/json");
    echo json_encode($response);

?>