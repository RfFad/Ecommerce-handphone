<?php
include '../konek.php';
session_start(); // Tambahkan session_start()


if (isset($_POST['checkout'])) {
    $id_user = $_POST['id_user'];
    $tgl = $_POST['tgl'];
    $total = $_POST['total'];
    $id_produk = $_POST['id_produk']; // Array
    $alamat = $_POST['alamat']; // Array
    $item_quantity = $_POST['item_quantity']; // Array
    $item_qty = $_POST['item_qty']; // Array

    if (empty($id_user) || empty($tgl) || empty($total) || empty($id_produk) || empty($item_quantity)) {
        $_SESSION['error'] = "Data tidak boleh kosong!";
        header("Location: keranjang.php");
        exit();
    }

    if (!is_array($id_produk) || !is_array($item_quantity) || count($id_produk) !== count($item_quantity)) {
        $_SESSION['error'] = "Data produk tidak valid!";
        header("Location: keranjang.php");
        exit();
    }
    // Mulai transaksi
    $koneksi->begin_transaction();
    try {
        // 1. Insert ke tabel checkout
        $queryCheckout = $koneksi->prepare("INSERT INTO checkout (id_user, tgl, alamat, item_qty, total) VALUES (?, ?, ?, ?, ?)");
        $queryCheckout->bind_param("issii", $id_user, $tgl, $alamat, $item_qty, $total);
        if (!$queryCheckout->execute()) {
            throw new Exception("Gagal menambahkan ke checkout!");
        }

        // 2. Ambil ID checkout terakhir
        $id_checkout = $koneksi->insert_id;

        // 3. Insert banyak produk ke tabel detail
        $queryDetail = $koneksi->prepare("INSERT INTO detail (id_checkout, item_quantity, id_produk) VALUES (?, ?, ?)");
        foreach ($id_produk as $index => $produk) {
            $qty = intval($item_quantity[$index]);
            if ($qty <= 0) {
                throw new Exception("Jumlah produk tidak valid!");
            }
            $queryDetail->bind_param("iii", $id_checkout, $qty, $produk);
            if (!$queryDetail->execute()) {
                throw new Exception("Gagal menambahkan produk ke detail!");
            }
        }

        $queryDelete = $koneksi->prepare("DELETE FROM keranjang WHERE id_user = ?");
        $queryDelete->bind_param("i", $id_user);
        $queryDelete->execute();
        $queryDelete->close();

        // 4. Commit transaksi jika semua berhasil
        $koneksi->commit();
        $_SESSION['sukses'] = "Checkout berhasil!";
    } catch (Exception $e) {
        // Rollback jika ada error
        $koneksi->rollback();
        $_SESSION['error'] = $e->getMessage();
    }

    // Redirect kembali ke halaman keranjang
    header("Location: keranjang.php");
    exit();
}

?>
