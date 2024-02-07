<?php 
include 'konek.php';
session_start();
if(isset($_POST['login'])){
$username=$_POST['username'];
$password=$_POST['password'];
$email=$_POST['email'];


if($username!="" && $password!="" && $email!=""){
  $query=mysqli_query($koneksi, "select * from admin  where username='$username'  and password='$password' and email='$email'"); 
  if($data = mysqli_fetch_array($query)){
    $_SESSION['username']=$data['username'];
    $_SESSION['password']=$data['password'];
    $_SESSION['email']=$data['email'];
    header('Location:coba.php');
  
               
  
}else {
  echo'<script language="javascript">
  alert("password kamu salah! silahkan login ulang"); document.location="login_admin.php";</script>';
  
  
   }
}
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Document</title>
</head>
<body>
<div class="parent clearfix">
    <div class="bg-illustration">
      

      <div class="burger-btn">
        <span></span>
        <span></span>
        <span></span>
      </div>

    </div>
    
    <div class="login">
      <div class="container">
        <h1>Login For Admin <br /></h1>
    
        <div class="login-form">
          <form action="login_admin.php" method="post">
            <input type="text " placeholder="Ussername" name="username">
            <input type="password" placeholder="Password" name="password">
            <input type="text" placeholder="E-mail Address" name="email">

            <div class="remember-form">
              <input type="checkbox">
              <span>Remember me</span>
            </div>
            <div class="forget-pass">
              <a href="#"></a><br><br>
              <a href=""></a>

            </div>

            <button type="submit" name="login" value="login">Login</button>

          </form>
        </div>
    
      </div>
      </div>
  </div>
</body>
</html>