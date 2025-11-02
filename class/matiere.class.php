<?php
/**
 * Classe permettant de gérer l'entité Matière
 * 
 * Cette classe gère les opérations CRUD (Create, Read, Update, Delete) sur les matières.
 * Une matière est associée à un module et possède un numéro, un nom et un coefficient.
 * 
 * @package TD3
 * @subpackage Class
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
declare(strict_types=1);

/**
 * Classe Matiere
 * 
 * Représente une matière dans le système avec toutes ses propriétés
 * et méthodes pour interagir avec la base de données.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
class Matiere {
    /** @var int Identifiant unique de la matière dans la base de données */
    public int $rowid;
    
    /** @var string Numéro de la matière */
    public string $num_matiere;
    
    /** @var string Nom de la matière */
    public string $name;
    
    /** @var float Coefficient de la matière */
    public float $coef;
    
    /** @var int Identifiant du module associé (clé étrangère) */
    public int $fk_module;

    /** @var string|null Nom du module associé (pour l'affichage) */
    public ?string $module_name = null;

    /**
     * Constructeur de la classe Matiere
     * 
     * Initialise un objet Matiere avec les données fournies en paramètre.
     * Seules les propriétés existantes sont assignées.
     * 
     * @param array<string, mixed> $data Tableau associatif contenant les données de la matière
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public function __construct(array $data = []) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    /**
     * Crée une nouvelle matière dans la base de données
     * 
     * Insère une nouvelle matière avec toutes ses informations dans la table mp_matieres.
     * L'identifiant rowid est automatiquement assigné après l'insertion.
     * 
     * @return void
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public function create() {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $stmt = $db->prepare("
            INSERT INTO mp_matieres (num_matiere, name, coef, fk_module)
            VALUES (:num_matiere, :name, :coef, :fk_module)
        ");
        $stmt->execute([
            ':num_matiere' => $this->num_matiere,
            ':name' => $this->name,
            ':coef' => $this->coef,
            ':fk_module' => $this->fk_module
        ]);
        $this->rowid = $db->lastInsertId();
    }

    /**
     * Récupère une matière par son identifiant
     * 
     * Recherche une matière dans la base de données en utilisant son rowid.
     * Inclut également le nom du module associé.
     * 
     * @param int $id Identifiant unique de la matière
     * @return Matiere|null La matière trouvée ou null si aucun résultat
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public static function fetch(int $id): ?Matiere {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $stmt = $db->prepare("
            SELECT m.*, mo.name AS module_name
            FROM mp_matieres m
            LEFT JOIN mp_modules mo ON m.fk_module = mo.rowid
            WHERE m.rowid = :id
        ");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Matiere($data) : null;
    }

    /**
     * Récupère toutes les matières de la base de données
     * 
     * Retourne une liste de toutes les matières avec le nom du module associé,
     * triées par nom alphabétique.
     * 
     * @return array<Matiere> Tableau d'objets Matiere
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public static function fetchAll(): array {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $stmt = $db->query("
            SELECT m.*, mo.name AS module_name
            FROM mp_matieres m
            LEFT JOIN mp_modules mo ON m.fk_module = mo.rowid
            ORDER BY m.name ASC
        ");
        $list = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $list[] = new Matiere($row);
        }
        return $list;
    }

    /**
     * Recherche dynamique de matières selon des critères
     * 
     * Permet de rechercher des matières avec des critères multiples.
     * Les recherches sont effectuées avec LIKE (pattern matching).
     * 
     * @param array<string, string> $criteria Tableau associatif des critères de recherche
     *                                        (ex: ['name' => 'Mathématiques', 'num_matiere' => 'MATH'])
     * @return array<Matiere> Tableau d'objets Matiere correspondant aux critères
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public static function find(array $criteria = []): array {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $sql = "SELECT m.*, mo.name AS module_name
                FROM mp_matieres m
                LEFT JOIN mp_modules mo ON m.fk_module = mo.rowid
                WHERE 1=1";
        $params = [];
        foreach ($criteria as $key => $value) {
            $sql .= " AND m.$key LIKE :$key";
            $params[":$key"] = "%$value%";
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $list = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $list[] = new Matiere($row);
        }
        return $list;
    }

    /**
     * Met à jour les informations de la matière dans la base de données
     * 
     * Met à jour toutes les propriétés de la matière. La matière doit avoir un rowid valide.
     * 
     * @return void
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public function update() {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $stmt = $db->prepare("
            UPDATE mp_matieres
            SET num_matiere = :num_matiere,
                name = :name,
                coef = :coef,
                fk_module = :fk_module
            WHERE rowid = :id
        ");
        $stmt->execute([
            ':num_matiere' => $this->num_matiere,
            ':name' => $this->name,
            ':coef' => $this->coef,
            ':fk_module' => $this->fk_module,
            ':id' => $this->rowid
        ]);
    }

    /**
     * Supprime la matière de la base de données
     * 
     * Supprime la matière correspondante à l'identifiant rowid de l'objet.
     * 
     * @return void
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public function delete() {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $stmt = $db->prepare("DELETE FROM mp_matieres WHERE rowid = :id");
        $stmt->execute([':id' => $this->rowid]);
    }
}
