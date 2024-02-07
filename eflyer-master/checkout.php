<?php
include '../konek.php';
session_start();
if(!isset($_SESSION['email'])){
   echo'<script language="javascript">
   alert("login dulu lah cuy"); document.location="../login.php";</script>'; 
  
}

if(isset($_POST['order'])){
$nama=$_POST['nama'];
$alamat=$_POST['alamat'];
$kota=$_POST['kota'];
$kode_pos=$_POST['kode_pos'];
$no_hp=$_POST['no_hp'];
$email=$_POST['email'];

if($nama!="" && $alamat!="" && $kota!="" && $email!="") {
$query=mysqli_query($koneksi, "INSERT INTO checkout (nama,alamat,kota,kode_pos,no_hp,email)VALUES('$nama','$alamat','$kota','$kode_pos','$no_hp','$email')"); 
if($query){
  header("Location:perulangan.php");
}


}
else{
  echo '<script language="javascript">alert("isi yang kosong!!!");</script>';
 
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <style>
      a{
        color: red;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
    bottom: 30px;
    font-size: 30px;
    text-decoration: none;
}
img{
  width: 100px;
}

    </style>
</head>
<body>
  <?php 
  
  ?>
<div class="container">
<a href="perulangan.php"><span class="close">&#10005;</span>back</a>
          
  <div class="title">
      <h2>Product Order Form</h2>
  </div>
<div class="d-flex">
  <form action="checkout.php" method="post">
    <label>
      <span class="fname">nama <span class="required">*</span></span>
      <input type="text" name="nama">
    </label>

   
   
    <label>
      <span>alamat <span class="required">*</span></span>
      <input type="text" name="alamat"  placeholder="House number and street name" required>
    </label>

    <label>
      <span>kota <span class="required">*</span></span>
      <input type="text" name="kota" > 
    </label>
   
    <label>
      <span>kode pos <span class="required">*</span></span>
      <input type="text" name="kode_pos" > 
    </label>
    <label>
      <span>no hp<span class="required">*</span></span>
      <input type="text" name="no_hp" > 
    </label>
    <label>
      <span>email<span class="required">*</span></span>
      <input type="text" name="email" > 
    </label>
    
  
  <div class="Yorder">
    <?php
  include '../konek.php';
  $q2=mysqli_query($koneksi,"SELECT * FROM produk WHERE id_pembeli='$_GET[id]'");
  while($data=mysqli_fetch_array($q2)){
    ?>
    <table>
      <tr>
        <th colspan="2">Your order</th>
      </tr>
      <?php
      
      ?>
      <tr>
        <td ><h3><?=$data['nama']?></h3></td>
        <td></td>
      </tr>
      <tr>
        <td><?=$data["harga"]?></td>
        <td></td>
      </tr>
      <tr>
        <td><img src="../img/<?=$data["produk"]?>"></td>
       
      </tr>
    </table><br>
    <?php } ?>
    <div>
      <input type="radio" name="dbt" value="dbt" checked>Saldo Dana
    </div>
    <p>
      
    </p>
    <div>
      <input type="radio" name="dbt" value="cd"> Cash on Delivery
    </div>
    <div>
      <input type="radio" name="dbt" value="cd">  <span>
      <img src="https://www.logolynx.com/images/logolynx/c3/c36093ca9fb6c250f74d319550acac4d.jpeg" alt="" width="50">
      </span>
    </div>
    <button type="submit" name="order" value="order">Place Order</button>
  </div><!-- Yorder -->
 </div>
</div>
</form>
</body>
</html>