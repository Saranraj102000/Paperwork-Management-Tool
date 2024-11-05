<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up Form | CodingNepal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"> -->
   
  <style>

/* Google Fonts Link */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Montserrat", sans-serif;
}
    /* General body styling */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #000108;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /* Main content styling */
    .main-content {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 8px;
        padding: 40px 30px;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        transition: 0.3s ease;
    }

    /* Header styling */
    h3 {
        margin-bottom: 20px;
        font-size: 24px;
        text-align: center;
        color: #333;
    }

    /* Input box styling */
    .input_box {
        margin-bottom: 20px;
    }

    .input_box label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        color: #555;
    }

    .input_box input {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        color: #333;
        box-sizing: border-box;
        transition: border 0.3s ease;
    }

    .input_box input:focus {
        border-color: #3085d6;
        outline: none;
    }

    /* Button styling */
    #registerBtn {
        width: 100%;
        padding: 12px 0;
        background-color: #626CD6;
        border: none;
        border-radius: 5px;
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #registerBtn:hover {
        background-color: #4954d0;
    }

    /* Separator styling */
    .separator {
        text-align: center;
        margin: 20px 0;
        position: relative;
    }

    .separator span {
        background: #fff;
        padding: 0 10px;
        color: #666;
    }

    .separator:before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #ddd;
        z-index: 1;
    }

    /* Social login option styling */
    .login_option {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .option {
        width: 48%;
        text-align: center;
        background: #f1f1f1;
        padding: 10px 0;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .option:hover {
        background-color: #ddd;
    }

    .option img {
        width: 20px;
        margin-right: 10px;
        vertical-align: middle;
    }

    .option span {
        vertical-align: middle;
        font-size: 14px;
        color: #555;
    }

    /* Sign up link styling */
    .sign_up {
        text-align: center;
        margin-top: 20px;
        color: #666;
    }

    .sign_up a {
        color: #3085d6;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .sign_up a:hover {
        color: #1e73b5;
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

    form .input_box label {
    display: block;
    font-weight: 500;
    margin-bottom: 8px;
    color: #171645;
}

/* Input field styling */
form .input_box input {
    width: 100%;
    height: 57px;
    border: 1px solid #DADAF2;
    border-radius: 5px;
    outline: none;
    background: #F8F8FB;
    font-size: 17px;
    padding: 0px 20px;
    margin-bottom: 25px;
    transition: 0.3s ease;
}

form .input_box input:focus {
    border-color: #626cd6;
    box-shadow: 0 0 5px rgba(98, 108, 214, 0.5);
}

/* Password visibility toggle styling */
form .input_box .password_title {
    display: flex;
    justify-content: space-between;
    text-align: center;
}

form .input_box .password_title a {
    color: #626cd6;
    font-size: 14px;
    text-decoration: none;
    transition: 0.2s ease;
}

form .input_box .password_title a:hover {
    text-decoration: underline;
}

form .input_box {
    position: relative;
}
    /* Add this style if it's not already in your CSS file */
    .blur-background {
        filter: blur(5px);
        transition: filter 0.3s ease;
    }
  </style>
</head>
<body>
<div id="particles-js"></div>
  <div class="main-content">
    <div class="login_form">
      <!-- Sign Up form container -->
      <form id="registrationForm" method="POST">
        <!-- <h3>Signup with</h3> -->

      <center>
      <header>
            <img src="images.png" alt="Image" style="width: 50px; height: auto; margin-right: 5px; vertical-align: middle; margin-top: -10px;">
            <span style="font-size: 24px; color: #000;">Signup with</span>
      </header>
      </center> 
<br>
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

        <!-- Sign Up option separator -->
        <p class="separator">
          <span>or</span>
        </p>

        <!-- Name input box -->
        <div class="input_box">
          <label for="name">Full name</label>
          <input type="text" id="name" placeholder="Enter full name" name="name" required />
        </div>

        <!-- Email input box -->
        <div class="input_box">
          <label for="email">Email</label>
          <input type="email" id="email" placeholder="Enter email address" name="email" required />
        </div>

        <!-- Password input box -->
        <div class="input_box">
          <label for="password">Password</label>
          <input type="password" id="password" placeholder="Enter your password" name="password" required />
        </div>

        <!-- Sign up button -->
        <button type="button" id="registerBtn">Sign up</button>

        <p class="sign_up">Already have an account? <a href="login.php">Login</a></p>
      </form>
    </div>
  </div>

  <!-- Include SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
        $('#registerBtn').click(function(event) {
            event.preventDefault(); // Prevent form from submitting immediately

            // SweetAlert2 confirmation popup
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to proceed with the registration?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, register me!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform AJAX form submission
                    $.ajax({
                        url: 'register.php', // URL to the PHP script
                        type: 'POST',
                        data: $('#registrationForm').serialize(),
                        beforeSend: function() {
                            // Apply blur effect to the background content only
                            $('.main-content').addClass('blur-background');
                        },
                        success: function(response) {
                            // Display success message with animation
                            Swal.fire({
                                title: 'Registered Successfully!',
                                text: 'You have been registered successfully.',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000, // Auto close after 2 seconds
                                willClose: () => {
                                    // Remove blur effect after success message
                                    $('.main-content').removeClass('blur-background');
                                    // Redirect to login page after success animation
                                    window.location.href = 'login.php';
                                }
                            });
                        },
                        error: function() {
                            // Display error message
                            Swal.fire(
                                'Error!',
                                'There was an issue with your registration. Please try again later.',
                                'error'
                            ).then(() => {
                                // Remove blur effect after error message
                                $('.main-content').removeClass('blur-background');
                            });
                        }
                    });
                }
            });
        });
    });
  </script>
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
</body>
</html>
