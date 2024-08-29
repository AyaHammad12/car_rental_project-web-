<?php
// session_start();





function displayUserLinks() {
    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['role'] == 'maneger') { ?>
            <!-- Manager-specific links -->
            <a href="add_car.php">Add car</a><br>
            <a href="add_location_form.php">Add Location</a><br>
            <a href="manager_finalize_return.php">Return car</a><br>
            <a href="car_search.php">Search car</a><br>
            <a href="car_incuery.php">Inquiry car</a><br>
            <a href="About_us.php">About us</a><br>
            <a href="step1.php">Registration</a><br>
            <a href="logout.php">Logout</a><br>
        <?php } else { ?>
            <!-- Customer-specific links -->
            <a href="profile.php"><?php echo ($_SESSION['username']); ?></a><br>
            <a href="view_rented_cars.php">View rented cars</a><br>
            <a href="customer_return_car.php">Return car</a><br>
            <a href="car_search.php">Search car</a><br>
            <a href="rent.php">Rent car</a><br>
            <a href="step1.php">Sign-Up</a><br>
            <a href="logout.php">Logout</a><br>
            <a href="login.php">Login</a><br>
            <a href="About_us.php">About us</a><br>
        <?php }
    } else { ?>
        <!-- Links for non-logged-in users -->
        <a href="car_search.php">Search car</a><br>
        <a href="login.php">Login</a><br>
        <a href="About_us.php">About us</a><br>
        <a href="step1.php">Registration</a><br>
    <?php }
}



// function getHeader() {
//     return "
//         <header>
//             <h1>Welcome to Koton Style :) <img src=\"./images/Screenshot.png\" alt=\"logo\" width=\"50\" height=\"60\"></h1>
//             <hr>
//             <nav>
//                 <ul>
//                     <li><a href=\"./../index.html\">Personal page</a></li>
//                     <li><a href=\"./products.php\">Home ass2 </a></li>
//                     <li><a href=\"./../ass/ass1/index.html\">Home</a></li>
                    
//                     <li><a href=\"./../ass/ass1/product1.html\">Products</a></li>
//                     <li><a href=\"./../ass/ass1/contact.html\">Contact Us</a></li>
//                     <li><a href=\"./../ass/ass1/registration.html\">Register</a></li>
//                 </ul>
//             </nav>
//             <hr>
//         </header>
//     ";
// }




function generateHeader() {
   
    // Agency name and logo
    echo '<span >BZU Car Rental </span>';

    echo '<img src="logo.png" alt="Logo" class="logo">';

    // About us page link
    echo '<a href="about_us.php">About Us</a>';
    
    
    if (isset($_SESSION['user_id'])&&  $_SESSION['role'] == 'customer') {
        // User profile link
        echo '<a href="profile.php">' . htmlspecialchars($_SESSION['username']) . '</a>';
        
       
    }else if (isset($_SESSION['user_id'])&& ($_SESSION['role'] == 'maneger')) {
        // User profile link
        echo  $_SESSION['username'] ;
        echo '<a href="car_incuery.php">search incuery</a>';
        }

        echo '<a href="login.php">Login</a>';
        
        echo '<a href="logout.php">Logout</a>';
      
       
    }
    
    function getFooter() {
        $lastUpdate = "JUNE 22, 2024";
        $storeAddress = "123 Ramallah Street, Ramallah, Palestine";
        $customerSupportPhone = "+0598527811";
        $customerSupportEmail = "BZUCar_Rental@gmail.com";
        $contactPage = "./../ass/ass1/contact.html";
        $companyName = "Koton Style";
        $year = date("Y");

        return "
        <footer>
            <hr>
            <ul>
                <li><img src=\"logo.png\" alt=\"Logo\" class=\"logo\"></li>
                <li>Last Update: {$lastUpdate}</li>
                <li>Store Address: {$storeAddress}</li>
                <li>Customer Support: Phone: {$customerSupportPhone} | Email: <a href=\"mailto:{$customerSupportEmail}\">{$customerSupportEmail}</a></li>
                <li><a href=\"{$contactPage}\">Contact Us</a></li>
                <li>&copy; {$year} {$companyName}. All rights reserved.</li>
            </ul>
        </footer>
    ";

    }

   
?>