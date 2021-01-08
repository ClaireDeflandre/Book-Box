<?php
session_start();


if(isset($_POST['formconnexion']))
{
    $bdd = new PDO('mysql:host=localhost;dbname=boitealivres', 'root','');
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = ($_POST['mdpconnect']);
    $date = date('Y-m-d H:i:s');
    $sql="INSERT INTO connexions(login, motdepasse, date) VALUES ('$mailconnect','$mdpconnect','$date')";
    $bdd ->query($sql);
   

    if(!empty($mailconnect) AND !empty($mdpconnect))
    {
        
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
        $requser->execute(array($mailconnect));
        //$userexist = $requser->rowCount();
        $userinfo = $requser->fetch();
        if($userinfo)
        {            
            if (password_verify ($mdpconnect, $userinfo['motdepasse']))
            {
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("Location: profil.php?id=".$_SESSION['id']);
            }
            else
            {
                $erreur = "Mauvais mail ou mot de passe";
            }
        }
        
    }
    else
    {
        $erreur = "Tous les champs doivent être complétés";
    }
}

if(isset($_POST['forgot']))
{
    header("Location: resetpassword.php");
}

?>

<html>
    <head>
        <title>Connexion</title>
        <meta charset="utf-8">
    </head>
    <body>

    <nav>
        <label class="logo">Pick and read</label>
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Chercher une boîte à livres</a></li>
            <li><a href="#">Avez-vous découvert une boîte à livres ?</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Connexion</a></li>
        </ul>
   </nav>

<div class="signin">

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
        
            <h2>Connexion</h2>
            <br /><br />
            <form method="POST" action="">
                <input type="email" name="mailconnect" placeholder="E-Mail"required="required"autocomplete="off"/>
                <input type="password" name="mdpconnect" placeholder="Mot de passe"required="required"autocomplete="off"/>
                <button type="submit" id="formconnexion" name="formconnexion">Se connecter</button>
                <br>
                <br>
                <button type="submit" id="forgot" name="forgot">Mot de passe oublié ?</button>
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

.signin {
    border: 3px solid black;
    border-radius:15px;
    padding: 3em;
    position: absolute;
    top: 50%;
    left: 50%;
    transform:translateX(-50%) translateY(-50%);
    background-color:  rgba(255,255,255,0.5);
    margin-top: 30px;
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


