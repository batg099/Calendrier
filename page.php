<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- MÃƒÂ©ta-donnÃƒÂ©es pour dÃƒÂ©finir le jeu de caractÃƒÂ¨res et la mise ÃƒÂ  l'ÃƒÂ©chelle -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Titre de la page -->
    <title>Site</title>
    <!-- Liens vers les fichiers CSS et JavaScript externes -->
    <!-- 
    <link rel="stylesheet" type="text/css" media="screen and (min-width:600px)" href="sitebureau.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-width:600px)" href="filmmobile.css">
    -->
    <link rel="stylesheet" type="text/css" media="screen" href="./test.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    
</head>
<body>

<!--   Bouton Scroll UP   -->
<div id="scrollUp">
<a href="#top"><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#000000"><path d="M320.33-288 480-360.33 639.67-288l8.33-8.33-168-406.34-168 406.34 8.33 8.33ZM480-80q-82.33 0-155.33-31.5-73-31.5-127.34-85.83Q143-251.67 111.5-324.67T80-480q0-83 31.5-156t85.83-127q54.34-54 127.34-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 82.33-31.5 155.33-31.5 73-85.5 127.34Q709-143 636-111.5T480-80Zm0-66.67q139.33 0 236.33-97.33t97-236q0-139.33-97-236.33t-236.33-97q-138.67 0-236 97-97.33 97-97.33 236.33 0 138.67 97.33 236 97.33 97.33 236 97.33ZM480-480Z"/></svg> </a>
</div>
<script>
jQuery(function(){
    $(function () {
        $(window).scroll(function () { //Fonction appelÃƒÂ©e quand on descend la page
            if ($(this).scrollTop() > 200 ) {  // Quand on est ÃƒÂ  200pixels du haut de page,
                $('#scrollUp').css('right','10px'); // Replace ÃƒÂ  10pixels de la droite l'image
            } else { 
                $('#scrollUp').removeAttr( 'style' ); // EnlÃƒÂ¨ve les attributs CSS affectÃƒÂ©s par javascript
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
   $open = fopen("../uploads/Produits.csv","r");
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
   $menu = ['Objectifs','Pour qui ?','PrÃ©-Requis','Programme','PÃ©dagogie','Evaluation','Certification'];
   $contenu = [];
   $i=0;
   $limite = 0; // A SUPPRIMER PLUS TARD
   while ( ($data = fgetcsv($open,2000,";")) == true && $i>=0  ){
        if($i>4 && $limite == 0 && $data[0]==$url){
            $titre = $data[1];
            //echo $data[36];
            if(getStringBetween($data[36],'<points>','</points>')!==''){
                $info = $data[3].' jours'.' ('.$data[2].' heures)'.' | '.'Prix : '.$data[4].' â‚¬ht'. ' | '.'CLC : '. getStringBetween($data[36],'<points>','</points>');
            }
            else { $info = $data[3].' jours'.' ('.$data[2].' heures)'.' | '.'Prix : '.$data[4].' â‚¬ht'; }
            $objectifs = $data[37];
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
        <button id="generatePDF"><svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#000000"><path d="M280-280h400v-60H280v60Zm197-126 158-157-42-42-85 84v-199h-60v199l-85-84-42 42 156 157Zm3 326q-82 0-155-31.5t-127.5-86Q143-252 111.5-325T80-480q0-83 31.5-156t86-127Q252-817 325-848.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 82-31.5 155T763-197.5q-54 54.5-127 86T480-80Zm0-60q142 0 241-99.5T820-480q0-142-99-241t-241-99q-141 0-240.5 99T140-480q0 141 99.5 240.5T480-140Zm0-340Z"/></svg>
        </button>
        <script>
            document.getElementById("generatePDF").addEventListener("click", function () {
                html2canvas(document.body, {
                    onrendered: function (canvas) {
                        const { jsPDF } = window.jspdf;
                        const imgData = canvas.toDataURL('image/png');
                        const doc = new jsPDF('p', 'mm', 'a4'); // DÃ©finition du format A4

                        // Calcul des dimensions de l'image dans le PDF
                        const imgWidth = 210;
                        const imgHeight = canvas.height * imgWidth / canvas.width;

                        let position = 0;
                        let heightLeft = imgHeight;

                        // Ajout de la premiÃ¨re page avec l'image
                        doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                        heightLeft -= 297; // Soustraction de la hauteur de la page A4

                        // Ajout de pages supplÃ©mentaires si nÃ©cessaire
                        while (heightLeft >= 0) {
                            position = heightLeft - imgHeight;
                            doc.addPage();
                            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                            heightLeft -= 297;
                        }

                        // Ajout de la date en bas Ã  droite sur la derniÃ¨re page
                        const date = new Date().toLocaleString();
                        const totalPages = doc.internal.getNumberOfPages();
                        for (let i = 1; i <= totalPages; i++) {
                            doc.setPage(i);
                            doc.setFontSize(6);
                            doc.text(`Date de gÃ©nÃ©ration: ${date}`, 160, 285, null, null, 'right');
                        }

                        // Injection de la variable PHP dans JavaScript
                        var variableJS = <?php echo json_encode($url); ?>;
                        doc.save('Formation - ' + variableJS + '.pdf');

                    }
                });
            });

        </script>
        <?php
            echo "<div class='alignement'>";
                echo '<h2>'.$info.'</h2>';
                //echo $data[36];
                if(getStringBetween($data[36],'<CURVER>','</CURVER>') !==''){
                    echo '<p >'.'Ref : '.$data[0]. ' | '. 'Version : '. getStringBetween($data[36],'<CURVER>','</CURVER>').'</p>';
                }
                else{ echo '<p >'.'Ref : '.$data[0].'</p>'; }
                //echo getStringBetween($data[36],'<CAT>','</CAT>');
            echo '</div>';        
	echo '</div>';
        
        echo "<div class='alignement_2'>";
    	
   $open_liste = fopen("../uploads/liste.csv","r");
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
                    case 'CISCO':
                        $image = './images/CISCO'.'.png';
			break;
                    case 'VEEAM':
                        $image = './images/VEEAM'.'.png';
		        break;
                    default:
                        $image = './images/'.$data_2[42].'-'.$data_2[41].'.png';            
		}
	    }
        }
    }    
$j++;
   }
        echo "<div class='img'> <img src=$image  alt='Description de l'image' width='100' height='100'> </div>";
        echo "<div class='texte'>";
        if($data[35] !== '' && $data[35] !== null){
            echo '<p id="petit_titre" >'.replaceX000d($data[35]).'</p>';
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
            /***********  Menu dÃ©roulant  ************/ 
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
                    echo '<p>' . replaceX000d($contenu[$j]) . '</p>';
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
            
            $open = fopen("../uploads/liste.csv","r");
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
                // Convertir les chaÃ®nes en minuscule pour les recherches insensibles Ã  la casse
                $stringLower = strtolower($string);
                $startLower = strtolower($start);
                $endLower = strtolower($end);
                
                // Trouver la position de la chaÃ®ne de dÃ©but
                $startPos = stripos($stringLower, $startLower);
                if ($startPos === false) {
                    return ''; // Si la chaÃ®ne de dÃ©part n'est pas trouvÃ©e, retourner une chaÃ®ne vide
                }
                $startPos += strlen($startLower); // Avancer le dÃ©but juste aprÃ¨s la chaÃ®ne de dÃ©part
                
                // Trouver la position de la chaÃ®ne de fin
                $endPos = stripos($stringLower, $endLower, $startPos);
                if ($endPos === false) {
                    return ''; // Si la chaÃ®ne de fin n'est pas trouvÃ©e, retourner une chaÃ®ne vide
                }
                
                // Extraire et retourner la sous-chaÃ®ne entre les positions de dÃ©but et de fin
                return substr($string, $startPos, $endPos - $startPos);
            }

            function replaceX000d($input) {
                // VÃ©rifier et remplacer '_x000d_' si prÃ©sent
                if (strpos($input, '_x000d_') !== false) {
                    return str_replace('_x000d_', '', $input);
                }
                // Sinon, vÃ©rifier et remplacer '_x000D_' si prÃ©sent
                elseif (strpos($input, '_x000D_') !== false) {
                    return str_replace('_x000D_', '', $input);
                }
                // Si aucune des chaÃ®nes n'est trouvÃ©e, retourner la chaÃ®ne d'origine
                return $input;
            }

            ?>
            <div id='buttons'>
                <br>
                <button type="button" id="bouton_inscription">Comment s'inscrire</button>
            </div>

            <br>
            <h3> ModalitÃ©s d'accÃ©s </h3>
            <p> Le client qui souhaite souscrire Ã  une formation remplit <a href='https://www.learneo.fr/formulaire-formation.html'>une demande de
                prÃ©-inscription</a>. Learneo retourne une proposition commerciale comprenant
                les caractÃ©ristiques de formation (type, durÃ©e) et la proposition financiÃ¨re.
                La commande n'est ferme et dÃ©finitive qu'une fois la proposition commerciale signÃ©e par le client. <br>
                5 jours ouvrÃ©s (en moyenne) avant le dÃ©but de la formation </p>
            <br>
            <p style="font-weight:bold;border:1px solid black;border-radius:10px 10px;margin-left:78%;padding-right:7px"> <a href='https://www.learneo.fr/accessibilite-handicap.html'>AccessibilitÃ© aux personnes en situation de handicap </a></p>
    <script src="site.js" ></script></body>

</html>

