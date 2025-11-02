<?php
/**
 * Class for managing the Module entity
 * 
 * This class manages CRUD operations (Create, Read, Update, Delete) for modules.
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
 * Represents a module in the system with all its properties
 * and methods to interact with the database.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
class Module {
    /** @var int Unique identifier of the module in the database */
    public int $rowid;
    
    /** @var string Numéro of the module */
    public string $num_module;
    
    /** @var string Nom of the module */
    public string $name;
    
    /** @var float Coefficient of the module */
    public float $coef;

    /**
     * Constructeur de la classe Module
     * 
     * Initialise un objet Module avec les données fournies en paramètre.
     * Only existing properties are assigned.
     * 
     * @param array<string, mixed> $data Tableau associatif contenant les données of the module
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
     * Creates a new module in the database
     * 
     * Inserts a new module with all its information into the mp_modules table.
     * The rowid identifier is automatically assigned after insertion.
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
     * Met à jour les informations of the module in the database
     * 
     * Updates all properties of the module. The module must have a valid rowid.
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
     * Recherche un module in the database en utilisant son rowid.
     * 
     * @param int $id Unique identifier of the module
     * @return Module|null The module found or null if no result
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
     * Retourne une liste of all modules triés par nom alphabétique.
     * 
     * @return array<Module> Array of objects Module
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
