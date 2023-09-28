<?php
// Start session 
session_start();

// Get data from session 
$sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';

// Get status from session 
if (!empty($sessData['status']['msg'])) {
    $statusMsg = $sessData['status']['msg'];
    $status = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Include and initialize DB class 
require_once 'DB.class.php';
$db = new DB();

// Fetch the user data by ID 
if (!empty($_GET['id'])) {
    $conditons = array(
        'where' => array(
            'id' => $_GET['id']
        ),
        'return_type' => 'single'
    );
    $userData = $db->getRows('user_accounts', $conditons);
}

// Redirect to list page if invalid request submitted 
if (empty($userData)) {
    header("Location: index.php");
    exit;
}

// Get submitted form data  
$postData = array();
if (!empty($sessData['postData'])) {
    $postData = $sessData['postData'];
    unset($_SESSION['postData']);
}
?>

<div class="row">
    <div class="col-md-12 head">
        <h5>Edit User</h5>
        <!-- Back link -->
        <div class="float-right">
            <a href="index.php" class="btn btn-success"><i class="back"></i> Back</a>
        </div>
    </div>

    <!-- Status message -->
    <?php if (!empty($statusMsg)) { ?>
        <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
    <?php } ?>

    <div class="col-md-12">
        <form method="post" action="action.php" class="form">
            <div class="form-group">
                <label>Full name</label>
                <input type="text" class="form-control" name="fullname" value="<?php echo !empty($postData['fullname']) ? $postData['fullname'] : $userData['fullname']; ?>" required="">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="username" value="<?php echo !empty($postData['username']) ? $postData['username'] : $userData['username']; ?>" required="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" value="<?php echo !empty($postData['password']) ? $postData['password'] : $userData['password']; ?>" required="">
            </div>
            <input type="hidden" name="id" value="<?php echo $userData['id']; ?>" />
            <input type="hidden" name="action_type" value="edit" />
            <input type="submit" class="form-control btn-primary" name="submit" value="Update User" />
        </form>
    </div>
</div>