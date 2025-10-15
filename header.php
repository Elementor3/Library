<!-- 
    This file contains the header section of the Web Shop application.
    It includes the navigation links and user indication.
    It also conditionally displays the "Admin Panel" link based on the user -->
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Shop</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
    <div id="message-box" style="display: none ;" class="message-box"></div>

    <header>
        <div class="header-content">
             <!-- Display the current user if logged in -->
            <div class="user-indication">
                <?php if (isset($_SESSION['username'])) { ?>
                    <p class="current-user"><?php echo $_SESSION['username']; ?></p>
                <?php } ?>
            </div>
            <nav>
                <a href="index.php">Home</a>
                <a href="products.php">Products</a>
                <a href="cart.php" class="cart-icon-link">
                    <i class="fas fa-cart-shopping"></i>
                    <span class="cart-count">
                        <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
                    </span>
                </a>


                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
                 <!-- Show Admin Panel link only for admin users -->
                <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) { ?>
                    <a href="admin_panel.php">Admin Panel</a>
                <?php } ?>
                
            </nav>
        </div>
    </header>
    <script>
        function showMessage(message, type = 'success') {
            const box = document.getElementById('message-box');
            box.textContent = message;
            box.className = 'message-box message-' + type;

            // Reset opacity to 0
            box.style.opacity = '0';
            box.style.display = 'block';

            // Force reflow to ensure transition triggers
            void box.offsetWidth;

            // Fade in
            box.style.opacity = '1';

            // Auto-hide after 3s
            setTimeout(() => {
                box.style.opacity = '0';
                setTimeout(() => {
                    box.style.display = 'none';
                }, 500);
            }, 3000);
        }
        let slideIndex = 0;
        let slideTimer;

        document.addEventListener("DOMContentLoaded", () => {
        const slides = document.getElementsByClassName("slide");
        const dots = document.getElementsByClassName("dot");

        function showSlides() {
            for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
            }
            for (let i = 0; i < dots.length; i++) {
            dots[i].classList.remove("active");
            }

            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1; }

            if (slides.length > 0) {
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1]?.classList.add("active");
            }

            slideTimer = setTimeout(showSlides, 6000);
        }

        function currentSlide(n) {
            clearTimeout(slideTimer);     
            slideIndex = n - 1;
            showSlides();                   
        }

        window.currentSlide = currentSlide;

        showSlides();
        });

    </script>
