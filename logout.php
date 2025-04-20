<?php
session_start();
session_unset(); 
session_destroy(); 
header("Location: PreMenu.html"); // bring them here!
exit;
?>
