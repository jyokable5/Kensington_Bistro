<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $email = $password = "";
$name_err =  $email_err =  $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if NAME is empty
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter name.";
    } else{
        $name = trim($_POST["name"]);
    }
    // Check if EMAIL is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }    
    // Check if PASSWORD is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($name_err) && empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, name,email password FROM users WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = $name;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $name, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body{
            background-image:url(mistMount.jpg);
            background-position: center;
            background-size: cover;
            height: 95vh;
            display:flex;
            align-items:center;
            justify-content:center;
            font-family:Arial;
        }
        .login-box{
        width: 320px;
        height: 390px;
        background: radial-gradient(rgba(255,255,255,0.6));
        box-shadow: 5px 10px 20px rgba(0,0,0,0.6);
        backdrop-filter: blur(3px);
        border-radius:30px;
    }
    
    img{
        width: 90px;
        height: 90px;
        margin-left: 37%;
        font-size: 22px;
    }
    
    h3,input{
        margin-left: 30px;
    }
    h3{
        font-size: 20px;
        margin-bottom: 5px;
        cursor: pointer;
    }
    input{
        width:70%;
        height: 15px;
        outline:none;
        border-top: none;
        border-left: none;
        border-right: none;
        background: transparent;
        border-bottom: solid teal;
        color: #000;
        font-size: 15px;
        letter-spacing: 1px;
        font-family: Arial;
        padding-bottom: 1px;
        margin-bottom: 1px;
        transition: 0.3s ease;
    }
    input:hover{
        border-bottom: solid rgb(161, 103, 8);
    }
    ::placeholder{
        color: black;
    }
    i{
        color: #fff;
        margin-left: -20px;
    }
    button{
        font-size: 12px;
        padding: 6px 12px;
        margin-top: 10px;
        border-radius: 10px;
        outline: none;
        border: none;
        color: #fff;
        background: rgb(45, 146, 177);
        margin-left: 50px;
        cursor: pointer;
        transition: 0.3s ease;
    }
    button:hover{
        color: #000;
        background: rgb(20, 183, 183);
    }
    </style>

    <meta charset="UTF-8">
    <meta http-equiv ="X-UA-Compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <img src="minion.jpg">
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <h3>Name</h3>
                <input type="text" name="name" placeholder="Your Name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>   
            <div class="form-group">
                <h3>Email</h3>
                <input type="email" name="email" placeholder="@gmail.com" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group">
                <h3>Password</h3>
                <input type="password" name="password" placeholder="password" id="pass" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <button type="button">SUBMIT</button>
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>