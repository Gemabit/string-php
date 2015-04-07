<?php

namespace Gemabit\String;

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
     * Appends a new string to the old one
     * @param string    $str
     * @return object
     */
    public function append($str)
    {
        $this->value .= $str;
        return $this;
    }
    
    /**
     * Prepends a new string to the old one
     * @param string    $str
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
     * @param boolean   $capitalizeAllWords Uppercase the first character of each word in a string if it's true
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
     * @param string    $needle
     * @return boolean
     */
    public function startsWith($needle)
    {
        return !strncmp($this->value, $needle, strlen($needle));
    }
    
    /**
     * Checks if it ends with the $needle
     * @param string    $needle
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
     * @param string    $needle
     * @return boolean
     */
    public function contains($needle)
    {
        return strpos($this->value, $needle) !== false;
    }
    
    /**
     * Returns the first n chars of the string
     * @param integer   $n
     * @return boolean
     */
    public function firstChar($n = 1)
    {
        return substr($str, $n);
    }

    /**
     * Returns the last n chars of the string
     * @param integer   $n
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
    
        if ($this->length() < 1)    return 0;
        if ($this->length() < 4)    return 1;
        if ($this->length() >= 8)   $strength++;
        if ($this->length() >= 10)  $strength++;
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