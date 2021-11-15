<?php

    //Include contansts.php file here
    include('../config/constants.php');

    // 1. Get the ID of Admin to be deleted
    $id = $_GET['id'];

    // 2. create SQL query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    //check whether the query execute successfully or not
    if($res==true)
    {
        // Query executed successfully and admin deleted
        // echo "Admin Deleted";
        // create session variable to display message
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Sucessfully</div>";
        // redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        // failed to delete admin
        // echo "Failed to Delete Admin";
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');

    }

    // 3. redirect to manage admin page with message (success/error)


?>