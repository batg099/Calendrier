<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- MÃ©ta-donnÃ©es pour dÃ©finir le jeu de caractÃ¨res et la mise Ã  l'Ã©chelle -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre de la page -->
    <title>Site</title>
    <!-- Liens vers les fichiers CSS et JavaScript externes -->
    <!-- 
    <link rel="stylesheet" type="text/css" media="screen and (min-width:600px)" href="sitebureau.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-width:600px)" href="filmmobile.css">
    -->
    <link rel="stylesheet" type="text/css" media="screen" href="./page.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    
</head>
<body>
<!--   Bouton Scroll UP   -->
<div id="scrollUp">
<a href="#top"><img src="to_top.png"/></a>
</div>
<script>
jQuery(function(){
    $(function () {
        $(window).scroll(function () { //Fonction appelée quand on descend la page
            if ($(this).scrollTop() > 200 ) {  // Quand on est à 200pixels du haut de page,
                $('#scrollUp').css('right','10px'); // Replace à 10pixels de la droite l'image
            } else { 
                $('#scrollUp').removeAttr( 'style' ); // Enlève les attributs CSS affectés par javascript
            }
        });
    });
});
</script>
<!-- FIN Scroll UP -->
<?php

('Content-Type: text/html; charset=utf-8');
   ini_set('display_errors',1);
   ini_set('display_startup_errors',1);
   error_reporting(E_ALL);
   $open = fopen("./uploads/Produits.csv","r");
   if (isset($_GET['param'])){
    $url = $_GET['param'];
   }
   else{
    $url = 'SEBTEST';
   }
   //$url = $_SERVER['REQUEST_URI'];
   //echo $url;
   $url = explode('/',$url); $taille = count($url);$url = $url[$taille-1];
   $titre='';
   $info='';
   $objectifs ='';
   $public='';
   $requis='';
   $programme='';
   $methode='';
   $eval='';
   $certif='';
   $menu = ['Objectifs','Pour qui ?','Pré-Requis','Programme','Pédagogie','Evaluation','Certification'];
   $contenu = [];
   $i=0;
   $limite = 0; // A SUPPRIMER PLUS TARD
   while ( ($data = fgetcsv($open,2000,";")) == true && $i>=0  ){
        if($i>4 && $limite == 0 && $data[0]==$url){
            $titre = $data[1].' - '.$data[0];
            if(getStringBetween($data[36],'<CLC>','</CLC>')!==''){
                $info = $data[3].' jours'.' ('.$data[2].' heures)'.' | '.'Prix : '.$data[4].' €ht'. ' | '.'CLC : '. getStringBetween($data[36],'<CLC>','</CLC>');
            }
            else { $info = $data[3].' jours'.' ('.$data[2].' heures)'.' | '.'Prix : '.$data[4].' €ht'; }            $objectifs = $data[37];
            $public = $data[43];
            $requis = $data[38];
            $programme = $data[40];
            $methode = $data[42];
            $eval = $data[41];
            $certif = $data[67]; // A VERIFIER !!!!!
            array_push($contenu,$objectifs,$public,$requis,$programme,$methode,$eval,$certif,'...');
            //var_dump($contenu);
            echo '<h1>'.$titre.'</h1>';
            break;
            $limite++ ; // A SUPPRIMER PLUS TARD

        }
        $i=$i+1;
    }

    fclose($open);
?>          
        <div class='info'>
        <!-- Image Download -->
        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#000000"><path d="M280-280h400v-60H280v60Zm197-126 158-157-42-42-85 84v-199h-60v199l-85-84-42 42 156 157Zm3 326q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-156t86-127Q252-817 325-848.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 82-31.5 155T763-197.5q-54 54.5-127 86T480-80Zm0-60q142 0 241-99.5T820-480q0-142-99-241t-241-99q-141 0-240.5 99T140-480q0 141 99.5 240.5T480-140Zm0-340Z"/></svg>
            <?php
            echo "<div class='alignement'>";
                echo '<h2>'.$info.'</h2>';
                if(getStringBetween($data[36],'<CURVER>','</CURVER>') !==''){
                    echo '<p >'.'Ref : '.$data[0]. ' | '. 'Version : '. getStringBetween($data[36],'<CURVER>','</CURVER>').'</p>';
                }
                else{ echo '<p >'.'Ref : '.$data[0].'</p>'; }                //echo getStringBetween($data[36],'<CAT>','</CAT>');
            echo '</div>';        
	echo '</div>';
        
        echo "<div class='alignement_2'>";
    	
   $open_liste = fopen("./liste.csv","r");
   $image = '';
   $j=0;
   while ( ($data_2 = fgetcsv($open_liste,2000,";")) == true && $j>=0  ){
    if($j>=1){
        //echo $data_2[42].' ';
        if($data_2[1] == $url){
            //echo $data_2[42].' /';
            //echo $data_2[41].' ';
            if(stripos($data_2[41], $data_2[42]) !== false && $data_2[41] !=='Agile SCRUM' && $data_2[42]!=='CISCO'){
            $image = './images/'.$data_2[42].'.png';
            }
            else {
            
                 switch($data_2[42]){
                    case 'MICROSOFT':
                        $image = './images/'.$data_2[42].'.png';
                        break;
                    case 'AGILE':
                        $image = './images/AGILE-SCRUM'.'.png';
			break;
                    case 'VEEAM':
                        $image = './images/VEEAM'.'.png';
		        break;
                    case 'CISCO':
                        $image = './images/CISCO'.'.png';
			break;
                    default:
                        $image = './images/'.$data_2[42].'-'.$data_2[41].'.png';            
		}
	    }
        }
    }    
$j++;
   }
        echo "<div class='img'> <img src=$image  alt='Description de l'image' width='120' height='120'> </div>";
        echo "<div class='texte'>";
        if($data[35] !== '' && $data[35] !== null){
            echo '<p id="petit_titre" >'.str_replace('_x000d_', "", $data[35]).'</p>';
        }
        echo '</div>';
        echo '</div>';

            ?>
            <div id='buttons'>
                <button type="button" id="bouton_intra">Faire une demande d'intra</button>
                <button type="button" id="bouton_devis">Recevoir un devis</button>
                <!-- <a href=#bouton_calendrier><button type="button" id="bouton_cal" ><svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#e8eaed"><path d="M216-96q-29.7 0-50.85-21.5Q144-139 144-168v-528q0-29 21.15-50.5T216-768h72v-96h72v96h240v-96h72v96h72q29.7 0 50.85 21.5Q816-725 816-696v528q0 29-21.15 50.5T744-96H216Zm0-72h528v-360H216v360Zm0-432h528v-96H216v96Zm0 0v-96 96Zm264.21 216q-15.21 0-25.71-10.29t-10.5-25.5q0-15.21 10.29-25.71t25.5-10.5q15.21 0 25.71 10.29t10.5 25.5q0 15.21-10.29 25.71t-25.5 10.5Zm-156 0q-15.21 0-25.71-10.29t-10.5-25.5q0-15.21 10.29-25.71t25.5-10.5q15.21 0 25.71 10.29t10.5 25.5q0 15.21-10.29 25.71t-25.5 10.5Zm312 0q-15.21 0-25.71-10.29t-10.5-25.5q0-15.21 10.29-25.71t25.5-10.5q15.21 0 25.71 10.29t10.5 25.5q0 15.21-10.29 25.71t-25.5 10.5Zm-156 144q-15.21 0-25.71-10.29t-10.5-25.5q0-15.21 10.29-25.71t25.5-10.5q15.21 0 25.71 10.29t10.5 25.5q0 15.21-10.29 25.71t-25.5 10.5Zm-156 0q-15.21 0-25.71-10.29t-10.5-25.5q0-15.21 10.29-25.71t25.5-10.5q15.21 0 25.71 10.29t10.5 25.5q0 15.21-10.29 25.71t-25.5 10.5Zm312 0q-15.21 0-25.71-10.29t-10.5-25.5q0-15.21 10.29-25.71t25.5-10.5q15.21 0 25.71 10.29t10.5 25.5q0 15.21-10.29 25.71t-25.5 10.5Z"/></svg>  Voir les prochaines dates</button> </a>
                -->
            </div>
                <script>
        	 document.getElementById('bouton_devis').addEventListener('click', function() {
           	 window.location.href = 'https://www.learneo.fr/formulaire-devis.html';
        	});
    		</script>
            <br>
            <br>
            


            <?php
            /***********  Menu déroulant  ************/ 
            echo '<nav class="topnav">';
            for ($j = 0; $j < count($menu); $j++) {
                // Remplacer les espaces par des tirets dans les IDs
                if($contenu[$j]!==''){
                    $id = str_replace(' ', '-', $menu[$j]);
                    echo '<a href="#' . $id . '">' . $menu[$j] . '</a>';
                }
            }
            echo '</nav>';
            echo '<div class=main>';
            echo '<div class=contenu>';
            echo '            <br>
            <div class="v-line">
            </div>';

	    echo '<div id="text">';
            // Contenu des sections
            for ($j = 0; $j < count($menu); $j++) {
                if ($titre !== '' && $contenu[$j]!=='') {
                    // Remplacer les espaces par des tirets dans les IDs
                    $id = str_replace(' ', '-', $menu[$j]);
                    echo '<h3 id="' . $id . '">' . $menu[$j] . '</h3>';
                    echo '<p>' . str_replace('_x000d_', "", $contenu[$j]) . '</p>';
                    echo '<hr>';
                }
            }
	    echo '</div>';
            echo '</div>';
            
            echo '<div class = page> ';
            echo '</div>';

            echo '</div>';
            
            ?>
            
            <?php
            /**************** Dates  ***************/
            
            $open = fopen("./liste.csv","r");
            $chaine = '';
            $tab = [];
            while ( ($data = fgetcsv($open,2000,";")) == true && $i>=0  ){
                if($i>=1){
                    $date = explode('/',$data[3]);
                    if($data[1] === $url && $date[2]>=date('Y') && $date[1]>=date('m')){
                        array_push($tab,$data[3]);
                    }
                }
            }
            //echo '<p>' . "habibibiaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa" . '</p>';
            usort($tab, "compare_dates");
  
            echo '<h3 id="bouton_calendrier">' . 'Dates' . '</h3>';
            echo '<ul>';
            foreach($tab as $element){
                echo '<li>' . $element . '</li> ';
            }
            echo '</ul>';

            fclose($open);

            function compare_dates($a, $b) {
                $date_1 = explode('/',$a);
                $date_2 = explode('/',$b);
            
                if ($date_1[0] == $date_2[0] && $date_1[1] == $date_2[1]) {
                    return 0;
                }
                // Pas d'accord
                return ($date_1[2] < $date_2[2]) ? -1 : (($date_1[2] > $date_2[2]) ? 1 : (($date_1[1] < $date_2[1]) ? -1 : (($date_1[1] > $date_2[1]) ? 1 : (($date_1[0] < $date_2[0]) ? -1 : 1))));

            }
        function getStringBetween($string, $start, $end) {
            $startPos = strpos($string, $start);
            if ($startPos === false) {
                return ''; // Si la chaîne de départ n'est pas trouvée, retourner une chaîne vide
            }
            $startPos += strlen($start); // Avancer le début juste après la chaîne de départ
            $endPos = strpos($string, $end, $startPos);
            if ($endPos === false) {
                return ''; // Si la chaîne de fin n'est pas trouvée, retourner une chaîne vide
            }
            return substr($string, $startPos, $endPos - $startPos);
        }
            ?>
            <div id='buttons'>
                <br>
                <button type="button" id="bouton_inscription">Comment s'inscrire</button>
            </div>

            <br>
            <h3> Modalités d'accés </h3>
            <p> Le client qui souhaite souscrire à une formation remplit <a href='https://www.learneo.fr/formulaire-formation.html'>une demande de
                pré-inscription</a>. Learneo retourne une proposition commerciale comprenant
                les caractéristiques de formation (type, durée) et la proposition financière.
                La commande n'est ferme et définitive qu'une fois la proposition commerciale signée par le client. <br>
                5 jours ouvrés (en moyenne) avant le début de la formation </p>
            <br>
            <p style="font-weight:bold;border:1px solid black;border-radius:10px 10px;margin-left:78%;padding-right:7px"> <a href='https://www.learneo.fr/accessibilite-handicap.html'>Accessibilité aux personnes en situation de handicap </a></p>
    <script src="site.js" ></script></body>

</html>
