<?php
    require "koneksi.php";
    $queryProduk = mysqli_query($con, "SELECT id,nama,harga,foto,detail FROM produk LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/ccs/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php" ?>

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Crafleur Studio</h1>
            <h3>Cari Produk Apa?</h3>
            <div class="col-md-8 offset-md-2">
                <form method="get" action="produk.php">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Nama Produk" aria-label="Nama Produk" aria-describedby="basic-addon2" name="keyword">
                        <button class="btn warna2 text-dark">Telusuri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--highlighted kategori-->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Kategori Terlaris</h3>

            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-bouquet-kawat  d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=bouquet kawat Bulu">Bouquet Kawat Bulu</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-gantungan-kawat d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=gantungan Kawat Bulu">Gantungan Kawat Bulu</a></h4>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="highlighted-kategori kategori-bouquet-bunga d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=bouquet Bunga">Bouquet Bunga</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- tentang kami -->
     <div class="container-fluid warna3 py-5">
        <div class="container text-center">
            <h3>Tentang Kami</h3>
            <p class="fs-5 mt-3">
                CRAFLEUR.STUDIO adalah toko bouquet bunga kreatif yang menghadirkan rangkaian bunga unik dan estetik untuk berbagai momen spesial, seperti ulang tahun, pernikahan, wisuda, hingga hadiah apresiasi. Setiap bouquet dibuat dengan penuh ketelitian, memadukan detail yang rapi dan bahan berkualitas agar tercipta hasil yang elegan, personal, dan berkesan. Dengan sistem pemesanan berbasis web, pelanggan dapat melihat katalog, memilih desain favorit, melakukan custom order, hingga memesan dengan mudah dan nyaman. CRAFLEUR.STUDIO berkomitmen untuk memberikan pengalaman berbelanja bunga yang modern sekaligus menghadirkan sentuhan hangat karya UMKM lokal melalui inovasi dan pelayanan yang profesional.
            </p>
        </div>
     </div>

     <!--produk-->
     <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>

            <div class="row mt-5">
                <?php while($data = mysqli_fetch_array($queryProduk)){?>
                <div class=" col-sm-6 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="image-box">
                            <img src="image/<?php echo $data['foto'];?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $data['nama']; ?></h4>
                            <p class="card-text text-truncate"><?php echo $data['detail'];?></p>
                            <p class="card-text text-harga">Rp <?php echo $data['harga'];?></p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama'];?>" class="btn warna2">Lihat Detail</a>
                            <a href="https://wa.me/629624619461?text=<?php echo urlencode(
                                "Halo, saya mau pesan produk:\n" .
                                "📦 Nama Produk : " . $produk['nama'] . "\n" .
                                "💰 Harga       : Rp " . $produk['harga'] . "\n\n" .
                                "Mohon isi data berikut ya:\n" .
                                "🔢 Jumlah     : \n" .
                                "👤 Nama       : \n" .
                                "📍 Alamat     : \n" .
                                "📞 No. HP     : \n"
                            ); ?>" class="btn warna3"> Order via WhatsApp</a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <a class="btn btn-outline-warning mt-3 pt-2 fs-3" href="produk.php">See More</a>
        </div>
     </div>

     <!--footer-->
     <?php require "footer.php";?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>
</html>