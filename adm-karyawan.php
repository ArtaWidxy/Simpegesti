<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<?php 
    session_start();
    if (!isset($_SESSION['username'])) {
        header("location: index.php");
    }else {
        $username = $_SESSION['username'];  
    }

 ?>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="adm-index.php" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">NiceAdmin</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

       

        </nav>
        <!-- End Icons Navigation -->

    </header>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="adm-index.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Data Master</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="adm-petugas.php">
                            <i class="bi bi-circle"></i><span>Petugas</span>
                        </a>
                    </li>
                    <li>
                        <a href="adm-karyawan.php">
                            <i class="bi bi-circle"></i><span>Karyawan</span>
                        </a>
                    </li>
                    <li>
                        <a href="adm-jabatan.php">
                            <i class="bi bi-circle"></i><span>Jabatan</span>
                        </a>
                    </li>
                    <li>
                        <a href="adm-lembur.php">
                            <i class="bi bi-circle"></i><span>Lembur</span>
                        </a>
                    </li>
                    <li>
                        <a href="adm-potongan.php">
                            <i class="bi bi-circle"></i><span>Potongan</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Salary</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                        <a href="adm-kehadiran.php">
                            <i class="bi bi-circle"></i><span>Kehadiran</span>
                        </a>
                    </li>
                    <li>
                        <a href="adm-keterangan.php">
                            <i class="bi bi-circle"></i><span>Keterangan</span>
                        </a>
                    </li>
                    <li>
                        <a href="adm-gaji.php">
                            <i class="bi bi-circle"></i><span>Gaji</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Forms Nav -->


            <li class="nav-item">
                <a class="nav-link collapsed" href="logout.php">
                    <i class="bi bi-file-earmark"></i>
                    <span>Keluar</span>
                </a>
            </li>
            <!-- End Blank Page Nav -->

        </ul>

    </aside>
    <!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Karyawan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="adm-index.php">Home</a></li>
                    <li class="breadcrumb-item active">Data Karyawan</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Tambah Data Karyawan</h5>
                        <form action="dt_karyawan_sv.php" enctype="multipart/form-data" method="post">
                            <div class="row mb-3">
                                <label  class="col-sm-2 col-form-label">NIP</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" autocomplete="off" name="id_karyawan">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label  class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" autocomplete="off" name="username">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" autocomplete="off" name="password">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" autocomplete="off" name="nama">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tempat Lahir</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tempat_lahir" autocomplete="off">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputDate" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="tmp_tgl_lahir" autocomplete="off">
                                </div>
                            </div>
                            <fieldset class="row mb-3">
                                <legend class="col-form-label col-sm-2 pt-0">Jenis Kelamin</legend>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenkel" id="gridRadios1" value="Laki-Laki" checked>
                                        <label class="form-check-label">
                        Laki-laki
                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenkel" id="gridRadios2" value="Perempuan">
                                        <label class="form-check-label" >
                        Perempuan
                        </label>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Agama</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="agama">
                                        <option selected>Open this select menu</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katholik">Katholik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Budha">Budha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" style="height: 100px" name="alamat"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">No Telpon</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="no_tel">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jabatan</label>
                                <div class="col-sm-10">
                                    <select class="form-select" aria-label="Default select example" name="id_jabatan">
                                    <?php 
                                                include 'koneksi.php';
                                                $sql = "SELECT * FROM tb_jabatan";
                                                $hasil = mysqli_query($koneksi, $sql);
                                                while ($data = mysqli_fetch_array($hasil)) {
                                                 ?>
                                                <option value="<?php echo $data['id'];?>"><?php echo $data['jabatan']; ?></option>
                                                <?php } ?> 
                                    </select>
                                </div>
                            </div>
                        
                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-2 col-form-label">Foto</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="formFile" name="foto">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="simpan">Tambah Karyawan</button>
                                </div>
                            </div>

                        </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-body">
                            <h5 class="card-title">Data Karyawan</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Tempat, Tanggal Lahir</th>
                                        <th scope="col">Jenis Kelamin</th>
                                        <th scope="col">Agama</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">No HP</th>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col">Foto</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        include 'koneksi.php';
                                        $sql = "SELECT * FROM tb_karyawan join tb_jabatan on tb_karyawan.id_jabatan = tb_jabatan.id";
                                        $query = mysqli_query($koneksi, $sql);

                                        $no = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['id_karyawan']; ?></td>
                                            <td><?php echo $row['nama']; ?></td>
                                            <td><?php echo $row['tempat_lahir']; ?>, <?php echo $row['tmp_tgl_lahir']; ?></td>
                                            <td><?php echo $row['jenkel']; ?></td>
                                            <td><?php echo $row['agama']; ?></td>
                                            <td><?php echo $row['alamat']; ?></td>
                                            <td><?php echo $row['no_tel']; ?></td>
                                            <td><?php echo $row['jabatan']; ?></td>
                                            <td>
                                                <?php 
                                                    if ($row['foto'] != '') {
                                                    echo '<img src="images/'.$row['foto'].'" style="max-width: 50px; height: auto;" />';
                                                    } else {
                                                    echo 'Tidak ada foto';
                                                    }
                                                ?>
                                            </td>

                                            <td> 
                                                    <a href="karyawan_del.php?id_karyawan=<?php echo $row['id_karyawan']; ?>"><button class="btn btn-danger" onclick="return confirm('yakin ingin dihapus?');">Hapus</button></a>
                                                </td>
                                        </tr>
                                    <?php 
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-body">
                            <h5 class="card-title">Ganti Password Akun Karyawan</h5>

                            <form action="pass_up.php" method="post">
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Nama Karyawan</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" aria-label="Default select example" name="id_karyawan">
                                        <?php 
                                                include 'koneksi.php';
                                                $sql = "SELECT * FROM tb_karyawan";
                                                $hasil = mysqli_query($koneksi, $sql);
                                                while ($data = mysqli_fetch_array($hasil)) {
                                                ?>
                                                <option value="<?php echo $data['id_karyawan'];?>"><?php echo $data['nama']; ?></option>
                                                <?php } ?> 
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password" autocomplete="off">
                                    </div>
                                </div>
                               
                                <div class="row mb-3">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary"  name="simpan">Update</button>
                                    </div>
                                </div>

                            </form>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Password</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        include 'koneksi.php';
                                        $sql = "SELECT * FROM tb_karyawan";
                                        $query = mysqli_query($koneksi, $sql);

                                        $no = 1;
                                        while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['id_karyawan']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['password']; ?></td>
                                            <td> 
                                                    <a href="karyawan_del.php?id_karyawan=<?php echo $row['id_karyawan']; ?>"><button class="btn btn-danger" onclick="return confirm('yakin ingin dihapus?');">Hapus</button></a>
                                                </td>
                                        </tr>
                                    <?php 
                                        }
                                    ?>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
            
        </section>


    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->

    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>