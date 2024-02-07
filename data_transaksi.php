<?php
include 'konek.php';
session_start();
if(!isset($_SESSION['username'])){
  header('location:loginadmin.php');
}
$mysql_adm=mysqli_query($koneksi, "select * from admin where username='$_SESSION[username]'");
$data_adm=mysqli_fetch_array($mysql_adm);
$host = "localhost";
$user = "root";
$pass = "";
$db = "handphone";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
  die("tidak bisa terkoneksi ke database");
}
$id_transaksi = "";
$id_pembeli = "";
$nama_pembeli= "";
$alamat = "";
$tgl_transaksi = "";
$total_harga = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
      <!-- font awesome -->
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!--  -->
      <!-- owl stylesheets -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesoeet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
 <style>
     a{
      text-decoration: none;
    }
    .mx-auto {
      width: 800px;
    }

    .card {
      margin-top: 10px;
    }
    .gmbr{
      width: 50px;
      
    }
  </style>
</head>

<body>
<div id="mySidenav" class="sidenav">
                     <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                     <a href="coba.php">Upload produk</a>
                     <a href="data_user.php">data user</a>
                     <a href="data_dibeli.php">data dibeli</a>
                     <a href="data_transaksi.php">data transaksi</a>
                     
                  </div>
                  <div class="gmbr">
                  <span class="toggle_icon" onclick="openNav()"><img src="img/iconmenu.png"></span>
                  </div>
  <div class="mx-auto">
  <div class="mx-auto">
          <!--untuk mengeluarkan data-->
        </div>
      </div>
      <div class="card">
        <div class="card-header text-white bg-secondary">
          Data transaksi
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">id_pembeli</th>
                <th scope="col">nama_pembeli</th>
                <th scope="col">alamat</th>
                <th scope="col">tgl_transaksi</th>
                <th scope="col">total_harga</th>
              </tr>
            <tbody>
              <?php
                $sql2 = "select * from checkout order by id_checkout desc";
                $q2 = mysqli_query($koneksi, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $id_pembeli = $r2['id_user'];
                  $alamat = $r2['alamat'];
                  $tgl_transaksi = $r2['tgl'];
                  $total_harga = $r2['total'];
                $sql3 = "select * from login where id_user='$id_pembeli'";
                $q3 = mysqli_query($koneksi, $sql3);
                while ($r3 = mysqli_fetch_array($q3)) {
                  $nama_pembeli = $r3["username"];
                }
                  ?>
              <tr>
                <th scope="row">
                  <?php echo $urut++ ?>
                </th>
                <td scope="row">
                  <?php echo $id_pembeli ?>
                </td>
                <td scope="row">
                  <?php echo $nama_pembeli ?>
                </td>
                <td scope="row">
                  <?php echo $alamat ?>
                </td>
                <td scope="row">
                  <?php echo $tgl_transaksi ?>
                </td>
                <td scope="row">
                  <?php echo $total_harga ?>
                </td>
                <td scope="row">
                </td>
              </tr>
              <?php
                }
                ?>
          </tbody>
          </thead>
        </table>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
      crossorigin="anonymous">
    </script>
     <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "250px";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
      </script>
</body>

</html>