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
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="./styles/page.css" media="screen" />
    <link rel="stylesheet" type="text/css" media="screen" href="./styles/mobile.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    
</head>
<body style="font-family:'Roboto';">

<!--   Bouton Scroll UP   -->
<div id="scrollUp">
<a href="#top"><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#000000"><path d="M320.33-288 480-360.33 639.67-288l8.33-8.33-168-406.34-168 406.34 8.33 8.33ZM480-80q-82.33 0-155.33-31.5-73-31.5-127.34-85.83Q143-251.67 111.5-324.67T80-480q0-83 31.5-156t85.83-127q54.34-54 127.34-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 82.33-31.5 155.33-31.5 73-85.5 127.34Q709-143 636-111.5T480-80Zm0-66.67q139.33 0 236.33-97.33t97-236q0-139.33-97-236.33t-236.33-97q-138.67 0-236 97-97.33 97-97.33 236.33 0 138.67 97.33 236 97.33 97.33 236 97.33ZM480-480Z"/></svg> </a>
</div>
<script>
jQuery(function(){
    $(function () {
        $(window).scroll(function () { //Fonction appelÃ©e quand on descend la page
            if ($(this).scrollTop() > 200 ) {  // Quand on est Ã  200pixels du haut de page,
                $('#scrollUp').css('right','10px'); // Replace Ã  10pixels de la droite l'image
            } else { 
                $('#scrollUp').removeAttr( 'style' ); // EnlÃ¨ve les attributs CSS affectÃ©s par javascript
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


    /********** Anomalie ********/
    $indesirable='';
    $data_ban='';
    $ref = [];
    $img = [];
    $open_ban = fopen("./settings/anomalie.txt","r");
    while(($data_ban = fgets($open_ban)) == true){
        // trim sert a enlever les \n
        $indesirable = explode(',',trim($data_ban));
        array_push($ref,$indesirable[0]);
        array_push($img,$indesirable[1]);
    }
    /****************************/

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
            $titre = $data[1];
            //echo $data[36];
            if(getStringBetween($data[36],'<points>','</points>')!==''){
                $info = $data[3].' jours'.' ('.$data[2].' heures)'.' | '.'Prix par personne : '.$data[4].' €ht'. ' | '.getStringBetween($data[36],'<libpoints>','</libpoints>'). ' : '. getStringBetween($data[36],'<points>','</points>');
            }
            else { $info = $data[3].' jours'.' ('.$data[2].' heures)'.' | '.'Prix par personne : '.$data[4].' €ht'; }
            $objectifs = $data[37];
            $public = $data[43];
            $requis = $data[38];
            $programme = $data[40];
            $methode = $data[42];
            $eval = $data[41];
            $certif = $data[67]; // A VERIFIER !!!!!
            array_push($contenu,$objectifs,$public,$requis,$programme,$methode,$eval,$certif,'...');
            //var_dump($contenu);
            //echo '<h1>'.$titre.'</h1>';
            break;
            $limite++ ; // A SUPPRIMER PLUS TARD

        }
        $i=$i+1;
    }

    //echo "wkhtmltopdf learneo.pupitro.com/formations/page_pdf.php?param=".$url.' '.'../uploads/'.$url.'.pdf';
    exec("wkhtmltopdf --margin-top 10 --margin-bottom 10 --margin-left 20 --margin-right 20   https://learneo.pupitro.com/formations/page_pdf.php?param=".$url.' '.'../uploads/pdf/'.$url.'.pdf');
    fclose($open);
?>          
        
        <div class='info'>
        <!-- Image Download -->
        <button id="generatePDF"><svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#522583"><path d="M480-313 287-506l43-43 120 120v-371h60v371l120-120 43 43-193 193ZM220-160q-24 0-42-18t-18-42v-143h60v143h520v-143h60v143q0 24-18 42t-42 18H220Z"/></svg>
        </button>
        <script>
            document.getElementById('generatePDF').addEventListener('click', function() {
            // Nom du fichier à télécharger
            var url = <?php echo json_encode($url); ?>;
            var filename = url+'.pdf';
            // Effectuer une requête AJAX pour récupérer le contenu du fichier
            var xhr = new XMLHttpRequest();
            xhr.open('GET','../uploads/pdf/'+url + '.pdf' , true);
            xhr.responseType = 'blob'; // La réponse attendue est un objet Blob (binaire)

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Récupérer le contenu du fichier
                    var blob = xhr.response;

                    // Créer un objet de lien temporaire pour le téléchargement
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;

                    // Simuler un clic sur l'élément de lien pour déclencher le téléchargement
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            };

            // Envoyer la requête AJAX
            xhr.send();
});

        </script>
        <?php
            /***********  Images  ************/ 
            $open_liste = fopen("../uploads/liste.csv","r");
            $image = '';
            $j=0;
            while ( ($data_2 = fgetcsv($open_liste,2000,";")) == true && $j>=0  ){
                if($j>=1){
                    if($data_2[1] == $url){
                        // Si une référence n'est pas présente dans le fichier anomalie
                        if( ($index = array_search($data_2[1],$ref)) === false ){
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
                                case 'AWS':
                                    $image = './images/AWS'.'.png';
                                    break;
                                case 'ISACA':
                                    $image = './images/ISACA'.'.png';
                                    break;
                                case 'UCOPIA':
                                    $image = './images/UCOPIA'.'.png';
                                    break;
                                case 'GOUVERNANCE GDPR':
				case 'GOUVERNANCE SECURITE DU SI':
				case 'GOUVERNANCE DSI':
                                    $image = './images/GOUVERNANCE_GDPR'.'.png';
                                    break;
                                case "ETAT DE L'ART":
                                    $image = './images/ETAT_DE_LART'.'.gif';
                                    break;
                                case "HUAWEI":
                                    $image = './images/HUAWEI'.'.png';
                                    break;
                                case "PROJECT MANAGEMENT":
                                    $image = './images/PROJECT_MANAGEMENT'.'.webp';
                                    break;
                                default:
                                    $image = './images/'.$data_2[42].'-'.$data_2[41].'.png';            
                            }
                        }
                        else{
                            // Si une référence est présente dans le fichier anomalie
                            //echo $img[$index];
                            $image = './images/'.$img[$index];
                        }
                    }
                }
            $j++;
            }
            if(stripos($image,'CISCO') === false){
               // echo "<div class='img'> <img src=$image  alt='Description de l'image' width='140' height='110'> </div>";
            }
	    //else { echo "<div class='img'> <img src=$image  alt='Description de l'image' width='100' height='100'> </div>";}
            /*********** ******* ************/ 
            
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
                <a  href="#bouton_inscription"><button  type="button" >Comment s'inscrire ? </button></a>
            </div>
    		<script>
    		var url = <?php echo json_encode($url); ?>;
                document.getElementById('bouton_intra').addEventListener('click', function() {

		     //window.open('https://www.learneo.fr/formulaire-devis.html?nom-cours='+url);
		     window.open("http://172.20.42.10/demande-formation-intra-standard?formation="+url);
                 });
    		
    		document.getElementById('bouton_devis').addEventListener('click', function() {
		     window.open("http://172.20.42.10/demande-devis-inter?formation=" + url);
		});

            </script>
            <br>
            <br>
            


            <?php
            /***********  Menu déroulant  ************/ 
                if($objectifs !== ''){
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
		    echo "<a id='bouton_inscription'><h3> Modalités d'accés & inscription </h3></a>";
		    echo "<p>Le client qui souhaite souscrire à une formation remplit <a target='_blank' rel='noopener' rel='noreferrer'  href='https://www.learneo.fr/formulaire-formation.html'>une demande de pré-inscription</a>. Learneo retourne une proposition commerciale comprenant
                les caractéristiques de formation (type, durée) et la proposition financière.
                La commande n'est ferme et définitive qu'une fois la proposition commerciale signée par le client. <br>
                5 jours ouvrés (en moyenne) avant le début de la formation </p>";
		    echo '<hr>';
            	    echo "<p style='font-weight:bold;padding-right:7px'> <a target='_blank' rel='noopener' rel='noreferrer'  href='https://www.learneo.fr/accessibilite-handicap.html'>Accessibilité aux personnes en situation de handicap </a></p>
            <p> Contact : 01.53.20.37.00 | info@learneo.fr  </p>";

                    echo '</div>';
                    echo '</div>';
                    
                    echo '<div class = page> ';
                    echo '</div>';

                    echo '</div>';
                }
            ?>
            
              <br>
              <!-- Image Calendrier -->
             <h3> Dates
                <a href ='https://www.learneo.fr/formations/calendriers-formations.html' style='text-decoration:none;'><svg xmlns="http://www.w3.org/2000/svg" height="28px" viewBox="0 -960 960 960" width="48px" fill="#321D71"><path d="M180-80q-24 0-42-18t-18-42v-620q0-24 18-42t42-18h65v-60h65v60h340v-60h65v60h65q24 0 42 18t18 42v620q0 24-18 42t-42 18H180Zm0-60h600v-430H180v430Zm0-490h600v-130H180v130Zm0 0v-130 130Zm300 230q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z"/></svg>
                </a>
            </h3>

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
  
            echo '<ul>';
            foreach($tab as $element){
                echo '<li style="font-size:18px"><a target="_blank" rel="noopener" rel="noreferrer"  href="http://172.20.42.10/demande-devis-inter/?formation=' . $url . '&date=' . $element . '">' . $element . '</a></li>';
		echo '<br>';
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
                // Convertir les chaînes en minuscule pour les recherches insensibles à la casse
                $stringLower = strtolower($string);
                $startLower = strtolower($start);
                $endLower = strtolower($end);
                
                // Trouver la position de la chaîne de début
                $startPos = stripos($stringLower, $startLower);
                if ($startPos === false) {
                    return ''; // Si la chaîne de départ n'est pas trouvée, retourner une chaîne vide
                }
                $startPos += strlen($startLower); // Avancer le début juste après la chaîne de départ
                
                // Trouver la position de la chaîne de fin
                $endPos = stripos($stringLower, $endLower, $startPos);
                if ($endPos === false) {
                    return ''; // Si la chaîne de fin n'est pas trouvée, retourner une chaîne vide
                }
                
                // Extraire et retourner la sous-chaîne entre les positions de début et de fin
                return substr($string, $startPos, $endPos - $startPos);
            }

            // Sert a remplacer les chaines '_x000d_' par du vide 
            function replaceX000d($input) {
                // Vérifier et remplacer '_x000d_' si présent
                if (strpos($input, '_x000d_') !== false) {
                    return str_replace('_x000d_', '', $input);
                }
                // Sinon, vérifier et remplacer '_x000D_' si présent
                elseif (strpos($input, '_x000D_') !== false) {
                    return str_replace('_x000D_', '', $input);
                }
                // Si aucune des chaînes n'est trouvée, retourner la chaîne d'origine
                return $input;
            }
            

            ?>

            <br>
            <br>
    <script src="site.js" ></script></body>

</html>

