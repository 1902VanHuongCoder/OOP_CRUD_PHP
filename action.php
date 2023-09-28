<?php
// Start session 
session_start();

// Include and initialize DB class 
require_once 'DB.class.php';
$db = new DB();

// Database table fullname 
$tblfullname = 'user_accounts';

$postData = $statusMsg = $valErr = '';
$status = 'danger';
$redirectURL = 'index.php';

// If Add request is submitted 
if (!empty($_REQUEST['action_type']) && $_REQUEST['action_type'] == 'add') {
    $redirectURL = 'add.php';

    // Get user's input 
    $postData = $_POST;
    $fullname = !empty($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $username = !empty($_POST['username']) ? trim($_POST['username']) : '';
    $password = !empty($_POST['password']) ? trim($_POST['password']) : '';

    // Validate form fields 
    if (empty($fullname)) {
        $valErr .= 'Please enter your full fullname.<br/>';
    }
    if (empty($username)) {
        $valErr .= 'Please enter your userfullname.<br/>';
    }
    if (empty($password)) {
        $valErr .= 'Please enter your password.<br/>';
    }

    // Check whether user inputs are empty 
    if (empty($valErr)) {
        // Insert data into the database 
        $userData = array(
            'fullname' => $fullname,
            'username' => $username,
            'password' => $password
        );
        $insert = $db->insert($tblfullname, $userData);

        if ($insert) {
            $status = 'success';
            $statusMsg = 'User data has been added successfully!';
            $postData = '';

            $redirectURL = 'index.php';
        } else {
            $statusMsg = 'Something went wrong, please try again after some time.';
        }
    } else {
        $statusMsg = '<p>Please fill all the mandatory fields:</p>' . trim($valErr, '<br/>');
    }

    // Store status into the SESSION 
    $sessData['postData'] = $postData;
    $sessData['status']['type'] = $status;
    $sessData['status']['msg'] = $statusMsg;
    $_SESSION['sessData'] = $sessData;
} elseif (!empty($_REQUEST['action_type']) && $_REQUEST['action_type'] == 'edit' && !empty($_POST['id'])) { // If Edit request is submitted 
    $redirectURL = 'edit.php?id=' . $_POST['id'];

    // Get user's input 
    $postData = $_POST;
    $fullname = !empty($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $username = !empty($_POST['username']) ? trim($_POST['username']) : '';
    $password = !empty($_POST['password']) ? trim($_POST['password']) : '';

    // Validate form fields 
    if (empty($fullname)) {
        $valErr .= 'Please enter your fullname.<br/>';
    }
    if (empty($username)) {
        $valErr .= 'Please enter your username.<br/>';
    }
    if (empty($password)) {
        $valErr .= 'Please enter your password<br/>';
    }

    // Check whether user inputs are empty 
    if (empty($valErr)) {
        // Update data in the database 
        $userData = array(
            'fullname' => $fullname,
            'username' => $username,
            'password' => $password
        );
        $conditions = array('id' => $_POST['id']);
        $update = $db->update($tblfullname, $userData, $conditions);

        if ($update) {
            $status = 'success';
            $statusMsg = 'User data has been updated successfully!';
            $postData = '';

            $redirectURL = 'index.php';
        } else {
            $statusMsg = 'Something went wrong, please try again after some time.';
        }
    } else {
        $statusMsg = '<p>Please fill all the mandatory fields:</p>' . trim($valErr, '<br/>');
    }

    // Store status into the SESSION 
    $sessData['postData'] = $postData;
    $sessData['status']['type'] = $status;
    $sessData['status']['msg'] = $statusMsg;
    $_SESSION['sessData'] = $sessData;
} elseif (!empty($_REQUEST['action_type']) && $_REQUEST['action_type'] == 'delete' && !empty($_GET['id'])) { // If Delete request is submitted 
    // Delete data from the database 
    $conditions = array('id' => $_GET['id']);
    $delete = $db->delete($tblfullname, $conditions);

    if ($delete) {
        $status = 'success';
        $statusMsg = 'User data has been deleted successfully!';
    } else {
        $statusMsg = 'Something went wrong, please try again after some time.';
    }

    // Store status into the SESSION 
    $sessData['status']['type'] = $status;
    $sessData['status']['msg'] = $statusMsg;
    $_SESSION['sessData'] = $sessData;
}

// Redirect to the home/add/edit page 
header("Location: $redirectURL");
exit;
