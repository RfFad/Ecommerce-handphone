<?php 
include 'konek.php';
session_start();
if(isset($_POST['register'])){
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];
$no_hp=$_POST['no_hp'];
$alamat=$_POST['alamat'];


if($username!="" && $email!="" && $password!="" && $no_hp!="" && $alamat!=""){
  $query=mysqli_query($koneksi, "INSERT INTO login(username,email,password,no_hp,alamat) VALUES ('$username','$email','$password','$no_hp','$alamat')") ; 
  if($query){
    
    header('Location:login.php');
  }  
               
  
}else {
  echo'<script language="javascript">
  alert("ada yang belum terisi!"); document.location="register.php";</script>';
  
  
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
    <style>
        .forget-pass{
position: relative;
bottom: 10px;
        }
    </style>
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
        <h1>SIG IN<br />YOUR ACCOUNT</h1>
    
        <div class="login-form">
          <form action="register.php" method="post">
            <input type="text" placeholder="username" name="username">
            <input type="text" placeholder="E-mail Address" name="email">
            <input type="password" placeholder="Password" name="password">
            <input type="text" placeholder="nomer_hp" name="no_hp">
            <input type="text" placeholder="alamat" name="alamat">

            
              <div class="forget-pass" style="bottom: 80px; font-size:50px; ">
              <h3><a href="login.php">Login</a></h3>
              </div>
          
            
            <button type="submit" name="register" value="register">Register</button>
            
        </form>
       
    </div>
    
      </div>
      </div>
  </div>
</body>
</html>