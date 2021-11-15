<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Supply</h1>

        <br> <br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
             <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" placeholder="Title of Supply">
                </td>
             </tr>

             <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5" placeholder="Description of the Supply"></textarea>
                </td>
             </tr>

             <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price">
                </td>
             </tr>

             <tr>
                <td>Select Image: </td>
                <td>
                    <input type="file" name="image">
                </td>
             </tr>

             <tr>
                <td>Category: </td>
                <td>
                    <select name="category">

                        <?php
                            // Create PHP code to display categories from database
                            // 1. Create sql to get all active categories from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                            // Executing Query
                            $res = mysqli_query($conn, $sql);

                            // Count rows to check whether we have categories or not
                            $count = mysqli_num_rows($res);

                            // if count is greater than 0 we have categories
                            if($count>0)
                            {
                                // we have categories
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    // get the details of categories
                                    $id = $row['id'];
                                    $title = $row['title'];

                                    ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                    <?php

                                }
                            }
                            else
                            {
                                // we don't have categories
                                ?>

                                <option value="0">No Categories Found</option>

                                <?php
                            }

                            // 2. Display on dropdown
                        ?>

                    </select>
                </td>
             </tr>

             <tr>
                <td>Featured: </td>
                <td>
                    <input type="radio" name="featured" value="Yes"> Yes
                    <input type="radio" name="featured" value="No"> No
                </td>
             </tr>

             <tr>
                <td>Active: </td>
                <td>
                    <input type="radio" name="active" value="Yes"> Yes
                    <input type="radio" name="active" value="No"> No
                </td>
             </tr>

             <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Supply" class="btn-secondary">
                </td>
             </tr>
            </table>
        </form>

        <?php

        // Check whether the button is clicked or not
        if(isset($_POST['submit']))
        {
            // Add the supply in database
            // echo "Clicked";

            // 1. Get the data from Form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // check whether radio button for featured and active are checked or not
            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
            }
            else
            {
                $featured = "No"; // setting the default value
            }
            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else
            {
                $active = "No"; // setting the default value
            }

            // 2. Upload the image if selected
            // check whether the select image is clicked or not and upload the image only if the image is selected
            if(isset($_FILES['image']['name']))
            {
                // get the details of the selected image
                $image_name = $_FILES['image']['name'];

                // check whether the image is selected or not, upload image only if selected
                if($image_name!="")
                {
                    // image is selected
                    // A. Rename the image
                    // get the extension of the selected image (jpg, png, etc.)
                    $ext = end(explode('.', $image_name));

                    // Create new name for image
                    $image_name = "Supply-Name".rand(0000, 9999).".".$ext; // New Image name "Supply-Name-1200.jpg"

                    // B. Upload the image
                    // get the source path and destination path

                    // Source path is the current location of the image
                    $src=$_FILES['image']['tmp_name'];

                    // Destination path for the image to be uploaded
                    $dst = "../images/supply/".$image_name;

                    // Finally upload the image
                    $upload = move_uploaded_file($src, $dst);

                    // check whether image uploaded or not
                    if($upload==false)
                    {
                        // Failed to upload the image
                        // Redirect to Add Supply page with error message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                        header('location:'.SITEURL.'admin/add-supply.php');
                        // Stop the process
                        die();
                    }
                }
            }
            else
            {
                $image_name = ""; // setting te default value as blank
            }

            // 3. Insert into Database

            // Create sql query to save or add supply
            // for numerical value we do not need to pass value inside quotes '' but for string value vice versa
            $sql2 = "INSERT INTO tbl_supply SET
                title = '$title',
                description = '$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
            ";

            // Execute the Query
            $res2 = mysqli_query($conn, $sql2);
            //check whether data is inserted or not

            // 4. Redirect with message to manage supply page

            if($res2 == true)
            {
                // Data inserted successfully
                $_SESSION['add'] = "<div class='success'>Supply Added Sucessfulluy</div>";
                header('location:'.SITEURL.'admin/manage-supply.php');
            }
            else
            {
                // Failed to insert data
                $_SESSION['add'] = "<div class='error'>Failed to Add Supply</div>";
                header('location:'.SITEURL.'admin/manage-supply.php');
            }

        }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>