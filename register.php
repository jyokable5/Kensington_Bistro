<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $email = $password = $confirm_password = "";
$name_err = $email_err =  $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["name"]))){
        $name_err = "name can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $name_err = "This username is already taken.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    // Validate EMAIL
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["name"]))){
        $email_err = "email can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }


    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (name,email, password) VALUES (?, ?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_name, $param_email, $param_password);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
    width: 400px;
    height: 580px;
    background: radial-gradient(rgba(255,255,255,0.6));
    box-shadow: 5px 5px 50px rgba(0,0,0,0.6);
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
    margin-left: 60px;
}
h3{
    font-size: 20px;
    margin-bottom: 5px;
    margin-top: 1px;
    cursor: pointer;
}
h2{
    font-size: 30px;
    margin-top: 5px;
    margin-left: 150px;
    
}
h5{
    font-size: 10px;
    margin-top: 20px;
    margin-left: 100px;
    
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
    padding-bottom: 10px;
    margin-bottom: 10px;
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
.button{
    font-size: 12px;
    padding: 6px 12px;
    margin-top: 10px;
    border-radius: 10px;
    outline: none;
    border: none;
    color: #fff;
    background: rgb(45, 146, 177);
    margin-left: 90px;
    cursor: pointer;
    transition: 0.3s ease;
}
.button:hover{
    color: #000;
    background: rgb(20, 183, 183);
}
select{
    font-size: 12px;
    padding: 6px 12px;
    margin-top: 20px;
    border-radius: 10px;
    outline: none;
    border: none;
    color: #fff;
    background: rgb(45, 146, 177);
    margin-left: 160px;
    cursor: pointer;
    transition: 0.3s ease;
}
select:hover{
    color: #000;
    background: rgb(20, 183, 183);
}
</style>

    <meta charset="UTF-8">
    <meta http-equiv ="X-UA-Compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=0">
    <title>Register form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="login-box">
      <img src="minion.jpg">
        <h2>Sign Up</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <h3>Name</h3>
                <input type="text" name="name" placeholder="Your Name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>   
            <div class="form-group">
                <h3>Email</h3>
                <input type="email" name="email" placeholder="@gmail.com" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group">
                <h3>Password</h3>
                <input type="password" name="password" placeholder="password" id="pass" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <i class="fa fa-eye" onclick="see()"></i>
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <h3>Confirm Password</h3>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
               <select name="user_type">
                <option value="user">User</option>
                <option value="admin">Admin</option></select>
            </div>
            <div class="form-group">
               
                <input type="submit" class="button" value="Submit">
                <input type="reset" class="button" value="Reset">
               
            </div>
            
            <h5>Already have an account? <a href="login.php">Login here</h5>.</p>

           <script>
             function see(){
             var x= document.getElementById("pass");
             if(x.type == "password"){
                x.type = "text";
               }
             else{
                x.type="password"
              }
             }
          </script>
        </form>
    </div>    
</body>
</html>