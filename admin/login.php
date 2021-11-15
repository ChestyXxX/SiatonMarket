<?php include('../config/constants.php');?>

<html>
    <head>
        <title>Login - Computer Supplies</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>

        <div class="login">
        <h1 class="text-center">Login</h1>
        <br> <br>

        <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        <br> <br>

        <!-- Login form starts here-->
        <form action="" method="POST" class="text-center">
        Username: <br>
        <input type="text" name="username" placeholder="Enter Your Username"> <br> <br>

        Password: <br>
        <input type="password" name="password" placeholder="Enter Your Password"> <br> <br>

        <input type="submit" name="submit" value="Login" class="btn-primary">
        <br> <br>
        </form>
        <!-- Login form ends here-->

        <p class="text-center">Created By - <a href="https://www.facebook.com/Chesty.143/">Alchester Saberon</a></p>
        </div>

    </body>
</html>

<?php
    // check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        // Process for login
        // 1. Get the data from login form
        //$username = $_POST['username'];
        //$password = md5($_POST['password']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);


        // 2. SQL to check whether te user with username and password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        // 3. Execute the query
        $res = mysqli_query($conn, $sql);

        // 4. Count rows to check whether the user exist or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            // user available and login success
            $_SESSION['login'] = "<div class='success'>Login Successful</div>";
            $_SESSION['user'] = $username; // To check whether the user is logged in and log out with unset

            // redirect to home page/dashbord
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            // user not available and login failed
            $_SESSION['login'] = "<div class='error text-center'>Login Failed</div>";
            // redirect to home page/dashbord
            header('location:'.SITEURL.'admin/login.php');
        }

    }
?>