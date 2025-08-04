<?php
session_start();
include 'koneksi.php'; // pastikan koneksi.php ada

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Ambil data user dari database
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama_lengkap'];
            header("Location: index.php?page=profile");
            exit;
        } else {
            $error = "Password salah";
        }
    } else {
        $error = "Username atau email tidak ditemukan";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Login - Gym</title>
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            height: 100vh;
            display: flex;
            flex-direction: column;
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
        /* ======== Login Section ======== */
        
        .login-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .login-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
        }
        
        form {
            display: flex;
            flex-direction: column;
        }
        
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        button {
            padding: 10px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        
        button:hover {
            background: #219150;
        }
        
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
        
        .register-link a {
            text-decoration: none;
            color: #003b8b;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }

      .error-message {
        color: red;
        text-align: center;
        margin-bottom: 15px;
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

  <!-- Login Form Section -->
  <div class="login-wrapper">
    <div class="login-container">
      <h2>Login to Your Gym Account</h2>

      <?php if (!empty($error)) echo "<div class='error-message'>$error</div>"; ?>

      <form action="" method="post">
        <label for="username">Username or Email</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
      </form>
      <div class="register-link">
        <p>Don't have an account? <a href="index.php?page=register">Register here</a></p>
      </div>
    </div>
  </div>

</body>
</html>
