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
    
   
    .container{
        min-height: 20vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        padding-bottom: 60px;
    }
    .container .content{
        text-align: center;
    }
    .container .content h3{
        font-size: 30px;
        color:rgb(2, 80, 7);

    }
    .container .content .btn{
        display: inline-block;
        padding: 10px 10px;
        font-size: 20px;
        background: rgba(17, 88, 131, 0.674);
        color: rgb(6, 97, 46);
        border-radius: 10px;
        outline: none;
        border: none;
        color: rgb(253, 253, 253);
        margin-left: 50px;
        cursor: pointer;
        transition: 0.3s ease;
    }
    .container .content .btn:hover{
        background: rgb(87, 232, 217);
    }

    </style>

    <meta charset="UTF-8">
    <meta http-equiv ="X-UA-Compatible" content="IE=edge" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="login-box">
       <img src="minion.jpg">
    
    <div class="container">
        <div class="content">
            <h3>Hello Admin!</h3><br/>
            <a href="login.php" class="btn">Login</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="register.php" class="btn">Register</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="logout.php" class="btn">Log out</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
    </div>
    </div>
</body>
</html>