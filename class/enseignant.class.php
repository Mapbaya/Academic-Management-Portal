<?php
/**
 * Classe permettant de gérer l'entité Enseignant
 * 
 * Cette classe gère les opérations CRUD (Create, Read, Update, Delete) sur les enseignants.
 * Elle permet également de créer l'utilisateur associé lors de la création d'un enseignant.
 * 
 * @package TD3
 * @subpackage Class
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
declare(strict_types=1);

/**
 * Classe Enseignant
 * 
 * Représente un enseignant dans le système avec toutes ses propriétés
 * et méthodes pour interagir avec la base de données.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
class Enseignant
{
    /** @var int|null Identifiant unique de l'enseignant dans la base de données */
    private ?int $rowid = null;
    
    /** @var string|null Prénom de l'enseignant */
    private ?string $firstname = null;
    
    /** @var string|null Nom de famille de l'enseignant */
    private ?string $lastname = null;
    
    /** @var string|null Date de naissance de l'enseignant (format YYYY-MM-DD) */
    private ?string $birthday = null;
    
    /** @var string|null Adresse postale */
    private ?string $adress = null;
    
    /** @var string|null Code postal */
    private ?string $zipcode = null;
    
    /** @var string|null Ville */
    private ?string $town = null;
    
    /** @var int|null Identifiant de l'utilisateur associé dans la table mp_users */
    private ?int $fk_user = null;

    /**
     * Constructeur de la classe Enseignant
     * 
     * Initialise un objet Enseignant avec les données fournies en paramètre.
     * Seules les propriétés existantes sont assignées.
     * 
     * @param array<string, mixed> $data Tableau associatif contenant les données de l'enseignant
     * @author Kime Marwa
     * @since 2 novembre 2025
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
     * @return mixed Valeur de l'attribut ou null si inexistant
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public function __get(string $att) { return $this->$att ?? null; }
    
    /**
     * Méthode magique pour définir la valeur d'une propriété
     * 
     * Permet de modifier les propriétés privées de la classe.
     * 
     * @param string $att Nom de la propriété à modifier
     * @param mixed $val Valeur à assigner à la propriété
     * @return void
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public function __set(string $att, $val) { $this->$att = $val; }

    /**
     * Établit une connexion PDO à la base de données
     * 
     * Crée et retourne une instance PDO configurée pour la base de données r301project.
     * 
     * @return PDO Instance PDO configurée
     * @throws PDOException Si la connexion à la base de données échoue
     * @author Kime Marwa
     * @since 2 novembre 2025
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
     * Crée un nouvel enseignant et son utilisateur associé
     * 
     * Cette méthode effectue une transaction pour créer simultanément :
     * - Un utilisateur dans la table mp_users
     * - Un enseignant dans la table mp_enseignants
     * 
     * La transaction garantit que les deux créations sont atomiques.
     * 
     * @param string $username Nom d'utilisateur pour le compte associé
     * @param string $password Mot de passe en clair (sera hashé en MD5)
     * @return bool true si la création réussit
     * @throws Exception Si le nom d'utilisateur existe déjà ou si une erreur survient
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public function create(string $username, string $password): bool
    {
        $pdo = self::getPDO();
        try {
            $pdo->beginTransaction();

            // Vérifie si le user existe déjà
            $stmt = $pdo->prepare("SELECT rowid FROM mp_users WHERE username=:u");
            $stmt->execute([':u'=>$username]);
            if ($stmt->fetch()) throw new Exception("Nom d'utilisateur déjà pris");

            // Création user
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

            // Création enseignant
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
     * Récupère un enseignant par son identifiant ou son identifiant utilisateur
     * 
     * Recherche un enseignant dans la base de données en utilisant soit son rowid (identifiant),
     * soit son fk_user (identifiant utilisateur). Si la valeur est numérique, la recherche se fait par rowid,
     * sinon par fk_user.
     * 
     * @param int|string $idOrNum Identifiant (int) ou identifiant utilisateur (string)
     * @return Enseignant|null L'enseignant trouvé ou null si aucun résultat
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
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
     * Récupère tous les enseignants de la base de données
     * 
     * Retourne une liste de tous les enseignants triés par nom de famille puis par prénom.
     * 
     * @return array<Enseignant> Tableau d'objets Enseignant
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
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
     * Permet de rechercher des enseignants avec des critères multiples.
     * Les recherches sont effectuées en insensible à la casse avec LIKE.
     * 
     * @param array<string, string> $criteria Tableau associatif des critères de recherche
     *                                        (ex: ['firstname' => 'Jean', 'town' => 'Lille'])
     * @return array<Enseignant> Tableau d'objets Enseignant correspondant aux critères
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
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
     * Met à jour les informations de l'enseignant dans la base de données
     * 
     * Met à jour toutes les propriétés de l'enseignant (sauf rowid et fk_user).
     * L'enseignant doit avoir un rowid valide.
     * 
     * @return bool true si la mise à jour réussit
     * @throws Exception Si le rowid est manquant
     * @throws PDOException Si une erreur de base de données survient
     * @author Kime Marwa
     * @since 2 novembre 2025
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
     * Supprime l'enseignant de la base de données
     * 
     * Supprime l'enseignant et optionnellement l'utilisateur associé.
     * L'opération est effectuée dans une transaction pour garantir la cohérence.
     * 
     * @param bool $deleteUser Si true, supprime également l'utilisateur associé (par défaut: true)
     * @return bool true si la suppression réussit
     * @throws Exception Si le rowid est manquant
     * @throws Exception Si une erreur survient lors de la suppression
     * @author Kime Marwa
     * @since 2 novembre 2025
     */
    public function delete(bool $deleteUser=true): bool
    {
        if (!$this->rowid) throw new Exception("Rowid manquant pour suppression");
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
     * Retourne toutes les propriétés de l'enseignant sous forme de tableau associatif.
     * Utile pour la sérialisation JSON ou le passage de données aux vues.
     * 
     * @return array<string, mixed> Tableau associatif contenant toutes les propriétés
     * @author Kime Marwa
     * @since 2 novembre 2025
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
