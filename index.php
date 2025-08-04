<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);

// Tangani aksi logout
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>FitClub</title>
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
        header {
            background-color: #2c3e50;
            color: white;
            padding: 40px 0;
            text-align: center;
            margin: 0;          
            border: none;        
        }

        header * {
            margin: 2px;
            padding: 20px;
        }

        body {
            margin: 0;
            padding: 0;
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
    <script>
        function selectMembership(type) {
            // Scroll ke bagian form
            const formSection = document.getElementById("register-form");
            if (formSection) {
                formSection.scrollIntoView({ behavior: "smooth" });
            }

            // Pilih opsi pada dropdown
            const select = document.querySelector("select[name='membership']");
            if (select) {
                select.value = type;
            }
        }
    </script>
</head>
<body>


<!-- Navbar -->
  <div class="navbar">
    <h1>FitClub</h1>
    <ul>
        <li><a href="#membership-section">Membership</a></li>
        <li><a href="#trainer-section">Trainer</a></li>
        <li><a href="#lokasi-section">Location</a></li>

        <?php if (!$isLoggedIn): ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php else: ?>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="?logout=true">Logout</a></li>
        <?php endif; ?>
    </ul>
  </div>

<header>
    <h1>Welcome to Gym</h1>
    <p>Get Fit, Stay Healthy, Be Happy</p>
</header>

<section class="about" >
    <h2>About Us</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
</section>

<!-- MEMBERSHIP -->
<section id="membership-section">
    <h2 style="text-align: center;">Choose Your Membership</h2>
    <div class="membership-container">
        <div class="membership-card blue">
            <h3>VIP</h3>
            <p class="price">Rp 300.000 / month</p>
            <ul><li>Basic Gym Access</li><li>Group Classes</li><li>Locker</li></ul>
            <button> <a href="register.php"> Choose  </a></button>
        </div>
        <div class="membership-card red">
            <h3>PREMIUM</h3>
            <p class="price">Rp 500.000 / month</p>
            <ul><li>All Blue Benefits</li><li>Premium Facilities</li><li>Private Coach</li></ul>
            <button> <a href="register.php"> Choose  </a></button>
        </div>
        <div class="membership-card gold">
            <h3>MVP</h3>
            <p class="price">Rp 1.000.000 / month</p>
            <ul><li>Pilates Access</li><li>Group Classes</li><li>All Ultra Benefits</li></ul>
            <button> <a href="register.php"> Choose  </a></button>
        </div>
    </div>
</section>

<!-- Trainer -->

<section id="trainer-section">
  <h2>Personal Trainers</h2>
  <div class="trainer-container">
    <div class="trainer-card">
        <img src="image/trainer1.png" alt="Trainer 1" width="200">
      <h3>Strength Coach</h3>
      <p>Gusti </p>
    </div>
    <div class="trainer-card">
         <img src="image/trainer2.png" alt="Trainer 2" width="200">
      <h3>Nutrition Specialist</h3>
      <p>Reza </p>
    </div>
    <div class="trainer-card">
         <img src="image/trainer3.jpg" alt="Trainer 3" width="200">
      <h3>Yoga Instructor</h3>
      <p>Ramzy</p>
  
<!-- GMAPS -->

</section>
<section id="lokasi-section">
    <h2>Our Location</h2>
    <iframe src="https://maps.google.com/maps?q=jakarta&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
</section>

</body>
</html>
