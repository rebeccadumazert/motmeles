<?php
$user_id = $_GET['id'];
$token = $_GET['token'];
require 'db.php';
$req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();
//recuper le parametre d'url token et l'id suite à la validation du lien dans le mail par l'utilisateur et le compare avec le tokende l'id correspondant dans la BDD enregistrer..
if ($user && $user->confirmation_token == $token){
    session_start();
    // Efface le confirmation token et ajoute la date au confirmation_at
$req = $pdo->prepare('UPDATE users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?')->execute([$user_id]);
    $_SESSION['auth'] = $user;
    header('Location: account.php');

} else {
    die('pas ok');
}
