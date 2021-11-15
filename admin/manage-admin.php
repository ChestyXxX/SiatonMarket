<?php include('partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="main-content">
        <div class="wrapper">
            <h1>Manage Admin</h1>
            <br /> <br />

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add']; //Displaying Session Message
                    unset($_SESSION['add']); //Removing Session Message
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

                if(isset($_SESSION['user-not-found']))
                {
                    echo $_SESSION['user-not-found'];
                    unset($_SESSION['user-not-found']);
                }

                if(isset($_SESSION['pwd-not-match']))
                {
                    echo $_SESSION['pwd-not-match'];
                    unset($_SESSION['pwd-not-match']);
                }

                if(isset($_SESSION['change-pwd']))
                {
                    echo $_SESSION['change-pwd'];
                    unset($_SESSION['change-pwd']);
                }

            ?>

            <br /> <br /> <br />

            <!-- Button to add admin-->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>

            <br /> <br /> <br />

            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <?php
                    //Query to get all admin
                    $sql = "SELECT * FROM tbl_admin";
                    //Execute the Query
                    $res = mysqli_query($conn, $sql);

                    //chechk whether the Query is executed or not
                    if($res==TRUE)
                    {
                        //Count Rows to check wheteher we have data in database
                        $count = mysqli_num_rows($res); // get all the rows in database

                        $sn=1; //Create a variable and assign the value

                        //Check the num of rows
                        if($count>0)
                        {
                            // we have data
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                //using while loop to get all the data from database
                                // while loop while run as long as we have data

                                //get individual data
                                $id=$rows['id'];
                                $full_name=$rows['full_name'];
                                $username=$rows['username'];

                                //Display the values in our table
                                ?>

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                    <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                     </td>
                                </tr>
                                <?php
                            }
                        }
                        else
                        {
                            // we don't have data
                        }
                    }
                ?>




            </table>
        </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>