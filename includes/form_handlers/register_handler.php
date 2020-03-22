<?php
    // variables declaretion
    $fname = "";
    $lname = "";
    $em = "";
    $em2 = "";
    $password = "";
    $password2 = "";
    $date = ""; // to store the current date user signed in
    $error_array = array(); // Holds error message

if (isset($_POST['register_button'])) {
    // Registration From Values 
    //First Name
    $fname = strip_tags($_POST['reg_fname']); //Remove html tags
    $fname = str_replace(' ', '', $fname); //Remove spaces
    $fname = ucfirst(strtolower($fname)); //Uppercase first latter
    $_SESSION['reg_fname'] = $fname; // Stores the First name into the session variable

    // Last Name
    $lname = strip_tags($_POST['reg_lname']); //Remove html tags
    $lname = str_replace(' ', '', $lname);  //Remove spaces
    $lname = ucfirst(strtolower($lname)); //Uppercase fist latter
    $_SESSION['reg_lname'] = $lname; // Stores the Last name into the session variable

    // Email
    $em = strip_tags($_POST['reg_email']); //Remove html tags
    $em = str_replace(' ', '', $em); //Remove spaces
    $em = ucfirst(strtolower($em)); //Uppercase first latter
    $_SESSION['reg_email'] = $em; // Stores the email into the session variable

    // Email 2
    $em2 = strip_tags($_POST['reg_email2']); //Remove html tags
    $em2 = str_replace(' ', '', $em2); // Remove spcaes
    $em2 = ucfirst(strtolower($em2)); // Uppercase first latter
    $_SESSION['reg_email2'] = $em2; // Stores the email 2 into the session variable

    // Password
    $password = strip_tags($_POST['reg_password']); // Remove html tags

    // Password
    $password2 = strip_tags($_POST['reg_password2']); //Remove html tags

    $date = date("Y-m-d");
    // $date = "GATEDATE()";
    if ($em == $em2) {
        if (filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);
            // check if email already exist 
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");
            $num_rows = mysqli_num_rows($e_check);
            if ($num_rows > 0) {
                array_push($error_array, "Email already exists<br>");
            }
        } else {
            array_push($error_array, "Invalid Email format<br>");
        }
    } else {
        array_push($error_array, "Emails don't match<br>");
    }
    if (strlen($fname) < 3 || strlen($fname) > 25) {
        array_push($error_array, "Your first name must be between 3 to 25 characters<br>");
    }
    if (strlen($lname) < 3 || strlen($lname) > 25) {
        array_push($error_array, "Your last name must be between 3 to 25 characters<br>");
    }
    if ($password != $password2) {
        array_push($error_array, "Your Password do not match<br>");
    } else {
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your Password can only contain English characters and letters<br>");
        }
    }
    if (strlen($password) < 5 || strlen($password) > 30) {
        array_push($error_array, "Your password must between 5 to 30 characters<br>");
    }
    if(empty($error_array)){
        $password = md5($password); // Encrypt the password before sending it to the database
        $username = strtolower($fname . "_" . $lname);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

        $i=0;
        while (mysqli_num_rows($check_username_query) != 0) {
            $i++;
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

        }

        // Profile picture assingment
        $rand = rand(1,2);
        if($rand == 1){
            $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
        }
        else if($rand == 2){
            $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";
        }
        $query = mysqli_query($con, "INSERT INTO `users` VALUES (NULL,'$fname','$lname','$username','$em','$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

        array_push($error_array, "<span style='color:#14C800;'>You are all set Go ahead and Login!</span><br>");

        // Clear session variables
        $_SESSION['reg_fname'] = "";
        $_SESSION['reg_lname'] = "";
        $_SESSION['reg_email'] = "";
        $_SESSION['reg_email2'] = "";
    }
}

        

?>