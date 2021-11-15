<?php
    // include constants page
    include('../config/constants.php');
    //echo "Delete Food Page";

    if(isset($_GET['id']) && isset($_GET['image_name'])) // either use && or AND
    {
        // Process to Delete
        //echo "Process to Delete";

        // 1. Get ID and image ame
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // 2. Remove the image if available
        // check whether the image is available or not, delete only if available
        if($image_name != "")
        {
            // it has image and need to be deleted from folder
            // get the image path
            $path = "../images/supply/".$image_name;

            // remove image file from folder
            $remove = unlink($path);

            // check whether the image is removed or not
            if($remove == false)
            {
                // failed to remove image
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File</div>";
                // redirect to manage supply
                header('location:'.SITEURL.'admin/manage-supply.php');
                // stop the process of deleting supply
                die();
            }
        }

        // 3. Delete supply from database
        $sql = "DELETE FROM tbl_supply WHERE id=$id";
        // Execute the Query
        $res = mysqli_query($conn, $sql);

        // Check whether the query is executed or not and set the session message
        // 4. Redirect to manage supply with session manage
        if($res==true)
        {
            // Supply Deleted
            $_SESSION['delete'] = "<div class='success'>Supply Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-supply.php');
        }
        else
        {
            // Failed to Delete supply
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Supply</div>";
            header('location:'.SITEURL.'admin/manage-supply.php');
        }


    }
    else
    {
        // Redirect to Manage Supply Page
        //echo "Redirect";
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-supply.php');
    }
?>