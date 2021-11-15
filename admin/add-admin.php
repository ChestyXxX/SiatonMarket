<?php include('partials/menu.php');?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br /> <br />

        <?php
            if(isset($_SESSION['add'])) // Checking whether the session is set or not
            {
                echo $_SESSION['add']; //display session message if set
                unset($_SESSION['add']); //remove session message
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Your Username">
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php');?>


<?php
    //Process the value from form and save it in Database

    //Check whether the button is clicked or not

    if(isset($_POST['submit']))
    {
        // Button Clicked
        //echo "Button Clicked";

        // 1. Get Data from Form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password); //Password Encryption with MD5

        // 2. SQL Query to save data to Database
        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";


        // 3. Executing Query and saving data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // 4. Check whether the query is executed data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            // Data inserted
            //echo "Data Inserted";
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
            //Redirect Page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // Failed to insert data
            //echo "Failed to Insert Data";
            // Create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
            //Redirect Page to Add Admin
            header("location:".SITEURL.'admin/add-admin.php');
        }

    }
?>