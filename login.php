<!DOCTYPE html>
<!-- Source Codes By CodingNepal - www.codingnepalweb.com -->
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Form in HTML and CSS | CodingNepal</title>
  <link rel="stylesheet" href="loginstyles.css" />
</head>
<style>
  /* ===== Google Font Import - Poppins ===== */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
  /* General Reset and Styling */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Montserrat", sans-serif;
}

body {
    width: 100%;
    min-height: 170vh;
    margin: 0;
    overflow: hidden; /* Prevent scrollbars */
    background: #000108;
}

/* Background Particles Styling */
#particles-js {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: -1; /* Place behind the form */
}

/* Login Form Styling */
.login_form {
    width: 100%;
    max-width: 435px;
    background: #fff;
    border-radius: 8px;
    padding: 40px 30px;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    transition: 0.3s ease;
    position: relative; /* Ensure it stays above the background */
    margin: 0 auto;
    top: 50%;
    transform: translateY(-50%); /* Center vertically */
}

.login_form:hover {
    box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
}

.login_form h3 {
    font-size: 22px;
    text-align: center;
    margin-bottom: 20px;
}

/* Additional Styles as needed for the login form */
</style>
<body>
<div id="particles-js"></div>
  <div class="login_form">
    <!-- Login form container -->
    <form action="loginvalidation.php" method="POST">
      <!-- <h3>Log in with</h3> -->
      <center>
      <header>
            <img src="images.png" alt="Image" style="width: 50px; height: auto; margin-right: 5px; vertical-align: middle; margin-top: -10px;">
            <span style="font-size: 24px; color: #000;">Login with</span>
      </header>
      </center> 

      <div class="login_option">
        <!-- Google button -->
        <div class="option">
          <a href="#">
            <img src="google.png" alt="Google" />
            <span>Google</span>
          </a>
        </div>

        <!-- Apple button -->
        <div class="option">
          <a href="#">
            <img src="apple.png" alt="Apple" />
            <span>Apple</span>
          </a>
        </div>
      </div>

      <!-- Login option separator -->
      <p class="separator">
        <span>or</span>
      </p>

      <!-- Email input box -->
      <div class="input_box">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Enter email address" name="email" required />
      </div>

      <!-- Paswwrod input box -->
      <div class="input_box">
        

      <label for="password">Password</label>
        <input type="password" id="password" placeholder="Enter your password" name="password" required />

        <div class="password_title">
          
          <a href="#">Forgot Password?</a><br><br>
        </div>

      </div>

       <!-- Login button -->
      <button type="submit">Log In</button>

      <p class="sign_up">Don't have an account? <a href="signup.php">Sign up</a></p>
    </form>
  </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
// script.js
particlesJS('particles-js', {
    "particles": {
        "number": {
            "value": 100,
            "density": {
                "enable": true,
                "value_area": 800
            }
        },
        "color": {
            "value": "#ffffff"
        },
        "shape": {
            "type": "circle",
            "stroke": {
                "width": 0,
                "color": "#000000"
            },
            "polygon": {
                "nb_sides": 5
            }
        },
        "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
                "enable": false,
                "speed": 1,
                "opacity_min": 0.1,
                "sync": false
            }
        },
        "size": {
            "value": 3,
            "random": true,
            "anim": {
                "enable": true,
                "speed": 10,
                "size_min": 0.1,
                "sync": false
            }
        },
        "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1
        },
        "move": {
            "enable": true,
            "speed": 6,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 1200
            }
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
            "onhover": {
                "enable": true,
                "mode": "bubble" // Change to 'repulse' if you prefer particles moving away from the cursor
            },
            "onclick": {
                "enable": true,
                "mode": "push"
            },
            "resize": true
        },
        "modes": {
            "grab": {
                "distance": 100,
                "line_linked": {
                    "opacity": 1
                }
            },
            "bubble": {
                "distance": 100,
                "size": 10, // Adjusted for a more visible effect
                "duration": 2,
                "opacity": 1,
                "speed": 3
            },
            "repulse": {
                "distance": 150, // Adjusted for better interaction
                "duration": 0.4
            },
            "push": {
                "particles_nb": 4
            },
            "remove": {
                "particles_nb": 2
            }
        }
    },
    "retina_detect": true
});
</script>
