<?php
session_start();
date_default_timezone_set( 'Europe/Paris' );

if(isset(parse_url($_SERVER["REQUEST_URI"])["query"]))
{
  parse_str(parse_url($_SERVER["REQUEST_URI"])["query"], $node);
  if(isset($node["follow"]))
  {
    header("Location: " . $node["follow"]);
  }
}

if(isset($_GET["lang"]))
{
  $_SESSION["Lang"] = $_GET["lang"];
}

if(!isset($_SESSION["Lang"]))
{
  $_SESSION["Lang"] = "fr";
}

if(isset($_POST["changelang"]))
{
  $_SESSION["Lang"] = $_POST["lang"];
}

require_once "resources/i18n.class.php";
$i18n = new i18n('resources/lang/lang_{LANGUAGE}.ini', 'resources/langcache/', 'en');
$i18n->setFallbackLang('en');
$i18n->setForcedLang($_SESSION["Lang"]) ;
$i18n->init();

if(!isset($_SESSION["Form"]["effect"]))
{
  $_SESSION["Form"]["effect"] = 0;
}

$_SESSION["bypass"] = false;


if(basename($_SERVER['REQUEST_URI']) !="")
{
  $page = basename($_SERVER['REQUEST_URI']);
}
else
{
  $page = "default";
}


?><!DOCTYPE html>
<html lang="en">
<!--
 _____                   _____                           _
/  ___|                 |  __ \                         | |
\ `--.  ___ __ _ _ __   | |  \/ ___ _ __   ___ _ __ __ _| |_ ___  _ __
 `--. \/ __/ _` | '_ \  | | __ / _ \ '_ \ / _ \ '__/ _` | __/ _ \| '__|
/\__/ / (_| (_| | | | | | |_\ \  __/ | | |  __/ | | (_| | || (_) | |
\____/ \___\__,_|_| |_|  \____/\___|_| |_|\___|_|  \__,_|\__\___/|_|

Forever here.
-->
<head>
  <?php
  if(isset($_GET["goto"]))
  {
    echo '<meta http-equiv="refresh" content="1; url=mon-panier">';
  }

  if(isset($_GET["product"]))
  {
  	$product = $_GET["product"];
  }

  if ($page=="payment") {

    $_SESSION["bypass"] = true;
    if(isset($_POST["uid"]))
    {
      $_SESSION["Command"][$_POST["uid"]]["valid"] = true;
      $_SESSION["final_address"] = $btc_address;
    }
    if(isset($_GET["action"]))
    {
      switch($_GET["action"])
      {
        case "remove":
          unset($_SESSION["Command"][$_GET["id"]]);
        break;
      }
    }

    $totalEUR = 0;
    $totalBTC = 0;
    $iterator = 0;
  }
  ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo L::title; ?> // Générateur de faux documents / CNI / JDD / FDP / SCANS / Factures / Vrai documents / </title>
    <link rel="stylesheet" type="text/css" href="resources/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="resources/css/font-awesome.min.css" />
    <link rel="stylesheet" href="resources/css/app/app.v1.css" />
    <link rel="stylesheet" type="text/css" href="resources/css/style.css" />

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600|Raleway:400,500,600,700,300' rel='stylesheet' type='text/css' />
    <link href="static/favicon.png" rel="icon" type="image/png" />

</head>
<body data-ng-app>
  <?php
  if(isset($_SERVER["HTTP_X_TOR2WEB"]))
  {
    echo L::tor;
  }
  ?>
	<aside class="left-panel">

            <div class="user text-center">
                  <a href="/"><img src="static/favicon.png" class="img-circle" alt="...">
                  <h4 class="user-name">Auto'Scan <sup><small>4.0</small></sup></h4></a>

                  <div class="dropdown user-login">
                    <form action="" method="post" style='margin-bottom:0px;'>
                      <input type="hidden" name="changelang" value="true">
                      <?php
                      if($_SESSION["Lang"] == "fr")
                      {
                        ?>
                      <button class="btn btn-xs dropdown-toggle btn-rounded" type="button" data-toggle="dropdown" aria-expanded="true">
                        <img src="static/fr.png" class="lang-choose" /> Français <i class="fa fa-angle-down"></i>
                      </button>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <input type="hidden" name="lang" value="en">
                        <li><button class="langButton" type="submit"><img src="static/en.png" class="lang-choose" /> Anglais</button></li>
                      </ul>
                        <?php
                      }
                      else
                      {
                        ?>
                      <button class="btn btn-xs dropdown-toggle btn-rounded" type="button" data-toggle="dropdown" aria-expanded="true">
                        <img src="static/en.png" class="lang-choose" /> English <i class="fa fa-angle-down"></i>
                      </button>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <input type="hidden" name="lang" value="fr">
                        <li><button class="langButton" type="submit"><img src="static/fr.png" class="lang-choose" /> French</button></li>
                      </ul>
                      <?php
                    }
                    ?>
                    </form>
                  </div>
            </div>
            <nav class="navigation">
            	<ul class="list-unstyled">
                    <li id="identity" class="has-submenu <?php if($page == "cni" or $page == "decla" or $page == "passeport" or $page == "usapc" or $page == "vitale" or $page == "pdc") {echo 'active';} ?>"><a href="#identity"><i class="fa fa-user"></i> <span class="nav-label"><?php echo L::menu_identity; ?>  <sup><small>Maj</small></sup></span></a>
                    	<ul class="list-unstyled">
                        	<li><a href="cni"><?php echo L::menu_cni; ?> <sup><small>Maj</small></sup></a></li>
                          <li><a href="usapc"><img src="static/us.jpg"> <?php echo L::menu_usapc; ?> <sup><small>Maj</small></sup></a></li>
                          <li><a href="decla"><?php echo L::menu_decla; ?> <sup><small>Maj</small></sup></a></li>
                          <li><a href="pdc"><?php echo L::menu_drive; ?></a></li>
                          <li><a href="vitale"><?php echo L::menu_vitale; ?> <sup><small>Maj</small></sup></a></li>
                          <li class="notactive"><a href="eupasseport"><?php echo L::menu_eupasseport; ?></a></li>
                        </ul>
                    </li>
                    <li id="address" class="has-submenu <?php if($page == "edf" or $page == "dengy" or $page == "free") {echo 'active';} ?>"><a href="#address"><i class="fa fa-home"></i> <span class="nav-label"><?php echo L::menu_address; ?>  <sup><small>Maj</small></sup></span></a>
                    	<ul class="list-unstyled">
                      	<li><a href="edf"><?php echo L::menu_edf; ?></a></li>
                        <li><a href="free"><?php echo L::menu_facturefree; ?> <sup><small>Maj</small></sup></a></li>
                        <li><a href="dengy"><?php echo L::menu_den; ?> <sup><small>Maj</small></sup></a></li>
                      </ul>
                    </li>
                    <li class="<?php if($page == "fdp") {echo 'active';} ?>"><a href="fdp"><i class="fa fa-file-text-o"></i> <span class="nav-label"><?php echo L::menu_payslip; ?></span></a></li>
                    <li class="<?php if($page == "rib") {echo 'active';} ?>"><a href="rib"><i class="fa fa-bank"></i> <span class="nav-label"><?php echo L::menu_rib; ?></span></a></li>
                    <li id="cc" class="has-submenu <?php if($page == "cc_visa_premier") {echo 'active';} ?>"><a href="#cc"><i class="fa fa-credit-card"></i> <span class="nav-label"><?php echo L::menu_creditcard; ?></span></a>
                    	<ul class="list-unstyled">
                        	<li><a href="visa-premier"><?php echo L::menu_visapremier; ?></a></li>
                        </ul>
                    </li>
                    <li id="other" class="has-submenu <?php if($page == "darty" or $page == "bac" or $page == "bts" or $page == "dut") {echo 'active';}?>"><a href="#other"><i class="fa fa-list"></i> <span class="nav-label"><?php echo L::menu_other; ?></span></a>
                    	<ul class="list-unstyled">
                        	<li><a href="bac"><?php echo L::menu_bac; ?></a></li>
                          <li><a href="darty"><?php echo L::menu_darty; ?></a></li>
                          <li class="notactive"><a href="kbis"><?php echo L::menu_kbis; ?></a></li>
                          <li class="notactive"><a href="#"><?php echo L::menu_bts; ?></a></li>
                          <li class="notactive"><a href="#"><?php echo L::menu_dut; ?></a></li>
                          <li class="notactive"><a href="#"><?php echo L::menu_absence; ?></a></li>
                          <li class="notactive"><a href="bac"><?php echo L::menu_prescription; ?></a></li>

                          <li></li>
                          <li></li>
                        </ul>
                    </li>
                </ul>

                <center>

                <form action="index.php" method="GET">
                <select name="follow">
                    <option value="about">Accueil</option>
                    <option></option>
                    <option value="cni">Carte Nationale d'Identité</option>
                    <option value="decla">Déclaration perte CNI</option>
                    <option value="pdc">Permis de conduire</option>
                    <option value="edf">Facture EDF</option>
                    <option value="free">Facture Free</option>
                    <option value="dengy">Facture Direct Energie</option>
                    <option value="fdp">Fiche de Paie</option>
                    <option value="cc_visa_premier">Carte Bancaire Visa Premier</option>
                    <option value="rib">Relevé d'Identité Bancaire</option>
                    <option value="bac">Diplôme du Baccalauréat</option>
            <!--         <option value="bts">Diplôme du BTS</option> -->
                    <option value="vitale">Carte Vitale</option>
                    <option value="darty">Facture Darty</option>
                  </select>
                  <input id="gow" type="submit" value="Go" />
              </form>

                </center>
            </nav>
    </aside>
    <section class="content">
        <header class="top-head container-fluid">
<!--             <button type="button" class="navbar-toggle pull-left">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button> -->
            <nav class=" navbar-default hidden-xs" role="navigation">
              <ul class="nav navbar-nav">
<li><a><?php echo L::welcome; ?></a></li>
</ul>
</nav>
            <ul class="nav-toolbar">
              <li>
                <a><?php echo L::btcprice; ?> :
                    <?php
                    $BTC_EUR = 500;
                    echo sprintf("%.0f", $BTC_EUR);
                    ?>
                    &euro;</a>
              </li>
            </ul>
        </header>
        <div class="warper container-fluid">
          <?php
          switch($page)
          {
            case "cni":
            include "content/cni/index.php";
            break;

            case "decla":
            include "content/decla/index.php";
            break;

            case "fdp":
            include "content/fdp/index.php";
            break;

            case "edf":
            include "content/edf/index.php";
            break;

            case "visa-premier":
            include "content/cc/visa/premier/index.php";
            break;

            case "rib":
            include "content/rib/index.php";
            break;

            case "vitale":
            include "content/vitale/index.php";
            break;

            case "darty":
            include "content/darty/index.php";
            break;

            case "free":
            include "content/free/index.php";
            break;

            case "gallery":
            include "content/gallery.php";
            break;

            case "pdc":
            include "content/pdc/index.php";
            break;

            case "bac":
            include "content/bac/index.php";
            break;

            case "bts":
            include "content/bts/index.php";
            break;

            case "dengy":
            include "content/dengy/index.php";
            break;

            case "usapc":
            include "content/usapc/index.php";
            break;

            case "seller":
            include "content/seller.php";
            break;

            case "sales":
            include "content/sales_tracking.php";
            break;

            default:
            ?>
            <h1><?php echo L::construction_title; ?></h1>
            <p class="lead"><?php echo L::construction_description; ?></p>
            <?php
            break;

            case "about":
            case "default":
            ?>
            <div class="row">
              <div class="col-md-12">
                  <h1><?php echo L::home_title; ?></h1>
                  <p class="lead"><?php echo L::home_nodata; ?></p>
                  <!--- <p class="red">Pour la version 4.0 <u>Beta</u> il est nécessaire d'activer Javascript, qui ne représente aucun danger en terme d'anonymat.</p> -->
              </div>
            </div>
          <?php
          setlocale(LC_ALL, 'fr_FR');
             ?>
             <br />
            <?php
            break;
          }
          ?>
        </div>
    </section>
<!--     <script src="resources/js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="resources/js/bootstrap/bootstrap.min.js"></script>
    <script src="resources/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="resources/js/app/custom.js" type="text/javascript"></script> -->
</body>
</html>
