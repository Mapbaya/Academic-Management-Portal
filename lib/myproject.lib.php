<?php
/**
 * TD3 project utility functions library
 * 
 * This file contains utility functions used throughout the project,
 * particularly for GET/POST parameter management and string manipulation.
 * 
 * @package TD3
 * @subpackage Lib
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */

require_once(dirname(__FILE__) . '/../vendor/autoload.php');

/**
 * Retrieves a parameter from $_POST or $_GET
 * 
 * Searches first in $_POST, then in $_GET if the parameter is not found.
 * Returns null if the parameter is empty or non-existent.
 * 
 * @param string $paramname Name of the parameter to retrieve
 * @return mixed|null Parameter value or null if not found or empty
 * @author Kime Marwa
 * @since November 2, 2025
 */
function GETPOST($paramname)
{
    if (isset($_POST[$paramname]) && !empty($_POST[$paramname]))
        return $_POST[$paramname];
    if (isset($_GET[$paramname]) && !empty($_GET[$paramname]))
        return $_GET[$paramname];
    return null;
}

/**
 * Checks if a parameter exists in $_POST or $_GET
 * 
 * Checks for the presence of a parameter in $_POST or $_GET,
 * regardless of its value (even if it is empty).
 * 
 * @param string $paramname Name of the parameter to check
 * @return bool true if the parameter exists in $_POST or $_GET, false otherwise
 * @author Kime Marwa
 * @since November 2, 2025
 */
function GETPOSTISSET($paramname)
{
    return (isset($_POST[$paramname]) || isset($_GET[$paramname]));
}

/**
 * Capitalizes the first letter of a name/first name
 * 
 * Formats a name or first name by capitalizing the first letter
 * and making the rest lowercase. Uses mb_convert_case to correctly handle
 * UTF-8 characters (accents, special characters).
 * 
 * @param string|null $name The name/first name to capitalize
 * @return string The name with the first letter capitalized, empty string if null or empty
 * @author Kime Marwa
 * @since November 2, 2025
 */
function capitalizeName(?string $name): string {
    if (empty($name)) {
        return '';
    }
    return mb_convert_case(trim($name), MB_CASE_TITLE, 'UTF-8');
}