<?php
/**
 * Classe permettant de gérer l'authentification
 * 
 * Cette classe fournit des méthodes statiques pour vérifier l'authentification
 * des utilisateurs et pour authentifier un utilisateur avec un nom d'utilisateur
 * et un mot de passe.
 * 
 * @package TD3
 * @subpackage Class
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */

/**
 * Classe myAuthClass
 * 
 * Gère l'authentification des utilisateurs dans le système.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
class myAuthClass
{
    /**
     * Vérifie si un utilisateur est authentifié
     * 
     * Vérifie si la session contient les informations d'un utilisateur authentifié.
     * 
     * @param array<string, mixed> $current_session Tableau de session PHP ($_SESSION)
     * @return bool true si l'utilisateur est authentifié, false sinon
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public static function is_auth($current_session)
    {
        if (isset($current_session['user']) && !empty($current_session['user']))
            return true;
        return false;
    }

    /**
     * Authentifie un utilisateur avec un nom d'utilisateur et un mot de passe
     * 
     * Vérifie les identifiants de connexion dans la base de données.
     * Le mot de passe est comparé après hashage MD5.
     * 
     * @param string $username Nom d'utilisateur
     * @param string $password Mot de passe en clair (sera hashé en MD5 pour comparaison)
     * @return array<string, mixed>|false Tableau associatif contenant les informations de l'utilisateur
     *                                   (rowid, username, firstname, lastname) ou false si échec
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
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
