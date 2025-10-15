<!-- 
    This file serves as the main entry point of the Web Shop application.
    It includes the header and footer files, displays a welcome message, and promotes the latest products and special deals.
-->

<?php session_start(); ?>
<?php include('header.php'); ?>

<main>
    <h1>Welcome to Our Shop!</h1>
    <p>Check out our latest products and special deals.</p>
    <div class="slideshow-container">
        <?php
        require_once('db.php');
        $result = mysqli_query($conn, "SELECT name, imageToPath FROM product LIMIT 5");

        $first = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $image = htmlspecialchars($row['imageToPath']);
            $name = htmlspecialchars($row['name']);
            $class = $first ? "slide fade show" : "slide fade";
            $first = false;
            echo "<div class='$class'>
                    <img src='$image' alt='$name'>
                    <div class='caption'>$name</div>
                </div>";
        }
        ?>
    </div>
    <br>
    <div style="text-align:center">       
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
        <span class="dot" onclick="currentSlide(5)"></span>

    </div>


</main>

<?php include('footer.php'); ?>
