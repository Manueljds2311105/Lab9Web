<?php
// modules/user/delete.php - Menghapus data barang

include_once '../../config/database.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM data_barang WHERE id_barang = '{$id}'";
    $result = mysqli_query($conn, $sql);
}

header('location: ../../index.php?page=user/list');
exit;
?>