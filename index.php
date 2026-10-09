<?php
require 'connect.php';
//login
if(isset($_POST['login-submit']))
{
    $email=$_POST['email'];
    $pwd=$_POST['password'];
    $sql = "SELECT * FROM user WHERE Email='".$email."' AND Password='".$pwd."'";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)==1)
    {
        session_start();
        $_SESSION['user_email']=$_POST['email'];
        $_SESSION['user_password']=$_POST['password'];          
        $_SESSION['status']="loggedin";
        // header("location:home.php?status=loggedin");    
        header("location:dashboard.php");    
    }
    else
    {
        echo "<script type='text/javascript'>alert('Invalid Login Credentials'); window.location='index.php'</script>"; 
    }   
 }

//register
if(isset($_POST['register-submit']))
{
    $fname=$_POST['firstname'];
    $lname=$_POST['lastname'];
    $email=$_POST['userEmail'];
    $p1=$_POST['userPassword'];
    $p2=$_POST['confirm-password'];
    if($p1===$p2)
    {
        $check = "SELECT Email FROM user where Email='".$email."'";
        $result = mysqli_query($conn, $check);
        if (mysqli_num_rows($result) > 0) 
        {
            echo "<script type='text/javascript'>alert('User already exists! Please login to continue.'); window.location='index.php'</script>";
        }
        else
        {
            $sql = "INSERT INTO user (FirstName,LastName,Email,Password) VALUES ('".$fname."','".$lname."','".$email."','".$p1."')";
            if ($conn->query($sql) === TRUE) 
            {
                echo "<script type='text/javascript'>alert('Registration Successful!'); window.location='dashboard.php'</script>";
            } 
            else 
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
    else
    {
        echo "<script type='text/javascript'>alert('Passwords do not match.'); window.location='index.php'</script>";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Diary - Pour Your Heart Out!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="images/logo.png">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg auth-page">
<main class="auth-shell">
    <section class="brand-panel">
        <img src="images/logo.png" class="brand-logo" alt="Diary logo">
        <p class="eyebrow">Personal Diary</p>
        <h1>Diary</h1>
        <p class="brand-line">Pour Your Heart Out!</p>
    </section>

    <section class="tabs auth-card">
        <ul class="tab-group">
            <li class="tab active" id="loginTab"><a href="#login">Login</a></li>
            <li class="tab" id="registerTab"><a href="#signup">Register</a></li>
        </ul>

        <form action="#" id="login-form" method="POST">
            <h2>Welcome back</h2>
            <div class="form-group">
                <p class="label">
                    <span>Email</span>
                    <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="name@example.com" value="" required>
                </p>
            </div>
            <div class="form-group">
                <p class="label">
                    <span>Password</span>
                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Enter password" required>
                </p>
            </div>
            <div class="form-group">     
                <input type="submit" name="login-submit" class="btn btn-primary btn-block" id="login-submit" tabindex="4" value="Log In">
            </div>
        </form>

        <form action="#" id="register-form" method="POST">
            <h2>Create account</h2>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <p class="label">
                        <span>First Name</span>
                        <input type="text" name="firstname" id="firstname" tabindex="1" class="form-control" placeholder="First name" value="" required>
                    </p>
                </div>
                <div class="form-group col-md-6">
                    <p class="label">
                        <span>Last Name</span>
                        <input type="text" name="lastname" id="lastname" tabindex="1" class="form-control" placeholder="Last name" value="" required>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <p class="label">
                    <span>Email</span>
                    <input type="email" name="userEmail" id="userEmail" tabindex="2" class="form-control" placeholder="name@example.com" value="" required>
                </p>
            </div>
            <div class="form-group">
                <p class="label">
                    <span>Password</span>
                    <input type="password" name="userPassword" id="userPassword" tabindex="2" class="form-control" placeholder="Create password" required>
                </p>
            </div>
            <div class="form-group">
                <p class="label">
                    <span>Re-enter Password</span>
                    <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm password" required>
                </p>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" name="register-submit" id="register-submit" tabindex="4" value="Register">
            </div>
        </form>
    </section>
</main>

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script type="text/javascript">
        
    var login = document.getElementById("login-form");
    var register = document.getElementById("register-form");
    var loginBtn = document.getElementById("loginTab");
    var registerBtn = document.getElementById("registerTab");
    window.onload=function(){
        login.style.display= "block";
        register.style.display= "none";
    }
    loginBtn.addEventListener("click", function(){
        login.style.display= "block";
        register.style.display= "none";
        loginBtn.classList.add("active");
        registerBtn.classList.remove("active");
    });
    registerBtn.addEventListener("click", function(){
        login.style.display= "none";
        register.style.display= "block";
        registerBtn.classList.add("active");
        loginBtn.classList.remove("active");

    });
</script>
</html>
