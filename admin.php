<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "handphone";

$konek = mysqli_connect($host, $user, $pass, $db);
if (!$konek) { //cek koneksi
  die("tidak bisa terkoneksi ke database");
}



$nama = "";
$produk= "";
$harga = "";
$error = "";
$sukses = "";

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}

if ($op == 'delete') {
  $id = $_GET['id'];
  $sql1 = "delete from admin where id_pembeli = '$id'";
  $q1 = mysqli_query($konek, $sql1);
  if ($q1) {
    $sukses = "Berhasil hapus data";
  } else {
    $error = "Gagal melakukan delete data";
  }
}

if ($op == 'edit') {
  $id = $_GET['id'];
  $sql1 = "select * from admin where id_pembeli = '$id'";
  $q1 = mysqli_query($konek, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $nama = $r1['nama'];
  $produk = $r1['produk'];
  $harga = $r1['harga'];
 

  if ($nama == '') {
    $error = "Data tidak ditemukan";
  }
}
if (isset($_POST['simpan'])) { //untuk create
  
  $nama = $_POST['nama'];
  $produk =$_FILES['produk']['name'];
   
   $file_tmp=$_FILES['produk']['tmp_name'];
  $harga = $_POST['harga'];
   
    move_uploaded_file($file_tmp, 'img/'.$produk);
  
  

  if ($nama && $produk && $harga ) {
    if ($op == 'edit') { //untuk update
      $sql1 = "update admin set nama = '$nama', produk='$produk', harga='$harga' where id_pembeli='$_GET[id]'";
      $q1 = mysqli_query($konek, $sql1);
      if ($q1) {
        $sukses = "Data berhasil diupdate";
      } else {
        $error = "Data gagal diupdate";
      }
    } else { //untuk insert
      $sql1 = "insert into admi(nama,produk,harga) values ('$nama','$produk','$harga')";
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
  <style>
     
            .a {
              text-decoration: none;
            }
           
    .mx-auto {
      width: 800px;
    }

    .card {
      margin-top: 10px;
    }
  </style>
</head>

<body>
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
          header("refresh:3;url=admin.php"); //5 : detik
        }
        ?>
        <?php
        if ($sukses) {
          ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
          <?php
          header("refresh:3;url=admin.php"); //5 : detik
        }
        ?>
        
        <form action="" method="POST" enctype="multipart/form-data">
          
          
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
              </tr>
            <tbody>
              <?php
                $sql2 = "select * from admin order by id_pembeli";
                $q2 = mysqli_query($konek, $sql2);
                $urut = 1;
                while ($r2 = mysqli_fetch_array($q2)) {
                  $id = $r2['id_pembeli'];
                  $nama = $r2['nama'];
                  $produk = $r2['produk'];
                  $harga = $r2['harga'];


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
                  <a href="admin.php?op=edit&id=<?php echo $id ?>"><button type="button"
                      class="btn btn-warning">Edit</button></a>
                  <a href="admin.php?op=delete&id=<?php echo $id ?>"> <button type="button" class="btn btn-danger"
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
</body>

</html>