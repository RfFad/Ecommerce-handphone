
<?php
include '../konek.php';
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['id'])) {
   echo "<script>alert('Login terlebih dahulu sebelum membeli :)'); window.location='../login.php'</script>";
   exit();
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>RF PHONE</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="../asset/css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="../css/style_pesanan.css">
      <!-- style css -->

      <!-- Responsive-->
      <link rel="stylesheet" href="../asset/css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="../asset/images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="../asset/css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
      <!-- font awesome -->
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <!--  -->
      <!-- owl stylesheets -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <link rel="stylesheet" href="../asset/css/owl.carousel.min.css">
      <link rel="stylesoeet" href="../asset/css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <style>
         /*--------------------------------------------------------------------- File Name: style.css ---------------------------------------------------------------------*/
/*--------------------------------------------------------------------- import Files ---------------------------------------------------------------------*/



/* copyright section end */
      </style>
   </head>
   <body>
      <!-- banner bg main start -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
         <a class="navbar-brand" href="#">RF PHONE</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
               <li class="nav-item active">
               <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
               </li>
               <li class="nav-item">
               <a class="nav-link" href="#">Produk</a>
               </li>
               <li class="nav-item">
               <a class="nav-link" href="#">Contact</a>
               </li>
            </ul>
         </div>
         </nav>
         <div class="fashion_section">
         
      
         <div id="main_slider" class="carousel slide" data-ride="carousel">
            
            
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <h1 class="fashion_taital mt-3" id="best" style="color:#F0F8FF;"><span class="btn btn-dark">PESANAN</span></h1>
                     <div class="fashion_section_2" >
                        <div class="row">
                           <div class="col-md-12">
                            <div class="card">
                               <div class="card-body shadow table-responsive">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tanggal Pemesanan</th>
                                                <th>Alamat</th>
                                                <th>Jumlah produk</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $id = $_SESSION['id'];
                                            $query = $koneksi->prepare("SELECT * FROM checkout WHERE id_user = ? ORDER BY id_checkout DESC");
                                            $query->bind_param("i", $id);
                                            $query->execute();
                                            $result = $query->get_result();
                                            $no = 1;
                                            while($row = $result->fetch_array()){ 
                                             ?>
                                            
                                                <tr>
                                                    <td><?= $no ++ ?></td>
                                                    <td><?= $row['tgl'] ?></td>
                                                    <td><?= $row['alamat'] ?></td>
                                                    <td><?= $row['item_qty'] ?></td>
                                                    <td>Rp. <?= number_format($row['total']) ?></td>
                                                    <td>
                                                        <span class="badge <?= $row['status'] === 'menunggu' ? 'badge-secondary' : ($row['status'] === 'diproses' ? 'badge-warning' : ($row['status'] === 'dikirim' ? 'badge-primary' : 'badge-success')) ?>"><?= $row['status'] ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="detail.php?id=<?= $row['id_checkout'] ?>" class="btn btn-sm btn-primary">Detail</a>
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
               </div>
               
               
               
            <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
            <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
            <i class="fa fa-angle-right"></i>
            </a>
         </div>
      </div>
      <!-- fashion section end -->
       <!-- copyright section end -->
      <!-- Javascript files-->
      <script src="../asset/js/jquery.min.js"></script>
      <script src="../asset/js/popper.min.js"></script>
      <script src="../asset/js/bootstrap.bundle.min.js"></script>
      <script src="../asset/js/jquery-3.0.0.min.js"></script>
      <script src="../asset/js/plugin.js"></script>
      <!-- sidebar -->
      <script src="../asset/js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="../asset/../asset/js/custom.js"></script>
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