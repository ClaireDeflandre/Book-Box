<?php
$bdd = new PDO('mysql:host=localhost;dbname=boitealivres;charset=utf8', 'root', '');

if(isset($_POST['forminscription']))
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp =($_POST['mdp']);
    $mdp2 =($_POST['mdp2']);

    if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    { 
        $pseudolenght = strlen($pseudo);
        if($pseudolenght<=50)
        {
            if($mail == $mail2)
            {
                if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                {
                    $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
                    $reqmail->execute (array($mail));
                    $mailexist = $reqmail->rowCount();
                    if($mailexist == 0)
                    {
                        if($mdp == $mdp2)
                        {
                            $hashedpass = password_hash($mdp,PASSWORD_DEFAULT);
                            $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?,?,?)");
                            $insertmbr->execute(array($pseudo, $mail, $hashedpass));
                            $erreur = "Votre compte a bien été créé <a href=\"connexion.php\">Me connecter</a>";
                            //header('Location: connexion.php');
                        }
                        else
                        {
                            $erreur = "Les mots de passe doivent être identiques";
                        }
                    }
                    else
                    {
                        $erreur = "Cette adresse mail a déjà été utilisée";
                    }
                }
                else
                {
                    $erreur = "Votre adresse mail n'est pas valide";
                }
            }
            else
            {
                $erreur = "Vos adresses mail ne correspondent pas";
            }
        }
        else
        {
            $erreur = "Votre pseudo ne doit pas dépasser 255 caractères";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent être remplis";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
<nav>
        <label class="logo">Pick and read</label>
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Chercher une boîte à livres</a></li>
            <li><a href="#">Avez-vous découvert une boîte à livres ?</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="connexion.php">Connexion</a></li>
        </ul>
   </nav>

<div class="signup">
<?php
    if(isset($_GET['reg_err']))
    {
        $error = htmlspecialchars($_GET['reg_err']);

        switch($error)
        {
            case 'success':
                ?>
                <div class="succes">
                    <strong>Succès:</strong> inscription réussie !
                </div>
            <?php
            break;
        }
    }
    ?>
    <div>
        <h2>Inscription</h2>
        <br /><br /><br />
        <form method="POST" action="">
            
                
            <input type="text" name="pseudo" id="pseudo" placeholder="Pseudo" required="required"autocomplete="off" value="<?php if(isset($pseudo)) { echo $pseudo;}?>"/>
                    
                    
            <input type="email" name="mail" id="mail" placeholder="Email" required="required"autocomplete="off" value="<?php if(isset($mail)) { echo $mail;}?>"/>

                   
            <input type="email" name="mail2" id="mail2" placeholder="Confirmation de l'email" required="required"autocomplete="off" value="<?php if(isset($mail2)) { echo $mail2;}?>"/>

            <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required="required"autocomplete="off"/>

                  
            <input type="password" name="mdp2" id="mdp2" placeholder="Confirmation du mot de passe" required="required"autocomplete="off"/>

            <button type="submit"name="forminscription">Valider</button>

                    
        </form>

        <br>
        <br>
        <?php
        if(isset($erreur))
        {
            echo '<font color="red">'.$erreur.'</font>';
        }
        ?>
        <br>

    </div>
</body>
</html>

<style>
*{
    padding; 0;
    margin: 0;
    text-decoration: none;
    list-style: none;
    box-sizing: border-box;
}

.logo{

    color:black;
    font-size:30px;
    line-height:80px;
    padding-left: 10px;
    font-weight: bold;
    font-family:'Bookman Old Style';
    position: absolute;
}

nav{
    background-color: #95A5A6; 
    height: 80px;
    width: 100%;
    position: absolute;
}

nav ul{
    float: right;
    margin-right:20px;
}

nav ul li{
    display: inline-block;
    line-height: 80px;
    margin: 0 5px;
}

nav ul li a{
    color: black;
    font-size:17px;
    font-weight: bold;
    padding: 7px 13px;
    border-radius: 3px;
    text-transform: uppercase;
}

html {
    margin :0;
    padding: 0;
    width: 100%;
    height: 100vh;
}

body {
    margin:0;
    padding: 0;
    width: 100%;
    height: 100vh;
    background: url(b.jpg) 50% 50% no-repeat;
    background-size: cover;
    position: absolute;
    display: table;
    min-height: 100vh;
}

.signup {
    border: 3px solid black;
    border-radius:15px;
    padding: 2em;
    position: absolute;
    top: 50%;
    left: 50%;
    transform:translateX(-50%) translateY(-50%);
    background-color:  rgba(255,255,255,0.5);
    margin-top: 40px;
}

h2 {
    margin-top: 0;
    margin-bottom:5px;
    font-family:Arial, Helvetica, sans-serif;
    font-weight:lighter;
    color:black;
    font-size: 50px;
    text-align: center;
}

input {
    display: block;
    width:320px;
    height:50px;
    background:white;
    outline:none;
    border: 2px solid rgba(0,0,0,0.5);
    font-family:Arial, Helvetica, sans-serif;
    font-weight:lighter;
    font-size:20px;
    margin-bottom:10px;
    padding-left:10px;
    border-radius: 5px;
    text-align: center;
}

::placeholder {
    color:black;
}

button {
    width:332px;
    height:50px;
    background: white;
    font-weight: lighter;
    color:black;
    border: 2px solid rgba(0,0,0,0.5);
    border-radius: 5px;
    font-family:Arial, Helvetica, sans-serif;
    font-weight:lighter;
    font-size:20px;
    margin-top: 30px;
}

</style>