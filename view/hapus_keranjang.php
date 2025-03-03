<?php 
include '../konek.php';
if(isset($_GET['id'])){
    $id= $_GET['id'];
    $query=$koneksi->prepare("DELETE FROM keranjang WHERE id_keranjang = ? ");
    $query->bind_param("i", $id);
    if($query->execute()){
        header('Location: keranjang.php');
    }
    $query->close();
}
?>