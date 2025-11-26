<?php
// modules/user/list.php - Menampilkan data barang

include("config/database.php");

// Query untuk menampilkan data
$sql = 'SELECT * FROM data_barang';
$result = mysqli_query($conn, $sql);
?>

<div class="content">
    <h2>Data Barang</h2>
    <a href="index.php?page=user/add" class="btn-tambah">Tambah Barang</a>
    
    <div class="main">
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result && mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_array($result)): ?>
                    <tr>
                        <td><img src="<?= $row['gambar'];?>" alt="<?= $row['nama'];?>" width="100"></td>
                        <td><?= $row['nama'];?></td>
                        <td><?= $row['kategori'];?></td>
                        <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.');?></td>
                        <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.');?></td>
                        <td><?= $row['stok'];?></td>
                        <td>
                            <a href="index.php?page=user/edit&id=<?= $row['id_barang'];?>" class="btn-edit">Ubah</a>
                            <a href="modules/user/delete.php?id=<?= $row['id_barang'];?>" 
                               onclick="return confirm('Yakin ingin menghapus data ini?')" 
                               class="btn-hapus">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Belum ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>