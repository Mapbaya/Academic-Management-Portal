<?php
/**
 * Class for managing l'entité Cours
 * 
 * Cette classe gère les opérations CRUD (Create, Read, Update, Delete) sur les cours.
 * Un cours contient une date, une matière, un enseignant, un groupe TD, un groupe TP et une salle.
 * 
 * @package TD3
 * @subpackage Class
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
declare(strict_types=1);

/**
 * Class Cours
 * 
 * Représente un cours dans le système avec toutes ses propriétés
 * et méthodes pour interagir avec la base de données.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
class Cours
{
    /** @var int|null Identifiant du cours */
    public ?int $rowid = null;

    /** @var string|null Date du cours */
    public ?string $date_cours = null;

    /** @var int|null ID de la matière */
    public ?int $fk_matiere = null;

    /** @var int|null ID de l’enseignant */
    public ?int $fk_enseignant = null;

    /** @var string|null Groupe TD */
    public ?string $groupe_td = null;

    /** @var string|null Groupe TP */
    public ?string $groupe_tp = null;

    /** @var string|null Salle */
    public ?string $salle = null;

    /** @var string|null Nom affiché de la matière */
    public ?string $matiere_name = null;

    /** @var string|null Nom affiché de l’enseignant */
    public ?string $enseignant_name = null;

    /**
     * Constructeur de la classe Cours
     * 
     * Initialise un objet Cours avec les données fournies en paramètre.
     * Seules les propriétés existantes sont assignées.
     * 
     * @param array<string, mixed> $data Tableau associatif contenant les données du cours
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    /**
     * Établit une connexion PDO à la base de données
     * 
     * Creates et retourne une instance PDO configurée pour la base de données r301project.
     * 
     * @return PDO Instance PDO configurée
     * @throws PDOException Si la connexion à la base de données échoue
     * @author Kime Marwa
     * @since November 2, 2025
     */
    private static function getPDO(): PDO
    {
        $host = 'localhost';
        $dbname = 'r301project';
        $user = 'simpleuser';
        $pass = 'simplepass';
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    /**
     * Creates un nouveau cours dans la base de données
     * 
     * Insère un nouveau cours avec toutes ses informations dans la table mp_cours.
     * L'identifiant rowid est automatiquement assigné après l'insertion.
     * 
     * @return bool true si la création réussit
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function create(): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            INSERT INTO mp_cours (date_cours, fk_matiere, fk_enseignant, groupe_td, groupe_tp, salle)
            VALUES (:date_cours, :fk_matiere, :fk_enseignant, :groupe_td, :groupe_tp, :salle)
        ");
        $stmt->execute([
            ':date_cours' => $this->date_cours,
            ':fk_matiere' => $this->fk_matiere,
            ':fk_enseignant' => $this->fk_enseignant,
            ':groupe_td' => $this->groupe_td,
            ':groupe_tp' => $this->groupe_tp,
            ':salle' => $this->salle,
        ]);
        $this->rowid = (int)$pdo->lastInsertId();
        return true;
    }

    /**
     * Retrieves tous les cours de la base de données
     * 
     * Retourne une liste de tous les cours avec les informations associées
     * (nom de la matière et nom de l'enseignant) triés par date décroissante.
     * 
     * @return array<Cours> Tableau d'objets Cours
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function fetchAll(): array
    {
        $pdo = self::getPDO();
        $sql = "
            SELECT c.*, 
                   m.name AS matiere_name, 
                   CONCAT(e.firstname, ' ', e.lastname) AS enseignant_name
            FROM mp_cours c
            LEFT JOIN mp_matieres m ON c.fk_matiere = m.rowid
            LEFT JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
            ORDER BY c.date_cours DESC
        ";
        $stmt = $pdo->query($sql);
        return array_map(fn($r) => new Cours($r), $stmt->fetchAll());
    }

    /**
     * Recherche dynamique de cours selon des critères
     * 
     * Permet de rechercher des cours avec des critères multiples.
     * Les recherches sont effectuées en insensible à la casse avec LIKE.
     * 
     * @param array<string, string> $criteria Tableau associatif des critères de recherche
     *                                        (ex: ['salle' => 'A101', 'groupe_td' => 'TD1'])
     * @return array<Cours> Tableau d'objets Cours correspondant aux critères
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function find(array $criteria = []): array
    {
        $pdo = self::getPDO();
        $where = [];
        $params = [];

        foreach ($criteria as $k => $v) {
            $where[] = "LOWER($k) LIKE LOWER(:$k)";
            $params[":$k"] = "%$v%";
        }

        $sql = "
            SELECT c.*, 
                   m.name AS matiere_name,
                   CONCAT(e.firstname, ' ', e.lastname) AS enseignant_name
            FROM mp_cours c
            LEFT JOIN mp_matieres m ON c.fk_matiere = m.rowid
            LEFT JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
        ";

        if ($where) $sql .= " WHERE " . implode(" AND ", $where);
        $sql .= " ORDER BY c.date_cours DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return array_map(fn($r) => new Cours($r), $stmt->fetchAll());
    }

    /**
     * Retrieves un cours par son identifiant
     * 
     * Recherche un cours dans la base de données en utilisant son rowid.
     * 
     * @param int $id Identifiant unique du cours
     * @return Cours|null Le cours trouvé ou null si aucun résultat
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function fetch(int $id): ?Cours
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM mp_cours WHERE rowid = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ? new Cours($row) : null;
    }

    /**
     * Met à jour les informations du cours dans la base de données
     * 
     * Met à jour toutes les propriétés du cours. Le cours doit avoir un rowid valide.
     * 
     * @return bool true si la update réussit
     * @throws Exception Si le rowid est manquant
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function update(): bool
    {
        if (!$this->rowid) throw new Exception("Rowid manquant pour la update");

        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            UPDATE mp_cours 
            SET date_cours = :date_cours,
                fk_matiere = :fk_matiere,
                fk_enseignant = :fk_enseignant,
                groupe_td = :groupe_td,
                groupe_tp = :groupe_tp,
                salle = :salle
            WHERE rowid = :id
        ");
        return $stmt->execute([
            ':date_cours' => $this->date_cours,
            ':fk_matiere' => $this->fk_matiere,
            ':fk_enseignant' => $this->fk_enseignant,
            ':groupe_td' => $this->groupe_td,
            ':groupe_tp' => $this->groupe_tp,
            ':salle' => $this->salle,
            ':id' => $this->rowid
        ]);
    }

    /**
     * Supprime le cours de la base de données
     * 
     * Supprime le cours correspondant à l'identifiant rowid de l'objet.
     * 
     * @return bool true si la suppression réussit
     * @throws Exception Si le rowid est manquant
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function delete(): bool
    {
        if (!$this->rowid) throw new Exception("Rowid manquant pour suppression");
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("DELETE FROM mp_cours WHERE rowid = :id");
        return $stmt->execute([':id' => $this->rowid]);
    }
}
