<?php
session_start();
require 'function.php';
?>

<?php 
    require 'head.php';
    require 'header.php';
?>

<h1>Votre Compte</h1>

<?php debug($_SESSION); ?>

<?php 
    require 'footer.php'; 
?>