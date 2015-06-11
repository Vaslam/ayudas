<?php

class Utils {
   
	static $allowedImageExts = array("JPG", "BMP", "PNG", "JPEG");
    static $allowedPDFexts = array("PDF");
    static $allowedOfficeExts = array("DOT", "DOC", "DOCX", "DOCM", "DOTX", "DOTM", "XLS", 
                                        "XLT", "XLM", "XLSX", "XLSM", "XLTX", "XLTM", "XLSB", 
                                        "XLA", "XLAM", "XLL", "XLW", "PPT", "PPTX", "PPTM", 
                                        "POTX", "POTM", "PPAM", "PPSX", "PPSM", "SLDX", "SLDM");
    
    const IMAGES = 1;
    const PDF = 2;
    const MS_OFFICE = 3;
    const GENERAL = 4;

    public static function deleteFolder($_url) {
        //Prevents deleting folders outside the uploads folder
        $url = str_replace("..", BASE_PATH, $_url);
        if(strpos($url, BASE_PATH."/uploads") === false) {
            return false;
        }
		$files = glob($url."/*");
		foreach($files as $file) { 
            if(is_file($file)) {
                unlink($file);
            }
            if(is_dir($file)) {
                self::deleteFolder($file);
            }
		}
		if(rmdir($url)) {
			return true;
		} 
        return false;
	}
    
    public static function validateUpload($file, $size, $type) {
        $filename = $file["name"];
        $filesize = $file["size"];
        $exploded = explode(".", $filename);
		$fileExtension = strtoupper(end($exploded));
		if($filesize <= $size && in_array($fileExtension, self::getAllowedFileTypes($type))) {
			return true;
		} else {
			return false;
		}
	}
    
    public static function extensionIsValid($ext, $type) {
		if(!in_array(strtoupper($ext), self::getAllowedFileTypes($type))) {
			return false;
		} else {
			return true;
		}
	}
	
	public static function sizeIsValid($size, $maxsize) {
		if($size > $maxsize) {
			return false;
		} else {
			return true;
		}
	}
    
    public static function getFileExtension($file) {
        $exploded = explode(".", $file);
        $ext = end($exploded);
        return $ext;
    }
    
    public static function getAllowedFileTypes($type) {
        switch($type) {
			case self::IMAGES:
				$allowedExtensions = static::$allowedImageExts;
				break;
            case self::PDF:
                $allowedExtensions = static::$allowedPDFexts;
				break;
            case self::MS_OFFICE:
                $allowedExtensions = static::$allowedOfficeExts;
				break;
            case self::GENERAL:
                $allowedExtensions = array_merge(static::$allowedOfficeExts, static::$allowedImageExts, static::$allowedPDFexts);
                break;
		}
        return $allowedExtensions;
    }
    
    public static function getSpanishDate($arr = false) {
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        if(!$arr) {
            return $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " de ".date('Y') ;
        } else {
            $arr = [
                "strDay" => $dias[date('w')],
                "day" => date("d"),
                "strMonth" => $meses[date('n')-1],
                "year" => date("Y")
            ];
            return $arr;
        }
    }
    
    /**
    * Replace accented characters with non accented
    *
    * @param $str
    * @return mixed
    * @link http://myshadowself.com/coding/php-function-to-convert-accented-characters-to-their-non-accented-equivalant/
    */
    public static function removeAccents($str) {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
        return str_replace($a, $b, $str);
    }
   
    public static function formatFileName($filename) {
        return str_replace(" ", "-", preg_replace("/[^A-Za-z0-9 ]/", '', self::removeAccents($filename)));
    }
   
    public static function getFileNameWithOutExtension($filename) {
       $exploded = explode(".", $filename);
       array_pop($exploded);
       return implode("", $exploded);
    }
   
    public static function getContactEmails($array = false) {
       $json = BASE_PATH."/admin/emailconfig.json";
       $emails = json_decode(file_get_contents($json), true);
       if($array) {
           return explode(",", $emails["contact"]);
       } else {
           return $emails["contact"];
       }
    }
   
   public static function getSalesEmails($array = false) {
       $json = BASE_PATH."/admin/emailconfig.json";
       $emails = json_decode(file_get_contents($json), true);
       if($array) {
           return explode(",", $emails["cart"]);
       } else {
           return $emails["cart"];
       }
    }
   
    public static function my_var_dump($expression) {
       echo "<pre>";
       var_dump($expression);
       echo "</pre>";
    }
   
	//THANKS JESSE FORREST!
    public static function getUrlFriendlyString($str) {
        // convert spaces to '-', remove characters that are not alphanumeric
        // or a '-', combine multiple dashes (i.e., '---') into one dash '-'.
        
        $_str = preg_replace("/-+/", "-", preg_replace("/[^a-z0-9-]/", "",
           strtolower(str_replace(" ", "-", $str))));
        return substr($_str, 0, 60);
    }
	
}