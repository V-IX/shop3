<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*if ( ! function_exists(''))
{
	function action_result()
	{
		return $return;
	}
}*/

/*
|--------------------------------------------------------------------------
| TAGS HELPERS
|--------------------------------------------------------------------------
*/
if ( ! function_exists('script'))
{
	function script($src = '', $type = 'text/javascript', $attr = array())
	{
		$attr['src'] = ( ! preg_match('!^\w+://! i', $src)) ? base_url($src) : $src;
		$attr['type'] = $type;
		
		$content = '';
		foreach($attr as $k => $v) $content .= ' '.$k.'="'.$v.'"';
		
		return "<script ".$content."></script>\n";
	}
}

/*
|--------------------------------------------------------------------------
| HTML HELPERS
|--------------------------------------------------------------------------
*/

if ( ! function_exists('fa'))
{
	function fa($class, $attr = array())
	{
		$icon = '<i class="fa fa-' . $class . '" ';
		foreach($attr as $k => $v)
		{
			$icon .= $k . '="'. $v .'" ';
		}
		$icon .= '></i>';
		return $icon;
	}
}

if ( ! function_exists('action_result'))
{
	function action_result($status = false, $text = "", $close = false)
	{
		$status = $status ? 'note-'.$status : "";
		$close = $close ? '<div class="note-close"></div>' : "";
		$return = '<div class="note '.$status.'">'.$close.$text.'</div>';
		return $return;
	}
}

if ( ! function_exists('check_img'))
{
	function check_img($src, $attr = array(), $nophoto = 'default.png', $only_url = false)
	{
		if(file_exists('./'.$src) and $src != "" and !is_dir('./'.$src)) {
			if(!empty($attr))
			{
				$attr['src'] = $src;
				return !$only_url ? img($attr) : base_url($src);
			} else {
				return !$only_url ? img($src) : base_url($src);
			}
		} else {
			if($nophoto)
			{
				$np = $nophoto != '' ? $nophoto : '300x200.png';
				$attr['src'] = 'assets/uploads/nophoto/'.$np;
				
				return !$only_url ? img($attr) : base_url('assets/site/img/no-photo/'.$np);
			} else {
				return '';
			}
		}
	}
}

if ( ! function_exists('price'))
{
	function price($price)
	{
		$return = number_format($price, 2, ',', ' ');	
		return $return;
	}
}

if ( ! function_exists('price_old'))
{
	function price_old($price)
	{
		$return = intval($price * 10000);
		$return = preg_replace( "~(\d(?=(?:\d{3})+(?!\d)))~s", "\\1 ", $return );
		return $return;
	}
}

if ( ! function_exists('price_calc'))
{
	function price_calc($price = 0, $default = 1, $current = 1)
	{
		$price = $price * $current / $default;
		return $price;
	}
}

if ( ! function_exists('phone'))
{
	function phone($phone, $mask)
	{
		$return = '';
		$j = 0;
		for($i = 0; $i < strlen($mask); $i++)
		{
			if($mask[$i] == '?' and isset($phone[$j]))
			{
				$return .= $phone[$j];
				$j++;
			} else {
				$return .= $mask[$i];
			}
		}
		return $return;
	}
}

if ( ! function_exists('raiting'))
{
	function raiting($comments)
	{
		$return = 0;
		$total = 0;
		$count = count($comments);
		
		if(!empty($comments))
		{
			foreach($comments as $com)
			{
				$total += intval($com['raiting']);
			}
			
			$return = round($total / $count);
		}
		return $return;
	}
}

if ( ! function_exists('month'))
{
	function month($id = false)
	{
		$return = array(
			'01' => 'января',
			'02' => 'февраля',
			'03' => 'марта',
			'04' => 'апреля',
			'05' => 'мая',
			'06' => 'июня',
			'07' => 'июля',
			'08' => 'августа',
			'09' => 'сентября',
			'10' => 'октября',
			'11' => 'ноября',
			'12' => 'декабря',
		);
		
		if($id !== false)
		{
			if(array_key_exists($id, $return)) return $return[$id];
			else return 'Ошибка вывода';
		} else {
			return $return;
		}
		
	}
}

if ( ! function_exists('weekday'))
{
	function weekday($id = false)
	{
		$return = array(
			1 => 'понедельник', 2 => 'вторник', 3 => 'среда', 4 => 'четверг', 5 => 'пятница', 6 => 'суббота', 0 => 'воскресенье',
		);
		
		if($id !== false)
		{
			if(array_key_exists($id, $return)) return $return[$id];
			else return 'Ошибка вывода';
		} else {
			return $return;
		}
		
	}
}

if ( ! function_exists('translate_date'))
{
	function translate_date($date)
	{
		$d = date('d', strtotime($date));
		$m = date('m', strtotime($date));
		$y = date('Y', strtotime($date));
		
		return $d.' '.month($m).' '.$y;
	}
}

if ( ! function_exists('translate_day'))
{
	function translate_day($date)
	{
		$d = date('d', strtotime($date));
		$m = date('m', strtotime($date));
		$w = date('w', strtotime($date));
		$y = date('Y', strtotime($date));
		
		return $d.' '.month($m).' '.$y.', '.weekday($w);
	}
}

if( ! function_exists('banner'))
{
	function banner($banner)
	{
		if($banner['visibility'] == 0) return '';
		$img = img(array('src' => 'assets/uploads/banners/thumb/'.$banner['img'], 'alt' => $banner['alt']));
		$return = '<div class="banner">'.$img.'</div>';
		if($banner['link']) $return = anchor($banner['link'], $img, array('target' => $banner['target'], 'class' => 'banner'));
		return $return;
	}
}

if( ! function_exists('path'))
{
	function path($id, $paths = array(), $suffix = false)
	{
		$return = 'catalog';
		if(array_key_exists($id, $paths))
		{
			$return .= '/'.$paths[$id];
			if($suffix != '') $return .= '/'.$suffix;
		}	
		
		return base_url($return);
	}
}

/*
|--------------------------------------------------------------------------
| PHP HELPERS
|--------------------------------------------------------------------------
*/

if ( ! function_exists('deletefile'))
{
	function deletefile($src)
	{
		if(!is_array($src)) $src[] = $src;
		
		foreach($src as $path)
		{
			if(file_exists('.'.$path) and !is_dir('.'.$path)) unlink('.'.$path);
		}
		return true;
	}
}

if ( ! function_exists('translit'))
{
	function translit($str)
	{
		
		$translit = array(
            'а' => 'a',		'б' => 'b',		'в' => 'v',
            'г' => 'g',		'д' => 'd',		'е' => 'e',
            'ё' => 'yo',	'ж' => 'zh',	'з' => 'z',
            'и' => 'i',		'й' => 'j',		'к' => 'k',
            'л' => 'l',		'м' => 'm',		'н' => 'n',
            'о' => 'o',		'п' => 'p',		'р' => 'r',
            'с' => 's',		'т' => 't',		'у' => 'u',
            'ф' => 'f',		'х' => 'x',		'ц' => 'c',
            'ч' => 'ch',	'ш' => 'sh',	'щ' => 'shh',
            'ь' => '',		'ы' => 'y',		'ъ' => '',
            'э' => 'e',		'ю' => 'yu',	'я' => 'ya',
  
            'А' => 'A',		'Б' => 'B',		'В' => 'V',
            'Г' => 'G',		'Д' => 'D',		'Е' => 'E', 
            'Ё' => 'YO',	'Ж' => 'Zh',	'З' => 'Z',  
            'И' => 'I',		'Й' => 'J',		'К' => 'K',  
            'Л' => 'L',		'М' => 'M',		'Н' => 'N',  
            'О' => 'O',		'П' => 'P',		'Р' => 'R',  
            'С' => 'S',		'Т' => 'T',		'У' => 'U',  
            'Ф' => 'F',		'Х' => 'X',		'Ц' => 'C',  
            'Ч' => 'CH',	'Ш' => 'SH',	'Щ' => 'SHH',  
            'Ь' => '',		'Ы' => 'Y',		'Ъ' => '',  
            'Э' => 'E',		'Ю' => 'YU',	'Я' => 'YA',
			
			' ' => '-'
        );
  
		$return = strtr($str, $translit);
	   
		$return = preg_replace ("/[^a-zA-ZА-Яа-я0-9-\s]/", "", $return);
		$return = trim($return, '-');
	   
	   return strtolower($return);
	}
}