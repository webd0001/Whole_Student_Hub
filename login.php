<?php
// Redirect to the actual login page in auth folder
header("Location: auth/login.php" . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : ''));
exit();
?>
