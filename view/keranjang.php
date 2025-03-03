<?php
include '../konek.php';
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "handphone");

if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
    echo "<script>alert('Login terlebih dahulu sebelum membeli :)'); window.location='../login.php'</script>";
    exit();
}
$sukses = "";
$error = "";
$id_produk = "";
$id_user = "";
$qty = "";

if (isset($_POST['add'])) {
    $id_produk = $_POST['id_produk'];
    $id_user = $_POST['id_user'];
    $qty = $_POST['qty'];

    if (!empty($id_produk) && !empty($id_user) && !empty($qty) && is_numeric($qty)) {
        $query = $koneksi->prepare("INSERT INTO keranjang (id_produk, qty, id_user) VALUES (?, ?, ?)");
        $query->bind_param("iii", $id_produk, $qty, $id_user);
        
        if ($query->execute()) {
            $sukses = "Berhasil menambahkan produk ke keranjang!";
        } else {
            $error = "Gagal menambahkan produk ke keranjang!";
        }
    } else {
        $error = "Data tidak valid!";
    }
}


// Menampilkan data dari keranjang
$id = $_SESSION['id'];
$query = $koneksi->prepare("
    SELECT k.*, p.nama AS nama_produk, p.harga, p.produk, u.username  
    FROM keranjang k 
    JOIN produk p ON k.id_produk = p.id_produk 
    JOIN user u ON k.id_user = u.id 
    WHERE u.id = ?
");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$total = 0;


$queryCount = $koneksi->prepare("SELECT COUNT(*) AS total_item FROM keranjang k JOIN user u ON k.id_user = u.id WHERE u.id = ?");
$queryCount->bind_param("i", $id);
$queryCount->execute();
$resultCount= $queryCount->get_result();
$getCount = $resultCount->fetch_assoc();
$countCart = $getCount['total_item'];
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    
    <div class="container mt-5 p-3 rounded cart">
        <div class="row no-gutters">
            <div class="col-md-8">
                <div class="product-details mr-2">
                    <div class="d-flex flex-row align-items-center">
                        <a href="index.php"><i class="fa fa-long-arrow-left"></i></a>
                        <span class="ml-2">Lanjut Belanja</span>
                    </div>
                    <hr>
                    <h6 class="mb-0">Keranjang Belanja</h6>
                
                    <?php while ($row = $result->fetch_array()): 
                        $subtotal = $row['harga'] * $row['qty'];
                        $total += $subtotal;
                    ?>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3 p-2 items rounded">
                        <div class="d-flex flex-row">
                            <img class="rounded" src="../img/<?= htmlspecialchars($row['produk']) ?>" width="40px">
                            <div class="ml-2">
                                <span class="font-weight-bold d-block"><?= htmlspecialchars($row['nama_produk']) ?></span>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <span class="d-block mr-5">Qty: <?= intval($row["qty"]); ?></span>
                            <span class="d-block ml-5 font-weight-bold">Rp<?= number_format($subtotal) ?></span>
                            <a href="hapus_keranjang.php?id=<?= $row['id_keranjang'] ?>" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                <i class="fa fa-trash-o ml-3 text-black-50"></i>
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="payment-info">
                    <h6>Detail Pembayaran</h6>
                    <hr class="line">
                    <?php if (isset($_SESSION['sukses'])): ?>
    <div class="alert alert-success"><?= $_SESSION['sukses']; ?></div>
    <?php unset($_SESSION['sukses']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
<form method="post" action="checkout.php">
    <input type="hidden" name="id_user" value="<?= $_SESSION['id'] ?>">
    <input type="hidden" name="item_qty" value="<?= $countCart ?>">
    <input type="hidden" name="tgl" value="<?= date("Y-m-d") ?>">
    <input type="hidden" name="total" value="<?= $total ?>">
    <!-- Input hidden untuk setiap item dalam keranjang -->
    <?php 
    $result->data_seek(0); // Reset hasil query ke baris pertama
    while ($row = $result->fetch_array()): 
    ?>
        <input type="hidden" name="id_produk[]" value="<?= $row['id_produk'] ?>">
        <input type="hidden" name="item_quantity[]" value="<?= $row['qty'] ?>">
    <?php endwhile; ?>

    <div>
        <label class="credit-card-label">Nama</label>
        <input type="text" class="form-control credit-inputs" value="<?= htmlspecialchars($_SESSION['username']) ?>" disabled>
    </div>

    <div>
        <label class="credit-card-label">Alamat</label>
        <input type="text" class="form-control credit-inputs" name="alamat" value="<?= $_SESSION['alamat'] ?>" placeholder="Isi dengan alamat lengkap" required>
    </div>

    <hr class="line">
    <div class="d-flex justify-content-between information">
        <span><b>Subtotal</b></span>
        <span><b style="color:red;">Rp. <?= number_format($total) ?></b></span>
    </div>

    <button type="submit" name="checkout" class="btn btn-primary btn-block mt-3">
        <i class="fa fa-shopping-cart"></i> Beli Sekarang
    </button>
</form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
