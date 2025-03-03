<?php 
include '../konek.php';
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
        <li class="nav-item"><a class="nav-link" href="produk.php">Data Produk</a></li>
        <li class="nav-item"><a class="nav-link active" href="user.php">Data User</a></li>
        <li class="nav-item"><a class="nav-link" href="pesanan.php">Data Pesanan</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8 mx-auto">
      <div class="card mt-4">
        <div class="card-header bg-secondary text-white">
          Data User
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="table-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Email</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $queryProduk = $koneksi->prepare("SELECT * FROM user ORDER BY id DESC");
                $queryProduk->execute();
                $result = $queryProduk->get_result();
                $no = 1;
                while($row = $result->fetch_array()){ ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($row['username']) ?></td>
                  <td><?= htmlspecialchars($row['email']) ?></td>
                  <td>
                    <a href="produk.php?op=edit&id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="produk.php?op=hapus&id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data?')">Hapus</a>
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