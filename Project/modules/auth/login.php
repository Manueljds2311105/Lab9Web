<?php
// modules/auth/login.php - Halaman Login

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Contoh validasi sederhana
    if ($username == 'admin' && $password == 'admin') {
        echo "<script>alert('Login berhasil!'); window.location='index.php?page=home';</script>";
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<div class="content">
    <h2>Login</h2>
    
    <div class="main">
        <?php if(isset($error)): ?>
            <div class="alert alert-error">
                <?= $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="index.php?page=auth/login">
            <div class="input">
                <label>Username</label>
                <input type="text" name="username" required placeholder="admin" />
            </div>
            <div class="input">
                <label>Password</label>
                <input type="password" name="password" required placeholder="admin" />
            </div>
            <div class="submit">
                <input type="submit" name="submit" value="Login" />
            </div>
        </form>
        <p style="margin-top: 15px; color: #666;">
            <small>Demo: username: <strong>admin</strong>, password: <strong>admin</strong></small>
        </p>
    </div>
</div>