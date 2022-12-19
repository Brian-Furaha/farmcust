<?php
session_start();
require 'db_connect.php';

if (isset($_POST['login2'])) {

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = md5($_POST['password']);

  $result = mysqli_query($conn, " SELECT * FROM users WHERE email = '$email' && password = '$pass'");

  if (mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_array($result);
    $_SESSION['login_id'] = $row['id'];
    header("Location:admin.php");
  } else {
    $_SESSION['error'] = 'Login: Incorrect email or password!';
    header("Location: login2.php");
    exit(0);
  }
}

if (isset($_POST['add_user'])) {

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $fname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $sname = mysqli_real_escape_string($conn, $_POST['surname']);
  $pass = md5($_POST['password']);
  $cpass = md5($_POST['cpassword']);
  $role = $_POST['flexRadioDefault'];
  $result = mysqli_query($conn, " SELECT email FROM users WHERE email = '$email'");

  if (mysqli_num_rows($result) > 0) {
    // old user new account with different role
    $row = mysqli_fetch_array($result);
    if ($email == $row['email']) {
      $_SESSION['error'] = 'Add user: user already exists!';
      header("location: usertables.php");
      exit(0);
    } else {
      if ($pass != $cpass) {
        $_SESSION['error'] = 'Add user: password does not match!';
        header("location: usertables.php");
        exit(0);
      } else {
        $insert = "INSERT INTO users(id, firstname, lastname, email, password) VALUES('$id', '$fname', '$sname', '$email', '$pass')";
        $query_run = mysqli_query($conn, $insert);

        if ($query_run) {
          $_SESSION['error'] = "User Created Successfully";
          header("Location: usertables.php");
        } else {
          $_SESSION['message'] = "User Not Created";
          header("Location: usertables.php");
        }
      }
    }
  } else {

    if ($pass != $cpass) {
      $_SESSION['error'] = 'Signup: password does not match!';
      header("Location: usertables.php");
      exit(0);
    } else {
      $insert = "INSERT INTO user(id, firstname, lastname, email, password) VALUES('$id', '$fname', '$sname', '$email', '$role', '$pass')";
      $query_run = mysqli_query($conn, $insert);

      if ($query_run) {
        $_SESSION['error'] = "User Created Successfully";
        header("Location: usertables.php");;
      } else {
        $_SESSION['message'] = "User Not Created";
        header("Location: usertables.php");;
      }
    }
  }
};



if (isset($_POST['delete_user'])) {
  $user_id = mysqli_real_escape_string($conn, $_POST['delete_user']);

  $query = "DELETE FROM users WHERE id='$user_id' ";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {
    $_SESSION['error'] = "User Deleted Successfully";
    header("Location: usertables.php");
    exit(0);
  } else {
    $_SESSION['message'] = "User Not Deleted";
    header("Location: usertables.php");
    exit(0);
  }
};

if (isset($_POST['update_profile'])) {
  $userid = $_SESSION['userid'];
  $email = mysqli_real_escape_string($conn, $_POST['inputEmail']);
  $fname = mysqli_real_escape_string($conn, $_POST['update_fname']);
  $sname = mysqli_real_escape_string($conn, $_POST['update_sname']);
  $loca = mysqli_real_escape_string($conn, $_POST['inputLocation']);
  $mobile = mysqli_real_escape_string($conn, $_POST['inputPhone']);
  $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));
  $npass = mysqli_real_escape_string($conn, md5($_POST['newpass']));
  $cpass = mysqli_real_escape_string($conn, md5($_POST['cnewpass']));
  $opass = $_POST['oldpass'];
  $image = $_FILES['image']['name'];
  $image_size = $_FILES['image']['size'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_folder = 'uploaded_img/' . $image;

  if (!empty($pass) || !empty($npass) || !empty($cpass)) {
    if ($opass != $pass) {
      $_SESSION['error'] = 'old password does not match!';
    } elseif ($npass != $cpass) {
      $_SESSION['error'] = 'new password does not match!';
    } else {
      mysqli_query($conn, "UPDATE user SET user_password= '$npass' WHERE user_id= '$id'");
      $_SESSION['error'] = 'password update successful!';
    }
  }

  if (!empty($image)) {
    if ($image_size > 2000000) {
      $_SESSION['error'] = 'image is to large!';
    } else {
      $image_query = mysqli_query($conn, "UPDATE user SET image = '$image' WHERE user_id = '$userid'");
      if ($image_query) {
        move_uploaded_file($image_tmp_name, $image_folder);
      }
      $_SESSION['error'] = 'image update successful!';
    }
  }

  $query = "UPDATE user SET user_fname='$name', user_email='$email', user_mobile='$mobile', user_sname='$sname', user_location='$loca' WHERE user_id='$userid' ";
  $query_run = mysqli_query($conn, $query);

  if ($query_run) {
    $_SESSION['error'] = "Updated Successfully";
    header("Location: ./farmer/farmer_profile.php");
  } else {
    $_SESSION['error'] = "Not Updated";
    header("Location: ./farmer/farmer_profile.php");
  }
};
