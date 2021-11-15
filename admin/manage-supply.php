<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
    <h1>Manage Supply</h1>
    <br /> <br />

            <!-- Button to add admin-->
            <a href="<?php echo SITEURL; ?>admin/add-supply.php" class="btn-primary">Add Supply</a>

            <br /> <br /> <br />

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }

                if(isset($_SESSION['unauthorize']))
                {
                    echo $_SESSION['unauthorize'];
                    unset($_SESSION['unauthorize']);
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php

                // Create SQL Query to get all the supply
                $sql = "SELECT * FROM tbl_supply";

                // Execute the Query

                $res = mysqli_query($conn, $sql);

                // Count rows to check whether we have food or not
                $count = mysqli_num_rows($res);

                // Create serial number variable and set default value as 1
                $sn=1;

                if($count>0)
                {
                    // we have supply in database
                    // get the food in database and display
                    while($row=mysqli_fetch_assoc($res))
                    {
                        // get the value from individual columns
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td>₱<?php echo $price; ?></td>
                            <td>
                                <?php
                                // check whether we have image or not
                                if($image_name=="")
                                {
                                    // we do not have image display error message
                                    echo "<div class='error'>Image Not Added</div>";
                                }
                                else
                                {
                                    // we have image, we need to display
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/supply/<?php echo $image_name; ?>" width="100px">
                                    <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-supply.php?id=<?php echo $id; ?>" class="btn-secondary">Update Supply</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-supply.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Supply</a>
                            </td>
                        </tr>

                        <?php
                    }
                }
                else
                {
                    // supplu not added in databse
                    echo "<tr><td colspan='7' class='error'> Supply Not Added Yet </td></tr>";
                }
                ?>


            </table>
    </div>
</div>

<?php include('partials/footer.php');?>