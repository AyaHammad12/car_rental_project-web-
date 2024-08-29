
<?php
try {
  

session_start();
session_destroy();
header("Location: login.php");
exit();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    return null;
}
?>

