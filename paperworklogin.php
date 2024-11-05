<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="animatedloginstyles.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>VDart PMT</title>
    <link rel="icon" href="images.png" type="image/png">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
}

body{
    background-color: #c9d6ff;
    background: linear-gradient(to right, #e2e2e2, #c9d6ff);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    height: 100vh;
}

.container{
    background-color: #fff;
    border-radius: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
    position: relative;
    overflow: hidden;
    width: 768px;
    max-width: 100%;
    min-height: 480px;
}

.container p{
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.3px;
    margin: 20px 0;
}

.container span{
    font-size: 12px;
}

.container a{
    color: #333;
    font-size: 13px;
    text-decoration: none;
    margin: 15px 0 10px;
}

.container button{
    background-color: #512da8;
    color: #fff;
    font-size: 12px;
    padding: 10px 45px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-top: 10px;
    cursor: pointer;
}

.container button.hidden{
    background-color: transparent;
    border-color: #fff;
}

.container form{
    background-color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    height: 100%;
}

.container input{
    background-color: #eee;
    border: none;
    margin: 8px 0;
    padding: 10px 15px;
    font-size: 13px;
    border-radius: 8px;
    width: 100%;
    outline: none;
}

.form-container{
    position: absolute;
    top: 0;
    height: 100%;
    transition: all 0.6s ease-in-out;
}

.sign-in{
    left: 0;
    width: 50%;
    z-index: 2;
}

.container.active .sign-in{
    transform: translateX(100%);
}

.sign-up{
    left: 0;
    width: 50%;
    opacity: 0;
    z-index: 1;
}

.container.active .sign-up{
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: move 0.6s;
}

@keyframes move{
    0%, 49.99%{
        opacity: 0;
        z-index: 1;
    }
    50%, 100%{
        opacity: 1;
        z-index: 5;
    }
}

.social-icons{
    margin: 20px 0;
}

.social-icons a{
    border: 1px solid #ccc;
    border-radius: 20%;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    margin: 0 3px;
    width: 40px;
    height: 40px;
}

.toggle-container{
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: all 0.6s ease-in-out;
    border-radius: 150px 0 0 100px;
    z-index: 1000;
}

.container.active .toggle-container{
    transform: translateX(-100%);
    border-radius: 0 150px 100px 0;
}

.toggle{
    background-color: #512da8;
    height: 100%;
    background: linear-gradient(to right, #5c6bc0, #512da8);
    color: #fff;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.container.active .toggle{
    transform: translateX(50%);
}

.toggle-panel{
    position: absolute;
    width: 50%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 30px;
    text-align: center;
    top: 0;
    transform: translateX(0);
    transition: all 0.6s ease-in-out;
}

.toggle-left{
    transform: translateX(-200%);
}

.container.active .toggle-left{
    transform: translateX(0);
}

.toggle-right{
    right: 0;
    transform: translateX(0);
}

.container.active .toggle-right{
    transform: translateX(200%);
}
</style>
<style>
    /* Modal container */
    .modal {
        display: none; 
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.6);
        justify-content: center;
        align-items: center;
    }

    /* Modal content */
    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        animation: slideDown 0.3s ease-out;
    }

    /* Slide down animation */
    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Modal close button */
    .close-btn {
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 20px;
    }

    .close-btn:hover {
        background-color: #2980b9;
    }

    /* Success/Failure styles */
    .modal-header.success {
        color: #27ae60;
    }
    
    .modal-header.error {
        color: #e74c3c;
    }

    /* The popup modal */
    .popup {
    display: none; /* Hidden by default */
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.4);
    z-index: 1;
    }

    /* Popup content */
    .popup-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    width: 30%;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    /* Close button */
    .close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 20px;
    cursor: pointer;
    }

    .login-icons .icon {
    margin-right: 15px; /* Adds space between icons */
    text-decoration: none; /* Removes underline on links */
    color: #333; /* Sets the icon color to a neutral tone */
    font-size: 20px; /* Adjusts icon size */
}

.login-icons .icon:last-child {
    margin-right: 0; /* Removes extra space after the last icon */
}

.registration-icons .icon {
    margin-right: 15px; /* Adds space between icons */
    text-decoration: none; /* Removes underline on links */
    color: #333; /* Sets the icon color to a neutral tone */
    font-size: 20px; /* Adjusts icon size */
}

.registration-icons .icon:last-child {
    margin-right: 0; /* Removes extra space after the last icon */
}

/* Slide in for the heading */
@keyframes slideIn {
    from {
        transform: translateX(-100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Fade in for the paragraph */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Bounce animation for the button */
@keyframes bounceIn {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-20px);
    }
    60% {
        transform: translateY(-10px);
    }
}

/* Paperwork movement animation (for a paperwork effect) */
@keyframes paperworkMove {
    0% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
    100% {
        transform: translateY(0);
    }
}

/* Styling for the paper icon (optional, related to paperwork) */
.paper-icon {
    font-size: 40px;
    color: #666;
}


/* Slide in from the right for the heading */
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Fade in for the paragraph */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Bounce animation for the button */
@keyframes bounceIn {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-20px);
    }
    60% {
        transform: translateY(-10px);
    }
}

/* Paperwork movement animation */
@keyframes paperworkMove {
    0% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
    100% {
        transform: translateY(0);
    }
}

</style>


<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form id="signupForm" method="POST" action="animatedsignup.php">

            <h1 style="display: flex; align-items: center; font-size: 32px; color: #000; margin: 0;">
                <img src="images.png" alt="Sign In Icon" style="width: 50px; height: auto; margin-right: 3px; margin-left: -30px">
                Create account
            </h1>

            <div class="registration-icons">
                <a  class="icon" aria-label="Username"><i class="fa-solid fa-user"></i></a>
                <a  class="icon" aria-label="Email"><i class="fa-solid fa-envelope"></i></a>
                <a  class="icon" aria-label="Password"><i class="fa-solid fa-key"></i></a>
                <a  class="icon" aria-label="Register"><i class="fa-solid fa-user-plus"></i></a>
            </div>

                <span>Use your email for registration</span>
                <input type="text" name="fullname" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign Up</button>
            </form>
        </div>

       

        <div class="form-container sign-in">
            <form id="loginForm" method="POST" action="animatedloginval.php">
                
            <h1 style="display: flex; align-items: center; font-size: 22px; color: #000; margin-left: 28px; margin-top: -80px">
                <img src="images.png" alt="Sign In Icon" style="width: 50px; height: auto; margin-right: 3px; margin-left: -30px">
                Paperwork Management Tool
            </h1>
<br>
                <div class="login-icons">
                    <a  class="icon" aria-label="User"><i class="fa-solid fa-id-badge"></i></a>
                    <a  class="icon" aria-label="Email"><i class="fa-solid fa-at"></i></a>
                    <a  class="icon" aria-label="Password"><i class="fa-solid fa-shield-alt"></i></a>
                    <a  class="icon" aria-label="Lock"><i class="fa-solid fa-unlock-alt"></i></a>
                    <a  class="icon" aria-label="Fingerprint"><i class="fa-solid fa-hand-sparkles"></i></a>
                    <a  class="icon" aria-label="Login"><i class="fa-solid fa-door-open"></i></a>
                </div>


                <span>Enter your email password</span>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <!-- <a href="#" onclick="showPopup(); return false;">Forget Your Password?</a> -->

                

                <button type="submit">Sign In</button>
            </form>

            
        </div>

        
        <div class="toggle-container">
        <div class="toggle" style="display: flex; justify-content: space-between; align-items: center;">
            <!-- Left Panel -->
            <div class="toggle-panel toggle-left" style="text-align: center; position: relative; flex: 1; padding: 20px;">
                <h1 style="animation: bounceIn 2s ease-out;">Welcome Back!</h1>
                <!-- <p style="animation: fadeIn 1.5s ease-out;">Enter your personal details to use all of site features</p> -->
                <button class="hidden" id="login" style="animation: bounceIn 2s ease-out;">Sign In</button>

                <!-- Optional paperwork icon for animation -->
                <!-- <div class="paper-icon" style="position: absolute; bottom: 10px; left: 10px; animation: paperworkMove 2s infinite;">
                    <i class="fa-solid fa-file-alt" style="font-size: 40px; color: #666;"></i>
                </div> -->
            </div>

            <!-- Right Panel -->
            <div class="toggle-panel toggle-right" style="text-align: center; position: relative; flex: 1; padding: 20px;">
                <h1 style="animation: bounceIn 2s ease-out;">Create an account!</h1>
                <!-- <p style="animation: fadeIn 1.5s ease-out;">Register with your personal details to use all of site features</p> -->
                <button class="hidden" id="register" style="animation: bounceIn 2s ease-out;">Sign Up</button>

                <!-- Paperwork icon (optional, representing paperwork animation) -->
                <!-- <div class="paper-icon" style="position: absolute; bottom: 10px; right: 10px; animation: paperworkMove 2s infinite;">
                    <i class="fa-solid fa-file-alt" style="font-size: 40px; color: #666;"></i>
                </div> -->
            </div>
        </div>

            <!-- Popup Modal -->
            <div id="popup" class="popup" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0, 0, 0, 0.5); align-items:center; justify-content:center;">
                <div class="popup-content" style="position:relative; max-width:600px; padding:20px; border:1px solid #888; background-color:white; border-radius:10px; text-align:center; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);">
                    <!-- Close button or 'X' icon to close the popup -->
                    <span class="close" aria-label="Close" onclick="closePopup()" style="position:absolute; top:10px; right:15px; font-size:25px; font-weight:bold; cursor:pointer;">&times;</span>
                    <h2>Reset Your Password</h2>
                    <p>Please enter your email to reset your password.</p>
                    <form id="forgotPasswordForm" method="POST">
                        <input type="email" id="email" name="email" placeholder="Enter your email" required style="width:100%; padding:10px; margin-bottom:10px;" />
                        <input type="password" id="newPassword" name="new_password" placeholder="Enter new password" required style="width:100%; padding:10px; margin-bottom:10px;" />
                        <button type="submit" style="padding:10px 20px; background-color:#4CAF50; color:white; border:none; cursor:pointer;">Reset Password</button>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <!-- Modal Structure -->
    <div id="popupModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle" class="modal-header"></h2>
            <p id="modalMessage"></p>
            <button id="modalCloseBtn" class="close-btn">OK</button>
        </div>
    </div>

    <!-- Popup Modal -->
    <div id="popupModal" class="modal hidden">
        <div class="modal-content">
            <h2 id="modalTitle"></h2>
            <p id="modalMessage"></p>
            <button id="modalCloseBtn">Close</button>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
          // Function to show the modal
function showModal(title, message, status) {
    const modal = document.getElementById('popupModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    
    // Apply success or error styles
    if (status === 'success') {
        modalTitle.classList.add('success');
        modalTitle.classList.remove('error');
    } else {
        modalTitle.classList.add('error');
        modalTitle.classList.remove('success');
    }

    modalTitle.textContent = title;
    modalMessage.textContent = message;
    
    // Show the modal
    modal.style.display = 'flex';

    // Close modal when clicking the button
    document.getElementById('modalCloseBtn').onclick = function() {
        modal.style.display = 'none';
    };

    // Optional: Close modal when clicking outside the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
}

// Event listener for form submission
document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting immediately

    // Get form data
    const form = event.target;
    const formData = new FormData(form);

    // Send data via fetch
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())  // Ensure the response is JSON
    .then(data => {
        if (data.status === 'success') {
            showModal('Success!', 'You are logged in!', 'success');
            setTimeout(() => {
                window.location.href = data.redirect;
            }, 2000); // Optional delay before redirect
        } else if (data.status === 'error') {
            showModal('Invalid Login!', data.message, 'error');
        }
    })
    .catch(error => {
        showModal('Error!', 'Something went wrong while processing your request.', 'error');
    });
});

        </script>
<script>
    const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});
</script>

<script>
    // Function to show the modal
function showModal(title, message, status) {
    const modal = document.getElementById('popupModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    
    // Apply success or error styles
    if (status === 'success') {
        modalTitle.classList.add('success');
        modalTitle.classList.remove('error');
    } else {
        modalTitle.classList.add('error');
        modalTitle.classList.remove('success');
    }

    modalTitle.textContent = title;
    modalMessage.textContent = message;
    
    // Show the modal
    modal.style.display = 'flex';

    // Close modal when clicking the button
    document.getElementById('modalCloseBtn').onclick = function() {
        modal.style.display = 'none';
    };

    // Optional: Close modal when clicking outside the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
}

// Event listener for form submission
document.getElementById('signupForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting the usual way

    // Get form data
    const form = event.target;
    const formData = new FormData(form);

    // Send data via fetch
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())  // Ensure the response is JSON
    .then(data => {
        if (data.status === 'success') {
            showModal('Success!', 'Signup successful!', 'success');
            setTimeout(() => {
                window.location.href = 'paperworklogin.php'; // Redirect after delay
            }, 2000); // Optional delay before redirect
        } else if (data.status === 'error') {
            showModal('Error!', data.message, 'error');
        }
    })
    .catch(error => {
        showModal('Error!', 'Something went wrong while processing your request.', 'error');
    });
});
</script>


<script>
  // Function to show the popup
  function showPopup() {
    document.getElementById("popup").style.display = "flex";
  }

  // Function to close the popup
  function closePopup() {
    document.getElementById("popup").style.display = "none";
  }

  document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('forgotPasswordForm');
    
    if (form) {
      form.onsubmit = function(event) {
        event.preventDefault();
        
        var email = document.getElementById('email').value;
        var newPassword = document.getElementById('newPassword').value;

        if (email === "" || newPassword === "") {
          alert("Both fields are required.");
          return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'reset_password.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
          if (xhr.status === 200) {
            alert(xhr.responseText);
            closePopup();
          } else {
            alert("An error occurred. Please try again.");
          }
        };

        xhr.onerror = function() {
          alert("Request failed. Please check your network connection.");
        };

        xhr.send('email=' + encodeURIComponent(email) + '&new_password=' + encodeURIComponent(newPassword));
      };
    }

    // Close the popup when clicking outside of the popup-content
    var popup = document.getElementById('popup');
    popup.addEventListener('click', function(event) {
      if (event.target === popup) {
        closePopup();
      }
    });
  });
</script>

</body>

</html>
