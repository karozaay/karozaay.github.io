<?php
class GeneratorCNI
{
	var $Source;
	var $Resolutions;

	var $LayerTop;
	var $LayerBottom;
	var $LayerPhoto;

	var $Photo;
	var $SignRecto;
	var $SignVerso;

	var $ColorBlack;
	var $ColorWhite;
	var $ColorGrey;
	var $ColorTransparent;

	var $CNINumber;
	var $CNIAlgo1;
	var $CNIAlgo2;
	var $AfterDep;
	var $Random;

	var $FirstName;
	var $LastName;
	var $Gender;
	var $BirthDate;
	var $BirthCity;
	var $Tall;
	var $Address;
	var $FromDate;
	var $EndDate;
	var $Prefecture;
	var $PrefectureDepartment;
	var $DeliveryDate;

	public function GeneratorCNI($photo, $sign1, $sign2)
	{
		header("content-type: image/jpeg; charset=utf-8");
		header('Content-Disposition: inline; filename="CNI.jpg"');

		$this->Resolutions = array(1897, 2836);

		$this->LayerBottom = imagecreatefrompng("static/.1.png");
		$this->LayerTop = imagecreatefrompng("static/.2.png");

		$this->Photo = $photo;
		$this->SignRecto = $sign1;
		$this->SignVerso = $sign2;

		if($this->SignRecto == null)
		{
			$recto = array();
			foreach(scandir("static/signs/Recto/") as $files)
			{
				if(!is_dir($files))
				{
					array_push($recto, $files);
				}
			}
			$this->LayerSignRecto = imagecreatefrompng("static/signs/Recto/" . $recto[array_rand($recto)]);
			$_SESSION["Preview"]["CNI"]["sign1"] = file_get_contents("static/signs/Recto/" . $verso[array_rand($recto)]);
		} else {
			$this->LayerSignRecto = imagecreatefromstring($this->SignRecto);
		}

		if($this->SignVerso == null)
		{
			$verso = array();
			foreach(scandir("static/signs/Verso/") as $files)
			{
				if(!is_dir($files))
				{
					array_push($verso, $files);
				}
			}
			$this->LayerSignVerso = imagecreatefrompng("static/signs/Verso/" . $verso[array_rand($verso)]);
			$_SESSION["Preview"]["CNI"]["sign2"] = file_get_contents("static/signs/Verso/" . $verso[array_rand($verso)]);
		} else {
			$this->LayerSignVerso = imagecreatefromstring($this->SignVerso);
		}

		$this->LayerObfuscate = imagecreatefrompng("../../static/obfuscate.png");

		$this->Source = imagecreatetruecolor($this->Resolutions[0], $this->Resolutions[1]);

		//Colors
		$this->ColorWhite = imagecolorallocate($this->Source, 255, 255, 255);
		$this->ColorGrey = imagecolorallocate($this->Source, 70, 70, 70);
		$this->ColorGrey2 = imagecolorallocate($this->Source, 60, 60, 60);
		$this->ColorRed = imagecolorallocate($this->Source, 255, 50, 50);
		$this->ColorTransparent = imagecolorallocatealpha($this->Source, 0, 255, 0, 128);
		$this->ColorFiligrane = imagecolorallocatealpha($this->Source, 50, 50, 50, 30);
	}

	public function Render($preview = false, $effect = 0)
	{
		//$effect = ($effect*-1)*20;
		$effect = -240*(1-log(101-$effect)/log(101));

		//Bottom
		imagecopy($this->Source, $this->LayerBottom, 0, 0, 0, 0, $this->Resolutions[0], $this->Resolutions[1]);

		//Photo
		$photos = array();
		$age = date("Y") - explode(".", $this->BirthDate)[2];
		$photos_path = "static/photos/" . $this->Gender . "/" . $this->getAgeRange($age) . "/";
		if($this->Photo == null)
		{
			foreach(scandir($photos_path) as $photo)
			{
				if(!is_dir($photo))
				{
					array_push($photos, $photo);
				}
			}
			$photo = $photos[array_rand($photos)];
			$this->LayerPhoto = imagecreatefromjpeg($photos_path . $photo);
			$_SESSION["Preview"]["CNI"]["Photo"] = file_get_contents($photos_path . $photo);
		}
		else
		{
			$this->LayerPhoto = imagecreatefromstring($this->Photo);
		}

		imagefilter($this->LayerPhoto, IMG_FILTER_GRAYSCALE);
		imagecopyresampled($this->Source, $this->LayerPhoto, 166, 368, 0, 0, 477, 625, imagesx($this->LayerPhoto), imagesy($this->LayerPhoto));
		//imagecopyresampled($this->Source, $this->LayerPhoto, 166, 369, 0, 0, 476, 624, 543, 698);

		imagecopy($this->Source, $this->LayerSignRecto, 895, 815, 0, 0, 650, 170);
		imagecopy($this->Source, $this->LayerSignVerso, 600, 2150, 0, 0, 850, 175);

		imagecolortransparent($this->Source, $this->ColorTransparent);

		if ($this->CNIAlgo1 == null || $this->CNIAlgo2 == null) {
			$algo = $this->generateAlgo();
		} else {
			$algo = $this->generateAlgo();
			$algo = array();
			$algo[0] = $this->CNIAlgo1;
			$algo[1] = $this->CNIAlgo2;
		}

		imagettftext($this->Source, 42, 0, 885, 362, $this->ColorGrey, "fonts/FontCNI.ttf", $this->CNINumber);
		imagettftext($this->Source, 30, 0, 598, 411, $this->ColorGrey, "fonts/FontCNI.ttf", $this->getInitial());
		imagettftext($this->Source, 42, 0, 790, 434, $this->ColorGrey, "fonts/FontCNI.ttf", utf8_decode(mb_strtoupper($this->LastName, 'UTF-8')));
		imagettftext($this->Source, 42, 0, 860, 555, $this->ColorGrey, "fonts/FontCNI.ttf", utf8_decode(mb_strtoupper($this->FirstName, 'UTF-8')));
		imagettftext($this->Source, 42, 0, 788, 673, $this->ColorGrey, "fonts/FontCNI.ttf", strtoupper($this->Gender));
		imagettftext($this->Source, 42, 0, 1255, 673, $this->ColorGrey, "fonts/FontCNI.ttf", $this->BirthDate);
		imagettftext($this->Source, 42, 0, 738, 730, $this->ColorGrey, "fonts/FontCNI.ttf", utf8_decode(mb_strtoupper($this->BirthCity, 'UTF-8')));
		imagettftext($this->Source, 42, 0, 816, 787, $this->ColorGrey, "fonts/FontCNI.ttf", $this->Tall);
		$this->imagettftextSp($this->Source, 28, 0, 375, 1900, $this->ColorGrey2, "fonts/FontCNI.ttf", utf8_decode(mb_strtoupper($this->Address[0], 'UTF-8')));
		$this->imagettftextSp($this->Source, 28, 0, 460, 1935, $this->ColorGrey2, "fonts/FontCNI.ttf", utf8_decode(mb_strtoupper($this->Address[1], 'UTF-8') . " (" . mb_strtoupper($this->Address[2], "UTF-8").")"));
		imagettftext($this->Source, 38, 0, 620, 2015, $this->ColorGrey2, "fonts/FontCNI.ttf", strtoupper($this->EndDate));
		imagettftext($this->Source, 38, 0, 430, 2078, $this->ColorGrey2, "fonts/FontCNI.ttf", strtoupper($this->FromDate));
		imagettftext($this->Source, 40, 0, 308, 2138, $this->ColorGrey2, "fonts/FontCNI.ttf", utf8_decode(mb_strtoupper($this->Prefecture, "UTF-8")));
		//$this->imagettftextblur($this->Source, 50, 0, 230, 1105, $this->ColorGrey2, "fonts/ocrbletm.ttf", $algo[0], 1);
		//$this->imagettftextblur($this->Source, 50, 0, 230, 1217, $this->ColorGrey2, "fonts/ocrbletm.ttf", $algo[1], 1);
		imagettftext($this->Source, 50.3, 0, 230, 1105, $this->ColorGrey2, "fonts/ocrbletm.ttf", $algo[0]);
		imagettftext($this->Source, 50.3, 0, 230, 1217, $this->ColorGrey2, "fonts/ocrbletm.ttf", $algo[1]);

		//Top
		imagecopy($this->Source, $this->LayerTop, 0, 0, 0, 0, $this->Resolutions[0], $this->Resolutions[1]);

		if($effect != 0)
		{
			imagefilter($this->Source, IMG_FILTER_GRAYSCALE);
			imagefilter($this->Source, IMG_FILTER_CONTRAST, $effect);
			imagefilter($this->Source, IMG_FILTER_SMOOTH, -1000);
		}

		imagejpeg($this->Source);
		imagedestroy($this->Source);
	}

	private function getAgeRange($age)
	{
		if($age < 20)
			return "-20";
		else if($age > 19 and $age < 30)
			return "20-29";
		else if($age > 29 and $age < 40)
			return "30-39";
		else if($age > 39 and $age < 50)
			return "40-49";
		else if($age > 49 and $age < 60)
			return "50-59";
		else if($age > 60)
			return "60+";
	}

	private function generateSign($number)
	{
		$rts = "";
		for($i=0; $i<$number; $i++)
		{
			$rts .= "<";
		}
		return $rts;
	}

	private function imagettftextSp($image, $size, $angle, $x, $y, $color, $font, $text, $spacing = -4)
	{
	    if ($spacing == 0)
	    {
	        imagettftext($image, $size, $angle, $x, $y, $color, $font, $text);
	    }
	    else
	    {
	        $temp_x = $x;
	        $temp_y = $y;
	        for ($i = 0; $i < strlen($text); $i++)
	        {
	            imagettftext($image, $size, $angle, $temp_x, $temp_y, $color, $font, $text[$i]);
	            $bbox = imagettfbbox($size, 0, $font, $text[$i]);
	            $temp_x += cos(deg2rad($angle)) * ($spacing + ($bbox[2] - $bbox[0]));
	            $temp_y -= sin(deg2rad($angle)) * ($spacing + ($bbox[2] - $bbox[0]));
	        }
	    }
	}

	private function imagettftextblur(&$image,$size,$angle,$x,$y,$color,$fontfile,$text,$blur_intensity = null)
    {
        $blur_intensity = !is_null($blur_intensity) && is_numeric($blur_intensity) ? (int)$blur_intensity : 0;
        if ($blur_intensity > 0)
        {
            $text_shadow_image = imagecreatetruecolor(imagesx($image),imagesy($image));
            imagefill($text_shadow_image,0,0,imagecolorallocate($text_shadow_image,0x00,0x00,0x00));
            imagettftext($text_shadow_image,$size,$angle,$x,$y,imagecolorallocate($text_shadow_image,0xFF,0xFF,0xFF),$fontfile,$text);
            for ($blur = 1;$blur <= $blur_intensity;$blur++)
                imagefilter($text_shadow_image,IMG_FILTER_GAUSSIAN_BLUR);
            for ($x_offset = 0;$x_offset < imagesx($text_shadow_image);$x_offset++)
            {
                for ($y_offset = 0;$y_offset < imagesy($text_shadow_image);$y_offset++)
                {
                    $visibility = (imagecolorat($text_shadow_image,$x_offset,$y_offset) & 0xFF) / 255;
                    if ($visibility > 0)
                        imagesetpixel($image,$x_offset,$y_offset,imagecolorallocatealpha($image,($color >> 16) & 0xFF,($color >> 8) & 0xFF,$color & 0xFF,(1 - $visibility) * 127));
                }
            }
            imagedestroy($text_shadow_image);
        }
        else
            return imagettftext($image,$size,$angle,$x,$y,$color,$fontfile,$text);
    }

	private function wd_remove_accents($str, $charset='utf-8')
	{
	    $str = htmlentities($str, ENT_NOQUOTES, $charset);

	    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
	    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
	    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

	    return $str;
	}

	private function generateSecurityKey($str)
	{
		$facteurs = array(7,3,1);
		$res = 0;
		$str_split = str_split($str);
		$i=0;
		foreach ($str_split as $char)
		{
			if ($char=="<")
			{
				$val = 0;
			}
			else if(is_numeric($char))
			{
				$val = intval($char);
			}
			else
			{
				$val = intval($char);
			}
			$res += $val*$facteurs[$i%3];
			$i++;
		}
		return $res%10;
	}

	private function generateAlgo()
	{
		$this->FromDate = str_replace("/", ".", $this->DeliveryDate);
/*		$this->EndDate = (explode("/", $this->DeliveryDate)[0]-1) . "." . explode("/", $this->DeliveryDate)[1] . "." . (explode("/", $this->DeliveryDate)[2]+10);*/

		$EndDateJ = explode("/", $this->DeliveryDate)[0];
		$EndDateM = explode("/", $this->DeliveryDate)[1];
		$EndDateA = explode("/", $this->DeliveryDate)[2];

		if ($EndDateA < 2014) {
			if ($EndDateJ==1 && $EndDateM==1) {
				$EndDateA+=9;
			} else {
				$EndDateA+=10;
			}
		} else {
			if ($EndDateJ==1 && $EndDateM==1) {
				$EndDateA+=14;
			} else {
				$EndDateA+=15;
			}
		}

		$j = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		if ($EndDateM == 1 && $EndDateJ == 1) {
			$EndDateM = 12;
		} else if ($EndDateJ == 1) {
			$EndDateM--;
		}

		if ($EndDateJ == 1) {
			if ($EndDateM==2 && $EndDateA%4==0) {
				$EndDateJ = 29;
			} else {
				$EndDateJ = $j[$EndDateM-1];
			}
		} else {
			$EndDateJ--;
		}


		$this->EndDate = (sprintf("%02d",$EndDateJ) . "." . sprintf("%02d",$EndDateM) . "." . sprintf("%02d",$EndDateA));

		$FirstName = str_replace(",", "<<", str_replace(", ", ",", str_replace("-", "<", $this->FirstName)));
		$FirstName = substr($FirstName, 0, 14);
		$LastName = str_replace(str_split("' "), '<', $this->LastName);
		$LastName = substr($LastName, 0, 24);
		$DeliveryDate = explode("/", $this->DeliveryDate);
		$BirthDate = explode(".", $this->BirthDate);
		$random = $this->Random;

		$line1 = "IDFRA";
		$line1 .= mb_strtoupper($LastName, 'UTF-8');
		$line1 .= $this->generateSign(25-strlen($LastName));
		$line1 .= $this->Address[2];
		$line1 .= $this->AfterDep;
		$line1 .= "101";
		if ($this->CNINumber!="") {
			$line2 = $this->CNINumber;
		} else {
			$line2 = substr($DeliveryDate[2], 2);
			$line2 .= $DeliveryDate[1];
			$line2 .= $this->Address[2];
			$line2 .= $this->AfterDep;
			$line2 .= "0";
			if($random < 1000)
			{
				$line2 .= "0";
			}
			$line2 .= $random;
			$this->CNINumber = $line2;
		}
		$_SESSION["Form"]["cninumberpayment"] = $this->CNINumber;
		$line2 .= $this->generateSecurityKey($line2);
		$line2 .= mb_strtoupper($FirstName, 'UTF-8');
		$line2 .= $this->generateSign(14-strlen($FirstName));
		$line2 .= substr($BirthDate[2], 2);
		$line2 .= $BirthDate[1];
		$line2 .= $BirthDate[0];
		$line2 .= $this->generateSecurityKey(substr($BirthDate[2], 2) . $BirthDate[1] . $BirthDate[0]);
		$line2 .= strtoupper($this->Gender);
		$line2 .= $this->generateSecurityKey($line1 . $line2);

		return array($line1, $line2);
		//return array(wd_remove_accents($line1), wd_remove_accents($line2));
	}

	private function getInitial()
	{
		return strtoupper(substr($this->LastName, 0, 1) . substr($this->FirstName, 0, 1));
	}

	public function setFirstName($value)
	{
		$this->FirstName = $value;
	}

	public function setLastName($value)
	{
		$this->LastName = $value;
	}

	public function setGender($value)
	{
		$this->Gender = $value;
	}

	public function setBirthCity($value)
	{
		$this->BirthCity = $value;
	}

	public function setBirthDate($d, $m, $y)
	{
		$this->BirthDate = "$d.$m.$y";
	}

	public function setTall($value1, $value2)
	{
		$this->Tall = $value1 . "." . $value2 . "m";
	}

	public function setAddress($address, $city, $zipcode)
	{
		$this->AfterDep = "";
		$department = substr($zipcode, 0, 2);
		if ($department=="75") {
			switch ($zipcode) {
				case '75001':
					$this->AfterDep == 1;
					break;
				default:
					$this->AfterDep == 1;
					break;
			}
		}
		if ($this->AfterDep == "") {

			$search = $city;
			$search = trim($search);
			$search = $this->wd_remove_accents($search);
			$search = str_replace(' ', '-', $search);
			$search = strtoupper($search);

			$handle = fopen("static/comsimp2016.txt", "r");
			while (($line = fgets($handle)) !== false) {
			    $lineArray = explode("\t", $line);
			    if ($lineArray[3]==$department && $lineArray[9] == $search){
					$this->AfterDep = intval($lineArray[5]);
				}
			}
			fclose($handle);
		    fclose($handle);

			if ($this->AfterDep == "") {
				$this->AfterDep = 1;
			}
		}
		$this->Address = array($address, $city, $department);
	}

	public function setPrefecture($prefecture, $department)
	{
		$prefecture = str_replace("é", "É", $prefecture);
		$this->Prefecture = "$prefecture ($department)";
		$this->PrefectureDepartment = $department;
	}

	public function setDeliveryDate($deliverydate)
	{
		$this->DeliveryDate = $deliverydate;
	}

	public function setCNINumber($value)
	{
		$this->CNINumber = $value;
	}

	public function setCNIAlgo1($value)
	{
		$this->CNIAlgo1 = $value;
	}

	public function setCNIAlgo2($value)
	{
		$this->CNIAlgo2 = $value;
	}

	public function setRandom($value)
	{
		$this->Random = $value;
	}

}
?>
