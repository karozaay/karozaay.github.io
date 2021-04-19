<div class="row">
  <div class="col-md-6">

<form id="formCNI" action="content/cni/generate_preview.php" method="post" target="preview" enctype="multipart/form-data">
    <h2><?php echo L::page_base; ?></h2>
    <h5 style="color:#ff0000"><?php echo L::page_required; ?></h5>
    <div>
        <label for="effect"><?php echo L::field_effect; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control-light" max="100" min="0" type="range" name="effect" value='<?php if (isset($_SESSION["Form"]["effect"])) { echo $_SESSION["Form"]["effect"]; } else { echo "0"; }?>' required/>
    </div>
    <br />
    <div>
        <label for="lastname"><?php echo L::field_lastname; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control" type="text" name="lastname" placeholder="Ex: Nemmard" value='<?php if (isset($_SESSION["Form"]["lastname"])) echo $_SESSION["Form"]["lastname"]; ?>' required/>
    </div>
    <div>
        <label for="firstname"><?php echo L::field_firstnames; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control" type="text" name="firstname" placeholder="Ex: Jean" value='<?php if (isset($_SESSION["Form"]["firstname"])) echo $_SESSION["Form"]["firstname"]; ?>' required/>
                <br><span class="fieldsub">Séparez les prénoms avec une virgule</span>
    </div>
    <br>
    <div>
        <label for="gender"><?php echo L::field_gender; ?> <span style="color:#ff0000">*</span> :</label>
        <select class="form-control" name="gender" required>
          <option value="M" value='<?php if (isset($_SESSION["Form"]["gender"]) && $_SESSION["Form"]["gender"]=="M") echo "selected"; ?>'><?php echo L::field_man; ?></option>
          <option value="F" value='<?php if (isset($_SESSION["Form"]["gender"]) && $_SESSION["Form"]["gender"]=="F") echo "selected"; ?>'><?php echo L::field_woman; ?></option>
        </select>
    </div>
    <div>
        <label for="tall"><?php echo L::field_tall; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control" type="text" name="tall" placeholder="Ex: 180" value='<?php if (isset($_SESSION["Form"]["tall"])) echo $_SESSION["Form"]["tall"]; ?>' required/>
    </div>
    <br>
    <div>
        <label for="birthdate"><?php echo L::field_birthdate; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control" type="text" name="birthdate" placeholder="JJ/MM/YYYY" maxlength="10" value='<?php if (isset($_SESSION["Form"]["birthdate"])) echo $_SESSION["Form"]["birthdate"]; ?>' required/>
    </div>
    <div>
        <label for="birthcity"><?php echo L::field_birthcity; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control" type="text" name="birthcity" placeholder="Ex: Paris" value='<?php if (isset($_SESSION["Form"]["birthcity"])) echo $_SESSION["Form"]["birthcity"]; ?>' required/>
    </div>
    <br>
    <?php echo L::page_backcni; ?>
    <h2></h2>
    <div>
        <label for="address"><?php echo L::field_address; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control" type="text" name="address" placeholder="Ex: 10 rue Saint André" value='<?php if (isset($_SESSION["Form"]["address"])) echo $_SESSION["Form"]["address"]; ?>' required/>
    </div>
    <div>
        <label for="address_city"><?php echo L::field_address_city; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control" type="text" name="address_city" placeholder="Ex: Paris" value='<?php if (isset($_SESSION["Form"]["address_city"])) echo $_SESSION["Form"]["address_city"]; ?>' required/>
    </div>
    <div>
        <label for="address_zipcode"><?php echo L::field_address_zipcode; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control" type="text" name="address_zipcode" placeholder="Ex: 75001" value='<?php if (isset($_SESSION["Form"]["address_zipcode"])) echo $_SESSION["Form"]["address_zipcode"]; ?>' required/>
    </div>
    <br>
    <div>
        <label for="prefecture"><?php echo L::field_prefecture; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control special" type="text" name="prefecture" placeholder="Ex: Sous-préfecture de Brest" value='<?php if (isset($_SESSION["Form"]["prefecture"])) echo $_SESSION["Form"]["prefecture"]; ?>' required/>
        <a class="button" href="#popup1"><?php echo L::field_needhelp ?></a><br>
    </div>
    <div>
        <label for="prefecture_department"><?php echo L::field_prefecture_department; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control" type="number" name="prefecture_department" min="0" max="999" placeholder="Ex: 75" value='<?php if (isset($_SESSION["Form"]["prefecture_department"])) echo $_SESSION["Form"]["prefecture_department"]; ?>' required/>
    </div>
    <div>
        <label for="deliverydate"><?php echo L::field_deliverydatecni; ?> <span style="color:#ff0000">*</span> :</label>
        <input class="form-control" type="text" name="deliverydate" placeholder="JJ/MM/YYYY" maxlength="10" value='<?php if (isset($_SESSION["Form"]["deliverydate"])) echo $_SESSION["Form"]["deliverydate"]; ?>' required/>
    </div>
    <br>
    <hr />
    <h2><?php echo L::page_norequired; ?></h2>
    <h3><?php echo L::page_images; ?></h3>
    <?php echo L::page_norequiredfieldsimage; ?>
    <div>
        <label for="photo"><?php echo L::field_photo; ?> :</label>
        <input type="file" name="photo" accept="image/*" value='<?php if (isset($_SESSION["Form"]["photo"])) echo $_SESSION["Form"]["photo"]; ?>'/>
        <a class="button" href="#popup2">476x624px</a>
        <br><a class="fieldsub" target="_blank" href="gallery"><?php echo L::field_gallery; ?></a>
    </div>
    <p><?php echo L::page_png; ?></p>
    <div>
        <label for="sign1"><?php echo L::field_signature; ?> :</label>
        <input type="file" name="sign1" accept="image/*" value='<?php if (isset($_SESSION["Form"]["sign1"])) echo $_SESSION["Form"]["sign1"]; ?>'/>
        <a class="button" href="#popup3">650x170px</a>
    </div>
    <div>
        <label for="sign2"><?php echo L::field_stamppref; ?> :</label>
        <input type="file" name="sign2" accept="image/*" value='<?php if (isset($_SESSION["Form"]["sign2"])) echo $_SESSION["Form"]["sign2"]; ?>'/>
        <a class="button" href="#popup3">850x175px</a>
    </div>
    <br>
    <h3><?php echo L::page_suppl; ?></h3>
    <?php echo L::page_norequiredfields; ?>
    <div>
        <label for="cninumber"><?php echo L::field_cninumber; ?> :</label>
        <input class="form-control" type="text" name="cninumber" maxlength="12" value='<?php if (isset($_SESSION["Form"]["cninumber"])) echo $_SESSION["Form"]["cninumber"]; ?>' />
    </div>
    <div>
        <label for="cnialgo1"><?php echo L::field_cnialgo1; ?> :</label>
        <input class="form-control" type="text" name="cnialgo1" maxlength="36" value='<?php if (isset($_SESSION["Form"]["cnialgo1"])) echo $_SESSION["Form"]["cnialgo1"]; ?>' />
    </div>
    <div>
        <label for="cnialgo2"><?php echo L::field_cnialgo2; ?> :</label>
        <input class="form-control" type="text" name="cnialgo2" maxlength="36" value='<?php if (isset($_SESSION["Form"]["cnialgo2"])) echo $_SESSION["Form"]["cnialgo2"]; ?>' />
    </div>

    <input type="hidden" name="random" value='<?php echo rand(100, 9999); ?>' />

    <br><br>

    <button id="buttonPreviewCNI" class="button-secondary pure-button" form="formCNI" style="float:left;"><?php echo L::field_submit; ?></button>
    <button type="reset" class="button-secondary pure-button" style="float:left; background-color:#ff4444; margin-left:10px;"><?php echo L::field_reset; ?></button>
</form>

<div id="popup1" class="overlay light">
    <a class="cancel" href="#"></a>
    <div class="popup">
        <h3>Choix de la Préfecture</h3>
        <div class="content">
        <p>Sur le site <a href="http://www.annuaire-mairie.fr" target="_blank">http://www.annuaire-mairie.fr</a> vous trouverez pour chaque ville la préfecture ou sous-préfecture qui lui est associé.<br>
                              Attention aux arrondissements pour les grandes villes.</p>
        </div>
    </div>
</div>

<div id="popup2" class="overlay light">
    <a class="cancel" href="#"></a>
    <div class="popup">
        <h3>Dimensions recommandées</h3>
        <div class="content">
        <p>Afin que le scan soit le plus fidèle possible à une CNI réelle, il est vivement recommandé que les dimensions de la photo d'identité soient de 476x624.<br></p>
        </div>
    </div>
</div>

<div id="popup3" class="overlay light">
    <a class="cancel" href="#"></a>
    <div class="popup">
        <h3>Conseils signatures</h3>
        <div class="content">
        <p>Les dimensions indiquées correpondent à <b>l'espace entier où peut se situer la signature</b>. Vous pouvez envoyé une image avec des dimensions différentes, elle ne sera pas redimensionnée.<br><br>
        N'hésitez donc pas à faire plusieurs tests et adapter les dimensions de votre fichier. Et pensez bien à la transparence de votre signature !<br></p>
        </div>
    </div>
</div>

</div>
<div class="col-md-6">
<iframe style="height: 900px; width: 100%; border: 0pt none; overflox: hidden;" name="preview" src="content/cni/empty_preview.php"/></iframe>
</div>
</div>
