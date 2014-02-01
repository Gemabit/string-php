<?php

namespace Gemabit\Tools\String;

class String
{
	protected $value = '';
	
	/**
	 * Class constructor
	 * @param string $str
	 */
	public function __construct($str = '')
	{
		$this->value = $str;
	}

	/**
	 * Magic function
	 * @return string
	 */
	public function __toString()
	{
		return $this->value;
	}
	
	/**
	 * Sets the string value to the value defined
	 * @param string $newValue
	 * @return object
	 */
	public function set($newValue = '')
	{
		$this->value = $newValue;
		return $this;
	}
	
	/**
	 * Sets the string value to ''
	 * @return object
	 */
	public function clear()
	{
		return $this->set('');
		return $this;
	}
	
	/**
	 * Appends a new string to the old one
	 * @param string	$str
	 * @return object
	 */
	public function append($str)
	{
		$this->value .= $str;
		return $this;
	}
	
	/**
	 * Prepends a new string to the old one
	 * @param string	$str
	 * @return object
	 */
	public function prepend($str)
	{
		$this->value = $str . $this->value;
		return $this;
	}

	
	/**
	 * Converts all alphabetic characters to uppercase
	 * @return object
	 */
	public function toUpper()
	{
		$this->value = strtoupper($this->value);
		return $this;
	}

	/**
	 * Converts all alphabetic characters to lowercase
	 * @return object
	 */
	public function toLower($onlyFirstChar = false)
	{
		$this->value = $onlyFirstChar ? lcfirst($this->value) : strtolower($this->value);
		return $this;
	}
	
	/**
	 * Uppercase the first character of the string
	 * @param boolean	$capitalizeAllWords Uppercase the first character of each word in a string if it's true
	 * @return object
	 */
	public function toCapital($capitalizeAllWords = false)
	{
		$this->value = $capitalizeAllWords ? ucwords($this->value) : ucfirst($this->value);
		return $this;
	}
	
	/**
	 * Formats the string to camelCase
	 * @return object
	 */
	public function toCamelCase()
	{
		return $this->toCapital(true)->remove(' ')->toLower(true);
	}
	
	/**
	 * Checks if it starts with the $needle
	 * @param string	$needle
	 * @return boolean
	 */
	public function startsWith($needle)
	{
		return !strncmp($this->value, $needle, strlen($needle));
	}
	
	/**
	 * Checks if it ends with the $needle
	 * @param string	$needle
	 * @return boolean
	 */
	public function endsWith($needle)
	{
		if (strlen($needle) == 0)
			return true;
		
		return (substr($this->value, -strlen($needle)) === $needle);
	}
	
	/**
	 * Checks if it contains the $needle
	 * @param string	$needle
	 * @return boolean
	 */
	public function contains($needle)
	{
		return strpos($this->value, $needle) !== false;
	}
	
	/**
	 * Returns the first n chars of the string
	 * @param integer	$n
	 * @return boolean
	 */
	public function firstChar($n = 1)
	{
		return substr($str, $n);
	}

	/**
	 * Returns the last n chars of the string
	 * @param integer	$n
	 * @return boolean
	 */
	public function lastChar($n = 1)
	{
		return substr($str, -$n);
	}

	/**
	 * Returns an array of the sliced string, by the defined delimiter
	 * @param string $delimiter
	 * @return array
	 */
	public function explode($delimiter)
	{
		return explode($delimiter, $this->value);
	}
	
	/**
	 * Returns the length of the string
	 * @return integer
	 */
	public function length()
	{
		return strlen($this->value);
	}
	
	/**
	 * Calculates the string strength between 0 and 6, it may be used on password validations
	 * @return integer
	 */
	public function strength()
	{
		$strength = 1;
	
		if ($this->length() < 1) 	return 0;
		if ($this->length() < 4) 	return 1;
		if ($this->length() >= 8) 	$strength++;
		if ($this->length() >= 10) 	$strength++;
		$strength += (int) (preg_match("/[a-z]/", $this->value) && preg_match("/[A-Z]/", $this->value));
		$strength += preg_match("/[0-9]/", $this->value);
		$strength += preg_match("/.[!,@,#,$,%,^,&,*,?,_,~,-,£,(,)]/", $this->value);

		return $strength;
	}
	
	/**
	 * Returns an array with all the words in the string
	 * @return array
	 */
	public function words()
	{
		return explode(' ', preg_replace("/[^a-zA-Z0-9]+/", "", $this->value));
	}
	
	/**
	 * Returns the total amount of words in the string
	 * @return integer
	 */
	public function totalWords()
	{
		return count($this->words());
	}
	
	/**
	 * Return information about words used in a string
	 * @param integer $format
	 * @return array
	 * @link http://www.php.net/manual/en/function.str-word-count.php
	 */
	public function countWords($format = 0)
	{
		return str_word_count($this->value, $format);
	}
	
	/**
	 * Return information about characters used in a string
	 * @param integer $mode
	 * @return array
	 * @link http://www.php.net/manual/en/function.count-chars.php
	 */
	public function countChars($mode = 0)
	{
		return count_chars($this->value, $mode);
	}
	
	/**
	 * Find and replace a word or a group of words
	 * @param array|string $find
	 * @param array|string $replace
	 * @return object
	 */
	public function replace($find, $replace, $count = false)
	{
		$this->value = str_replace($find, $replace, $this->value, $count);
		return $this;
	}
	
	/**
	 * Removes the value, or group of values passed, from the string
	 * @param string $needle
	 * @return object
	 */
	public function remove($needle)
	{
		return $this->replace($needle, '');
	}
	
	/**
	 * This can be used for templating. i.e.: sstr::init("{0} bought a {1}, some {2} and another {1}... ")->format("john", "potato", "chicken"); will return "john bought a potato, some chicken and another potato..."
	 * @param args[string]
	 * @return object
	 */
	public function format()
	{
		$args = func_get_args();
		
		foreach ($args as $key => $value)
			$this->value = str_replace(sprintf('{%d}', $key), $value, $this->value);
		
		return $this;
	}
	
	/**
	 * Validates if the string is an email
	 * @return boolean
	 */
	public function isEmail()
	{
		return filter_var($this->value, FILTER_VALIDATE_EMAIL);
	}
	
	/**
	 * Validates if the string is an url
	 * @return boolean
	 */
	public function isUrl()
	{
		return filter_var($this->value, FILTER_VALIDATE_EMAIL);
	}
		
	/**
	 * Validates if the string is an IP
	 * @return boolean
	 */
	public function isIP()
	{
		return filter_var($this->value, FILTER_VALIDATE_IP);
	}
	
	/**
	 * Checks if the string is empty
	 * @return boolean
	 */
	public function isEmpty()
	{
		return empty($this->value);
	}
	
	/**
	 * Checks if all of the characters in the provided string, creates whitespace.
	 * @return boolean
	 */
	public function isBlank()
	{
		return ctype_space($this->value);
	}
	
	/**
	 * Checks if the string is a valid color
	 * @return boolean
	 */
	public function isColor()
	{
		return !!$this->toRGBColor();
	}
	
	/**
	 * Checks of the string is an Hexadeciaml color or not
	 * @return boolean
	 */
	public function isHexColor()
	{
		if ($this->startsWith('#'))
			return preg_match('/^#[a-f0-9]{6}$/i', $this->value);
		else
			return preg_match('/^[a-f0-9]{6}$/i', $this->value);
	}
	
	/**
	 * Checks if the string is a valid Date
	 * @param boolean
	 */
	public function isDate()
	{
		return !!strtotime($this->value);
	}
	
	/**
	 * Checks if all of the characters in the provided string, are alphabetic.
	 * @return boolean
	 */
	public function isAlpha()
	{
		return ctype_alpha($this->value);
	}

	/**
	 * Checks if all of the characters in the provided string, are alphanumeric.
	 * @return boolean
	 */
	public function isAlphanumeric()
	{
		return ctype_alnum($this->value);
	}
	
	/**
	 * Checks for numeric character(s)
	 * @return boolean
	 */
	public function isNumeric()
	{
		return ctype_digit($this->value);
	}
	
	/**
	 * Checks if all of the characters in the provided string, are lowercase letters.
	 * @return boolean
	 */
	public function isLower()
	{
		return ctype_lower($this->value);
	}

	/**
	 * Checks if all of the characters in the provided string, are uppercase characters.
	 * @return boolean
	 */
	public function isUpper()
	{
		return ctype_upper($this->value);
	}
	
	/**
	 * Checks if all of the characters in the provided string, are printable. i.e.: The string 'abcd\n\r\t' does not consist of all printable characters.
	 * @return boolean
	 */
	private function isPrintable()
	{
		return ctype_print($this->value);
	}
	
	/**
	 * Checks if all of the characters in the provided string, are punctuation character.
	 * @return boolean
	 */
	public function isPunctuation()
	{
		return ctype_punct($this->value);
	}
	
	/**
	 * Checks if all of the characters in the provided string, are hexadecimal 'digits'.
	 * @return boolean
	 */
	public function isHexValue()
	{
		return ctype_xdigit($this->value);
	}
	
	/**
	 * Checks of the value in the provided string is Integer
	 * @return boolean
	 */
	public function isInt()
	{
		return is_int($this->value);
	}
	
	/**
	 * Checks of the value in the provided string is Float
	 * @return boolean
	 */
	public function isFloat()
	{
		return is_float($this->value);
	}
	
	/**
	 * Checks of the value in the provided string is Double
	 * @return boolean
	 */
	public function isDouble()
	{
		return $this->isNumeric() && !$this->contains('.');
	}
	
	/**
	 * Returns the value as a timestamp
	 * @return integer|boolean Returns false if the string isn't a valid date expression
	 */
	public function toTimestamp()
	{
		return strtotime($this->value);
	}
	
	/**
	 * Returns the string as a formated date string(if its a valid date expression)
	 * @param string $format Date format that you want to retrieve
	 * @return integer|boolean Returns false if the string isn't a valid date expression
	 */
	public function toDate($format = 'd/m/Y H:i:s')
	{
		if (!$timestamp = $this->toTimestamp())
			return false;
		
		return date($format, $timestamp);
	}
	
	/**
	 * Returns an array with the RGB values of the color
	 * @url http://psoug.org/snippet/CSS_Colornames_to_RGB_values_415.htm
	 * @return array|boolean Returns false if the color is not valid
	 */
	public function toRGBColor()
	{
		$colors  =  array(
			//Colors  as  they  are  defined  in  HTML  3.2 
			'black'				=> array('red' => 0x00, 'green' => 0x00, 'blue' => 0x00),
			'maroon'			=> array('red' => 0x80, 'green' => 0x00, 'blue' => 0x00), 
			'green' 			=> array('red' => 0x00, 'green' => 0x80, 'blue' => 0x00), 
			'olive' 			=> array('red' => 0x80, 'green' => 0x80, 'blue' => 0x00), 
			'navy' 				=> array('red' => 0x00, 'green' => 0x00, 'blue' => 0x80), 
			'purple' 			=> array('red' => 0x80, 'green' => 0x00, 'blue' => 0x80), 
			'teal' 				=> array('red' => 0x00, 'green' => 0x80, 'blue' => 0x80), 
			'gray' 				=> array('red' => 0x80, 'green' => 0x80, 'blue' => 0x80), 
			'silver' 			=> array('red' => 0xC0, 'green' => 0xC0, 'blue' => 0xC0), 
			'red' 				=> array('red' => 0xFF, 'green' => 0x00, 'blue' => 0x00), 
			'lime' 				=> array('red' => 0x00, 'green' => 0xFF, 'blue' => 0x00), 
			'yellow' 			=> array('red' => 0xFF, 'green' => 0xFF, 'blue' => 0x00), 
			'blue' 				=> array('red' => 0x00, 'green' => 0x00, 'blue' => 0xFF), 
			'fuchsia' 			=> array('red' => 0xFF, 'green' => 0x00, 'blue' => 0xFF), 
			'aqua' 				=> array('red' => 0x00, 'green' => 0xFF, 'blue' => 0xFF), 
			'white' 			=> array('red' => 0xFF, 'green' => 0xFF, 'blue' => 0xFF), 
			 
			//Additional  colors  as  they  are  used  by  Netscape  and  IE 
			'aliceblue' 		=> array('red' => 0xF0, 'green' => 0xF8, 'blue' => 0xFF), 
			'antiquewhite' 		=> array('red' => 0xFA, 'green' => 0xEB, 'blue' => 0xD7), 
			'aquamarine' 		=> array('red' => 0x7F, 'green' => 0xFF, 'blue' => 0xD4), 
			'azure' 			=> array('red' => 0xF0, 'green' => 0xFF, 'blue' => 0xFF), 
			'beige' 			=> array('red' => 0xF5, 'green' => 0xF5, 'blue' => 0xDC), 
			'blueviolet' 		=> array('red' => 0x8A, 'green' => 0x2B, 'blue' => 0xE2), 
			'brown' 			=> array('red' => 0xA5, 'green' => 0x2A, 'blue' => 0x2A), 
			'burlywood' 		=> array('red' => 0xDE, 'green' => 0xB8, 'blue' => 0x87), 
			'cadetblue' 		=> array('red' => 0x5F, 'green' => 0x9E, 'blue' => 0xA0), 
			'chartreuse' 		=> array('red' => 0x7F, 'green' => 0xFF, 'blue' => 0x00), 
			'chocolate' 		=> array('red' => 0xD2, 'green' => 0x69, 'blue' => 0x1E), 
			'coral' 			=> array('red' => 0xFF, 'green' => 0x7F, 'blue' => 0x50), 
			'cornflowerblue' 	=> array('red' => 0x64, 'green' => 0x95, 'blue' => 0xED), 
			'cornsilk' 			=> array('red' => 0xFF, 'green' => 0xF8, 'blue' => 0xDC), 
			'crimson' 			=> array('red' => 0xDC, 'green' => 0x14, 'blue' => 0x3C), 
			'darkblue' 			=> array('red' => 0x00, 'green' => 0x00, 'blue' => 0x8B), 
			'darkcyan' 			=> array('red' => 0x00, 'green' => 0x8B, 'blue' => 0x8B), 
			'darkgoldenrod' 	=> array('red' => 0xB8, 'green' => 0x86, 'blue' => 0x0B), 
			'darkgray' 			=> array('red' => 0xA9, 'green' => 0xA9, 'blue' => 0xA9), 
			'darkgreen' 		=> array('red' => 0x00, 'green' => 0x64, 'blue' => 0x00), 
			'darkkhaki' 		=> array('red' => 0xBD, 'green' => 0xB7, 'blue' => 0x6B), 
			'darkmagenta' 		=> array('red' => 0x8B, 'green' => 0x00, 'blue' => 0x8B), 
			'darkolivegreen' 	=> array('red' => 0x55, 'green' => 0x6B, 'blue' => 0x2F), 
			'darkorange' 		=> array('red' => 0xFF, 'green' => 0x8C, 'blue' => 0x00), 
			'darkorchid' 		=> array('red' => 0x99, 'green' => 0x32, 'blue' => 0xCC), 
			'darkred' 			=> array('red' => 0x8B, 'green' => 0x00, 'blue' => 0x00), 
			'darksalmon' 		=> array('red' => 0xE9, 'green' => 0x96, 'blue' => 0x7A), 
			'darkseagreen' 		=> array('red' => 0x8F, 'green' => 0xBC, 'blue' => 0x8F), 
			'darkslateblue' 	=> array('red' => 0x48, 'green' => 0x3D, 'blue' => 0x8B), 
			'darkslategray' 	=> array('red' => 0x2F, 'green' => 0x4F, 'blue' => 0x4F), 
			'darkturquoise' 	=> array('red' => 0x00, 'green' => 0xCE, 'blue' => 0xD1), 
			'darkviolet' 		=> array('red' => 0x94, 'green' => 0x00, 'blue' => 0xD3), 
			'deeppink' 			=> array('red' => 0xFF, 'green' => 0x14, 'blue' => 0x93), 
			'deepskyblue' 		=> array('red' => 0x00, 'green' => 0xBF, 'blue' => 0xFF), 
			'dimgray' 			=> array('red' => 0x69, 'green' => 0x69, 'blue' => 0x69), 
			'dodgerblue' 		=> array('red' => 0x1E, 'green' => 0x90, 'blue' => 0xFF), 
			'firebrick' 		=> array('red' => 0xB2, 'green' => 0x22, 'blue' => 0x22), 
			'floralwhite' 		=> array('red' => 0xFF, 'green' => 0xFA, 'blue' => 0xF0), 
			'forestgreen' 		=> array('red' => 0x22, 'green' => 0x8B, 'blue' => 0x22), 
			'gainsboro' 		=> array('red' => 0xDC, 'green' => 0xDC, 'blue' => 0xDC), 
			'ghostwhite' 		=> array('red' => 0xF8, 'green' => 0xF8, 'blue' => 0xFF), 
			'gold' 				=> array('red' => 0xFF, 'green' => 0xD7, 'blue' => 0x00), 
			'goldenrod' 		=> array('red' => 0xDA, 'green' => 0xA5, 'blue' => 0x20), 
			'greenyellow' 		=> array('red' => 0xAD, 'green' => 0xFF, 'blue' => 0x2F), 
			'honeydew' 			=> array('red' => 0xF0, 'green' => 0xFF, 'blue' => 0xF0), 
			'hotpink' 			=> array('red' => 0xFF, 'green' => 0x69, 'blue' => 0xB4), 
			'indianred' 		=> array('red' => 0xCD, 'green' => 0x5C, 'blue' => 0x5C), 
			'indigo' 			=> array('red' => 0x4B, 'green' => 0x00, 'blue' => 0x82), 
			'ivory' 			=> array('red' => 0xFF, 'green' => 0xFF, 'blue' => 0xF0), 
			'khaki' 			=> array('red' => 0xF0, 'green' => 0xE6, 'blue' => 0x8C), 
			'lavender' 			=> array('red' => 0xE6, 'green' => 0xE6, 'blue' => 0xFA), 
			'lavenderblush' 	=> array('red' => 0xFF, 'green' => 0xF0, 'blue' => 0xF5), 
			'lawngreen' 		=> array('red' => 0x7C, 'green' => 0xFC, 'blue' => 0x00), 
			'lemonchiffon' 		=> array('red' => 0xFF, 'green' => 0xFA, 'blue' => 0xCD), 
			'lightblue' 		=> array('red' => 0xAD, 'green' => 0xD8, 'blue' => 0xE6), 
			'lightcoral' 		=> array('red' => 0xF0, 'green' => 0x80, 'blue' => 0x80), 
			'lightcyan' 		=> array('red' => 0xE0, 'green' => 0xFF, 'blue' => 0xFF), 
			'lightgoldenrodyellow' => array('red' => 0xFA, 'green' => 0xFA, 'blue' => 0xD2), 
			'lightgreen' 		=> array('red' => 0x90, 'green' => 0xEE, 'blue' => 0x90), 
			'lightgrey' 		=> array('red' => 0xD3, 'green' => 0xD3, 'blue' => 0xD3), 
			'lightpink' 		=> array('red' => 0xFF, 'green' => 0xB6, 'blue' => 0xC1), 
			'lightsalmon' 		=> array('red' => 0xFF, 'green' => 0xA0, 'blue' => 0x7A), 
			'lightseagreen' 	=> array('red' => 0x20, 'green' => 0xB2, 'blue' => 0xAA), 
			'lightskyblue' 		=> array('red' => 0x87, 'green' => 0xCE, 'blue' => 0xFA), 
			'lightslategray' 	=> array('red' => 0x77, 'green' => 0x88, 'blue' => 0x99), 
			'lightsteelblue' 	=> array('red' => 0xB0, 'green' => 0xC4, 'blue' => 0xDE), 
			'lightyellow' 		=> array('red' => 0xFF, 'green' => 0xFF, 'blue' => 0xE0), 
			'limegreen' 		=> array('red' => 0x32, 'green' => 0xCD, 'blue' => 0x32), 
			'linen' 			=> array('red' => 0xFA, 'green' => 0xF0, 'blue' => 0xE6), 
			'mediumaquamarine' 	=> array('red' => 0x66, 'green' => 0xCD, 'blue' => 0xAA), 
			'mediumblue' 		=> array('red' => 0x00, 'green' => 0x00, 'blue' => 0xCD), 
			'mediumorchid' 		=> array('red' => 0xBA, 'green' => 0x55, 'blue' => 0xD3), 
			'mediumpurple' 		=> array('red' => 0x93, 'green' => 0x70, 'blue' => 0xD0), 
			'mediumseagreen' 	=> array('red' => 0x3C, 'green' => 0xB3, 'blue' => 0x71), 
			'mediumslateblue' 	=> array('red' => 0x7B, 'green' => 0x68, 'blue' => 0xEE), 
			'mediumspringgreen' => array('red' => 0x00, 'green' => 0xFA, 'blue' => 0x9A), 
			'mediumturquoise' 	=> array('red' => 0x48, 'green' => 0xD1, 'blue' => 0xCC), 
			'mediumvioletred' 	=> array('red' => 0xC7, 'green' => 0x15, 'blue' => 0x85), 
			'midnightblue' 		=> array('red' => 0x19, 'green' => 0x19, 'blue' => 0x70), 
			'mintcream' 		=> array('red' => 0xF5, 'green' => 0xFF, 'blue' => 0xFA), 
			'mistyrose' 		=> array('red' => 0xFF, 'green' => 0xE4, 'blue' => 0xE1), 
			'moccasin' 			=> array('red' => 0xFF, 'green' => 0xE4, 'blue' => 0xB5), 
			'navajowhite' 		=> array('red' => 0xFF, 'green' => 0xDE, 'blue' => 0xAD), 
			'oldlace' 			=> array('red' => 0xFD, 'green' => 0xF5, 'blue' => 0xE6), 
			'olivedrab' 		=> array('red' => 0x6B, 'green' => 0x8E, 'blue' => 0x23), 
			'orange' 			=> array('red' => 0xFF, 'green' => 0xA5, 'blue' => 0x00), 
			'orangered' 		=> array('red' => 0xFF, 'green' => 0x45, 'blue' => 0x00), 
			'orchid' 			=> array('red' => 0xDA, 'green' => 0x70, 'blue' => 0xD6), 
			'palegoldenrod' 	=> array('red' => 0xEE, 'green' => 0xE8, 'blue' => 0xAA), 
			'palegreen' 		=> array('red' => 0x98, 'green' => 0xFB, 'blue' => 0x98), 
			'paleturquoise' 	=> array('red' => 0xAF, 'green' => 0xEE, 'blue' => 0xEE), 
			'palevioletred' 	=> array('red' => 0xDB, 'green' => 0x70, 'blue' => 0x93), 
			'papayawhip' 		=> array('red' => 0xFF, 'green' => 0xEF, 'blue' => 0xD5), 
			'peachpuff' 		=> array('red' => 0xFF, 'green' => 0xDA, 'blue' => 0xB9), 
			'peru' 				=> array('red' => 0xCD, 'green' => 0x85, 'blue' => 0x3F), 
			'pink' 				=> array('red' => 0xFF, 'green' => 0xC0, 'blue' => 0xCB), 
			'plum' 				=> array('red' => 0xDD, 'green' => 0xA0, 'blue' => 0xDD), 
			'powderblue' 		=> array('red' => 0xB0, 'green' => 0xE0, 'blue' => 0xE6), 
			'rosybrown' 		=> array('red' => 0xBC, 'green' => 0x8F, 'blue' => 0x8F), 
			'royalblue' 		=> array('red' => 0x41, 'green' => 0x69, 'blue' => 0xE1), 
			'saddlebrown' 		=> array('red' => 0x8B, 'green' => 0x45, 'blue' => 0x13), 
			'salmon' 			=> array('red' => 0xFA, 'green' => 0x80, 'blue' => 0x72), 
			'sandybrown' 		=> array('red' => 0xF4, 'green' => 0xA4, 'blue' => 0x60), 
			'seagreen' 			=> array('red' => 0x2E, 'green' => 0x8B, 'blue' => 0x57), 
			'seashell' 			=> array('red' => 0xFF, 'green' => 0xF5, 'blue' => 0xEE), 
			'sienna' 			=> array('red' => 0xA0, 'green' => 0x52, 'blue' => 0x2D), 
			'skyblue' 			=> array('red' => 0x87, 'green' => 0xCE, 'blue' => 0xEB), 
			'slateblue' 		=> array('red' => 0x6A, 'green' => 0x5A, 'blue' => 0xCD), 
			'slategray' 		=> array('red' => 0x70, 'green' => 0x80, 'blue' => 0x90), 
			'snow' 				=> array('red' => 0xFF, 'green' => 0xFA, 'blue' => 0xFA), 
			'springgreen' 		=> array('red' => 0x00, 'green' => 0xFF, 'blue' => 0x7F), 
			'steelblue' 		=> array('red' => 0x46, 'green' => 0x82, 'blue' => 0xB4), 
			'tan' 				=> array('red' => 0xD2, 'green' => 0xB4, 'blue' => 0x8C), 
			'thistle' 			=> array('red' => 0xD8, 'green' => 0xBF, 'blue' => 0xD8), 
			'tomato' 			=> array('red' => 0xFF, 'green' => 0x63, 'blue' => 0x47), 
			'turquoise' 		=> array('red' => 0x40, 'green' => 0xE0, 'blue' => 0xD0), 
			'violet' 			=> array('red' => 0xEE, 'green' => 0x82, 'blue' => 0xEE), 
			'wheat' 			=> array('red' => 0xF5, 'green' => 0xDE, 'blue' => 0xB3), 
			'whitesmoke' 		=> array('red' => 0xF5, 'green' => 0xF5, 'blue' => 0xF5), 
			'yellowgreen' 		=> array('red' => 0x9A, 'green' => 0xCD, 'blue' => 0x32)
		);
		
		return isset($colors[ $this->value ]) ? $colors[ $this->value ] : false;
	}
	
	/**
	 * Returns Hex value of the color, if it is a valid color
	 * @return array|boolean Returns false if the color is not valid
	 */
	public function toHexColor()
	{
		if (!$rgb = $this->toRGBColor())
			return false;
		
		$hex = "#";
		$hex .= str_pad(dechex($rgb[0]), 2, '0', STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[1]), 2, '0', STR_PAD_LEFT);
		$hex .= str_pad(dechex($rgb[2]), 2, '0', STR_PAD_LEFT);
		
		return $hex;
	}
	
	/**
	 * Returns the value as a string
	 * @return string
	 */
	public function toString()
	{
		return $this->value;
	}
	
	/**
	 * Returns the value as a integer
	 * @return integer
	 */
	public function toInt()
	{
		return intval($this->value);
	}
	
	/**
	 * Returns the value as a float
	 * @return integer
	 */
	public function toFloat()
	{
		return floatval($this->value);
	}
	
	/**
	 * Returns the value as a double
	 * @return double
	 */
	public function toDouble()
	{
		return doubleval($this->value);
	}
	
	/**
	 * Returns the value as a boolean
	 * @return string
	 */
	public function toBool()
	{
		return !!$this->value;
	}

	/**
	 * Returns the value as a defined type
	 * @param string $type
	 * @return mixed Returns false if it is not possible to convert
	 */
	public function toType($type)
	{
		$tmp = $this->value;
		
		if (settype ($tmp, $type))
			return $tmp;
		
		return false;
	}
	
	/**
	 * Returns the md5 of the value
	 * @param boolean $rawOutput If the optional raw_output is set to TRUE, then the md5 digest is instead returned in raw binary format with a length of 16.
	 * @return string
	 */
	public function toMD5($rawOutput = false)
	{
		return md5($this->value, $rawOutput);
	}
		
	/**
	 * Returns the sha1 of the value
	 * @param boolean $rawOutput If the optional raw_output is set to TRUE, then the sha1 digest is instead returned in raw binary format with a length of 20, otherwise the returned value is a 40-character hexadecimal number.
	 * @return string
	 */
	public function toSHA1($rawOutput = false)
	{
		return sha1($this->value, $rawOutput);
	}
	
	/**
	 * Generate a hash value
	 * @param string $hashAlgorithm Name of selected hashing algorithm (i.e. "md5", "sha256", "haval160,4", etc..)
	 * @param boolean $rawOutput When set to TRUE, outputs raw binary data. FALSE outputs lowercase hexits.
	 * @return string
	 */
	public function toHash($hashAlgorithm, $rawOutput = false)
	{
		return hash($hashAlgorithm, $this->value, $rawOutput);
	}
	
	/**
	 * Strip whitespace (or other characters) from the beginning and end of a string
	 * @param string $charList Default characters to strip
	 * @return object
	 */
	public function trim($charList = " \t\n\r\0\x0B")
	{
		$this->value = trim($this->value, $charList);
		return $this;
	}
	
	/**
	 * Strip whitespace (or other characters) from the beginning of a string
	 * @param string $charList Default characters to strip
	 * @return object
	 */
	public function trimLeft($charList = " \t\n\r\0\x0B")
	{
		$this->value = ltrim($this->value, $charList);
		return $this;
	}
	
	/**
	 * Strip whitespace (or other characters) from the end of a string
	 * @param string $charList Default characters to strip
	 * @return object
	 */
	public function trimRigth($charList = " \t\n\r\0\x0B")
	{
		$this->value = rtrim($this->value, $charList);
		return $this;
	}
	
	/**
	 * Convert all applicable characters to HTML entities
	 * @return object
	 */
	public function htmlEntities()
	{
		$this->value = htmlentities($this->value);
		return $this;
	}
	
	/**
	 * Convert all HTML entities to their applicable characters
	 * @return object
	 */
	public function htmlEntitiesDecode()
	{
		$this->value = html_entity_decode($this->value);
		return $this;
	}
		
	/**
	 * Convert special characters to HTML entities
	 * @return object
	 */
	public function htmlSpecialChars()
	{
		$this->value = htmlspecialchars($this->value);
		return $this;
	}
	
	/**
	 * Convert special HTML entities back to characters
	 * @return object
	 */
	public function htmlSpecialCharsDecode()
	{
		$this->value = htmlspecialchars_decode($this->value);
		return $this;
	}
	
	/**
	 * URL-encodes the string value
	 * @return object
	 */
	public function urlEncode()
	{
		$this->value = urlencode($this->value);
		return $this;
	}

	/**
	 * Decodes URL-encoded string
	 * @return object
	 */
	public function urlDencode()
	{
		$this->value = urldecode($this->value);
		return $this;
	}
	
	
}

function String($str)
{
	return new String($str);
}