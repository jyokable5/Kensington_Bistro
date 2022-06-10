<?php

   $connection = mysqli_connect('localhost','root','','book_db');

   if(isset($_POST['send'])){
      $name = $_POST['name'];
      $email = $_POST['email'];
      $phone = $_POST['phone'];
      $guests = $_POST['guests'];
      

      $request = " insert into book_form(name, email, phone, guests) values('$name','$email','$phone','$address','$guests') ";
      mysqli_query($connection, $request);

      header('location:book.php'); 

   }else{
      echo 'something went wrong please try again!';
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
        <h2>Book a table</h2>
        <img src="minion.jpg">
        
            <div class="form-group">
                <h3>Name</h3>
                <input type="text" name="name" placeholder="Your Name" class="form-control">
               
            </div>   
            <div class="form-group">
                <h3>Email</h3>
                <input type="email" name="email" placeholder="@gmail.com" class="form-control">
            </div> 
            <div class="form-group">
                <h3>Phone</h3>
                <input type="text" name="phone" placeholder="1234445" class="form-control">
            </div> 
            <div class="form-group">
                <h3>Guests</h3>
                <input type="text" name="guest" placeholder="Enter no of ppl" class="form-control">
            </div> 


            <div class="form-group">
                <button type="button">SUBMIT</button>
            </div>
            
        </form>
    </div>
</body>
</html>