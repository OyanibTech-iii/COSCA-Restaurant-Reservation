    <?php
    session_start();

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "customersdb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $verification_code = bin2hex(random_bytes(32)); // Generate a random verification code

        // Check if email already exists
        $checkEmail = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkEmail);

        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo "<script>
            window.onload = function(){

            // Create a new Audio object with the path to your sound file
const sound = new Audio('soundfx/errsound.mp3');
// Play the sound when the SweetAlert is triggered
sound.play();

Swal.fire({
  title: '<span class =\"custom-swal-title\">Login Failed<br><span class =\"username\"><?= echo $username ?> </span>is Already Exist</span>',
  html: '<span class =\"custom-swal-errorMessage\"><br>try again</span>',
  icon: 'warning',
  confirmButtonText: 'Ok',
  customClass: {
  popup: 'custom-swal-popup',
  confirmButton: 'custom-swal-button',
        }
});
        };
  </script>
  <style> 
  .username{
color: rgb(216, 213, 213);
  font-weight: bold;
        }
  .custom-swal-errorMessage{
        color: rgb(142, 137, 137);
        }
  .custom-swal-title {
  font-size: 32px;
            color: rgb(142, 137, 137);
            letter-spacing: 2px;
        }
  .custom-swal-popup{
  border-radius: 12px;
                background: rgba(4, 4, 4, 0.99);
        }
  .custom-swal-button{
  border:none;
  background-color: green;
        }
   .custom-swal-button:before{
  border:none;
        }
  </style>";
        } else {
            // Insert new user into database
            $query = "INSERT INTO users (username, email, password, is_verified, verification_code) 
                    VALUES (?, ?, ?, 0, ?)";

            $stmt = $conn->prepare($query);

            if (!$stmt) {
                header("Location: signup.php");
            }

            $stmt->bind_param("ssss", $username, $email, $password, $verification_code);

            if ($stmt->execute()) {
                echo "Account created! Please verify your email.";
                $_SESSION['email'] = $email;
                header("Location: login.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }

    $conn->close();
    ?>
    <!-- html document for animation and display -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#3498db">
        <title>Sign Up Page</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="icon" type="image/webp" href="assets/logo.webp">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="signup.css">
    </head>

    <body>
        <!-- canvas declaration -->
        <!-- sign up form -->
        <canvas id="particleCanvas"></canvas>
        <div class="signup-container">
            <h2>Create Account</h2>
            <img src="assets/logo.webp" alt="Company Logo" class="logo">
            <form method="post" action="signup.php">
                <input type="text" name="username" placeholder="Username" autocomplete="off" required>
                <input type="email" name="email" placeholder="Email" autocomplete="off" required>
                <div class="password-container">
                    <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required>
                    <span class="eye-icon" id="toggle-password" onclick="togglePassword()">
                        <i id="eye-icon" class="fas fa-eye"></i>
                    </span>
                </div>

                <button id="btnSubmit" type="submit">Sign Up</button>
            </form>
            <a href="login.php">Already have an account? <b>Log In<b></a>
        </div>
        <script>
            // hide and show password icon && logic
            function togglePassword() {
                const passwordInput = document.getElementById("password");
                const eyeIcon = document.getElementById("eye-icon");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text"; // Show password
                    eyeIcon.classList.remove("fa-eye"); // Remove closed eye icon
                    eyeIcon.classList.add("fa-eye-slash"); // Add open eye icon
                } else {
                    passwordInput.type = "password"; // Hide password
                    eyeIcon.classList.remove("fa-eye-slash"); // Remove open eye icon
                    eyeIcon.classList.add("fa-eye"); // Add closed eye icon
                }
            }



            //checking button if active
            const signup = document.querySelector("#btnSubmit");
            signup.addEventListener('click', (event) => {
                // debugging display
                console.log("Button is Actived");
            });
            // canvas for background animation
            const canvas = document.getElementById("particleCanvas");
            const ctx = canvas.getContext("2d");

            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            const particles = [];

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.size = Math.random() * 5 + 1;
                    this.speedY = Math.random() * 2 + 0.2;
                    this.color = `rgba(255, 255, 255, ${Math.random()})`;
                }
                update() {
                    this.y += this.speedY;
                    if (this.y > canvas.height) {
                        this.y = 0 - this.size;
                        this.x = Math.random() * canvas.width;
                    }
                }
                draw() {
                    ctx.fillStyle = this.color;
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            function init() {
                for (let i = 0; i < 100; i++) {
                    particles.push(new Particle());
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach((particle) => {
                    particle.update();
                    particle.draw();
                });
                requestAnimationFrame(animate);
            }

            init();
            animate();
            window.addEventListener("resize", () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                particles.length = 0;
                init(); // Repopulate the particles
            });
        </script>
    </body>

    </html>