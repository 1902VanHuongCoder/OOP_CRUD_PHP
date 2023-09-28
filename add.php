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

// Get submitted form data  
$postData = array();
if (!empty($sessData['postData'])) {
    $postData = $sessData['postData'];
    unset($_SESSION['postData']);
}
?>


<div class="row">
    <div class="col-md-12 head">
        <h5>Add User</h5>
        <?php

        echo $bool = empty($postData["fullname"]);
        ?>
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
                <input type="text" class="form-control" name="fullname" value="<?php echo !empty($postData['fullname']) ? $postData['fullname'] : ''; ?>" required="">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="username" value="<?php echo !empty($postData['username']) ? $postData['username'] : ''; ?>" required="">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" value="<?php echo !empty($postData['password']) ? $postData['password'] : ''; ?>" required="">
            </div>
            <input type="hidden" name="action_type" value="add" />
            <input type="submit" class="form-control btn-primary" name="submit" value="Add User" />
        </form>
    </div>
</div>