<?php
session_start();
include 'koneksi.php';

$isLoggedIn = isset($_SESSION['user_id']);
if (!$isLoggedIn) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Hapus akun
if (isset($_POST['delete_account'])) {
    mysqli_query($conn, "DELETE FROM users WHERE id = '$user_id'");
    session_destroy();
    header("Location: register.php");
    exit;
}

// Simpan perubahan
if (isset($_POST['save_changes'])) {
    $nama = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $alamat = $_POST['alamat'];
    $pekerjaan = $_POST['pekerjaan'];
    $membership = $_POST['membership'];

    $query_update = "UPDATE users SET 
        nama_lengkap = '$nama',
        email = '$email',
        username = '$username',
        alamat = '$alamat',
        pekerjaan = '$pekerjaan',
        membership = '$membership'
        WHERE id = '$user_id'";
    mysqli_query($conn, $query_update);
}

// Ambil data user terbaru
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$tanggal_lahir = $data['tgl_lahir'];
$umur = date('Y') - date('Y', strtotime($tanggal_lahir));
$edit_mode = isset($_POST['edit_profile']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <style>
    * {
        box-sizing: border-box;
        padding: 0;
        margin: 0;
    }
    body {
      font-family: Arial, sans-serif;
      background-color: #eef2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .profile-card {
        background-color: white;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 400px;
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
    }

    .profile-item {
        margin-bottom: 15px;
        font-size: 16px;
        color: #555;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-edit {
        background-color: orange;
        color: white;
    }

    .btn-delete {
        background-color: red;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
    }

    /* ======== Navbar ======== */
    .navbar {
        background-color: #2c3e50;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
    }

    .navbar h1 {
        font-size: 24px;
        color: #ffc107;
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

    @media (max-width: 768px) {
        .navbar {
            flex-direction: column;
            align-items: flex-start;
        }
        .navbar ul {
            flex-direction: column;
            width: 100%;
            padding: 0;
            margin-top: 10px;
        }
        .navbar ul li {
            padding: 10px 0;
            width: 100%;
        }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
  <h1>FitClub</h1>
  <ul>
      <li><a href="index.php#membership-section">Membership</a></li>
      <li><a href="index.php#trainer-section">Trainer</a></li>
      <li><a href="index.php#lokasi-section">Location</a></li>

      <?php if (!$isLoggedIn): ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
      <?php else: ?>
          <li><a href="profile.php">Profile</a></li>
          <li><a href="?logout=true">Logout</a></li>
      <?php endif; ?>
  </ul>
</div>

<!-- Kartu Profil -->
<div class="profile-card">
    <h2>Profil Pengguna</h2>
    <form method="POST">
      <?php if ($edit_mode): ?>
          <div class="profile-item"><strong>Nama Lengkap:</strong>
              <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($data['nama_lengkap']) ?>">
          </div>
          <div class="profile-item"><strong>Email:</strong>
              <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>">
          </div>
          <div class="profile-item"><strong>Username:</strong>
              <input type="text" name="username" value="<?= htmlspecialchars($data['username']) ?>">
          </div>
          <div class="profile-item"><strong>Alamat Lengkap:</strong>
              <input type="text" name="alamat" value="<?= htmlspecialchars($data['alamat']) ?>">
          </div>
          <div class="profile-item"><strong>Pekerjaan:</strong>
              <select name="pekerjaan">
                  <?php
                  $pekerjaan_list = ['PELAJAR / MAHASISWA', 'KARYAWAN', 'WIRAUSAHA'];
                  foreach ($pekerjaan_list as $job) {
                      $selected = ($data['pekerjaan'] === $job) ? 'selected' : '';
                      echo "<option value='$job' $selected>$job</option>";
                  }
                  ?>
              </select>
          </div>
          <div class="profile-item"><strong>Member Dipilih:</strong>
              <select name="membership">
                  <?php
                  $member_list = ['VIP', 'PREMIUM', 'MVP'];
                  foreach ($member_list as $member) {
                      $selected = ($data['membership'] === $member) ? 'selected' : '';
                      echo "<option value='$member' $selected>$member</option>";
                  }
                  ?>
              </select>
          </div>
          <div class="profile-item"><strong>Tanggal Lahir:</strong>
              <?= date('d F Y', strtotime($tanggal_lahir)) ?> (<?= $umur ?> tahun)
          </div>
          <br>
          <button type="submit" name="save_changes" style="background-color: green; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Simpan</button>
      <?php else: ?>
          <div class="profile-item"><strong>Nama Lengkap:</strong> <?= htmlspecialchars($data['nama_lengkap']) ?></div>
          <div class="profile-item"><strong>Email:</strong> <?= htmlspecialchars($data['email']) ?></div>
          <div class="profile-item"><strong>Username:</strong> <?= htmlspecialchars($data['username']) ?></div>
          <div class="profile-item"><strong>Password:</strong> ••••••••</div>
          <div class="profile-item"><strong>Alamat Lengkap:</strong> <?= htmlspecialchars($data['alamat']) ?></div>
          <div class="profile-item"><strong>Pekerjaan:</strong> <?= htmlspecialchars($data['pekerjaan']) ?></div>
          <div class="profile-item"><strong>Tanggal Lahir:</strong> <?= date('d F Y', strtotime($tanggal_lahir)) ?> (<?= $umur ?> tahun)</div>
          <div class="profile-item"><strong>Member Dipilih:</strong> <?= htmlspecialchars($data['membership']) ?></div>
          <br>
          <button type="submit" name="edit_profile" style="background-color: orange; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Edit</button>
      <?php endif; ?>
        <button type="submit" name="delete_account" style="background-color: red; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-left: 10px;">Delete Account</button>
    </form>
</div>
</body>
</html>
