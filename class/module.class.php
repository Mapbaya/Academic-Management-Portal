<?php
/**
 * Class for managing l'entité Module
 * 
 * Cette classe gère les opérations CRUD (Create, Read, Update, Delete) sur les modules.
 * Un module possède un numéro, un nom et un coefficient.
 * 
 * @package TD3
 * @subpackage Class
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
declare(strict_types=1);

/**
 * Class Module
 * 
 * Représente un module dans le système avec toutes ses propriétés
 * et méthodes pour interagir avec la base de données.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
class Module {
    /** @var int Identifiant unique du module dans la base de données */
    public int $rowid;
    
    /** @var string Numéro du module */
    public string $num_module;
    
    /** @var string Nom du module */
    public string $name;
    
    /** @var float Coefficient du module */
    public float $coef;

    /**
     * Constructeur de la classe Module
     * 
     * Initialise un objet Module avec les données fournies en paramètre.
     * Seules les propriétés existantes sont assignées.
     * 
     * @param array<string, mixed> $data Tableau associatif contenant les données du module
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function __construct(array $data = []) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    /**
     * Creates un nouveau module dans la base de données
     * 
     * Insère un nouveau module avec toutes ses informations dans la table mp_modules.
     * L'identifiant rowid est automatiquement assigné après l'insertion.
     * 
     * @return void
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function create() {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $stmt = $db->prepare("
            INSERT INTO mp_modules (num_module, name, coef)
            VALUES (:num_module, :name, :coef)
        ");
        $stmt->execute([
            ':num_module' => $this->num_module,
            ':name' => $this->name,
            ':coef' => $this->coef
        ]);
        $this->rowid = $db->lastInsertId();
    }

    /**
     * Met à jour les informations du module dans la base de données
     * 
     * Met à jour toutes les propriétés du module. Le module doit avoir un rowid valide.
     * 
     * @return void
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function update() {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $stmt = $db->prepare("
            UPDATE mp_modules
            SET num_module = :num_module,
                name = :name,
                coef = :coef
            WHERE rowid = :id
        ");
        $stmt->execute([
            ':num_module' => $this->num_module,
            ':name' => $this->name,
            ':coef' => $this->coef,
            ':id' => $this->rowid
        ]);
    }

    /**
     * Supprime le module de la base de données
     * 
     * Supprime le module correspondant à l'identifiant rowid de l'objet.
     * 
     * @return void
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function delete() {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $stmt = $db->prepare("DELETE FROM mp_modules WHERE rowid = :id");
        $stmt->execute([':id' => $this->rowid]);
    }

    /**
     * Retrieves un module par son identifiant
     * 
     * Recherche un module dans la base de données en utilisant son rowid.
     * 
     * @param int $id Identifiant unique du module
     * @return Module|null Le module trouvé ou null si aucun résultat
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function fetch(int $id): ?Module {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $stmt = $db->prepare("SELECT * FROM mp_modules WHERE rowid = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Module($data) : null;
    }

    /**
     * Retrieves tous les modules de la base de données
     * 
     * Retourne une liste de tous les modules triés par nom alphabétique.
     * 
     * @return array<Module> Tableau d'objets Module
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function fetchAll(): array {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $stmt = $db->query("SELECT * FROM mp_modules ORDER BY name ASC");
        $list = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $list[] = new Module($row);
        }
        return $list;
    }
}
