<?php
$file = 'fichier.txt';
if (isset($_POST['Ajouter']) && !empty($_POST['nom']) && !empty($_POST['note']) && !empty($_POST['matiere'])) {
    if (is_numeric($_POST['note'])) {
        $data = trim($_POST['nom']) . "\n" .
            trim($_POST['note']) . "\n" .
            trim($_POST['matiere']) . "\n";
        file_put_contents($file, $data, FILE_APPEND);
        header("Location:" . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <h2>Gestion des note des etudiants</h2>
    <fieldset> <legend>saisir les informations via le formulaire </legend>
        <form action="" method="post">
            <input type="text" name="nom" placeholder="saisir le nom de l'eleve" required>
            <input type="text" name="note" placeholder="saisir la note" required> <br>
            <input type="text" name="matiere" placeholder="saisir la matiere" required>
            <input type="submit" name="Ajouter" value="ajout">
        </form>
    </fieldset>
    <?php
    //affichage des donnees
    if (file_exists($file)) {
        $somme = 0;
        $compteur = 0;
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        //commencement du tableau   
        echo '<h3>liste des notes</h3>';
        echo '<table border="1" collapse="5"><tr><th>Nom</th><th>Note</th><th>Matiere</th><th>Mention</th>';
        for ($i = 0; $i < count($lines); $i += 3) {
            $nom = trim($lines[$i]);
            $note = trim($lines[$i + 1]);
            $matiere = trim($lines[$i + 2]);

            $mention = "";
            if ($note < 10) {
                $mention = 'insuffisant';
            } elseif ($note >= 10 && $note < 12) {
                $mention = 'passable';
            } elseif ($note > 12 && $note <= 15) {
                $mention = 'assez bien';
            } elseif ($note >= 15 && $note < 17) {
                $mention = 'bien';
            } else {
                $mention = 'tres bien';
            }
            echo '<tr><td>' . $nom . '</td><td>' . $note . '</td><td>' . $matiere . '</td><td>'.$mention.'</td></tr>';
            $somme += intval($note);
            $compteur++;
        }
        echo '</table>';
        if($compteur > 0) {
            $moyenne = $somme / $compteur ; 
             echo "la moyenne est :  $moyenne "."</br>";  
             echo "le total : $somme "."</br>"; 
             echo "le nombre d'eleve : $compteur "; 
            
        }
    }  
    ?>
</body>

</html>