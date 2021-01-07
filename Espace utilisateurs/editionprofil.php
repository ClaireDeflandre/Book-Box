<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=boitealivres', 'root','');

if(isset($_SESSION['id']))
{
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();

    if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo'])
    {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ? ");
        $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail'])
    {
        $newmail = htmlspecialchars($_POST['newmail']);
        $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ? ");
        $insertmail->execute(array($newmail, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newmail']) AND !empty($_POST['newmail']))
    {
        $newmail = htmlspecialchars($_POST['newmail']);
        $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ? ");
        $insertmail->execute(array($newmail, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
    }

     if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND $_POST['newmdp1'] != $user['motdepasse'])
    {
        $newmdp1 = htmlspecialchars($_POST['newmdp1']);
        $newmdp2 = htmlspecialchars($_POST['newmdp2']);
        $passwordvalid = !empty($newmdp1) && $password ===$newmdp2; 
        $passwordhash = password_hash($newmdp1,PASSWORD_DEFAULT);

        if($newmdp1 == $newmdp2)
         {
            try {
                $database = new PDO("mysql:host=localhost;dbname=boitealivres;charset=utf8", "root", "");
            } catch (Exception $err) {
                die("Erreur:" . $err->getMessage());
            }
            $insertmdp = $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ? ");
            $insertmdp->execute(array($passwordhash, $_SESSION['id']));
            header('Location: profil.php?id='.$_SESSION['id']);
             $erreur = "Votre compte a bien été modifié <a href=\"profil.php\">Voir mon profil</a>";
            //header('Location: connexion.php');
         }
    }else
                        {
                            $erreur = "Les mots de passe doivent être identiques";
                        }
        
                       
                    

?>

<html>
    <head>
        <title>Profil</title>
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
        <div class="edition">
            <h2>Edition de votre profil</h2>
                <form method="POST" action="">
<table>
                    <div class="pseudo">
                    <tr>
                        <td>
                        <label>Pseudo:</label>
                        </td>
                        <td>
                        <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo'];?>"/><br /><br />
                        </td>
                    </tr>
                    </div>

                    <div class="mail">
                    <tr>
                        <td>
                        <label>Mail:</label>
                        </td>
                        <td>
                        <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail'];?>"/><br /><br />
                        </td>
                    </tr>
                    </div>

                    <div class="password"> 
                    <tr>
                        <td> 
                        <label>Nouveau mot de passe:</label>
                        </td>
                        <td>
                        <input type="password" name="newmdp1" placeholder="Mot de passe" /><br /><br />
                        </td>
                    </tr>
                    </div>
                   
                    <div class="confirmation">
                    <tr>
                        <td>
                        <label>Confirmation:</label>
                        </td>
                        <td>
                        <input type="password" name="newmdp2" placeholder="Confirmation" /><br /><br />
                        </td>
                    </tr>
                    </div>
                    
</table>
                    <button type="submit" value ="Mettre à jour mon profil">Valider</button>
                    <br /><br />
                
                </form>
        </div>
    </body>
</html>  

<?php
}
else
{
    header("Location: connexion.php");
}
?>

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
    display: block;
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

.edition {
    border: 3px solid black;
    border-radius:5px;
    padding: 3em;
    position: absolute;
    top: 60%;
    left: 50%;
    transform:translateX(-50%) translateY(-50%);
    background-color:  rgba(255,255,255,0.5);
    text-align: center;
}

h2 {
    margin-bottom: 30px;
    font-family:Arial, Helvetica, sans-serif;
    font-weight:lighter;
    color:black;
    font-size: 50px;
    text-align: center;
}

input {
    margin-top: 15px;
    margin-left: 15px;
    width:200px;
    height:30px;
    background:white;
    outline:none;
    border: 2px solid rgba(0,0,0,0.5);
    font-family:Arial, Helvetica, sans-serif;
    font-weight:lighter;
    font-size:20px;
    border-radius: 5px;
    text-align: center;
}

button {
    margin-top: 30px;
    width:332px;
    height:50px;
    background: white;
    font-weight: lighter;
    color:black;
    border: 2px solid rgba(0,0,0,0.5);
    border-radius: 5px;
    font-family:Arial, Helvetica, sans-serif;
    font-size:20px;
}

label {

    font-weight: lighter;
    color:black;
    font-family:Arial, Helvetica, sans-serif;
    font-size:20px;
}
</style>
