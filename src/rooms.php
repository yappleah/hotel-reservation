<?php

if (!function_exists('getLocationRooms')) {
function getLocationRooms($location) {
    $link = 'data/' . $location . '.txt';
    $rooms = array();
    $file = fopen($link, "r");
    while(!feof($file)) { 
        $roomNumber = fgets($file);
        $type =  fgets($file);
        $capacity = fgets($file);
        $rate = fgets($file);
        $smokingAllowed = fgets($file);
        $room = array("roomNumber" => trim($roomNumber), "type" => trim($type), "capacity" => trim($capacity), "rate" => trim($rate), "smokingAllowed" => trim($smokingAllowed));
        array_push($rooms, $room);
    } 
    fclose($file);  
    return $rooms;
}
}

if (!function_exists('getRoomByLocationRoomNumber')) {
    function getRoomByLocationRoomNumber($location, $number) {
        $link = 'data/' . $location . '.txt';
        $file = fopen($link, "r");
        while(!feof($file)) {
            $roomNumber = fgets($file);
            $type =  fgets($file);
            $capacity = fgets($file);
            $rate = fgets($file);
            $smokingAllowed = fgets($file);
            if (trim($roomNumber) === trim($number)) {
                $room = array("roomNumber" => trim($roomNumber), "type" => trim($type), "capacity" => trim($capacity), "rate" => trim($rate), "smokingAllowed" => trim($smokingAllowed));
                break;
            }
        } 
        fclose($file); 
        return $room;
    }
    }

?>