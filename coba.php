<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "handphone";

$konek = mysqli_connect($host, $user, $pass, $db);
if (!$konek) { //cek koneksi
  die("tidak bisa terkoneksi ke database");
}
session_start();
if(!isset($_SESSION['username'])){
   echo'<script language="javascript">
   alert("login dulu lah cuy"); document.location="login_admin.php";</script>'; 
  
}



$nama = "";
$produk= "";
$harga = "";
$stok = "";
$error = "";
$sukses = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}

if ($op == 'delete') {
  $id = $_GET['id'];
  $sql1 = "delete from produk where id_pembeli = '$id'";
  $q1 = mysqli_query($konek, $sql1);
  if ($q1) {
    $sukses = "Berhasil hapus data";
  } else {
    $error = "Gagal melakukan delete data";
  }
}

if ($op == 'edit') {
  $id = $_GET['id'];
  $sql1 = "select * from produk where id_pembeli = '$id'";
  $q1 = mysqli_query($konek, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $nama = $r1['nama'];
  $produk = $r1['produk'];
  $harga = $r1['harga'];
  $stok = $r1['stok'];
 

  if ($nama == '') {
    $error = "Data tidak ditemukan";
  }
}
if (isset($_POST['simpan'])) { //untuk create
  
  $nama = $_POST['nama'];
  $produk =$_FILES['produk']['name'];
   
   $file_tmp=$_FILES['produk']['tmp_name'];
  $harga = $_POST['harga'];
  $stok = $_POST['stok'];
   
    move_uploaded_file($file_tmp, 'img/'.$produk);
  
  

  if ($nama && $produk && $harga && $stok ) {
    if ($op == 'edit') { //untuk update
      $sql1 = "update produk set nama = '$nama', produk='$produk', harga='$harga',stok='$stok' where id_pembeli='$_GET[id]'";
      $q1 = mysqli_query($konek, $sql1);
      if ($q1) {
        $sukses = "Data berhasil diupdate";
      } else {
        $error = "Data gagal diupdate";
      }
    } else { //untuk insert
      $sql1 = "insert into produk(nama,produk,harga,stok) values ('$nama','$produk','$harga','$stok')";
      $q1 = mysqli_query($konek, $sql1);
      if ($q1) {
        $sukses = "Berhasil memasukkan data baru";
      } else {
        $error = "Gagal memasukkan data";
      }
    }
  } else {
    $error = "Silahkan masukkan semua data";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
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
    <!----untuk memasukan data---->
    <div class="card">
      <div class="card-header">
        Create / edit data
      </div>
      <div class="card-body">
        <?php
        if ($error) {
          ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
          <?php
          header("refresh:3;url=coba.php"); //5 : detik
        }
        ?>
        <?php
        if ($sukses) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
          header("refresh:3;url=coba.php"); //5 : detik
        }
        ?>
        
        <form action="" method="POST" enctype="multipart/form-data">
        <a href="eflyer-master/perulangan.php"><span class="close">&#10005;</span>back</a>
          
          <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
            </div>
          </div>
         
          <div class="mb-3 row">
            <label for="produk" class="col-sm-2 col-form-label">produk</label>
            <div class="col-sm-10">
              <input type="file" class="form-control" name="produk" id="produk" value="<?php echo $produk ?>">
              </div>
            </div>
          <div class="mb-3 row">
            <label for="harga" class="col-sm-2 col-form-label">harga</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="harga" id="harga" value="<?php echo $harga ?>">
              </div>
            </div>
          <div class="mb-3 row">
            <label for="harga" class="col-sm-2 col-form-label">stok</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="stok" id="harga" value="<?php echo $stok ?>">
              </div>
            </div>
          
            <div class="col-12">
              <input type="submit" name="simpan" value="Simpan data" class="btn btn-primary">
            </div>
          </form>
          <!--untuk mengeluarkan data-->

        </div>
      </div>
      <div class="card">
        <div class="card-header text-white bg-secondary">
          data pembelian
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>

                <th scope="col">Nama</th>
                <th scope="col">Produk</th>
                <th scope="col">harga</th>
                <th scope="col">stok</th>
              </tr>
            <tbody>
              <?php
                $sql2 = "select * from produk order by id_pembeli";
                $q2 = mysqli_query($konek, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $id = $r2['id_pembeli'];
                  $nama = $r2['nama'];
                  $produk = $r2['produk'];
                  $harga = $r2['harga'];
                  $stok = $r2['stok'];


                  ?>
              <tr>
                <th scope="row">
                  <?php echo $urut++ ?>
                </th>
                
                <td scope="row">
                  <?php echo $nama ?>
                </td>
                
                <td scope="row">
                <img src="img/<?= $produk?>" class="img-thumbnail" width="100px" height="100px">
                </td>
            
                <td scope="row">
                  <?php echo $harga ?>
                </td>
                <td scope="row">
                  <?php echo $stok ?>
                </td>
                
                <td scope="row">
                  <a href="coba.php?op=edit&id=<?php echo $id ?>"><button type="button"
                      class="btn btn-warning">Edit</button></a>
                  <a href="coba.php?op=delete&id=<?php echo $id ?>"> <button type="button" class="btn btn-danger"
                      onclick="return confirm('Yakin ingin delete data?')">Delete</button></a>
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
      crossorigin="anonymous"></script>
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