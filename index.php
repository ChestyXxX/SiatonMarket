<?php include('partials-front/menu.php'); ?>

    <!-- Supply Search section Starts here -->
    <section class="supply-search text-center">
        <div class="container">

            <form action="<?php echo SITEURL; ?>supply-search.php" method="GET">
                <input type="search" name="search" placeholder="Search for Supplies..." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Supply Search section Ends here -->

    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

    <!-- Categories section Starts here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Categories</h2>

            <?php

                // Create SQL Query to display categories from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
                // Execute the Query
                $res = mysqli_query($conn, $sql);

                // Count rows to check whether the category is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    // Category available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        // get the values like id, title, image_name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL; ?>category-supply.php?category_id=<?php echo $id; ?>">

                            <div class="box-3 float-container">
                                <?php
                                    // check whether image is available or not
                                    if($image_name=="")
                                    {
                                        // display message
                                        echo "<div class='error'>Image Not Available</div>";
                                    }
                                    else
                                    {
                                        // image available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Input" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>

                                <h3 class="text-center text-blue"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else
                {
                    // Categories not available
                    echo "<div class='error'>Category not Added</div>";
                }

            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Search section Ends here -->

    <!-- Supplies section Starts here -->
    <section class="supplies">
        <div class="container">
            <h2 class="text-center">Explore Supplies</h2>

            <?php

            // Getting Supplies from DB that are active and featured
            // SQL Query
            $sql2 = "SELECT * FROM tbl_supply WHERE active='Yes' AND featured='Yes' LIMIT 6";

            // Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            // Count Rows
            $count2 = mysqli_num_rows($res2);

            // Check whether food available or not
            if($count2>0)
            {
                // Food Available
                while($row=mysqli_fetch_assoc($res2))
                {
                    // Get all the values
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>

                    <div class="supplies-box">
                        <div class="supplies-img">
                            <?php
                                // check whether image available or not
                                if($image_name=="")
                                {
                                    // Image Not Available
                                    echo "<div class='error'>Image not Available</div>";
                                }
                                else
                                {
                                    // Image Available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/supply/<?php echo $image_name ?>" alt="GTX300" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>

                        </div>

                            <div class="supplies-description">
                                <h4><?php echo $title; ?></h4>
                                <p class="price">₱<?php echo $price; ?></p>
                                <p class="details">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                        <a href="<?php echo SITEURL; ?>order.php?supply_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                    </div>

                    <?php
                }
            }
            else
            {
                // Products not Available
                echo "<div class='error'>Products Not Available</div>";
            }
            ?>


            <div class="clearfix"></div>
        </div>



        <p class="text-center">
            <a href="<?php echo SITEURL; ?>supplies.php">See All Supplies</a>
        </p>



    </section>

    <!-- Supplies Search section Ends here -->

   <?php include('partials-front/footer.php'); ?>