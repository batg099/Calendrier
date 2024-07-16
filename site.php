
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- MÃ©ta-donnÃ©es pour dÃ©finir le jeu de caractÃ¨res et la mise Ã  l'Ã©chelle -->
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <!-- Titre de la page -->
    <title>Calendrier - Learneo</title>
    <!-- Liens vers les fichiers CSS et JavaScript externes -->
    <!-- 
    <link rel="stylesheet" type="text/css" media="screen and (min-width:600px)" href="sitebureau.css">
    <link rel="stylesheet" type="text/css" media="screen and (max-width:600px)" href="filmmobile.css">
    -->
    <link rel="stylesheet" type="text/css" media="screen" href="learneo.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
     
</head>
<body>
    <div class="block" >
    <!-- En-tÃªte de la page -->




    <!-- A ameliorer car horrible -->
    <form  method="post">
        <div class="search">
            <span class="material-symbols-outlined"> search </span>
            <input  type="text" id="libre" name="libre"  placeholder="Recherche Libre" size="74" >
<?php
   header("Content-Type: text/html;charset=utf-8");
   ini_set('display_errors',1);
   ini_set('display_startup_errors',1);
   error_reporting(E_ALL);
    // On ouvre le fichier
   $open = fopen("liste.csv","r");
   $open_cle = fopen("Produits.csv","r");

    /********** Bannissements ********/
    $indesirable=[];
    $data_ban='';
    $open_ban = fopen("bannissement.txt","r");
    while(($data_ban = fgets($open_ban)) == true){
        // trim sert a enlever les \n
        array_push($indesirable,trim($data_ban));
    }
    //print_r($indesirable);
    /********************************* */

    $menu = [];
    $departement = '';
    $calendrier = [];
    $libre ='';
    $resultat='';
    $i=0;
    // Tant qu'on trouve une ligne (hors ligne 0 et 1) dans notre fichier, on la prend 
    while ( ($data = fgetcsv($open,2000,";")) == true && $i>=0  ){
        // On considere que chaque element de la ligne est un element d'un tableau 
        $ligne = str_getcsv($data[0],";");
        if($i>=2){ 
            array_push($calendrier,["coco"]);

            $departement = $data[42];
            // On vÃ©rifie si le departement est deja present dans le menu
            if(in_array($departement,$menu) == false){
                array_push($menu,$departement);
            }
        }
        $i++;
    };
    print "<div class='domaine'>";
    print '<select name="resultat" id="resultat" onchange="submitForm()">';
    print '<option style="text-align:center;" value="" disabled selected>Domaines</option>';
    sort($menu); // Sert a trier par ordre alphabetique
    foreach($menu as $value){
        if(in_array($value,$indesirable)==false){
            print '<option value="' . htmlspecialchars($value). '">' . htmlspecialchars($value)  . '</option>';
        }
    }
    print '</select>';

    ?>
    <script>
        function submitForm() {
            document.getElementById("resultat").form.submit();
        }
    </script>

        <button type="submit" style="border: 0; background: transparent">
        <span class="material-symbols-outlined">
search_off
</span>
        </button>
    </div>
        </div>
    </form>
    

    <h2 > <?php  
    if(isset($_POST["resultat"])){
        $resultat = $_POST["resultat"];
        echo " - ".htmlspecialchars($_POST["resultat"]); 
    }
    if(isset($_POST["libre"])){
        $libre = $_POST["libre"];
    }
        ?>
    </h2>

    <table>
        <tr class="header">
            <th>RÃ©fÃ©rence</th>
            <th>IntitulÃ© de la formation</th>
            <th>Jrs</th>
            <?php 
                    $limite = 0;
                    $date = new DateTimeImmutable();
                    // On prend le mois (en String) et on le transforme en Int
                    $mois = intval($date-> format("m"));
                    function getMonthName($monthNumber) {
                        $months = [
                            1 => 'Jan',
                            2 => 'Fev',
                            3 => 'Mars',
                            4 => 'Avr',
                            5 => 'Mai',
                            6 => 'Juin',
                            7 => 'Juil',
                            8 => htmlspecialchars('AoÃ»t'),
                            9 => 'Sept',
                            10 => 'Oct',
                            11 => 'Nov',
                            12 => 'Dec'
                        ];
                    
                        return $months[$monthNumber] ?? 'Mois invalide'; // Renvoie le mois ou "Mois invalide" si le chiffre n'est pas valide
                    }
                    while($limite <= 5){
                        echo "<th>".getMonthName($mois + $limite)."</th>";
                        $limite = $limite + 1;
                    }
            ?>
        </tr>
                <?php  
                        $i=0;
                        $open = fopen("liste.csv","r");
                        $test=[0,0,0,0];
                        $indice=0;
                        $numero = 0;

                        function tableau($data,$numero){
                            $nb = 0;
                            $date = new DateTimeImmutable();
                            $mois = intval($date-> format("m"));


                            /*
                            if($numero === 0){
                                if(in_array($data[41],$test) == false){
                                    echo "<tr>"."<td>"."/ "."</td>"."</tr>" ;
                                    array_push($test,$data[41]);
                                }
                            }
                            */
                            if(count($data[3]) == 1){
                                echo "<tr>";
                                echo "<td>". htmlspecialchars($data[1]) . "</td>";
                                echo "<td>". htmlspecialchars($data[2]) . "</td>";
                                $calcul = (int)($data[7])/7;
                                if(gettype($calcul) === "double" ){
                                    echo "<td style='text-align: center;'>". $data[7]. " h"."</td>";
                                }
                                else{echo "<td style='text-align: center;'>". (int)($data[7])/7 ."</td>";}
                                
    
                                $mois_temp = $data[3][0];
                                $mois_temp_bis = explode("/",$mois_temp);
                                $mois_temp = $mois_temp_bis[1];
                                if( $mois_temp == $mois){
                                    echo "<td style='text-align: center;'>". $mois_temp_bis[0] ."</td>";
                                    echo "<td>"." "."</td>";
                                    echo "<td>"." "."</td>";
                                    echo "<td>"." "."</td>";
                                    echo "<td>"." "."</td>";
                                    echo "<td>"." "."</td>";
                                }
                                else{
                                    echo "<td>"." "."</td>";
                                    if($mois_temp == ($mois+1) ){
                                        echo "<td style='text-align: center;'>". $mois_temp_bis[0] ."</td>";
                                        echo "<td>"." "."</td>";
                                        echo "<td>"." "."</td>";
                                        echo "<td>"." "."</td>";
                                        echo "<td>"." "."</td>";
                                        
                                    }
                                    else{
                                        echo "<td>"." "."</td>";
                                        if($mois_temp == ($mois+2) ){
                                            echo "<td style='text-align: center;'>". $mois_temp_bis[0] ."</td>";
                                            echo "<td>"."  "."</td>";
                                            echo "<td>"." "."</td>";
                                            echo "<td>"." "."</td>";
                                        }
                                        else{
                                            echo "<td>"."  "."</td>";
                                            if($mois_temp == ($mois+3) ){
                                                echo "<td style='text-align: center;'>". $mois_temp_bis[0] ."</td>";
                                                echo "<td>"." "."</td>";
                                                echo "<td>"." "."</td>";
                                            }
                                            else{
                                                    echo "<td>"."  "."</td>";
                                                    if($mois_temp == ($mois+4) ){
                                                        echo "<td style='text-align: center;'>". $mois_temp_bis[0] ."</td>";
                                                        echo "<td>"." "."</td>";
                                                    }
                                                    else{
                                                        echo "<td>"."  "."</td>";
                                                        if($mois_temp == ($mois+5) ){
                                                            echo "<td style='text-align: center;'>". $mois_temp_bis[0] ."</td>";
                                                            
                                                        }
                                                        else{
                                                            echo "<td style='text-align: center;'>"." NC "."</td>";
                                                        }
                                                    }
                                            }
                                        }
                                    }
                                }
                            }
                            else{
                                echo "<tr>";
                                echo "<td>". htmlspecialchars($data[1]) . "</td>";
                                echo "<td>". htmlspecialchars($data[2]) . "</td>";
                                echo "<td style='text-align: center;'>". (int)($data[7])/7 ."</td>";
                                $tab_mois=[];
                                // Je cree un tableau qui va contenir des associations (mois) => [date1, date2 ...]
                                foreach ($data[3] as $value) {
                                    $mois_temp = explode("/", $value)[1];
                                    $mois_temp = (int)$mois_temp; // Convertir en entier pour les comparaisons
                                
                                    if ($mois_temp >= $mois && $mois_temp <= 12) {
                                        if (!isset($tab_mois[$mois_temp])) {
                                            $tab_mois[$mois_temp] = [];
                                        }
                                        $tab_mois[$mois_temp][] = $value; // Ajoute la date au tableau du mois correspondant
                                    }
                                }
                                
                                // Ajouter des mois vides si nÃ©cessaire
                                for ($i = $mois; $i <= 12; $i++) {
                                    if (!isset($tab_mois[$i])) {
                                        $tab_mois[$i] = [];
                                    }
                                }
                                ksort($tab_mois);
                                //var_dump($tab_mois);

                                foreach($tab_mois as $cle => $value){
                                    if($nb <= 5){
                                        $chaine='';
                                        if($value == []){
                                            echo "<td>"."  "."</td>";
                                        }
                                        else{
                                            //print_r($value);
                                            $nombre = 0; // Va servir Ã  savoir s'il existe plusieurs dates dans le meme mois
                                            usort($value,"cmp");
                                            usort($value,"cmp_days"); // Sert Ã  trier selon le jour 
                                            foreach($value as $date){
                                                // On compte le nombre de date qu'on a dans le mois
                                                if($date != ''){
                                                    $nombre = $nombre + 1;
                                                }
                                                $jour = explode("/",$date)[0];
                                                // Sert Ã  Ã©viter la rÃ©pÃ©tition + On fait la difference entre les deux dates.
                                                
                                                    //echo "My date_1 is".$date;
                                                    //echo "My date_2 is".date('d-m-Y');
                                                    //echo "My diff is".$diff->format("%m");
                                                    // Si on a plus de 2 dates dans le mois, alors on affiche un |
                                                    if($nombre >= 2){
                                                        //echo "My date_1 is".$date;
                                                        $chaine = $chaine." | ".$jour;
                                                    }
                                                    // On affiche un espace sinon
                                                    else{$chaine = $chaine." ".$jour;}
                                                    $mois_temp = $date;
                                                    $mois_temp = explode("/",$mois_temp);
                                                    $mois_temp = $mois_temp[1];
                                                    //echo "My month is".$mois_temp;
                                                
                                            }
                                            //echo $chaine;
                                            $chaine = explode("/",$chaine);
                                            $chaine=$chaine[0];
                                            echo "<td style='text-align: center;'>".htmlspecialchars($chaine)."</td>"; 
                                            
                                        }
                                        
                                        $nb=$nb+1;
                                    }
                                }
                                /*
                                    if($nb <= 2){
                                        if($mois_temp == $mois || $mois_temp == $mois + 1  || $mois_temp == $mois + 2 ){
                                            echo "<td>".$value."</td>";
                                        }
                                        else{
                                            echo "<td>"." / "."</td>";
                                        }
                                        $nb = $nb +1;
                                    }
                                        */
                            }
                            
                            echo "</tr>";
                        }
                        function array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
                        {
                            $sort_col = array();
                            foreach ($arr as $key => $row) {
                                $sort_col[$key] = $row[$col];
                            }
                            array_multisort($sort_col, $dir, $arr);
                        }

                        $tab=[];
                        $tab_intitule=[];
                        // Tant qu'on trouve une ligne (hors ligne 0 et 1) dans notre fichier, on la prend 
                        while ( ($data = fgetcsv($open,2000,";")) == true && $i>=0  ){
                            if($i>0){
                                //if(in_array($data[1],$tab_intitule) == false){
                                    $non = 0;
                                    $date = $data[3];
                                    $date = explode('/',$date);
                                    // Si l'annee de la ligne = l'annee actuelle 
                                    if(differenceEnMois($data[3],date('d/m/Y')) <= 11 && $data[5]!=='INTRA' &&  $data[6]!=='A Annuler' && $date[2]>=date('Y')){
                                        // On parcours notre tableau
                                        foreach($tab as $ligne){

                                            $index = array_search($ligne,$tab);
                                            // On veut avoir un tableau qui va contenir les dates d'un meme intitule
                                            // On le cree s'il n'existe pas deja
                                            if (!is_array($tab[$index][3])) {
                                                $tab[$index][3] = [$tab[$index][3]];
                                            }
                                            // Si ce tableau existe, alors on ajoute les dates a celui-ci
                                            if($data[1] == $ligne[1] && $data != $ligne){
                                                array_push($tab[$index][3],$data[3]);
                                                $non = 1;
                                            }
                                        }
                                        if($non == 0 ){
                                            $data[3]=[$data[3]];
                                            array_push($tab,$data);
                                        }
                                    }

                                    //array_push($tab_intitule,$data[1]);
                                //}
                                /*
                                else{
                                    foreach($data as $element){
                                        if(array_search($element,$data)!=3 ){
                                            $element="/";
                                        }
                                    }
                                    array_push($tab,$data);
                                }
                                */
                            }
                            // On considere que chaque element de la ligne est un element d'un tableau 
                            $i++;
			}; 
			
			                     
			
                        
                            array_sort_by_column($tab, 42);

                            //Fonction qui sert Ã  comparer les dates de debut dans notre dictionnaire

                            foreach($tab as $data){
                                if($data[1]!=='F-AGCC'){
                                    if (!isset($tabi[$data[42]]) ) {
                                        $tabi[$data[42]] = [];
                                    }
                                //echo "I am pushing\n";print_r($tabi[$data[41]]);
                                    array_push($tabi[$data[42]],$data);
                                }
                            }
                            
                            foreach($tabi as $cle => $valeur){
                                    if(in_array($cle,$indesirable)==false){
                                        // Tableau de depart
                                        if(empty($libre)==true && empty($resultat)==true){
                                            $test[$cle]=1;
                                            if($cle !== 'AUTRES' && stripos($cle,'TESTS')===false){
                                                echo "<tr>";
                                                echo "<td colspan='9' class='table-heading'>".$valeur[0][42]."</td>" ;
                                                echo "</tr>";
                                            }
                                            // On trie le tableau associe a chaque cle en fonction des dates de debuts
                                            usort($valeur, "cmp");
                                            //usort($valeur, "cmp_cle");
                                            foreach($valeur as $ligne){
                                                //echo "Moshi Moshi".$valeur[0][41];
                                                if($ligne[1]==='F-ITIL-FOUND'|| stripos($ligne[2], "TEST") == false &&  stripos($ligne[1], "TEST") === false && (stripos($ligne[1],'F-') !== false || stripos($ligne[1],'UCO-') !== false )&& $ligne[1]!=='F-AGCC' ){
                                                    tableau($ligne,0);
                                                }
                                            }
                                        }
                                        else{
                                            
                                            if($valeur == $resultat || isset($_POST["libre"]) && empty($libre)==false){
                                                echo "<tr>";
                                                echo "<td colspan='9' class='table-heading'>".$valeur[0][42]."</td>" ;
                                                echo "</tr>";
                                            }
					    usort($valeur, "cmp");
					    //usort($valeur, "cmp_cle");
                                            foreach($valeur as $ligne){
                                                $departement = $ligne[42];
                                                // Recherche par Domaines
                                                if(isset($_POST["resultat"]) && empty($resultat)==false){
                                                    
                                                    if($departement == $resultat &&  (stripos($ligne[1],'F-') !== false || stripos($ligne[1],'UCO-') !== false ) && $ligne[1]!=='F-AGCC' ){
                                                        tableau($ligne,1);
                                                    }
                                                }
                                                // Recherche Libre
                                                else if(isset($_POST["libre"]) && empty($libre)==false ){
                                                    //echo "mon resultat_1 est".$libre;
                                                    //echo "mon resultat_2 est".$data[1];
                                                    if (stripos($ligne[2], $libre) !== false || stripos($ligne[1], $libre) !== false || stripos($ligne[42], $libre) !== false){
                                                        //echo "mon resultat_2 est".$data[1];
                                                        //On verifie que "Test" n'est pas dans l'intitule
                                                         if($ligne[1]==='F-ITIL-FOUND'|| stripos($ligne[2], "TEST") == false &&  stripos($ligne[1], "TEST") === false && (stripos($ligne[1],'F-') !== false || stripos($ligne[1],'UCO-') !== false )&& $ligne[1]!=='F-AGCC' ){
                                                            tableau($ligne,1);
                                                        }
                                                    }
                                                }
                                            }
                                        
                                    }                                    }
                                

                            }
                        
                        //print_r($tabi);
                        fclose($open);

                        function cmp($a, $b){
                            $dateA = DateTime::createFromFormat('d/m/Y', $a[3][0]);
                            $dateB = DateTime::createFromFormat('d/m/Y', $b[3][0]);
                        
                            if ($dateA == $dateB) {
                                return 0;
                            }
                        
                            return ($dateA < $dateB) ? -1 : 1;
                        }
                        function cmp_days($a, $b){
                        
                            $a = (int)explode('/',$a)[0];
                            $b = (int)explode('/',$b)[0];
                            

                            if ($a == $b) {
                                return 0;
                            }
                        
                            return ($a < $b) ? -1 : 1;
                        }
			 function cmp_cle($a, $b){
                            //echo $a[50].$b[50];
                            global $tab_cle;
                            $valeur_a=0;
                            $valeur_b=0;
                            //print_r($tab_cle);
                            foreach($tab_cle as $ligne){
                                //echo $ligne[0].' + '.$a[0].' ';
                                //echo $a[0];
                                //echo 'habibi';
                                if($ligne[0] == $a[1] && isset($ligne[1])){
                                    //echo 'habibi';
			                        if($ligne[1] !== ''){
                                    	$valeur_a=$ligne[1];
				                    }
				                    else{
					                    $valeur_a=1000000;
				                    }
                                }
                                if($ligne[0] == $b[1]){
			                        if($ligne[1] !== '' && isset($ligne[1])){
                                    	$valeur_b=$ligne[1];
				                    }
				                    else{
					                    $valeur_b=100000;
				                    }
                                }
                            }
                            echo $valeur_a.' + '.$valeur_b.' | ';
                            if ($valeur_a == $valeur_b) {
                                return 0;
                            }

                            return ($valeur_a < $valeur_b) ? -1 : 1;
                        }
                        function differenceEnMois($date1, $date2) {
                            // CrÃ©er des objets DateTime pour les deux dates
                            $datetime1 = DateTime::createFromFormat('d/m/Y', $date1);
                            $datetime2 = DateTime::createFromFormat('d/m/Y', $date2);
                        
                            // VÃ©rifier si les objets DateTime ont Ã©tÃ© crÃ©Ã©s correctement
                            if ($datetime1 === false || $datetime2 === false) {
                                return "Erreur: Format de date invalide.";
                            }
                        
                            // Calculer la diffÃ©rence entre les deux dates
                            $interval = $datetime1->diff($datetime2);
                        
                            // Calculer la diffÃ©rence totale en mois
                            $diffEnMois = $interval->y * 12 + $interval->m;
                        
                            // Ajouter les mois partiels s'il y a plus de jours dans l'une des dates
                            if ($interval->d > 0) {
                                $diffEnMois += 1;
                            }
                        
                            return $diffEnMois;
                        }
                ?>
   

        
    </table>
                        </div>


    

    
    <script src="site.js" ></script>
</body>

</html>
