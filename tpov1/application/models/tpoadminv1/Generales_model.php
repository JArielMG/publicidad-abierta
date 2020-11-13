<?php

/*
INAI / Generales
 */

class Generales_model extends CI_Model
{

    function get_estatus_name($estatus)
    {
        if($estatus == 1){
            return 'Activo';
        }else if($estatus == 2){
            return 'Inactivo';
        }else if($estatus == 3){
            return 'En Proceso';
        }else if($estatus == 4){
            return 'Pago Emitido';
        }else {
            return '-Seleccione-';
        }
    }

    function dateToString($fecha)
    {
        if(!empty($fecha) && $fecha != '0000-00-00'){
            $aux = DateTime::createFromFormat('Y-m-d', $fecha);
            if($aux !== false)  
                return $aux->format('d.m.Y'); 
        }
        return '';
        
    }

    function stringToDate($fecha)
    {
        $date = '';
        if(!empty($fecha))
        {
            $cad_date = str_replace('.', '-', $fecha);
            $aux = DateTime::createFromFormat('d-m-Y', $cad_date);
            if($aux !== false)  
                $date = $aux->format('Y-m-d'); 
                
        }
        return $date;
    }

    function ruta_descarga_archivos($name_file, $path_file)
    {
        if(isset($name_file) && !empty($name_file)){
            return base_url() . $path_file . $name_file;
        }else{
            return '';
        }
    }

    function existe_nombre_archivo($carpeta, $nombre){
        $filename = $carpeta . $nombre;
        if (file_Exists($filename)){
            return uniqid() . '_' . $nombre;
        }else{
            return  $nombre;
        }
    }

    function clear_date($date)
    {
        if($date == "0000-00-00"){
            return "";
        }else{
            return $date;
        }
    }

    function set_fecha_termino_trimestre($id_trimestre, $ejercicio, $es_inicio)
    {
        $inicio = '';
        $fin = '';
        switch($id_trimestre){
            case 1:
                $inicio = '01/01/' . substr($ejercicio, -2);
                $fin = '31/03/' . substr($ejercicio, -2);
                break;
            case 2:
                $inicio = '01/04/' . substr($ejercicio, -2);
                $fin = '30/06/' . substr($ejercicio, -2);
                break;
            case 3:
                $inicio = '01/07/' . substr($ejercicio, -2);
                $fin = '30/09/' . substr($ejercicio, -2);
                break;
            case 4:
                $inicio = '01/10/' . substr($ejercicio, -2);
                $fin = '31/12/' . substr($ejercicio, -2);
                break;
        }

        if($es_inicio){
            return $inicio;
        }else{
            return $fin;
        }
    }

    function get_texto_ayuda_presupuesto(){

        return array( 
            'id_presupuesto' => '',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_sujeto_obligado' => 'Sujeto obligado con presupuesto asignado.',
            'url_programa_anual' => 'Hipervínculo al programa anual',
            'file_programa_anual' => 'Archivo con el programa de presupuesto anual.',
            'monto_presupuesto' => 'Monto presupuestado originalmente.',
            'monto_modificacion' => 'Monto de modificaci&oacute;n de la partida, puede ser un n&uacute;mero negativo o positivo.',
            'monto_asignado' => 'Monto asignado correspondiente a la partida seleccionada.',
            'presupuesto_modificado' => 'Monto calculado autom&aacute;ticamente con Presupuesto original y monto de modificaci&oacute;n.',
            'nota' => 'Nota',
            'por_definir' => 'Por definir',
            'fuente_federal' => 'Son los que provienen de la Federaci&oacute;n, destinados a las Entidades Federativas y los Municipios, en t&eacute;rminos de la Ley Federal de Presupuesto y Responsabilidad Hacendaria y el Presupuesto de Egresos de la Federaci&oacute;n, que est&aacute;n destinados a un fin espec&iacute;fico por concepto de aportaciones, convenios de recursos federales etiquetados y fondos distintos de aportaciones.',
            'monto_fuente_federal' => 'Monto asignado a la fuente federal.',
            'fuente_local' => 'En el caso de los Municipios, son los que provienen del Gobierno Estatal y que cuentan con un destino espec&iacute;fico, en t&eacute;rminos de la Ley de Ingresos Estatal y del Presupuesto de Egresos Estatal.',
            'monto_fuente_local' => 'Monto asignado a la fuente local.',
            'active' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.',
            'denominacion_documento' => 'Denominaci&oacute;n del documento del Programa Anual de Comunicación Social o equivalente.',
            'fecha_publicacion' => 'Fecha de publicaci&oacute;n del Programa Anual de Comunicaci&oacute;n Social.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n.',
			'fecha_inicio_periodo' => 'Fecha de inicio del periodo que se informa',
            'fecha_termino_periodo' => 'Fecha de termino del periodo que se informa',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'id_presupuesto_concepto' => 'Indica la clave de la partida presupuestal.',
            'mision' => 'Misi&oacute;n y Visi&oacute;n oficiales del Ente P&uacute;blico.',
            'objetivo_institucional' => 'Objetivo u objetivos institucionales relacionados a los objetivos establecidos en el Plan Nacional de Desarrollo.',
            'metas' => 'Metas nacionales y/o Estrategias transversales relacionadas con los objetivos se&ntilde;alados en el campo &#34;Objetivo u objetivos institucionales&#34; establecidas en el Plan Nacional de Desarrollo.',
            'conjunto_campanas' => 'Las campa&ntilde;as deben ser acordes a los objetivos  institucionales que persiguen los Entes P&uacute;blicos con la difusi&oacute;n de las mismas, a difundirse en el ejercicio fiscal respectivo.',
            'objetivo_estrategico' => 'Objetivo estrat&eacute;gico o transversal, seg&uacute;n corresponda, alineado y vinculado al Plan Nacional de Desarrollo.',
            'temas' => 'Temas específicos derivados de los objetivos estrat&eacute;gicos o transversales que abordar&aacute;n en las Campa&ntilde;as del Programa anual de Comunicaci&oacute;n Social.',
            'programas' => 'Nombre del programa o programas relacionados al Programa Anual de Comunicaci&oacute;n Social.', 
            'sin_definir' => 'Sin definir'
        );
    }

    /**
	 * Filename Security
	 *
	 * @param	string
	 * @param 	bool
	 * @return	string
	 */
	public function sanitize_filename($str, $relative_path = FALSE)
	{
		$bad = array(
			"../",
			"<!--",
			"-->",
			"<",
			">",
			"'",
			'"',
			'&',
			'$',
			'#',
			'{',
			'}',
			'[',
			']',
			'=',
			';',
			'?',
			"%20",
			"%22",
			"%3c",		// <
			"%253c",	// <
			"%3e",		// >
			"%0e",		// >
			"%28",		// (
			"%29",		// )
			"%2528",	// (
			"%26",		// &
			"%24",		// $
			"%3f",		// ?
			"%3b",		// ;
			"%3d"		// =
		);

		if ( ! $relative_path)
		{
			$bad[] = './';
			$bad[] = '/';
		}

		$str = $this->_remove_invisible_characters($str, FALSE);
		return stripslashes(str_replace($bad, '', $str));
    }

    // --------------------------------------------------------------------
    
    protected function _remove_invisible_characters($str, $url_encoded = TRUE)
	{
		$non_displayables = array();
		
		// every control character except newline (dec 10)
		// carriage return (dec 13), and horizontal tab (dec 09)
		
		if ($url_encoded)
		{
			$non_displayables[] = '/%0[0-8bcef]/';	// url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%1[0-9a-f]/';	// url encoded 16-31
		}
		
		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

		do
		{
			$str = preg_replace($non_displayables, '', $str, -1, $count);
		}
		while ($count);

		return $str;
    }

    public function clean_file_name($txt)
    {
        $txt = trim($txt);
        $replace = array(
            'Š' => 'S',
            'Œ' => 'O',
            'Ž' => 'Z',
            'š' => 's',
            'œ' => 'oe',
            'ž' => 'z',
            'Ÿ' => 'Y',
            '¥' => 'Y',
            'µ' => 'u',
            'À' => 'A',
            'Á' => 'A',
            'Â' => 'A',
            'Ã' => 'A',
            'Ä' => 'A',
            'Å' => 'A',
            'Æ' => 'A',
            'Ç' => 'C',
            'È' => 'E',
            'É' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Ì' => 'I',
            'Í' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'І' => 'I',
            'Ð' => 'D',
            'Ñ' => 'N',
            'Ò' => 'O',
            'Ó' => 'O',
            'Ô' => 'O',
            'Õ' => 'O',
            'Ö' => 'O',
            'Ø' => 'O',
            'Ù' => 'U',
            'Ú' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ý' => 'Y',
            'ß' => 'ss',
            'à' => 'a',
            'á' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',
            'æ' => 'a',
            'ç' => 'c',
            'è' => 'e',
            'é' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'і' => 'i',
            'ð' => 'o',
            'ñ' => 'n',
            'ò' => 'o',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',
            'ø' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'ý' => 'y',
            'ÿ' => 'y',
            'ă' => 'a',
            'ş' => 's',
            'ţ' => 't',
            'ț' => 't',
            'Ț' => 'T',
            'Ș' => 'S',
            'ș' => 's',
            'Ş' => 'S',
            'А' => 'A',
            'Б' => 'B',
            'В' => 'V',
            'Г' => 'G',
            'Д' => 'D',
            'Е' => 'E',
            'Ё' => 'E',
            'Ж' => 'J',
            'З' => 'Z',
            'И' => 'I',
            'Й' => 'I',
            'К' => 'K',
            'Л' => 'L',
            'М' => 'M',
            'Н' => 'N',
            'О' => 'O',
            'П' => 'P',
            'Р' => 'R',
            'С' => 'S',
            'Т' => 'T',
            'У' => 'U',
            'Ф' => 'F',
            'Х' => 'H',
            'Ц' => 'C',
            'Ч' => 'CH',
            'Ш' => 'SH',
            'Щ' => 'SH',
            'Ы' => 'Y',
            'Э' => 'E',
            'Ю' => 'YU',
            'Я' => 'YA',
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'j',
            'з' => 'z',
            'и' => 'i',
            'й' => 'i',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'H',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'sh',
            'ы' => 'y',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'Ā' => 'A',
            'ā' => 'a',
            'Č' => 'C',
            'č' => 'c',
            'Ē' => 'E',
            'ē' => 'e',
            'Ģ' => 'G',
            'ģ' => 'g',
            'Ī' => 'I',
            'ī' => 'i',
            'Ķ' => 'K',
            'ķ' => 'k',
            'Ļ' => 'L',
            'ļ' => 'l',
            'Ņ' => 'N',
            'ņ' => 'n',
            'Ū' => 'U',
            'ū' => 'u',
            ' ' => '_');
        $txt = str_replace(array_keys($replace), array_values($replace), $txt);
        $txt = preg_replace('/[^a-zA-Z0-9_\-\.]+/', '', $txt);
        return strtoupper($txt);
    }

    function clear_html_tags($text){
        if(function_exists('htmlspecialchars_decode') && function_exists('html_entity_decode')){
            $a = htmlspecialchars_decode(strip_tags($text));
            return html_entity_decode($a);
        }else{
            return $text;
        }
        
    }
    
    function money_format($format, $number) 
    { 
        if(function_exists('number_format')){
            return '$ '. number_format($number, 2);
        }else
        {
            $regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'. 
            '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/'; 
            if (setlocale(LC_MONETARY, 0) == 'C') { 
                setlocale(LC_MONETARY, ''); 
            } 
            $locale = localeconv(); 
            preg_match_all($regex, $format, $matches, PREG_SET_ORDER); 
            foreach ($matches as $fmatch) { 
                $value = floatval($number); 
                $flags = array( 
                    'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ? 
                                $match[1] : ' ', 
                    'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0, 
                    'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ? 
                                $match[0] : '+', 
                    'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0, 
                    'isleft'    => preg_match('/\-/', $fmatch[1]) > 0 
                ); 
                $width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0; 
                $left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0; 
                $right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits']; 
                $conversion = $fmatch[5]; 

                $positive = true; 
                if ($value < 0) { 
                    $positive = false; 
                    $value  *= -1; 
                } 
                $letter = $positive ? 'p' : 'n'; 

                $prefix = $suffix = $cprefix = $csuffix = $signal = ''; 

                $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign']; 
                switch (true) { 
                    case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+': 
                        $prefix = $signal; 
                        break; 
                    case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+': 
                        $suffix = $signal; 
                        break; 
                    case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+': 
                        $cprefix = $signal; 
                        break; 
                    case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+': 
                        $csuffix = $signal; 
                        break; 
                    case $flags['usesignal'] == '(': 
                    case $locale["{$letter}_sign_posn"] == 0: 
                        $prefix = '('; 
                        $suffix = ')'; 
                        break; 
                } 
                if (!$flags['nosimbol']) { 
                    $currency = $cprefix . 
                                ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) . 
                                $csuffix; 
                } else { 
                    $currency = ''; 
                } 
                $space  = $locale["{$letter}_sep_by_space"] ? ' ' : ''; 

                $value = number_format($value, $right, $locale['mon_decimal_point'], 
                        $flags['nogroup'] ? '' : $locale['mon_thousands_sep']); 
                $value = @explode($locale['mon_decimal_point'], $value); 

                $n = strlen($prefix) + strlen($currency) + strlen($value[0]); 
                if ($left > 0 && $left > $n) { 
                    $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0]; 
                } 
                $value = implode($locale['mon_decimal_point'], $value); 
                if ($locale["{$letter}_cs_precedes"]) { 
                    $value = $prefix . $currency . $space . $value . $suffix; 
                } else { 
                    $value = $prefix . $value . $space . $currency . $suffix; 
                } 
                if ($width > 0) { 
                    $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ? 
                            STR_PAD_RIGHT : STR_PAD_LEFT); 
                } 

                $format = str_replace($fmatch[0], $value, $format); 
            } 
            return $format; 
        }  
    } 
}

?>