<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "handphone";

$konek = mysqli_connect($host, $user, $pass, $db);
if (!$konek) {
    die("Tidak bisa terkoneksi ke database");
}
session_start();
$nama = "";
$produk = "";
$harga = "";
$stok = "";
$error = "";
$sukses = "";

$op = isset($_GET['op']) ? $_GET['op'] : "";
$id = isset($_GET['id']) ? $_GET['id'] : "";

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $produkBaru = $_FILES['produk']['name'];
    $tmp_name = $_FILES['produk']['tmp_name'];

    $query = $konek->prepare("SELECT produk FROM produk WHERE id_produk=?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $produkLama = $row['produk'];
    } else {
        $produkLama = "";
    }

    if (!empty($produkBaru)) {
        move_uploaded_file($tmp_name, 'img/' . $produkBaru);
        $produk = $produkBaru;
    } else {
        $produk = $produkLama;
    }

    if (!empty($id)) {
        $query = $konek->prepare("UPDATE produk SET nama=?, harga=?, produk=?, stok=? WHERE id_produk=?");
        $query->bind_param("sisii", $nama, $harga, $produk, $stok, $id);
        if ($query->execute()) {
            $sukses = "Berhasil Mengupdate Data!";
        } else {
            $error = "Gagal mengupdate data!";
        }
    } else {
        $query = $konek->prepare("INSERT INTO produk(nama, harga, produk, stok) VALUES (?, ?, ?, ?)");
        $query->bind_param("sisi", $nama, $harga, $produk, $stok);
        if ($query->execute()) {
            $sukses = "Berhasil Menambahkan Data!";
        } else {
            $error = "Gagal menambahkan data!";
        }
    }

   // echo "<script>window.location='admin.php'</script>";
    
}

if ($op === 'edit') {
    $id = $_GET['id'];
    $queryEdit = $konek->prepare("SELECT * FROM produk WHERE id_produk = ?");
    $queryEdit->bind_param("i", $id);
    $queryEdit->execute();
    $resultEdit = $queryEdit->get_result();
    $rowEdit = $resultEdit->fetch_assoc();

    if ($rowEdit) {
        $nama = $rowEdit['nama'];
        $stok = $rowEdit['stok'];
        $harga = $rowEdit['harga'];
        $produk = $rowEdit['produk'];
    } else {
        $error = "Produk tidak ditemukan!";
    }
}

if($op === "hapus"){
  $id = $_GET['id'];
  $queryCheck = $konek->prepare("SELECT id_produk FROM produk WHERE id_produk = ? ");
  $queryCheck->bind_param("i", $id);
  $queryCheck->execute();
  $queryCheck->bind_result($id_produk);
  $queryCheck->fetch();
  $queryCheck->close();
  if(empty($id_produk)){
    $error="data tidak ditemukan";
  }else{
      $query = $konek->prepare("DELETE FROM produk WHERE id_produk = ?");
      $query->bind_param("i", $id);
      if($query->execute()){
        $sukses = "Berhasil Menghapus Data!";
      }else{
        $error = "Gagal Menghapus Data!";
      }
  }
 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">RF ADMIN</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="produk.php">Data Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="user.php">Data User</a></li>
        <li class="nav-item"><a class="nav-link" href="pesanan.php">Data Pesanan</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="card">
        <div class="card-header">
          Create / Edit Data
        </div>
        <div class="card-body">
          <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
            </div>

            <div class="mb-3">
              <label for="produk" class="form-label">Produk</label>
              <input type="file" class="form-control" name="produk" id="produk">
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="text" class="form-control" name="harga" id="harga" value="<?php echo $harga ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" name="stok" id="stok" value="<?php echo $stok ?>">
              </div>
            </div>

            <div class="text-end">
              <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
            </div>
          </form>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
          Data Pembelian
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="table-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Stok</th>
                  <th scope="col">Produk</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $queryProduk = $konek->prepare("SELECT * FROM produk ORDER BY id_produk DESC");
                $queryProduk->execute();
                $result = $queryProduk->get_result();
                $no = 1;
                while($row = $result->fetch_array()){ ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($row['nama']) ?></td>
                  <td>Rp. <?= number_format(htmlspecialchars($row['harga'])) ?></td>
                  <td><?= htmlspecialchars($row['stok']) ?></td>
                  <td>
                    <img src="../img/<?= htmlspecialchars($row['produk']) ?>" class="img-thumbnail" style="width: 100px; height: 60px; object-fit: cover;">
                  </td>
                  <td>
                    <a href="produk.php?op=edit&id=<?= htmlspecialchars($row['id_produk']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="produk.php?op=hapus&id=<?= htmlspecialchars($row['id_produk']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data?')">Hapus</a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    <?php if (!empty($sukses)) { ?>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '<?php echo $sukses; ?>'
        }).then(() => {
            window.location = 'produk.php';
        });
    <?php } ?>

    <?php if (!empty($error)) { ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?php echo $error; ?>'
        });
    <?php } ?>
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
      crossorigin="anonymous"></script>
</body>

</html>