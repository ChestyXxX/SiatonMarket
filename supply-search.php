<?php include('partials-front/menu.php'); ?>

    <!-- supply sEARCH Section Starts Here -->
    <section class="supply-search text-center">
        <div class="container">
            <?php

                // Get the Search Keyword
                $search = mysqli_real_escape_string($conn, $_GET['search']);

            ?>

            <h2>Supplies on Your Search <a href="#" class="text-blue">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- supply sEARCH Section Ends Here -->



    <!-- supply MEnu Section Starts Here -->
    <section class="supplies">
        <div class="container">
            <h2 class="text-center">Supplies</h2>

            <?php

            // SQL Query to get supply base on search keyword
            // $search = Keyboard '; DROP database name;
            // "SELECT * tbl_supply WHERE title LIKE '%Keyboard'%' OR description LIKE '%Keyboard'%'";
            $sql = "SELECT * FROM tbl_supply WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Count Rows
            $count = mysqli_num_rows($res);

            // Check whether supply available or not
            if($count>0)
            {
                // Food Available
                while($row=mysqli_fetch_assoc($res))
                {
                    // Get the details
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>

                    <div class="supplies-box">
                        <div class="supplies-img">
                            <?php
                                // Check whether image name is available or not
                                if($image_name=="")
                                {
                                    // Image Not Available
                                    echo "<div class='error'>Image Not Available</div>";
                                }
                                else
                                {
                                    // Image Available
                                    ?>
                                    <img src="<?php echo SITEURL;?>images/supply/<?php echo $image_name; ?>" alt="GTX300" class="img-responsive img-curve">
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

                        <div class="clearfix"></div>
                    </div>


                    <?php
                }
            }
            else
            {
                // Supply Not Available
                echo "<div class='error'>Supply Not Found</div>";
            }
            ?>

            <div class="clearfix"></div>



        </div>

    </section>
    <!-- Supply Menu Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>