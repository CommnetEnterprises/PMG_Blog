<?php
require 'config\database.php';

//get signup for data if signup button clicked

if(isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    //validate input vals

    if(!$firstname){
        $_SESSION['signup'] = "Please enter your First Name";
    }elseif(!$lastname){
        $_SESSION['signup'] = "Please enter your Last Name";
    }elseif(!$username){
        $_SESSION['signup'] = "Please enter your User Name";
    }elseif(!$email){
        $_SESSION['signup'] = "Please enter a valid email";
    }elseif(strlen($createpassword)< 8 || strlen($confirmpassword)<8){
        $_SESSION['signup'] = "Password should be 8+ characters";
    }elseif(!$avatar['name']){
        $_SESSION['signup'] = "Please add avatar";
    }
    else{
        if($createpassword !== $confirmpassword){
            $_SESSION['signup']= "Passwords do not match";
        }else{
            //hash password
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
            echo $createpassword . '<br/>';
            echo $hashed_password;

            //check if username or email exists in database
            $use_check_query = "SELECT * FROM users WHERE username = '$username' OR  email='$email'";
            $use_check_resilt = mysqli_query($connection, $use_check_query);
            if(mysqli_num_rows($use_check_resilt)>0){
                $_SESSION['signup'] = "Usename or Email already exists";
            }else{
                //Work on avatar
                //rename avatar
                $time = time();
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/' . $avatar_name;

                //validate image 
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extention = explode('.', $avatar_name);
                $extention = end($extention);
                if(in_array($extention,$allowed_files)){
                    //make sure image isnt too large
                    if($avatar['size']< 10000000){
                        //upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }else{
                        $_SESSION['signup']= "File size too big. Should be less than 1mb";
                    }
                }else{
                    $_SESSION['signup']= "File should be png, jpg or jpeg";
                }
            }
        }
    }

    //redirect back to signup if there was any problem
    if(isset($_SESSION['signup'])){
        //pass form data back to signup page
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
    }else{
        //insert user into users table
        $insert_user_query = "INSERT INTO users SET firstname = '$firstname', lastname ='$lastname', username = '$username', email = '$email', password = '$hashed_password', avatar = '$avatar_name', is_admin = 0";
        $insert_user_results = mysqli_query($connection, $insert_user_query);

        if (!mysqli_errno($connection)){
            //rediret to login page with sucess message
            $_SESSION['signup-success'] = "Resgistration successful. Please log in";
            header('location: '. ROOT_URL . 'signin.php');
            die();
        }
    }

}else{
    //if btn not clicked, bounce bak to signup
    header('location: '. ROOT_URL . 'signup.php');
    die();
}