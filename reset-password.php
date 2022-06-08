<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
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
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
</head>
<body>
    <div class="login-box">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <h3>New Password</h3>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <h3>Confirm Password</h3>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <button type="button">SUBMIT</button>
                <button type="button" href="welcome.php">Cancel
            </div>
        </form>
    </div>    
</body>
</html>