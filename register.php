<?php
include 'koneksi.php'; // Pastikan path-nya benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama       = $_POST['nama'];
    $email      = $_POST['email'];
    $username   = $_POST['username'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $pekerjaan       = $_POST['pekerjaan'];
    $tgl_lahir  = $_POST['tgl_lahir'];
    $membership = $_POST['membership'];
    $alamat     = $_POST['alamat'];

    // Cek duplikat username
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {
        $sql = "INSERT INTO users (username, password, email, nama_lengkap, pekerjaan, membership, alamat, tgl_lahir)
                VALUES ('$username', '$password', '$email', '$nama', '$pekerjaan', '$membership', '$alamat', '$tgl_lahir')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Pendaftaran berhasil!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menyimpan data!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Gym</title>
    <style>

          * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 1000px;
            margin: 80px auto 0 auto; /* Tambah jarak atas agar tidak tertutup navbar */
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-column {
            flex: 1;
            min-width: 300px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .submit-container {
            width: 100%;
            text-align: center;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            gap: 20px;
        }

        .btn {
            padding: 12px 24px;
            background-color: #7f8c8d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #636e72;
        }

        @media (max-width: 768px) {
            form {
                flex-direction: column;
            }
        }

          /* ======== Navbar ======== */
        .navbar {
            background-color: #2c3e50;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        
        .navbar h1 {
            font-size: 24px;
            color: #ffc107;
            font-size: 22px;
            font-weight: bold;
            margin-right: 40px;
        }
        
        .navbar ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        
        .navbar ul li {
            display: inline;
        }
        
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        
        .navbar a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
<h1>FitClub</h1>
<ul>
    <li><a href="index.php">Home</a></li>
</ul>
</div>


<div class="form-container">
    <h2>Form Pendaftaran Gym</h2>
    <form action="" method="post">
        <!-- KIRI -->
        <div class="form-column">
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <!-- KANAN -->
        <div class="form-column">
            <label for="pekerjaan">Pekerjaan</label>
            <select name="pekerjaan" id="pekerjaan" required>
                <option value="" disabled selected>-- Pilih Pekerjaan --</option>
                <option value="Karyawan">Karyawan</option>
                <option value="Pelajar">Pelajar</option>
                <option value="Wirausaha">Wirausaha</option>
            </select>

            <label for="tgl_lahir">Tanggal Lahir</label>
            <input type="date" name="tgl_lahir" id="tgl_lahir" required>

            <label for="membership">Jenis Membership</label>
            <select name="membership" id="membership" required>
                <option value="" disabled selected>-- Pilih Membership --</option>
                <option value="VIP">VIP</option>
                <option value="PREMIUM">PREMIUM</option>
                <option value="MVP">MVP</option>
            </select>

            <label for="alamat">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" rows="4" required></textarea>
        </div>

        <!-- TOMBOL -->
        <div class="submit-container">
            <button type="submit">Daftar Sekarang</button>
        </div>
        <div class="button-container">
            <a href="login.php" class="btn">Login</a>
        </div>
    </form>
</div>

</body>
</html>
