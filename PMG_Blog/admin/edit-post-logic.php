<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    //get updated form data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $prev_thumbnail_name = filter_var($_POST['prev_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    $is_featured = $is_featured ==1 ?:0;

    //check valid input
    if(!$title){
        $_SESSION['edit-post'] ="Could not update post. Invalid form data on edit post.";
    }
    elseif(!$category_id){
        $_SESSION['edit-post'] ="Could not update post. Invalid form data on edit post.";
    }
    elseif(!$body){
        $_SESSION['edit-post'] ="Could not update post. Invalid form data on edit post.";
    }
    else{
        if($thumbnail['name']){
            $prev_thumbnail_path = '../images/' . $prev_thumbnail_name;
            if($prev_thumbnail_path){
                unlink($prev_thumbnail_path);
            }
        

        //new thumbnail
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path= '../images/' . $thumbnail_name;

        //make sure file is an image

        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if(in_array($extension,$allowed_files)){
            //make sure image isnt too large
            if($thumbnail['size']< 2000000){
                //upload thumnail
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            }else{
                $_SESSION['edit-post']= "File size too big. Should be less than 2mb";
            }
        }else{
            $_SESSION['edit-post']= "File should be png, jpg or jpeg";
        }
    }
}
       
        if($_SESSION['edit-post']){
            header('location: ' . ROOT_URL . 'admin/');
            die();
        }else{
            if($is_featured ==1){
                $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
                $zero_all_is_featured_result = mysqli_query($connection,$zero_all_is_featured_query);
            }

            $thumbnail_to_insert = $thumbnail_name ?? $prev_thumbnail_name;

            $query = "UPDATE posts SET title='$title', body='$body', thumbnail='$thumbnail_to_insert', category_id=$category_id, is_featured= $is_featured WHERE id=$id LIMIT 1";
            $result = mysqli_query($connection, $query);
        
        }
    
    if (!mysqli_errno($connection)){
        //rediret to login page with sucess message
        $_SESSION['edit-post-success'] = "Post updated successfully";
        header('location: '. ROOT_URL . 'admin/');
        
    }else{
         $_SESSION['edit-post'] = "Could not edit post";
        header('location: '. ROOT_URL . 'admin/add-post.php');
         die();
     }
        
}
header('location: ' . ROOT_URL . 'admin/');
die();