<?php
// Test si connecté
session_start();
$is_in = false;
if (isset($_SESSION['connected']) && $_SESSION['connected'] === true) {
    $is_in = true;
}

// Imports
include_once('inc/constants.inc.php');
include_once('inc/dbconnect.inc.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap" rel="stylesheet">
    <script src="javascript/function.js"></script>
    <script src="javascript/index.js"></script>
    <script src="javascript/pop-up.js"></script>
</head>
<body>
<div id="interface">
    <header id="cabelhaco">
    <hgroup>
    <h1>Mon Profil</h1>
    <h2>Qui je suis</h2>
    <div id="dessin"><img src="images/dessin.png" alt=""></div>
    </hgroup>

    <img id="icone" src="images/machine.png">
        <nav id="menu">

        <h1>Menu Principal</h1>
            <ul>
                <li onmouseover="mudaFoto('images/home.png')"onmouseout="mudaFoto('images/machine.png')"><a href="index.php">Home</a></li>
                <li onmouseover="mudaFoto('images/especificacoes.png')"onmouseout="mudaFoto('images/machine.png')"><a href="specs.html">Caractéristiques</a></li>
                <li onmouseover="mudaFoto('images/fotos.png')"onmouseout="mudaFoto('images/machine.png')"><a href="fotos.html">Photos</a></li>
                <li onmouseover="mudaFoto('images/multimidia.png')"onmouseout="mudaFoto('images/machine.png')"><a href="multimidia.html">Vidéos</a></li>
                <!--<li onmouseover="mudaFoto('images/contato.png')"onmouseout="mudaFoto('images/machine.png')"><a href="fale-conosco.html">Contactez moi</a></li>-->
            </ul>
        </nav>
    </header>
    
    <section id="corpo">
        <article id="noticia-principal">
            <header id="cabelhaco-artigo">
                <form action="validate.php" method="post">
                    <table>
                    <tr>
                        <td>
                            <label>Entrer les nùmeros dans la case</label>
                            <input name="captcha" type="text">
                            <img src="captcha.php" style="vertical-align: middle;"/>
                        </td>
                    </tr>
                    <tr>
                        <td><input name="submit" type="submit" value="Submit"></td>
                    </tr>
                    </table>
                    </form>
    <hgroup>
    <h3>Salarié > &nbsp;Entrepeneur</h3>
    <h2>Mon parcours</h2>
    <h4>par Paulo Magalhaes</h4>
    <h3 class="direita">Actualisé le <span id="aujor"></span></h3>
    </hgroup>
            </header>

    <h4>Présentation</h4>
    <p>D'abord, Bonjour a tous, je m'appelle <span style="text-decoration: underline">Carlos</span>, j'ai 52 ans et je suis de nationalité Portugaise. Je suis arrive en France en 2011, en cherchent du travail en tant que Engin de chantier. Je m'a ensuite trouvé un travaile rapidement dans une entreprise, et, pendant 5 ans j'ai exerce en tant que Engin de chantier. Je m'a ensuite lancé, en tant que entrepreneur au début de l'année 2016, et je ne regrette pas. Je m'ai lancé en tant que entrepreneur, car c'est le métier que j'ai exerce tout ma vie, et sans doute c'est le métier que j'aime faire!
<figure class="foto-legenda">
    <img src="images/profil.JPG" style="width:400px; height:338px;"/>
</figure>
    <h4>Pourquoi je m'ai lancé</h4>
    <p>Je savais que que c'était le temps de me lancé tout seule, j'avait le sentiment que j'avais déja la expérience de le faire, et continue de plus en plus a avoir la éxperience et pursuivre mon rêve de monté une entreprise un jour.
        Franchement je ne regrette rien, et j'éspere que sa continue jusqu'a m'a retraite.
    </p>

    <h4>Caractéristiques téchniques</h4>
        <table id="tabelaspec">
            <caption>Table téchnique CX210D <span>Avril/2021</span></caption>

            <tr><td class="ce">Poids</td><td class="cd">26 tonnes</td></tr>
            <tr><td rowspan="2"class="ce">Perfomances</td><td class="cd">equivalent à 21 tonnes CX210D</td></tr>
            <tr><td class="cd">Stabilité de la machine</td></tr>
            <tr><td rowspan="2"class="ce">Conception compact</td><td class="cd">chassis alongé</td></tr>
            <tr><td class="cd">Aluminium trés resistant</td></tr>
            <tr><td class="ce">Puissance</td><td class="cd">suprenante</td></tr>
        </table>

    <h4>Comment ça marche</h4>
    <p>Alors, je suis une personne trés motivé, agréable et que buge beacoup et comme tout le monde, dans cet situation de entrepreneur, je me suis présente dans les entreprises ainsi que le pôle emploi, pour cherche du travail. Heuresement je m'ai trouvé une entreprise tout a fait vite, a qui j'ai peux donné mes éxperiences et atouts.</p>

    <h4>Mon métier</h4>
    <p>Consiste d'être chargé de conduire une pelleteuse (ou pelle mécanique), une chargeuse, ou un bouteur, et déblayer et préparer le terrain pour les chantiers. Il doit procéder à l'entretien et la maintenance mécanique de ces machines si besoin. Avec l'engin, il effectue au déblaiement, au nivellement, au terrassement du terrain. Il est amené parfois à faire plusieurs choses en même temps : diriger sa pelle, manœuvrer et orienter l'engin, avancer ou reculer, ce qui demande de la maîtrise et de la concentration..</p>
    <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;"> <iframe style="width:100%;height:100%;position:absolute;left:0px;top:0px;overflow:hidden" frameborder="0" type="text/html" src="https://www.dailymotion.com/embed/video/x6ow7j?autoplay=0"></iframe> </div>
    
        </article>
    </section>
    <aside id="lateral">

    <h1>Démonstration</h1>
    <video id="fFilme" controls="controls" poster="images/img1.png">
        <source src="videos/video.mp4" type="video/mp4">
        Désole, ce n'était pas posible de lire le vidéo.
    </video>

        <h2>Machines</h2>
        <table>
            <tr id="mini"><td class="ce">Mini Pelies</td><td class="cd">3.5t</td></tr>
            <tr id="mini"><td class="ce"></td><td class="cd">5t</td></tr>
            <tr id="mini"><td class="ce"></td><td class="cd">8t</td></tr>
            <tr id="cat"><td class="ce">Cat</td><td class="cd">311</td></tr>
            <tr id="cat"><td class="ce"></td><td class="cd">320</td></tr>
            <tr id="cat"><td class="ce"></td><td class="cd">324</td></tr>
            <tr id="lie"><td class="ce">Liebherr</td><td class="cd">920</td></tr>
            <tr id="lie"><td class="ce"></td><td class="cd">926</td></tr>
            <tr id="case"><td class="ce">Case</td><td class="cd">210</td></tr>
            <tr id="case"><td class="ce"></td><td class="cd">225</td></tr>
            <tr id="case"><td class="ce"></td><td class="cd">230</td></tr>
        </table>

    <p>Pour le moment j'ai utilisé (et surtout maitrisé) ses machines. Je veux continuer à apprende des nouvelles machines et avoir des nouvelles éxperiences, pour continuer a avoir plus des atouts.</p>

    <a href="incrip.php"><button class="yellow" type="button">Déconnexion</button></a>
    </aside>
    
    <footer id="rodape">
            <div id="conf">
                <a href="mentions.html" target="_blank">Mentions légales et de confidenlité</a>
            </div>
        <p>Copyright &copy;2021 - by Paulo Magalhaes<br>
            <a href="http://facebook.com" target="_blank">Facebook</a> |
            <a href="http://twitter.com" target="_blank">Twitter</a>
        </p>
    </footer>
</div>
</body>
</html>