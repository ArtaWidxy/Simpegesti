<?php
session_start(); 
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $nama = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    $alasan = $_POST['alasan'];
    $waktu = date('Y-m-d', strtotime($_POST['waktu']));

	$foto     = $_FILES['foto']['name'];
	$tmp      = $_FILES['foto']['tmp_name'];
	$fotobaru = date('dmYHis').$foto;
	$path     = "images/".$fotobaru;
}

if (move_uploaded_file($tmp, $path)) {
	$sql = "SELECT * FROM tb_keterangan WHERE id_karyawan = '".$id_karyawan."'";
	$tambah = mysqli_query($koneksi, $sql);
}

if ($row = mysqli_fetch_row($tambah)) {
    echo "<script>alert('Data Dengan NIP = ".$id_karyawan." sudah ada') </script>";
            echo "<script>window.location.href = \"peg-keterangan.php\" </script>";
}

$query = "INSERT INTO tb_keterangan set id_karyawan='$id_karyawan', nama='$nama', keterangan='$keterangan',alasan='$alasan', foto='$fotobaru'";
mysqli_query($koneksi, $query);

if ($query) {
    header("location: peg-keterangan.php");
} else {
    echo "gagal";
}
?>
                                                        