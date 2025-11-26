<?php
// modules/user/add.php - Menambah data barang

error_reporting(E_ALL);
include_once 'config/database.php';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;
    
    if ($file_gambar['error'] == 0) {
        $filename = str_replace(' ', '_', $file_gambar['name']);
        
        // Buat folder gambar jika belum ada
        if (!file_exists('gambar')) {
            mkdir('gambar', 0777, true);
        }
        
        $destination = 'gambar/' . $filename;
        
        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
            $gambar = $destination;
        }
    }
    
    $sql = 'INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar) ';
    $sql .= "VALUES ('{$nama}', '{$kategori}', '{$harga_jual}', '{$harga_beli}', '{$stok}', '{$gambar}')";
    $result = mysqli_query($conn, $sql);
    
    if($result) {
        header('location: index.php?page=user/list');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="content">
    <h2>Tambah Barang</h2>
    
    <div class="main">
        <form method="post" action="index.php?page=user/add" enctype="multipart/form-data">
            <div class="input">
                <label>Nama Barang</label>
                <input type="text" name="nama" required />
            </div>
            <div class="input">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="Komputer">Komputer</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Hand Phone">Hand Phone</option>
                </select>
            </div>
            <div class="input">
                <label>Harga Beli</label>
                <input type="number" name="harga_beli" required />
            </div>
            <div class="input">
                <label>Harga Jual</label>
                <input type="number" name="harga_jual" required />
            </div>
            <div class="input">
                <label>Stok</label>
                <input type="number" name="stok" required />
            </div>
            <div class="input">
                <label>File Gambar</label>
                <input type="file" name="file_gambar" />
            </div>
            <div class="submit">
                <input type="submit" name="submit" value="Simpan" />
                <a href="index.php?page=user/list" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>