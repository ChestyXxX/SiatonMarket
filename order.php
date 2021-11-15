<?php include('partials-front/menu.php'); ?>

    <?php
        // Check whether supply id is set or not
        if(isset($_GET['supply_id']))
        {
            // Get the Supply ID and details of the selected food
            $supply_id = $_GET['supply_id'];

            // get the details of the seleted Supply
            $sql = "SELECT * FROM tbl_supply WHERE id=$supply_id";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Count the Rows
            $count = mysqli_num_rows($res);

            // Check whether the data is available or not
            if($count==1)
            {
                // we have data
                // get the data from DB
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else
            {
                // Supply not available
                // redirect to homepage
                header('location:'.SITEURL);
            }
        }
        else
        {
            // Redirect to hompage
            header('location:'.SITEURL);
        }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="supply-search">
        <div class="container">

            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Supply</legend>

                    <div class="supplies-img">
                        <?php
                            // check whether the image is available or not
                            if($image_name=="")
                            {
                                // image not available
                                echo "<div class='error'>Image Not Available</div>";
                            }
                            else
                            {
                                // image is available
                                ?>
                                <img src="<?php echo SITEURL; ?>images/supply/<?php echo $image_name; ?>" alt="GTX300" class="img-responsive img-curve">
                                <?php
                            }
                        ?>

                    </div>

                    <div class="supplies-description">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="supply" value="<?php echo $title; ?>">
                        <p class="price">₱<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>

                    </div>

                </fieldset>

                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Chesty Padilla" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 09xxxxxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. ily143@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                // Check whether submit button is clicked or not
                if(isset($_POST['submit']))
                {
                    // Get all the details from the form

                    $supply = $_POST['supply'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty; // total = price x qty

                    $order_date = date("Y-m-d h:i:sa"); // Order date

                    $status = "Ordered"; // Ordered, On Delivery, Delivered, Cancelled
                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    // save the order in DB
                    // Create SQL to save the data
                    $sql2 = "INSERT INTO tbl_order SET
                        supply = '$supply',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    // Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    // Check whether query is executed successfully
                    if($res2==true)
                    {
                        // Query Execute and order saved
                        $_SESSION['order'] = "<div class='success text-center'>Supply Ordered Successfully</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        // Failed to save order
                        $_SESSION['order'] = "<div class='error text-center'>Failed to Order</div>";
                        header('location:'.SITEURL);
                    }
                }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>