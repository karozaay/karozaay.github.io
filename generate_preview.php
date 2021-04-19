<?php
session_start();
foreach ($_POST as $field=>$value) {
    $_SESSION["Form"][$field] = $value;
}
$_SESSION["Preview"]["CNI"] = $_POST;
$uid = uniqid();
$check=0;
$erreurs="";

if(!empty($_FILES["photo"]["name"]))
{
	$_SESSION["Preview"]["CNI"]["Photo"] = file_get_contents($_FILES["photo"]["tmp_name"]);
}
else
{
	$_SESSION["Preview"]["CNI"]["Photo"] = null;
}

if(!empty($_FILES["sign1"]["name"]))
{
	$_SESSION["Preview"]["CNI"]["sign1"] = file_get_contents($_FILES["sign1"]["tmp_name"]);
}
else
{
	$_SESSION["Preview"]["CNI"]["sign1"] = null;
}

if(!empty($_FILES["sign2"]["name"]))
{
	$_SESSION["Preview"]["CNI"]["sign2"] = file_get_contents($_FILES["sign2"]["tmp_name"]);
}
else
{
	$_SESSION["Preview"]["CNI"]["sign2"] = null;
}

if (!(preg_match("!^(0?\d|[12]\d|3[01])/(0?\d|1[012])/((?:19|20)\d{2})$!",$_SESSION["Preview"]["CNI"]["birthdate"]))) {
	$check++;
	$erreurs = $erreurs."La date de naissance n'est pas sous le format JJ/MM/AAAA<br>";
}

if (!(preg_match("!^(0?\d|[12]\d|3[01])/(0?\d|1[012])/((?:19|20)\d{2})$!",$_SESSION["Preview"]["CNI"]["deliverydate"]))) {
	$check++;
	$erreurs = $erreurs."La date de délivrance de la CNI n'est pas sous le format JJ/MM/AAAA<br>";
}

if (isset($_SESSION["Preview"]["CNI"]["cninumber"]) && strlen($_SESSION["Preview"]["CNI"]["cninumber"])>0 && strlen($_SESSION["Preview"]["CNI"]["cninumber"])<12) {
	$check++;
	$erreurs = $erreurs."Le numéro de CNI est incorrect<br>";
}

if (isset($_SESSION["Preview"]["CNI"]["cnialgo1"]) && strlen($_SESSION["Preview"]["CNI"]["cnialgo1"])>0 && strlen($_SESSION["Preview"]["CNI"]["cnialgo1"])<36) {
	$check++;
	$erreurs = $erreurs."La ligne d'algo 1 n'est pas complète.<br>";
}

if (isset($_SESSION["Preview"]["CNI"]["cnialgo2"]) && strlen($_SESSION["Preview"]["CNI"]["cnialgo2"])>0 && strlen($_SESSION["Preview"]["CNI"]["cnialgo2"])<36) {
	$check++;
	$erreurs = $erreurs."La ligne d'algo 2 n'est pas complète.<br>";
}


if ((strlen($_SESSION["Preview"]["CNI"]["cnialgo1"])>0 && strlen($_SESSION["Preview"]["CNI"]["cnialgo2"])==0) || (strlen($_SESSION["Preview"]["CNI"]["cnialgo2"])>0 && strlen($_SESSION["Preview"]["CNI"]["cnialgo1"])==0)) {
	$check++;
	$erreurs = $erreurs."Vous ne pouvez pas remplir qu'une seule des deux lignes d'algo.<br>";
}
?>
<!DOCTYPE html>
<?php
if ($check==0)
{
?>
<html>
<head>
	<link type="text/css" href="../../resources/css/bootstrap.min.css" rel="stylesheet" />
	<link type="text/css" href="../../resources/css/font-awesome.min.css" rel="stylesheet" />
	<link type="text/css" href="../../resources/css/app/app.v1.css" rel="stylesheet" />
	<link type="text/css" href="../../resources/css/style.css" rel="stylesheet" />
</head>
<body id="empty_body">
	<a href="preview.php?uid=<?php echo $uid; ?>" target="_blank"><img src="preview.php?uid=<?php echo $uid; ?>" style="width: 100%; max-width:500px;" /></a>
	<br><br>
	<form id="formPaymentCNI" action="../../index.php?page=payment" method="post" target="_parent" style="float:left; margin-left:10px;">
		<input type="hidden" name="uid" value="<?php echo $uid; ?>" />
	</form>
</body>
</html>

<?php

} else {

	echo "<p style='font-weight:bold;color:red;'><u>Erreurs</u><br>";
	echo $erreurs;
	echo "</p><br><br>";
	include("empty_preview.php");

}

?>
