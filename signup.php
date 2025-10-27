<?php
// Redirect to the actual signup page in auth folder
header("Location: auth/signup.php" . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : ''));
exit();
?>
