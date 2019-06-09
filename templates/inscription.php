<?php
require_once 'function.php'; 
    if(!empty($_POST)){
        $errors = array();
        require_once 'db.php'; //Permet de se connecter a la BDD
        //Verifie l'identifiant
        if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])){
            $errors['username'] = "Votre pseudo n'est pas valide";
        //Verifie que l'indentifiant n'existe pas déja dans la BDD
        } else {
            $req = $pdo->prepare('SELECT id FROM users WHERE username = ?');
            $req->execute([$_POST['username']]);
            $user = $req->fetch();
            if($user){
                $errors['username']='Ce pseudo est deja pris';
            }
        }
        if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = "Votre email n'est pas valide";
        } else {
            $req = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $req->execute([$_POST['email']]);
            $user = $req->fetch();
            if($user){
                $errors['email']='Cet email est deja pris';
            }
        }
        if(empty($_POST['password']))/*  || $_POST['password'] != $_POST['password_confirm']) */{
            $errors['password'] = "Votre mot de passe n'est pas valide";
        }
        //Si pas d'erreurs alors enregistrer les informations dans la BDD
        if(empty($errors)){
            $req = $pdo->prepare ("INSERT INTO users SET username = ?, password = ?, email = ?, confirmation_token = ?");
            //Securise le MDP en le cryptant 
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            // Fonction token pour la confirmation par e-mail
            $token = str_random(60);
            $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
            $user_id = $pdo->lastInsertId(); //recuperer le dernier id enregistrer et envoi un mail avec les code token 
            //configuration prealable pour fonctionnement d'envoi de mail en local avec fonction php mail (installer send mail et config boite mail et fichier conf/php.ini)
            mail($_POST['email'], 'Confirmation de votre comptre', "Afin de valider votre compte merci de cliquer sur ce lien/n/nhttp://rebzomar.test/templates/confirm.php?id=$user_id&token=$token");
            header('Location: connexion.php');
            exit();
        }
    }

    /* echo "<pre>";
    print_r($_POST);
    echo "</pre>"; */

    debug($errors)

?>

<html>
    <head>
    <?php
        include('./head.php');
    ?>
    </head>
    <body>
        <main> 
            <?php
            include('./header.php');
            ?>
 
        <div class="central">
            <h3 class="inscription">INSCRIPTION</h3>
            <!-- Creer une alert (qui ne fonctionne pas) qui liste toutes les erreurs et le signal a l'utilisateur avec une alert -->
            <?php
            if(!empty($errors)) {     
            ?>
                <div class= "alert alert-danger">
                    <p>Vous n'avez pas rempli le formulaire correctement</p>
                    <ul>
                        <?php
                        foreach($errors as $error){
                        ?>
                            <li>
                                <?= $error; ?>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            <?php
            }     
            ?>
            <form action="" method="POST">
                <div>
                    <label for="">Pseudo :</label>
                    <input type="text" class="inp" name="username"/>
                </div>
                <div>
                    <label for="">E-mail :</label>
                    <input type="email" class="inp" name="email"/>
                </div>
                <div>
                    <label for="">Mot de passe :</label>
                    <input type="password" class="inp" name="password"/>
                </div>
                <div>
                    <label for="">Confirmer mot de passe</label>
                    <input type="password_confirm" class="inp" name="password"/>
                </div>
                <button type="submit" class="butt">Envoyer</button>
            </form>
        </div>
        </main>
    </body>