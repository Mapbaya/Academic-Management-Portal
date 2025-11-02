<?php
/**
 * Class for managing l'entité Enseignant
 * 
 * Cette classe gère les opérations CRUD (Create, Read, Update, Delete) about enseignants.
 * Elle permet également de createsr the associated user lors de la création for a enseignant.
 * 
 * @package TD3
 * @subpackage Class
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
declare(strict_types=1);

/**
 * Class Enseignant
 * 
 * Represents a enseignant in the system with all its properties
 * et méthodes pour interagir avec la base de données.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
class Enseignant
{
    /** @var int|null Unique identifier of the teacher in the database */
    private ?int $rowid = null;
    
    /** @var string|null Prénom of the teacher */
    private ?string $firstname = null;
    
    /** @var string|null Nom de famille of the teacher */
    private ?string $lastname = null;
    
    /** @var string|null Date de naissance of the teacher (format YYYY-MM-DD) */
    private ?string $birthday = null;
    
    /** @var string|null Adresse postale */
    private ?string $adress = null;
    
    /** @var string|null Code postal */
    private ?string $zipcode = null;
    
    /** @var string|null Ville */
    private ?string $town = null;
    
    /** @var int|null Identifiant de the associated user dans la table mp_users */
    private ?int $fk_user = null;

    /**
     * Constructeur de la classe Enseignant
     * 
     * Initialise un objet Enseignant avec les données fournies en paramètre.
     * Only existing properties are assigned.
     * 
     * @param array<string, mixed> $data Tableau associatif contenant les données of the teacher
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
     * Magic method to access private properties
     * 
     * Allows reading private properties of the class.
     * 
     * @param string $att Nom de l'attribut à récupérer
     * @return mixed Valeur de l'attribut ou null si inexistant
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function __get(string $att) { return $this->$att ?? null; }
    
    /**
     * Méthode magique pour définir la valeur for ae propriété
     * 
     * Allows modifying private properties of the class.
     * 
     * @param string $att Name of the property to modify
     * @param mixed $val Valeur à assigner à la propriété
     * @return void
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function __set(string $att, $val) { $this->$att = $val; }

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
     * Creates un nouvel enseignant et son utilisateur associé
     * 
     * Cette méthode effectue une transaction pour createsr simultanément :
     * - Un utilisateur dans la table mp_users
     * - Un enseignant dans la table mp_enseignants
     * 
     * La transaction garantit que les deux créations sont atomiques.
     * 
     * @param string $username Username pour le compte associé
     * @param string $password Password in plain text (sera hashé en MD5)
     * @return bool true if creation succeeds
     * @throws Exception If username already exists or if an error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function create(string $username, string $password): bool
    {
        $pdo = self::getPDO();
        try {
            $pdo->beginTransaction();

            // Checks if the user already exists
            $stmt = $pdo->prepare("SELECT rowid FROM mp_users WHERE username=:u");
            $stmt->execute([':u'=>$username]);
            if ($stmt->fetch()) throw new Exception("Username déjà pris");

            // Create user
            $stmt = $pdo->prepare("
                INSERT INTO mp_users (username,password,firstname,lastname,date_created,admin)
                VALUES (:u,:p,:f,:l,NOW(),0)
            ");
            $stmt->execute([
                ':u'=>$username,
                ':p'=>md5($password),
                ':f'=>$this->firstname,
                ':l'=>$this->lastname
            ]);
            $fk_user = (int)$pdo->lastInsertId();

            // Create teacher
            $stmt = $pdo->prepare("
                INSERT INTO mp_enseignants (firstname,lastname,birthday,adress,zipcode,town,fk_user)
                VALUES (:f,:l,:b,:a,:z,:t,:u)
            ");
            $stmt->execute([
                ':f'=>$this->firstname,
                ':l'=>$this->lastname,
                ':b'=>$this->birthday,
                ':a'=>$this->adress,
                ':z'=>$this->zipcode,
                ':t'=>$this->town,
                ':u'=>$fk_user
            ]);

            $this->rowid = (int)$pdo->lastInsertId();
            $this->fk_user = $fk_user;

            $pdo->commit();
            return true;

        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Retrieves un enseignant par son identifiant ou son identifiant utilisateur
     * 
     * Recherche un enseignant in the database en utilisant soit son rowid (identifiant),
     * soit son fk_user (identifiant utilisateur). Si la valeur est numérique, la recherche se fait par rowid,
     * sinon par fk_user.
     * 
     * @param int|string $idOrNum Identifiant (int) ou identifiant utilisateur (string)
     * @return Enseignant|null L'enseignant trouvé ou null si aucun résultat
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function fetch(int|string $idOrNum): ?Enseignant
    {
        $pdo = self::getPDO();
        $sql = is_numeric($idOrNum) ? 
            "SELECT * FROM mp_enseignants WHERE rowid=:id" :
            "SELECT * FROM mp_enseignants WHERE fk_user=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id'=>$idOrNum]);
        $row = $stmt->fetch();
        return $row ? new Enseignant($row) : null;
    }

    /**
     * Retrieves tous les enseignants de la base de données
     * 
     * Retourne une liste de tous les enseignants triés par nom de famille puis par prénom.
     * 
     * @return array<Enseignant> Array of objects Enseignant
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function fetchAll(): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query("SELECT * FROM mp_enseignants ORDER BY lastname, firstname");
        return array_map(fn($r)=>new Enseignant($r), $stmt->fetchAll());
    }

    /**
     * Recherche dynamique d'enseignants selon des critères
     * 
     * Permet de rechercher of teachers avec des critères multiples.
     * Les recherches sont effectuées en insensible à la casse avec LIKE.
     * 
     * @param array<string, string> $criteria Associative array of search criteria de recherche
     *                                        (ex: ['firstname' => 'Jean', 'town' => 'Lille'])
     * @return array<Enseignant> Array of objects Enseignant correspondant aux critères
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function find(array $criteria=[]): array
    {
        $pdo = self::getPDO();
        $where = []; $params=[];
        foreach ($criteria as $k=>$v) {
            $where[] = "LOWER($k) LIKE LOWER(:$k)";
            $params[":$k"] = "%$v%";
        }
        $sql = "SELECT * FROM mp_enseignants";
        if ($where) $sql .= " WHERE ".implode(" AND ",$where);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return array_map(fn($r)=>new Enseignant($r), $stmt->fetchAll());
    }

    /**
     * Met à jour les informations of the teacher in the database
     * 
     * Updates all properties of the teacher (except rowid and fk_user).
     * L'enseignant doit avoir un rowid valide.
     * 
     * @return bool true if update succeeds
     * @throws Exception If rowid is missing
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function update(): bool
    {
        if (!$this->rowid) throw new Exception("Rowid manquant pour update");
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("
            UPDATE mp_enseignants SET
                firstname=:f, lastname=:l, birthday=:b, adress=:a, zipcode=:z, town=:t
            WHERE rowid=:id
        ");
        return $stmt->execute([
            ':f'=>$this->firstname,
            ':l'=>$this->lastname,
            ':b'=>$this->birthday,
            ':a'=>$this->adress,
            ':z'=>$this->zipcode,
            ':t'=>$this->town,
            ':id'=>$this->rowid
        ]);
    }

    /**
     * Deletes the teacher from the database
     * 
     * Deletes the teacher and optionally the associated user.
     * The operation is performed in a transaction to ensure consistency.
     * 
     * @param bool $deleteUser If true, also deletes the associated user (by default: true)
     * @return bool true if deletion succeeds
     * @throws Exception If rowid is missing
     * @throws Exception If an error occurs during deletion
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function delete(bool $deleteUser=true): bool
    {
        if (!$this->rowid) throw new Exception("Missing rowid for deletion");
        $pdo = self::getPDO();
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("DELETE FROM mp_enseignants WHERE rowid=:id");
            $stmt->execute([':id'=>$this->rowid]);
            if ($deleteUser && $this->fk_user) {
                $stmt = $pdo->prepare("DELETE FROM mp_users WHERE rowid=:uid");
                $stmt->execute([':uid'=>$this->fk_user]);
            }
            $pdo->commit();
            return true;
        } catch(Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Convertit l'objet Enseignant en tableau associatif
     * 
     * Returns all properties of the teacher as an associative array.
     * Utile pour la sérialisation JSON ou le passage de données aux vues.
     * 
     * @return array<string, mixed> Associative array containing all properties
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function toArray(): array
    {
        return [
            'rowid'=>$this->rowid,
            'firstname'=>$this->firstname,
            'lastname'=>$this->lastname,
            'birthday'=>$this->birthday,
            'adress'=>$this->adress,
            'zipcode'=>$this->zipcode,
            'town'=>$this->town,
            'fk_user'=>$this->fk_user
        ];
    }
}
