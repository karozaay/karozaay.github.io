<?php
session_start();
error_reporting(0);
ini_set('memory_limit', '-1');
require_once("render.php");
$CNIPriceEUR = 4.99;
$BTC_EUR = 500;
$CNIPriceBTC = sprintf("%.8f", $CNIPriceEUR / $BTC_EUR);

$cni = new GeneratorCNI($_SESSION["Preview"]["CNI"]["Photo"], $_SESSION["Preview"]["CNI"]["sign1"], $_SESSION["Preview"]["CNI"]["sign2"]);
$cni->setFirstName($_SESSION["Preview"]["CNI"]["firstname"]);
$cni->setLastName($_SESSION["Preview"]["CNI"]["lastname"]);
$cni->setGender($_SESSION["Preview"]["CNI"]["gender"]);
$cni->setBirthCity($_SESSION["Preview"]["CNI"]["birthcity"]);
$cni->setBirthDate(explode("/", $_SESSION["Preview"]["CNI"]["birthdate"])[0], explode("/", $_SESSION["Preview"]["CNI"]["birthdate"])[1], explode("/", $_SESSION["Preview"]["CNI"]["birthdate"])[2]);
$cni->setTall(substr($_SESSION["Preview"]["CNI"]["tall"], 0, 1), substr($_SESSION["Preview"]["CNI"]["tall"], 1, 3));
$cni->setPrefecture($_SESSION["Preview"]["CNI"]["prefecture"], 	$_SESSION["Preview"]["CNI"]["prefecture_department"]);
$cni->setAddress($_SESSION["Preview"]["CNI"]["address"], $_SESSION["Preview"]["CNI"]["address_city"], $_SESSION["Preview"]["CNI"]["address_zipcode"]);
$cni->setDeliveryDate($_SESSION["Preview"]["CNI"]["deliverydate"]);
$cni->setCNINumber($_SESSION["Preview"]["CNI"]["cninumber"]);
$cni->setCNIAlgo1($_SESSION["Preview"]["CNI"]["cnialgo1"]);
$cni->setCNIAlgo2($_SESSION["Preview"]["CNI"]["cnialgo2"]);
$cni->setRandom($_SESSION["Preview"]["CNI"]["random"]);
$cni->Render(true, $_SESSION["Preview"]["CNI"]["effect"]);
$_SESSION["Command"][$_GET["uid"]] = array("uid"=>$_GET["uid"], "type"=>"CNI", "photo"=>$_SESSION["Preview"]["CNI"]["Photo"], "sign1"=>$_SESSION["Preview"]["CNI"]["sign1"], "sign2"=>$_SESSION["Preview"]["CNI"]["sign2"], "cni"=>$cni, "post"=>$_SESSION["Preview"]["CNI"], "priceEUR"=>$CNIPriceEUR, "priceBTC"=>$CNIPriceBTC);
?>
