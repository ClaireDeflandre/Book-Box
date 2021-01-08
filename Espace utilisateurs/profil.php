<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=boitealivres', 'root','');

if (isset($_GET['id']) AND $_GET['id'] > 0)
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();
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

    <div class="profil">
    
                <h2>Bienvenue sur votre profil <?php echo $userinfo['pseudo'];?></h2>
    <table>            
                
            <tr>
                <td>
                <p class="pseudo">Votre pseudo est <?php echo $userinfo['pseudo'];?></p>
                </td>
            </tr>
                <br />
            <tr>
                <td>
                <p class="mail">Votre E-mail est <?php echo $userinfo['mail'];?></p>
                </td>
            </tr>
        
    </table> 
                <br />
                <?php
                if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
                {
                ?>

                <a class="edit" href="editionprofil.php">Editer mon profil</a>
                
                
                <a class="deconnexion" href="deconnexion.php">Se déconnecter</a>
                
                <?php
                }
                ?>
               
    </div>
    </body>
</html>  

<?php
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

.profil {
    border: 3px solid black;
    border-radius:15px;
    padding: 3em;
    position: absolute;
    top: 50%;
    left: 50%;
    transform:translateX(-50%) translateY(-50%);
    background-color:  rgba(255,255,255,0.5);
    text-align: center;
}

h2 {
    margin-bottom: 10px;
    font-family:Arial, Helvetica, sans-serif;
    font-weight:lighter;
    color:black;
    font-size: 50px;
    text-align: center;
}

p {
    display: flex;
    width:400px;
    height:50px;
    margin-top: 20px;
    background:white;
    outline:none;
    border: 2px solid rgba(0,0,0,0.5);
    font-family:Arial, Helvetica, sans-serif;
    font-weight:lighter;
    font-size:20px;
    border-radius: 5px;
    justify-content: center;
    align-items: center;

}

.edit {
    color: black;
    font-size: 20px;
    font-weight: bold;
    margin-right: 10px;
}

.deconnexion {
    color: black;
    font-size: 20px;
    font-weight: bold;
    margin-left: 10px;
}

table {
    display: flex;
    justify-content:center;
    margin-bottom: 15px;
}
</style>
