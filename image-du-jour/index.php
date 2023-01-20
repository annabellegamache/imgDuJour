<?php


//Étape 1 : inclure la config de la bd
include('config/bd.cfg.php');

setlocale(LC_TIME, "fr_FR", "French");

//Autochargement des classes spl_autoload_register 
spl_autoload_register(function ($nomClasse) {
    $fichierClasse = "classes/$nomClasse.cls.php";
    if (file_exists($fichierClasse)) {
        include($fichierClasse);
    } else {
        exit("Erreur fatal, il n'y a pas de fichier pour cette classe");
    }
});

//acces BD
new AccesBd();

//Date 
if (isset($_GET['jour'])) {
    $date  = $_GET['jour']; // Date affichage
} else {
    $date = date("Y-m-d");
}

$datePresent = date("Y-m-d"); // Date d'aujourd'hui
$datePrec = date("Y-m-d", strtotime($date . '- 1 days'));
$dateSuiv = date("Y-m-d", strtotime($date . '+ 1 days'));


//image du jour
$image = new ImageDuJour();
$imageJour = $image->unParDate($date);
$imgId = $imageJour->img_id;


//date première image
$dateImgPremier = $image->datePremiereImage()->img_jour;




//echo $datePrec; 
//echo $dateSuiv; 

//echo $imgId;
//echo $dateImgPremier;

//date formatée
$dateImg = new Utilitaire();
$dateFormater = $dateImg->dateFormatee($imageJour->img_jour);

//Commentaire correspondants à l'image du jour
$commentaire = new Commentaire($imgId);
$commentaires = $commentaire->toutSansVote();
//$commentaires  = $commentaire->toutAvecVote();

//Nombre de commentaire aimé
$aime = $commentaire->obtenirNombreAime();

//Taux
$tauxObj = new Utilitaire(); 

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image du jour</title>
    <link rel="shortcut icon" href="ressources/images/favicon.png" type="image/png">
    <link rel="stylesheet" href="ressources/css/idj.css">
    <style>
        html {
            background-image: url(ressources/photos/<?= $imageJour->img_fichier; ?>);
        }
    </style>
</head>

<body>
    <div class="etiquette aime">
        <img src="ressources/images/aime-actif.png" alt=""><?= $aime ?>
    </div>
    <aside>
        <form action="">
            <textarea name="commentaire" id="commentaire"></textarea>
        </form>
        <ul class="commentaires">
            <?php foreach ($commentaires as $com) : ?>
                <?php 
                    if ($com->com_texte) {

                        $votesPositifs = rand(0, 200);
                        $votesNegatifs = rand(0, 200);
                        $taux = $tauxObj->tauxVotesPositifs($votesPositifs, $votesNegatifs);
                        $style = "style='opacity:".$taux."'";
                ?>
                    <li  <?= $style ?> >
                        <?= $com->com_texte ?>
                        <div class="vote">
                            <span class="up"><?= $votesPositifs ?></span>
                            <span class="down"><?= $votesNegatifs ?></span>
                        </div>
                    </li>
                <?php } ?>
            <?php endforeach; ?>
        </ul>
    </aside>
    <div class="info">
        <div class="date">
            <?php
                if ($date == $dateImgPremier) {
                    $prec = 'inactif';
                } else {
                    $prec = '';
                }
            ?>
            <span class="premier <?= $prec ?>">
                <a title="Premier jour" href="index.php?jour=<?= $dateImgPremier ?>">&#x2B70;</a>
            </span>
            <span class="prec <?= $prec ?>">
                <a title="Jour précédent" href="index.php?jour=<?= $datePrec ?>">&#x2B60;</a>
            </span>
            <?php
            if ($date == $datePresent) {
                $suiv = 'inactif';
            } else {
                $suiv = '';
            }
            ?>
            <span class="suiv <?= $suiv ?>">
                <a title="Jour suivant" href="index.php?jour=<?= $dateSuiv ?>">&#x2B62;</a>
            </span>
            <span class="dernier <?= $suiv ?>">
                <a title="Aujourd'hui" href="index.php?jour=<?= $datePresent ?>">&#x2B72;</a>
            </span>
            <i><?= $dateFormater ?></i>
        </div>
        <?php if ($imageJour->img_description) : ?>
            <div class="etiquette etiquette-etendue description"><?= $imageJour->img_description ?></div>
        <?php endif ?>
    </div>
</body>

</html>