<?php include('partials-front/menu.php'); ?>

    <!-- Supply sEARCH Section Starts Here -->
    <section class="supply-search text-center">
        <div class="container">

            <form action="<?php echo SITEURL; ?>supply-search.php" method="GET">
                <input type="search" name="search" placeholder="Search for Supplies..." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Supply SEARCH Section Ends Here -->



    <!-- Supply MEnu Section Starts Here -->
    <section class="supplies">
        <div class="container">
            <h2 class="text-center">Supplies</h2>

            <?php
                // Display Food that are active
                $sql = "SELECT * FROM tbl_supply WHERE active='Yes'";

                // Execute the Query
                $res = mysqli_query($conn, $sql);

                // Count Rows
                $count = mysqli_num_rows($res);

                // check whether supply is available or not
                if($count>0)
                {
                    // Supply Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        // Get the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        ?>

                        <div class="supplies-box">
                             <div class="supplies-img">
                                 <?php
                                    // check whether image available or not
                                    if($image_name=="")
                                    {
                                        // Image not Available
                                        echo "<div class='error'>Image Not Available</div>";
                                    }
                                    {
                                        // Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/supply/<?php echo $image_name; ?>" alt="GTX300" class="img-responsive img-curve">
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
                    // Supply Not Available
                    echo "<div class='error'>Supply Not Found</div>";
                }
            ?>





            <div class="clearfix"></div>



        </div>

    </section>
    <!-- Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>