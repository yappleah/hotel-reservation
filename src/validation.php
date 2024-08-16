<?php
    if (isset($_POST['book'])) { 
        $firstName = test_input(ucwords($_POST["firstName"]));
        $lastName = test_input(ucwords($_POST["lastName"]));
        $emailAddress = test_input(strtolower($_POST["emailAddress"]));
        $phoneNumber = test_input($_POST["phoneNumber"]);
        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format"; 
            
        } else {  
            echo $firstName, $lastName, $emailAddress, $phoneNumber;
        } 
    } 
    
    function test_input($data) { 
        $data = trim($data); 
        $data = strip_tags($data);
        $data = stripslashes($data);
        $data = htmlentities($data);
        $data = htmlspecialchars($data); 
        return $data; 
    } 
?>