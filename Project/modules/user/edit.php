<?php
// modules/user/edit.php - Mengubah data barang

error_reporting(E_ALL);
include_once 'config/database.php';

// Proses update data
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;
    
    // Proses upload gambar baru jika ada
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
    
    // Query update
    $sql = 'UPDATE data_barang SET ';
    $sql .= "nama = '{$nama}', kategori = '{$kategori}', ";
    $sql .= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}', stok = '{$stok}' ";
    
    // Update gambar jika ada upload baru
    if (!empty($gambar)) {
        $sql .= ", gambar = '{$gambar}' ";
    }
    
    $sql .= "WHERE id_barang = '{$id}'";
    
    $result = mysqli_query($conn, $sql);
    
    if($result) {
        header('location: index.php?page=user/list');
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil data berdasarkan ID
$id = isset($_GET['id']) ? $_GET['id'] : '';
$sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Error: Data tidak tersedia');
}

$data = mysqli_fetch_array($result);

if(!$data) {
    echo "<div class='content'><h2>Data tidak ditemukan</h2></div>";
    exit;
}

// Fungsi helper untuk select option
function is_select($var, $val) {
    if ($var == $val) return 'selected="selected"';
    return false;
}
?>

<div class="content">
    <h2>Ubah Barang</h2>
    
    <div class="main">
        <form method="post" action="index.php?page=user/edit&id=<?= $data['id_barang']; ?>" enctype="multipart/form-data">
            <div class="input">
                <label>Nama Barang</label>
                <input type="text" name="nama" value="<?= $data['nama']; ?>" required />
            </div>
            
            <div class="input">
                <label>Kategori</label>
                <select name="kategori">
                    <option <?= is_select('Komputer', $data['kategori']); ?> value="Komputer">Komputer</option>
                    <option <?= is_select('Elektronik', $data['kategori']); ?> value="Elektronik">Elektronik</option>
                    <option <?= is_select('Hand Phone', $data['kategori']); ?> value="Hand Phone">Hand Phone</option>
                </select>
            </div>
            
            <div class="input">
                <label>Harga Beli</label>
                <input type="number" name="harga_beli" value="<?= $data['harga_beli']; ?>" required />
            </div>
            
            <div class="input">
                <label>Harga Jual</label>
                <input type="number" name="harga_jual" value="<?= $data['harga_jual']; ?>" required />
            </div>
            
            <div class="input">
                <label>Stok</label>
                <input type="number" name="stok" value="<?= $data['stok']; ?>" required />
            </div>
            
            <div class="input">
                <label>Gambar Saat Ini</label>
                <?php if($data['gambar']): ?>
                    <img src="<?= $data['gambar']; ?>" alt="<?= $data['nama']; ?>" width="150" style="display: block; margin: 10px 0; border-radius: 4px;">
                <?php else: ?>
                    <p style="color: #999;">Tidak ada gambar</p>
                <?php endif; ?>
            </div>
            
            <div class="input">
                <label>Ganti Gambar (Opsional)</label>
                <input type="file" name="file_gambar" />
                <small style="color: #666;">Biarkan kosong jika tidak ingin mengganti gambar</small>
            </div>
            
            <div class="submit">
                <input type="hidden" name="id" value="<?= $data['id_barang']; ?>" />
                <input type="submit" name="submit" value="Ubah" />
                <a href="index.php?page=user/list" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>