<?php

function wd_remove_accents($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

    return $str;
}

$city = "Annemasse";
$department = 74;
$afterDep="fail";

$search = $city;
$search = trim($search);
$search = wd_remove_accents($search);
$search = str_replace(' ', '-', $search);
$search = strtoupper($search);

$handle = fopen("static/comsimp2016.txt", "r");
while (($line = fgets($handle)) !== false) {
    $lineArray = explode("\t", $line);
    if ($lineArray[3]==$department && $lineArray[9] == $search){
		$afterDep = $lineArray[5];
	}
}
fclose($handle);

echo $afterDep;

?>