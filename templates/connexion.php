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
                <h3 class="inscription">CONNEXION AVEC EMAIL</h3>
                <form>
                    <div>
                        <label for="mail">E-mail:</label>
                        <input type="mail" class="inp" name="user_name">
                    </div>
                    <div>
                        <label for="mdp">Mot de passe</label>
                        <input type="password" class="inp" name="user_mail">
                    </div>
                    <button type="submit" class="butt" value="send">Connexion</button>
                    <p>Mot de passe oublié ?</p>
            </div>
        </main>
    </body>
</html>