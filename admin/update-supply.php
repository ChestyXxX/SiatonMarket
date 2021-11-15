<?php include('partials/menu.php'); ?>

<?php
    // check whether id is set or not
    if(isset($_GET['id']))
    {
        // get all the details
        $id = $_GET['id'];

        // SQL Query to get the selected supplu
        $sql2 = "SELECT * FROM tbl_supply WHERE id=$id";
        // Execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //Get the value based on Query executed
        $row2 = mysqli_fetch_assoc($res2);

        // Get the individual values of selected supply
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        // redirect to manage supply
        header('location:'.SITEURL.'admin/manage-supply.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Supply</h1>
        <br> <br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image == "")
                            {
                                //image not available
                                echo "<div class='error'>Image Not Available.</div>";
                            }
                            else
                            {
                                //image available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/supply/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                        <?php
                            // Query to get active categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            // Execute the query
                            $res = mysqli_query($conn, $sql);
                            // Count Rows
                            $count = mysqli_num_rows($res);

                            // check whether category available or not
                            if($count>0)
                            {
                                // category available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    //echo "<option value='$category_id'>$category_title</option>";
                                    ?>
                                    <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id ?>"><?php echo $category_title ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                // category not available
                                echo "<option value='0'>Category Not Available</option>";
                            }

                        ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Supply" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php

            if(isset($_POST['submit']))
            {
                // echo "Button Clicked";

                // 1. Get all the details from the form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2. Upload the image if selected

                // checl whether upload button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    // upload button clicked
                    $image_name = $_FILES['image']['name']; // New Image Name

                    // check whether the file is available or not
                    if($image_name!="")
                    {
                        // image is available
                        // A. Uploading new image
                        // rename the image
                        $ext = end(explode('.', $image_name)); // get the extension of the image
                        $image_name = "Supply-Name".rand(0000, 9999).'.'.$ext; // this will be rename image

                        // get the source path and destination path
                        $src_path = $_FILES['image']['tmp_name']; // Source path
                        $dest_path = "../images/supply/".$image_name; // Destination path

                        // upload the image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        // check whether image is uploaded or not
                        if($upload==false)
                        {
                            // failed to upload
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image</div>";
                            // redirect to manage supply
                            header('location:'.SITEURL.'admin/manage-supply.php');
                            // stop the process
                            die();
                        }

                        // 3.  Remove the image if new image is uploaded and current image exists
                        // B. Remove current image if available
                        if($current_image!="")
                        {
                            // current image is available
                            // remove the image
                            $remove_path = "../images/supply/".$current_image;

                            $remove = unlink($remove_path);

                            // check whether the image is removed or not
                            if($remove==false)
                            {
                                // failed to remove image
                                $_SESSION['remove_failed'] = "<div class='error'>Failed to Remove Current Image</div>";
                                // redirect to manage supply
                                header('location:'.SITEURL.'admin/manage-supply.php');
                                // stop the process
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image; // Default Image when Image is not Selected
                    }
                }
                else
                {
                    $image_name = $current_image; // Default Image when button is not clicked
                }

                // 4. Update the food in database
                $sql3 = "UPDATE tbl_supply SET
                    title = '$title',
                    description = 'description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                // Execute the SQL Query
                $res3 = mysqli_query($conn, $sql3);

                // Check whether the query is executed or not
                if($res3==true)
                {
                    // Query executed and supply updated
                    $_SESSION['update'] = "<div class='success'>Supply Updated Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-supply.php');
                }
                else
                {
                    // Failed to Update Food
                    $_SESSION['update'] = "<div class='error'>Failed to Update Supply</div>";
                    header('location:'.SITEURL.'admin/manage-supply.php');
                }

            }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>