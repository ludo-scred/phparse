<?php
	//afficher les erreurs sur la page directement.
    ini_set('display_errors', 1);

    // l'adresse du site où on va chercher.
    $url = 'https://www.worldometers.info/coronavirus/';

    //On paramètre cURL pour nous faire une jolie requette http.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_PROXY, '');
    $data = curl_exec($ch);
    curl_close($ch);

    //On initialise notre "arbre" de la page web pour la "ranger" virtuellement.
    $dom = new DOMDocument();
    @$dom->loadHTML($data);

    //On utilise l'outil XPath pour DOM. XPath c'est le chemin d'une balise html (Absolu ou relatif : là, nous, on utilise le relatif.)
    $xpath = new DOMXPath($dom);

    // On déclare une variable "valeur" qui sera donc la réponse de notre requete XPath. XPATH = LE CHEMIN

    //RELATIF => On utilise l'ID directement et on fini le chemin tranquillement.
	$casTotauxXPATH = $xpath->query('//*[@id="maincounter-wrap"]/div/span'); 
	$casActifsXPATH = $xpath->query('//*[@class="number-table-main"]'); 

	//ABSOLU => On écrit le chemin complet.   ATTENTION, parfois ca ne marche qu'avec 1 seul et parfois les deux.
	//  $valeur_absolue = $xpath->query('/html/body/div[3]/div[2]/div[1]/div/div[4]/div/span'); 

	// On range notre valeur dans un array. On la met au niveau 0, la première valeur de l'array.
	$casTotaux = $casTotauxXPATH[0]->nodeValue;
	$casActifs = $casActifsXPATH[0]->nodeValue;
	$casFinis = $casActifsXPATH[1]->nodeValue;


	var_dump($casTotauxXPATH);
    print "Nombre de cas <b>TOTAUX</b> du coronavirus =====> ".$casTotaux;
    print "<br>Nombre de cas <b>ACTIFS</b> du coronavirus =====> ".$casActifs;
 	print "<br>Nombre de cas <b>GUERIS</b> du coronavirus =====> ".$casFinis;


?>