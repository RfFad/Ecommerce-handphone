<?php 
include '../konek.php';
session_start();
$id = $_GET['id'];
$status = $_GET['status'];
$queryUpdate = $koneksi->prepare("UPDATE checkout SET status = ? WHERE id_checkout = ?");
$queryUpdate->bind_param("si", $status, $id);

if($queryUpdate->execute()){
   echo '<script>alert("Status Berhasil Diupdate!");window.location="pesanan.php"</script>';
}else{

}
?>