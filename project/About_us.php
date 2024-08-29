
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Car Rental Company</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php session_start(); ?>
<header>
<?php
 require_once 'connection.php';
 require_once 'Car.php';
 $pdo = db_connect();
    require_once 'file.php';
    
    generateHeader();

    ?>
  
</header>
<nav>
   <?php
   displayUserLinks();
   ?> 

</nav>
<main>
    <header>
        <h1>About Us</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="About_us.html">About Us</a></li>
                <li><a href="car_search.php">Our Cars</a></li>
                <!-- <li><a href=\"contact.php\">Contact</a></li> -->
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Welcome to Our Car Rental Company</h2>
            <p>
                At [Car Rental Company], we are committed to providing top-notch car rental services that cater to all your transportation needs. Whether you need a car for a business trip, a family vacation, or a special event, we have a wide range of vehicles to choose from. Our fleet includes economy cars, luxury sedans, SUVs, and more.
            </p>
        </section>
        <section>
            <h2>Our Mission</h2>
            <p>
                Our mission is to offer reliable, affordable, and convenient car rental solutions to our customers. We strive to provide exceptional customer service and ensure that every rental experience is smooth and hassle-free.
            </p>
        </section>
        <section>
            <h2>Why Choose Us?</h2>
            <ul>
                <li><strong>Wide Selection of Vehicles:</strong> We offer a diverse range of vehicles to suit every need and budget.</li>
                <li><strong>Competitive Rates:</strong> Our pricing is transparent and competitive, with no hidden fees.</li>
                <li><strong>Excellent Customer Service:</strong> Our team is dedicated to assisting you with any questions or concerns you may have.</li>
                <li><strong>Convenient Locations:</strong> We have multiple locations to serve you better, making it easy to pick up and drop off your rental car.</li>
                <li><strong>Flexible Rental Options:</strong> Whether you need a car for a day, a week, or a month, we offer flexible rental periods to accommodate your schedule.</li>
            </ul>
        </section>
        <section>
            <h2>Our Team</h2>
            <p>
                Our team is comprised of experienced professionals who are passionate about delivering excellent service. From our friendly customer support staff to our knowledgeable maintenance crew, we work together to ensure that your rental experience exceeds your expectations.
            </p>
        </section>
        <section>
            <h2>Contact Us</h2>
            <p>
                If you have any questions or would like more information about our services, please feel free to contact us. We are here to help!
            </p>
            <ul>
                <li>Phone: [Customer Support Phone]</li>
                <li>Email: <a href="mailto:[Customer Support Email]">[Customer Support Email]</a></li>
                <li>Address: [Store Address]</li>
            </ul>
        </section>
    </main>
    <footer>
    <?php
    echo getFooter();
    ?>

</footer>
</body>
</html>
