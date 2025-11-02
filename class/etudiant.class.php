<?php
/**
 * Class for managing l'entité Étudiant
 * 
 * Cette classe gère les opérations CRUD (Create, Read, Update, Delete) about étudiants.
 * Elle permet également de createsr the associated user lors de la création for a étudiant.
 * 
 * @package TD3
 * @subpackage Class
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
declare(strict_types=1);

/**
 * Class Étudiant
 * 
 * Représente un étudiant dans le système avec toutes ses propriétés
 * et méthodes pour interagir avec la base de données.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
class Etudiant
{
    /** @var int|null Unique identifier de l'étudiant in the database */
    private ?int $rowid = null;
    
    /** @var string|null Numéro d'étudiant unique */
    private ?string $numetu = null;
    
    /** @var string|null Prénom de l'étudiant */
    private ?string $firstname = null;
    
    /** @var string|null Nom de famille de l'étudiant */
    private ?string $lastname = null;
    
    /** @var string|null Date de naissance de l'étudiant (format YYYY-MM-DD) */
    private ?string $birthday = null;
    
    /** @var string|null Diplôme de l'étudiant (BUT, Licence Pro, Master) */
    private ?string $diploma = null;
    
    /** @var int|null Année d'étude */
    private ?int $year = null;
    
    /** @var string|null Groupe de travaux dirigés (TD) */
    private ?string $td = null;
    
    /** @var string|null Groupe de travaux pratiques (TP) */
    private ?string $tp = null;
    
    /** @var string|null Adresse postale */
    private ?string $adress = null;
    
    /** @var string|null Code postal */
    private ?string $zipcode = null;
    
    /** @var string|null Ville */
    private ?string $town = null;
    
    /** @var int|null Identifiant de the associated user dans la table mp_users */
    private ?int $fk_user = null;

    /**
     * Liste des diplômes disponibles
     * 
     * @var array<string> Liste des diplômes valides
     */
    public const DIPLOMAS = ['BUT', 'Licence Pro', 'Master'];

    /**
     * Constructeur de la classe Étudiant
     * 
     * Initialise un objet Étudiant avec les données fournies en paramètre.
     * Seules les propriétés existantes sont assignées.
     * 
     * @param array<string, mixed> $data Tableau associatif contenant les données de l'étudiant
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
     * Méthode magique pour accéder aux propriétés privées
     * 
     * Permet de lire les propriétés privées de la classe.
     * 
     * @param string $att Nom de l'attribut à récupérer
     * @return mixed Valeur de l'attribut
     * @throws Exception Si l'attribut n'existe pas
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function __get(string $att)
    {
        if (property_exists($this, $att)) {
            return $this->$att;
        }
        throw new Exception("Attribut $att inexistant");
    }

    /**
     * Méthode magique pour définir la valeur for ae propriété
     * 
     * Permet de modifier les propriétés privées de la classe.
     * 
     * @param string $att Nom de la propriété à modifier
     * @param mixed $val Valeur à assigner à la propriété
     * @return void
     * @throws Exception Si l'attribut n'existe pas
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function __set(string $att, $val)
    {
        if (property_exists($this, $att)) {
            $this->$att = $val;
            return;
        }
        throw new Exception("Attribut $att inexistant");
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
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        return $pdo;
    }

    /**
     * Creates un nouvel étudiant et son utilisateur associé
     * 
     * Cette méthode effectue une transaction pour createsr simultanément :
     * - Un utilisateur dans la table mp_users
     * - Un étudiant dans la table mp_etudiants
     * 
     * La transaction garantit que les deux créations sont atomiques.
     * 
     * @param string $username Username pour le compte associé
     * @param string $password Password in plain text (sera hashé en MD5)
     * @return bool true si la création réussit
     * @throws Exception Si le nom d'utilisateur existe déjà ou si une erreur survient
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function create(string $username, string $password): bool
    {
        $pdo = self::getPDO();
        try {
            $pdo->beginTransaction();

            // Checks si le user existe déjà
            $stmt = $pdo->prepare("SELECT rowid FROM mp_users WHERE username = :u");
            $stmt->execute([':u' => $username]);
            if ($stmt->fetch()) {
                throw new Exception("Username déjà pris");
            }

            // Création user
            $sqlUser = "INSERT INTO mp_users (username, password, firstname, lastname, date_created, admin)
                        VALUES (:u, :p, :f, :l, NOW(), 0)";
            $stmt = $pdo->prepare($sqlUser);
            $stmt->execute([
                ':u' => $username,
                ':p' => md5($password), // selon consigne du TD
                ':f' => $this->firstname,
                ':l' => $this->lastname
            ]);
            $fk_user = (int)$pdo->lastInsertId();

            // Création étudiant
            $sqlEt = "INSERT INTO mp_etudiants (numetu, firstname, lastname, birthday, diploma, year, td, tp, adress, zipcode, town, fk_user)
                      VALUES (:numetu, :firstname, :lastname, :birthday, :diploma, :year, :td, :tp, :adress, :zipcode, :town, :fk_user)";
            $stmt = $pdo->prepare($sqlEt);
            $stmt->execute([
                ':numetu' => $this->numetu,
                ':firstname' => $this->firstname,
                ':lastname' => $this->lastname,
                ':birthday' => $this->birthday,
                ':diploma' => $this->diploma,
                ':year' => $this->year,
                ':td' => $this->td,
                ':tp' => $this->tp,
                ':adress' => $this->adress,
                ':zipcode' => $this->zipcode,
                ':town' => $this->town,
                ':fk_user' => $fk_user
            ]);

            $this->rowid = (int)$pdo->lastInsertId();
            $this->fk_user = $fk_user;

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    /**
     * Retrieves un étudiant par son identifiant ou son numéro d'étudiant
     * 
     * Recherche un étudiant in the database en utilisant soit son rowid (identifiant),
     * soit son numetu (numéro d'étudiant). Si la valeur est numérique, la recherche se fait par rowid,
     * sinon par numetu.
     * 
     * @param int|string $idOrNum Identifiant (int) ou numéro d'étudiant (string)
     * @return Etudiant|null L'étudiant trouvé ou null si aucun résultat
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function fetch(int|string $idOrNum): ?Etudiant
    {
        $pdo = self::getPDO();
        if (is_numeric($idOrNum)) {
            $sql = "SELECT * FROM mp_etudiants WHERE rowid = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => (int)$idOrNum]);
        } else {
            $sql = "SELECT * FROM mp_etudiants WHERE numetu = :n";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':n' => $idOrNum]);
        }

        $row = $stmt->fetch();
        return $row ? new Etudiant($row) : null;
    }

    /**
     * Retrieves tous les étudiants de la base de données
     * 
     * Retourne une liste de tous les étudiants triés par nom de famille puis par prénom.
     * 
     * @return array<Etudiant> Array of objects Etudiant
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public static function fetchAll(): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query("SELECT * FROM mp_etudiants ORDER BY lastname, firstname");
        $rows = $stmt->fetchAll();
        return array_map(fn($r) => new Etudiant($r), $rows);
    }

    /**
     * Recherche dynamique d'étudiants selon des critères
     * 
     * Permet de rechercher des étudiants avec des critères multiples.
     * Les valeurs contenant '%' sont traitées comme des recherches LIKE (pattern matching),
     * sinon comme des comparaisons d'égalité exacte.
     * 
     * @param array<string, string> $criteria Associative array of search criteria de recherche
     *                                        (ex: ['firstname' => 'Jean', 'year' => '1'])
     * @return array<Etudiant> Array of objects Etudiant correspondant aux critères
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
            if (str_contains($v, '%')) {
                $where[] = "$k LIKE :$k";
            } else {
                $where[] = "$k = :$k";
            }
            $params[":$k"] = $v;
        }
        $sql = "SELECT * FROM mp_etudiants";
        if ($where) $sql .= " WHERE " . implode(' AND ', $where);
        $sql .= " ORDER BY lastname, firstname";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();
        return array_map(fn($r) => new Etudiant($r), $rows);
    }

    /**
     * Met à jour les informations de l'étudiant in the database
     * 
     * Met à jour toutes les propriétés de l'étudiant (sauf rowid et fk_user).
     * L'étudiant doit avoir un rowid valide.
     * 
     * @return bool true si la update réussit
     * @throws Exception Si le rowid est manquant
     * @throws PDOException If a database error occurs
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function update(): bool
    {
        if (!$this->rowid) throw new Exception("Rowid manquant pour update");

        $pdo = self::getPDO();
        $sql = "UPDATE mp_etudiants SET
                    numetu=:numetu,
                    firstname=:firstname,
                    lastname=:lastname,
                    birthday=:birthday,
                    diploma=:diploma,
                    year=:year,
                    td=:td,
                    tp=:tp,
                    adress=:adress,
                    zipcode=:zipcode,
                    town=:town
                WHERE rowid=:id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':numetu' => $this->numetu,
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':birthday' => $this->birthday,
            ':diploma' => $this->diploma,
            ':year' => $this->year,
            ':td' => $this->td,
            ':tp' => $this->tp,
            ':adress' => $this->adress,
            ':zipcode' => $this->zipcode,
            ':town' => $this->town,
            ':id' => $this->rowid
        ]);
    }

    /**
     * Supprime l'étudiant de la base de données
     * 
     * Supprime l'étudiant et optionnellement the associated user.
     * L'opération est effectuée dans une transaction pour garantir la cohérence.
     * 
     * @param bool $deleteUser Si true, deletes également the associated user (by default: true)
     * @return bool true si la suppression réussit
     * @throws Exception Si le rowid est manquant
     * @throws Exception Si une erreur survient during deletion
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function delete(bool $deleteUser = true): bool
    {
        if (!$this->rowid) throw new Exception("Rowid manquant pour suppression");

        $pdo = self::getPDO();
        try {
            $pdo->beginTransaction();

            // Supprime étudiant
            $stmt = $pdo->prepare("DELETE FROM mp_etudiants WHERE rowid=:id");
            $stmt->execute([':id' => $this->rowid]);

            // Supprime utilisateur associé
            if ($deleteUser && $this->fk_user) {
                $stmt = $pdo->prepare("DELETE FROM mp_users WHERE rowid=:uid");
                $stmt->execute([':uid' => $this->fk_user]);
            }

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Convertit l'objet Étudiant en tableau associatif
     * 
     * Retourne toutes les propriétés de l'étudiant sous forme de tableau associatif.
     * Utile pour le sérialisation JSON ou le passage de données aux vues.
     * 
     * @return array<string, mixed> Tableau associatif contenant toutes les propriétés
     * @author Kime Marwa
     * @since November 2, 2025
     */
    public function toArray(): array
    {
        return [
            'rowid' => $this->rowid,
            'numetu' => $this->numetu,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'birthday' => $this->birthday,
            'diploma' => $this->diploma,
            'year' => $this->year,
            'td' => $this->td,
            'tp' => $this->tp,
            'adress' => $this->adress,
            'zipcode' => $this->zipcode,
            'town' => $this->town,
            'fk_user' => $this->fk_user
        ];
    }
}
