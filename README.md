# Praktikum 9: PHP Modular

## Informasi
- **Nama:** Manuel Johansen Dolok Saribu
- **NIM:** 312410493
- **Kelas:** Ti.24.A5
- **Mata Kuliah:** Pemrograman Web 1

---

## Langkah-Langkah Praktikum

### 1. Membuat Struktur Folder
Buat folder di dalam `htdocs` dengan struktur sebagai berikut:

```
Project/
├── index.php
├── .htaccess
├── config/
│   └── database.php
├── views/
│   ├── header.php
│   ├── footer.php
│   └── dashboard.php
├── modules/
│   ├── user/
│   │   ├── list.php
│   │   ├── add.php
│   │   ├── edit.php
│   │   └── delete.php
│   └── auth/
│       ├── login.php
│       └── logout.php
├── assets/
│   └── css/
│       └── style.css
```

---

### 2. Membuat File Konfigurasi Database

Buat file `config/database.php` untuk koneksi ke database.

```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "latihan1";

$conn = mysqli_connect($host, $user, $pass, $db);

if ($conn == false) {
    echo "Koneksi ke server gagal.";
    die();
}
?>
```

**Penjelasan:**
- File ini berisi konfigurasi koneksi database
- Menggunakan fungsi `mysqli_connect()` untuk koneksi ke MySQL
- Akan digunakan oleh semua module yang membutuhkan akses database

---

### 3. Membuat Template Header

Buat file `views/header.php` sebagai template header yang akan digunakan di semua halaman.

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Modular</title>
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container">
        <header>
            <h1>Sistem Data Barang</h1>
            <p>Universitas Pelita Bangsa</p>
        </header>
        
        <nav>
            <a href="index.php?page=home">Home</a>
            <a href="index.php?page=user/list">Data Barang</a>
            <a href="index.php?page=user/add">Tambah Barang</a>
            <a href="index.php?page=auth/login">Login</a>
        </nav>
```

**Penjelasan:**
- Template header dengan navigasi menu
- Menggunakan external CSS untuk styling
- Menu navigasi menggunakan routing URL

---

### 4. Membuat Template Footer

Buat file `views/footer.php` sebagai template footer.

```php
        <footer>
            <p>&copy; 2025, Informatika, Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>
</html>
```

**Penjelasan:**
- Template footer sederhana
- Menutup tag HTML yang dibuka di header

---

### 5. Membuat Halaman Dashboard

Buat file `views/dashboard.php` untuk halaman home.

```php
<div class="content">
    <h2>Dashboard</h2>
    <p>Selamat datang di Sistem Manajemen Data Barang</p>
    
    <div class="info-box">
        <h3>Menu Aplikasi:</h3>
        <ul>
            <li><a href="index.php?page=user/list">Lihat Data Barang</a></li>
            <li><a href="index.php?page=user/add">Tambah Data Barang</a></li>
        </ul>
    </div>
</div>
```

**Penjelasan:**
- Halaman utama aplikasi
- Menampilkan informasi dan menu navigasi
- Menggunakan template header dan footer

---

### 6. Membuat Sistem Routing (index.php)

Buat file `index.php` sebagai router utama aplikasi.

```php
<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$parts = explode('/', $page);
$module = isset($parts[0]) ? $parts[0] : 'home';
$action = isset($parts[1]) ? $parts[1] : 'list';

include('views/header.php');

switch($module) {
    case 'user':
        $file = "modules/user/{$action}.php";
        if(file_exists($file)) {
            include($file);
        } else {
            echo "<div class='content'><h2>404</h2></div>";
        }
        break;
    case 'auth':
        $file = "modules/auth/{$action}.php";
        if(file_exists($file)) {
            include($file);
        } else {
            echo "<div class='content'><h2>404</h2></div>";
        }
        break;
    case 'home':
    default:
        include('views/dashboard.php');
        break;
}

include('views/footer.php');
?>
```

**Penjelasan:**
- File router utama yang mengatur alur halaman
- Menggunakan parameter `page` dari URL
- Memisahkan module dan action dari URL
- Include header dan footer di setiap halaman

---

### 7. Membuat Module List (READ)

Buat file `modules/user/list.php` untuk menampilkan data barang.

```php
<?php
include("config/database.php");
$sql = 'SELECT * FROM data_barang';
$result = mysqli_query($conn, $sql);
?>

<div class="content">
    <h2>Data Barang</h2>
    <a href="index.php?page=user/add" class="btn-tambah">Tambah Barang</a>
    
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
            <?php while($row = mysqli_fetch_array($result)): ?>
            <tr>
                <td><img src="<?= $row['gambar'];?>" width="100"></td>
                <td><?= $row['nama'];?></td>
                <td><?= $row['kategori'];?></td>
                <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.');?></td>
                <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.');?></td>
                <td><?= $row['stok'];?></td>
                <td>
                    <a href="index.php?page=user/edit&id=<?= $row['id_barang'];?>">Edit</a>
                    <a href="modules/user/delete.php?id=<?= $row['id_barang'];?>">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
```

**Penjelasan:**
- Menampilkan semua data barang dari database
- Menggunakan loop untuk menampilkan data dalam tabel
- Terdapat tombol Edit dan Hapus untuk setiap data

---

### 8. Membuat Module Add (CREATE)

Buat file `modules/user/add.php` untuk menambah data barang.

```php
<?php
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
        $destination = 'gambar/' . $filename;
        
        if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
            $gambar = $destination;
        }
    }
    
    $sql = 'INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok, gambar) ';
    $sql .= "VALUES ('{$nama}', '{$kategori}', '{$harga_jual}', '{$harga_beli}', '{$stok}', '{$gambar}')";
    mysqli_query($conn, $sql);
    
    header('location: index.php?page=user/list');
    exit;
}
?>

<div class="content">
    <h2>Tambah Barang</h2>
    <form method="post" action="index.php?page=user/add" enctype="multipart/form-data">
        <!-- Form fields -->
    </form>
</div>
```

**Penjelasan:**
- Form untuk input data barang baru
- Handle upload gambar
- Validasi dan insert ke database
- Redirect ke halaman list setelah berhasil

---

### 9. Membuat Module Edit (UPDATE)

Buat file `modules/user/edit.php` untuk mengubah data barang.

```php
<?php
error_reporting(E_ALL);
include_once 'config/database.php';

// Proses update
if (isset($_POST['submit'])) {
    // ... kode update ...
    header('location: index.php?page=user/list');
    exit;
}

// Ambil data
$id = $_GET['id'];
$sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($result);
?>

<div class="content">
    <h2>Ubah Barang</h2>
    <form method="post" enctype="multipart/form-data">
        <!-- Form dengan value dari database -->
    </form>
</div>
```

**Penjelasan:**
- Mengambil data existing dari database berdasarkan ID
- Form sudah terisi dengan data yang akan diubah
- Update data ke database
- Bisa mengganti gambar atau tidak

---

### 10. Membuat Module Delete (DELETE)

Buat file `modules/user/delete.php` untuk menghapus data.

```php
<?php
include_once '../../config/database.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM data_barang WHERE id_barang = '{$id}'";
    mysqli_query($conn, $sql);
}

header('location: ../../index.php?page=user/list');
exit;
?>
```

**Penjelasan:**
- Menghapus data berdasarkan ID
- Langsung redirect ke list setelah delete
- Menggunakan konfirmasi JavaScript di button

---

### 11. Membuat Module Login

Buat file `modules/auth/login.php` untuk halaman login.

```php
<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username == 'admin' && $password == 'admin') {
        echo "<script>alert('Login berhasil!');</script>";
        header('location: index.php?page=home');
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<div class="content">
    <h2>Login</h2>
    <form method="post" action="index.php?page=auth/login">
        <!-- Form login -->
    </form>
</div>
```

**Penjelasan:**
- Form login sederhana
- Validasi username dan password
- Demo: admin/admin

---

### 12. Membuat Stylesheet

Buat file `assets/css/style.css` untuk styling aplikasi.

```css
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f5f5;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    text-align: center;
}

/* ... styling lainnya ... */
```

**Penjelasan:**
- Styling modern dengan gradient
- Responsive design
- Button dengan hover effect
- Table styling yang clean

---

## Konsep Modularisasi yang Diterapkan

### 1. **Separation of Concerns**
- **Config**: Konfigurasi database terpisah
- **Views**: Template header, footer, dashboard terpisah
- **Modules**: Setiap fitur dalam module terpisah
- **Assets**: CSS terpisah dari logic

### 2. **Reusability**
- Header dan Footer digunakan di semua halaman
- Konfigurasi database di-include di module yang memerlukan
- CSS digunakan oleh semua halaman

### 3. **Routing System**
- Satu entry point (`index.php`)
- URL pattern: `index.php?page=module/action`
- Contoh: `index.php?page=user/list`

---

## Perbedaan dengan Praktikum 8

| Aspek | Praktikum 8 | Praktikum 9 |
|-------|-------------|-------------|
| Struktur | File terpisah tanpa pola | Modular dengan routing |
| Template | Setiap file punya header/footer sendiri | Satu template untuk semua |
| URL | File langsung (tambah.php) | Routing (index.php?page=user/add) |

---

## Kesimpulan

Praktikum ini berhasil mengimplementasikan konsep modularisasi pada aplikasi PHP dengan fitur:
- ✅ Routing system yang terstruktur
- ✅ Template yang reusable (header, footer)
- ✅ Module terpisah per fitur (user, auth)
- ✅ CRUD lengkap dengan modular approach

Modularisasi membuat aplikasi lebih terorganisir.

---
