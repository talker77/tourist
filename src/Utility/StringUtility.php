<?php
/**
 * Created by PhpStorm.
 * User: whosayin
 * Date: 1/10/14
 * Time: 10:07 AM
 */

namespace App\Utility;


class StringUtility
{

    /**
     * Recursively changes encoding to UTF-8
     *
     * @param  mixed $data
     * @return mixed
     */
    public static function encode($data)
    {
        return $data;
    }

    /**
     * Recursively changes encoding to ISO-8859-9
     *
     * @param  mixed $data
     * @return mixed
     */
    public static function decode($data)
    {
        return $data;
    }

    public static function tr2en($str)
    {
        $str = str_replace(
            array('ı', 'ü', 'ğ', 'ş', 'ö', 'ç', 'İ', 'Ü', 'Ğ', 'Ş', 'Ö', 'Ç'),
            array('i', 'u', 'g', 's', 'o', 'c', 'I', 'U', 'G', 'S', 'O', 'C'),
            $str);

        return $str;
    }

    public static function strToUpperTR($str)
    {
        $str = str_replace(array('i', 'ı', 'ü', 'ğ', 'ş', 'ö', 'ç'), array('İ', 'I', 'Ü', 'Ğ', 'Ş', 'Ö', 'Ç'), $str);
        return strtoupper($str);
    }

    public static function ucFirstTR($string)
    {
        return ltrim(mb_convert_case(str_replace(array(' I',' ı', ' İ', ' i'),
                    array(' I',' I',' İ',' İ'), ' ' . $string),
                MB_CASE_TITLE, "UTF-8"));
    }

    // copied from old codebase
    public static function secureString($value, $logo = false, $extension = '', $logistic = false)
    {
        if($logo) {
            $allowed = '<>şŞıIçÇüÜğĞöÖİi-/\.:, ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        } else {
            $value = strtolower($value);
            $allowed = 'abcdefghijklmnopqrstuvwxyz0123456789'.$extension;
        }

        if ($logistic) {
            $specials = array('<','>');
            $normals = array('&lt;','&gt;');
        }

        // turkish
        $specials = array('Ü','İ','ı','Ç','ç','Ş','ş','â', 'ç', '&#305;', '&#287;', 'ö', '&#351;', 'ü', 'Â', 'Ç', '&#304;', '&#286;', 'Ö', '&#350;' );
        $normals =  array('U','I','i','C','c','S','s','a', 'c', 'i', 'g', 'o', 's', 'u', 'A', 'C', 'I', 'G', 'O', 'S');
        $value = str_replace($specials, $normals, $value);
        // french
        $specials = array('Æ',  'À', 'Â', 'Ä', 'È', 'É', 'Ê', 'Ë', 'Î', 'Ï', 'Ô', '',  'Ù', 'Û', 'Ü', '', 'æ',  'á', 'â', 'ä', 'è', 'é', 'ê', 'ë', 'î', 'ï', 'ô', '',  'ú', 'û', 'ü', 'ÿ', 'Ç', 'ç');
        $normals =  array('ae', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'O', 'OE', 'U', 'U', 'U', 'Y', 'ae', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'o', 'oe', 'u', 'u', 'u', 'y', 'C', 'c');
        $value = str_replace($specials, $normals, $value);
        // russian (pure)
        $specials = array('&#1040;', '&#1041;', '&#1042;', '&#1043;', '&#1044;', '&#1045;', '&#1046;',  '&#1047;', '&#1048;', '&#1049;', '&#1050;', '&#1051;', '&#1052;', '&#1053;', '&#1054;', '&#1055;', '&#1056;', '&#1057;', '&#1058;', '&#1059;', '&#1060;', '&#1061;', '&#1062;',  '&#1063;',  '&#1064;',  '&#1065;',    '&#1066;', '&#1067;',  '&#1068;', '&#1069;', '&#1070;',  '&#1071;',  '&#1072;', '&#1073;', '&#1074;', '&#1075;', '&#1076;', '&#1077;', '&#1078;',  '&#1079;', '&#1080;', '&#1081;', '&#1082;', '&#1083;', '&#1084;', '&#1085;', '&#1086;', '&#1087;', '&#1088;', '&#1089;', '&#1090;', '&#1091;', '&#1092;', '&#1093;', '&#1094;',  '&#1095;',  '&#1096;',  '&#1097;',    '&#1098;', '&#1099;',  '&#1100;', '&#1101;', '&#1102;',  '&#1103;');
        $normals =  array('A', 'B', 'V', 'G', 'D', 'E', 'ZH', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'TS', 'CH', 'SH', 'SHCH', '',  'YE', '',  'E', 'YU', 'YA', 'a', 'b', 'v', 'g', 'd', 'e', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'shch', '',  'ye', '',  'e', 'yu', 'ya');
        $value = str_replace($specials, $normals, $value);
        // greek
        $specials = array('&#913;', '&#914;', '&#915;', '&#916;', '&#917;', '&#918;', '&#919;', '&#920;',  '&#921;', '&#922;', '&#923;', '&#924;', '&#925;', '&#926;', '&#927;', '&#928;', '&#929;', '&#931;', '&#932;', '&#933;', '&#934;', '&#935;',  '&#936;',  '&#937;', '&#945;', '&#946;', '&#947;', '&#948;', '&#949;', '&#950;', '&#951;', '&#952;',  '&#953;', '&#954;', '&#955;', '&#956;', '&#957;', '&#958;', '&#959;', '&#960;', '&#961;', '&#962;', '&#963;', '&#964;', '&#965;', '&#966;', '&#967;',  '&#968;',  '&#969;', '&#902;', '&#904;', '&#905;', '&#906;', '&#908;', '&#910;', '&#911;', '&#940;', '&#941;', '&#942;', '&#972;', '&#943;', '&#973;', '&#974;', '&#938;', '&#939;', '&#970;', '&#971;', '&#944;', '&#912;');
        $normals  = array('A', 'B', 'Y', 'D', 'E', 'Z', 'I', 'TH', 'I', 'K', 'L', 'M', 'N', 'X', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'KH', 'PS', 'O', 'a', 'b', 'y', 'd', 'e', 'z', 'i', 'th', 'i', 'k', 'l', 'm', 'n', 'x', 'o', 'p', 'r', 's', 's', 't', 'u', 'f', 'kh', 'ps', 'o', 'A', 'E', 'I', 'I', 'O', 'U', 'O', 'a', 'e', 'i', 'o', 'i', 'u', 'o', 'I', 'U', 'i', 'u', 'u', 'i');
        $value = str_replace($specials, $normals, $value);
        $retval = '';
        // portuguese
        $specials = array('À', 'Á', 'Â', 'Ã', 'É', 'Ê', 'Í', 'Ó', 'Ô', 'Õ', 'Ú', 'Ü', 'à', 'á', 'â', 'ã', 'é', 'ê', 'í', 'ó', 'ô', 'õ', 'ú', 'ü');
        $normals  = array('A', 'A', 'A', 'A', 'E', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'a', 'a', 'a', 'a', 'e', 'e', 'i', 'o', 'o', 'o', 'u', 'u');
        $value = str_replace($specials, $normals, $value);
        // spanish
        $specials = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ü', 'á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü');
        $normals  = array('A', 'E', 'I', 'O', 'U', 'N', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'u');
        $value = str_replace($specials, $normals, $value);
        // german
        $specials = array('Ä', 'ä', 'Ö', 'ö', 'Ü', 'ü', 'ß');
        $normals  = array('A', 'a', 'O', 'o', 'U', 'u', 'ss');

        //dinoSpecial
        $value = str_replace($specials, $normals, $value);

        for($i = 0; $i < strlen($value); $i++){
            if(strpos($allowed, $value[$i]) !== false){
                $retval .= $value[$i];
            }
        }

        return $retval;
    }

    public static function smartUrl( $value, $permalink = false )
    {
        $retval= '';
        $value = str_replace(array('/','ş','Ş','ı','I','ç','Ç','ü','Ü','ğ','Ğ','ö','Ö','İ','i',' ',chr(10)),
            array('-','s','s','i','i','c','c','u','u','g','g','o','o','i','i','-','-'),
            trim($value));
        $value = strtolower($value);

        $allowed = 'abcdefghijklmnopqrstuvwxyz0123456789-';
        for ( $i=0; $i < strlen($value); $i++ ) {
            if ( strpos($allowed, $value[$i]) !== false ) {
                $retval .= $value[$i];
            }
        }
        $retval = str_replace(array('---', '--'), '-', $retval);

        if ($permalink) $retval = '/kampanya/'.$retval . '/';

        return $retval;
    }

    /*******************************************************
     * An attempt to make the string look less ugly
     *******************************************************/
    public static function strip_string($str, $is_image = false) {
        $str = strtolower($str);

        if($is_image && (isset($_POST['matchType']) && $_POST['matchType'] == "similarity")){
            $str = substr($str, 0, strpos($str , '.'));

            if(preg_match('/[^0-9a-zA-Z](.{0,4})$/', $str) != 0) {
                $str = preg_replace('/.([^a-zA-Z\_\-\s]*)$/', "", $str);
//            $str = preg_replace('/[^0-9a-zA-Z](.{0,4})$/', "", $str);
            }
        }

        $str_stripped = preg_replace('/[^a-zA-Z0-9]/', "", $str);

        return $str_stripped;
    }

    /*******************************************************
     * Name of the function pretty much speaks for itself.
     * str1 shall always, ALWAYS be the artNr or eanNr.
     *******************************************************/
    public static function similarity_search($str1, $str2, $partialSearch, $customRangeBegin = 0, $customRange = 0) {
        $p = 0;

        if($partialSearch == "custom") {
            if($customRange > 0) {
                $str2 = substr(strtolower($str2), $customRangeBegin - 1, $customRange);

                $haystack =  "_" . $str1;
                if(strpos($haystack, $str2))
                    $p = 100;
            }
        } else {
            if(substr($partialSearch, 0, 1) == "f") {
                $str1 = substr($str1, 0, substr($partialSearch, 1, 1));
                $str2 = substr($str2, 0, substr($partialSearch, 1, 1));
            } else {
                $str1 = substr($str1, substr($partialSearch, 1, 1) * -1);
                $str2 = substr($str2, substr($partialSearch, 1, 1) * -1);
            }

            if(strcmp($str1, $str2) == 0)
                $p = 100;
        }

        return $p;
    }

    /*************************************************************************************************************************************************
     * EanNr comes as a string from DB result. i.e. 10000, 20000, 30000
     * What the below loop does is, it turns that string to an array by tokenizing and compares each EanNr with the stripped_str.
     *
     * When $partialSearch != false, it is used for the $p >= 80 part above. $isSearchSimilarText is for searches with similarity filter on.
     *
     * A side note for the first comparison (the $p >= 80 part):
     * Since EanNr match is somewhat more precise than of ArtNr, anything below 89% gets a "THOU SHALL NOT PASS!", right in the face.
     **************************************************************************************************************************************************/
    public static function search_in_eannr($eanNr_str, $stripped_str, $isSearchSimilarText = false, $partialSearch = false, $customRangeBegin = 0, $customRange = 0) {
        $eannr_arr = explode(',', $eanNr_str);
        $p = 0;
        $tmp_p = 0;

        foreach($eannr_arr as $eannr){
            $eannr_stripped = self::strip_string($eannr);

            if($isSearchSimilarText) {
                similar_text($eannr_stripped, $stripped_str, $p);

                if($p >= 89 )
                    $tmp_p = $p;

                $p = $tmp_p;
            } else {
                if($partialSearch){
                    $tmp_p = self::similarity_search($eannr_stripped, $stripped_str, $partialSearch, $customRangeBegin, $customRange);

                    if ($tmp_p > 0)
                        $p = 100;

                } else {
                    $haystack =  "_" . strtolower($stripped_str);
                    if(strpos($haystack, strtolower($eannr_stripped)))
                        $p = 100;
                }
            }
        }

        return $p;
    }

    public static function parseEmailString($supplierMailString)
    {
        $supplierEmailArray = array();
        $emailRaw = str_replace(" ","",$supplierMailString);
        $emailRaw = str_replace("'","",$emailRaw);
        $emailRaw = str_replace('"','',$emailRaw);
        $emailRaw = str_replace(',',';',$emailRaw);
        $emailRaw = self::tr2en($emailRaw);

        $supplierEmailArray = explode(';',$emailRaw);
        return $supplierEmailArray;
    }

    public static function addZero($value, $totalChar)
    {
        return str_pad($value, $totalChar, "0", STR_PAD_LEFT);
    }

    public static function showResult($data) {
        static $i = 0;
        echo ++$i . '. -> : ' . $data . PHP_EOL;
    }

	public static function parseDateRangeFilter($dateString)
	{
		$dateArray = explode(" - ",$dateString);
		return array(
			'dateFrom' => date_create_from_format('Y/m/d', $dateArray[0]),
			'dateTo' => date_create_from_format('Y/m/d', $dateArray[1]),
		);
	}

	public static function giveMeOneDayDateFilter()
	{
		$from = new \DateTime();
		$from->modify('-1 day');
		$to = new \DateTime();
		$dateFilter =   array(
			'dateFrom' => $from,
			'dateTo' =>  $to
		);
		return $dateFilter;
	}


	public static function generateUserPassword($simple = true)
    {
        if($simple) {
            $paswd = rand(10000, 99999);
        }else{
            $paswd= substr(hash('sha512',rand()),0,8); // Reduces the size to 12 chars
        }

        return  $paswd;
    }


    public static function slugify($input)
    {
        $a = array(
            'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï',
            'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á',
            'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò',
            'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą',
            'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ',
            'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ',
            'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ',
            'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ',
            'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ',
            'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ',
            'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ',
            'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ',
            'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ',
            'ǽ', 'Ǿ', 'ǿ', '?');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I',
            'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a',
            'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o',
            'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A',
            'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E',
            'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H',
            'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J',
            'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N',
            'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r',
            'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't',
            'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y',
            'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I',
            'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE',
            'ae', 'O', 'o', '');

        return str_replace($a, $b, $input);
    }

    public static function urlSlugify($text) {

        return strtolower(
            preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),
                array('','-',''),
                self::slugify($text)
            )
        );

    }



}
