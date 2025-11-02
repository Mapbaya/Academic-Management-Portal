<?php
/**
 * Class for managing authentication
 * 
 * This class provides static methods to verify authentication
 * of users and to authenticate a user with a username
 * and password.
 * 
 * @package TD3
 * @subpackage Class
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */

/**
 * Class myAuthClass
 * 
 * Manages user authentication in the system.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
class myAuthClass
{
    /**
     * Checks if a user is authenticated
     * 
     * Checks if the session contains the information of an authenticated user.
     * 
     * @param array<string, mixed> $current_session PHP session array ($_SESSION)
     * @return bool true if the user is authenticated, false otherwise
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function is_auth($current_session)
    {
        if (isset($current_session['user']) && !empty($current_session['user']))
            return true;
        return false;
    }

    /**
     * Authenticates a user with a username and password
     * 
     * Checks login credentials in the database.
     * Password is compared after MD5 hashing.
     * 
     * @param string $username Username
     * @param string $password Password in plain text (will be hashed in MD5 for comparison)
     * @return array<string, mixed>|false Associative array containing user information
     *                                   (rowid, username, firstname, lastname) or false on failure
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function authenticate($username, $password)
    {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $fields = array(
            'rowid',
            'username',
            'firstname',
            'lastname',
        );
        $sql = 'SELECT '.implode(', ', $fields).' ';
        $sql .= 'FROM mp_users ';
        $sql .= 'WHERE username = :username AND password = :passhash';
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->bindValue(':passhash', md5($password), PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
