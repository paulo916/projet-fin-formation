<?php

/**
 * Mini-framework écrit en PHP orienté objet (POO) permettant de se connecter à une BDD MySQL/MariaDB, SQL Server ou PostgreSQL et de gérer uneseule connexion, d'où son nom : SINGLETON
 */

class Singleton
{
    // Attributs statiques de la classe
    private static $engine;
    private static $host;
    private static $port;
    private static $dbname;
    private static $user;
    private static $pass;
    private static $dsn;
    private static $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    private static $cnn = null;

    // Constantes de classe
    const MYSQL = 'MY';
    const MSSQL = 'MS';
    const PGSQL = 'PG';

    /**
     * Constructeur : vide pour interdire la création de plusieurs instances
     */
    public function __construct()
    {
    }

    /**
     * Méthode permettant de passer les paramètres de connexion à la classe en cours
     * @param string $newEngine Moteur de BDD choisi entre MySQL/MariaDB, SQL Server ou PostgreSQL
     * @param string $newHost Nom ou adresse IP du serveur de BDD
     * @param int $newPort Port d'écoute du serveur de BDD
     * @param string $newDbname Nom de la BDD à laquelle se connecter
     * @param string $newUser Identifiant de connexion à la BDD
     * @param string $newPass Mot de passe de connexion à la BDD
     * @param array $newOptions OPtions de connexion à la BDD
     */

    public static function setConfig(string $newEngine, string $newHost, int $newPort, string $newDbname, string $newUser, string $newPass, array $newOptions = array())
    {
        self::$engine = $newEngine;
        self::$host = $newHost;
        self::$port = $newPort;
        self::$dbname = $newDbname;
        self::$user = $newUser;
        self::$pass = $newPass;
        self::$options += $newOptions;
    }

    /**
     * Méthode qui valide si une configuration de connexion est disponible ou non
     * @return bool Renvoie TRUE si un moteur, un serveur de BDD, un port et une BDD sont définis, FALSE sinon
     */
    public static function hasConfig(): bool
    {
        if (self::$engine && self::$host && self::$port && self::$dbname) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Méthode qui renvoie une connexion unique à la BDD
     * @return PDO Objet PDO de connexion à la BDD
     */
    public static function getPDO(): PDO
    {
        // Vérifie si une connexion est déjà active ou non
        if (!self::$cnn) {
            // Vérifie si une config est déjà dispo ou non
            if (self::hasConfig()) {
                // Teste le moteur de BDD
                switch (strtoupper(self::$engine)) {
                    case self::MSSQL:
                        self::$dsn = 'sqlsrv:Server=%s,%d;Database=%s';
                        break;
                    case self::MYSQL:
                        self::$dsn = 'mysql:host=%s;port=%d;dbname=%s;charset=utf8';
                        break;
                    case self::PGSQL:
                        self::$dsn = 'pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s;charset=utf8';
                        break;
                    default:
                        throw new Exception('Utiliser les valeurs suivantes pour le moteur de BDD : ' . self::MSSQL . ', ' . self::MYSQL . ', ' . self::PGSQL);
                }
                // Génère la connexion vers le moteur de BDD choisi
                try {
                    switch (self::$engine) {
                        case self::MSSQL:
                        case self::MYSQL:
                            self::$cnn = new PDO(sprintf(self::$dsn, self::$host, self::$port, self::$dbname), self::$user, self::$pass, self::$options);
                            break;
                        case self::PGSQL:
                            self::$cnn = new PDO(sprintf(self::$dsn, self::$host, self::$port, self::$dbname, self::$user, self::$pass), null, null, self::$options);
                            break;
                        default:
                            throw new Exception('Erreur ' . __CLASS__ . ' : Connexion au serveur de BDD impossible');
                    }
                } catch (PDOException $err) {
                    throw new PDOException('Erreur ' . __CLASS__ . ' : ' . $err->getMessage());
                }
            } else {
                throw new Exception('Erreur ' . __CLASS__ . ' : Créer une configuration avec setConfig() pour se connecter');
            }
        }
        return self::$cnn;
    }

    /**
     * Destructeur : déconnexion
     */
    public function __destruct()
    {
        if (!self::$cnn) {
            self::$cnn = null; // Pas d'unset sur une variable statique
        }
    }

    /**
     * Interdit le clônage de cette classe pour garder une connexion unique
     */
    public function __clone()
    {
        throw new Exception('Erreur ' . __CLASS__ . ' : Clônage de cette classe interdit');
    }

    /**
     * Méthode qui renvoie le résultat d'une requête SELECT sous
     * la forme d'un tableau associatif
     */
    public static function getData(string $sql, array $params = array()): array
    {
        try {
            $qry = self::$cnn->prepare($sql);
            $qry->execute($params);
            return $qry->fetchAll();
        } catch (PDOException $err) {
            throw new PDOException('Erreur PDO : ' . $err->getMessage());
        }
    }

    /** 
     * Méthode qui renvoie le résultat d'une requête SELECT sous
     * la forme d'un objet JSON
     * @param string $sql requête SQL de type SELECT
     * @param array $param tableau de paramètres pour requête préparée
     */
    public static function getJSON(string $sql, array $params = array()): string
    {
        $data = self::getData($sql, $params);
        return json_encode($data);
    }

    /**
     * Méthode qui renvoie le résultat d'une requête SELECT sous
     * la forme d'un élément HTML TABLE
     * @param string $id id de l'élément HTML TABLE
     * @param string $sql requête SQL de type SELECT
     * @param array $param tableau de paramètres pour requête préparée
     * @param array $crud tableau associatif contenant le nom de la table (t) et sa clé primaire (k)
     * @return string code HTML du TABLE
     */
    public static function makeTable(string $id, string $sql, array $params = array(), array $crud = array()): string
    {
        try {
            // Teste si requête SQL commence par SELECT ou SHOW
            $html = '';
            $stmt = explode(' ', strtolower($sql));
            if ($stmt[0] === 'select' || $stmt[0] === 'show') {
                // Requête SQL
                $qry = self::$cnn->prepare($sql);
                $qry->execute($params);

                // Génère l'élément HTML TABLE
                $html .= '<table id="' . $id . '" class="table table-striped table-hover">';
                // En-tête du tableau HTML
                $html .= '<thead class="thead-dark"><tr>';
                for ($i = 0; $i < $qry->columnCount(); $i++) {
                    $meta = $qry->getColumnMeta($i);
                    $html .= '<th>' . strtoupper($meta['name']) . '</th>';
                }
                if (!empty($crud)) {
                    $html .= '<th>&nbsp;</th>';
                }
                $html .= '</tr></thead><tbody>';
                // Corps du tableau HTML
                while ($row = $qry->fetch()) {
                    $html .= '<tr>';
                    foreach ($row as $val) {
                        // $html .= '<td>' . $val . '</td>';
                        $html .= "<td>$val</td>";
                    }
                    // Boutons C, U et D (CRUD)
                    if (!empty($crud)) {
                        $html .=
                            '<td>
                                <a href="edit.php?t=' . $crud['t'] . '&k=' . $crud['k'] . '&v=" class="btn btn-success btn-sm">C</a>
                                <a href="edit.php?t=' . $crud['t'] . '&k=' . $crud['k'] . '&v=' . $row[$crud['k']] . '" class="btn btn-warning btn-sm">U</a>
                                <a href="delete.php?t=' . $crud['t'] . '&k=' . $crud['k'] . '&v=' . $row[$crud['k']] . '" class="btn btn-danger btn-sm btnDel">D</a>
                            </td>';
                    }
                    $html .= '</tr>';
                }
                $html .= '</tbody></table>';
                return $html;
            } else {
                throw new Exception('Erreur ' . __CLASS__ . ' : La requête SQL doit commencer par SELECT ou SHOW.');
            }
        } catch (PDOException $err) {
            throw new PDOException('Erreur PDO : ' . $err->getMessage());
        }
    }

    /**
     * Méthode qui renvoie le résultat d'une requête SELECT sous 
     * la forme d'un élément HTML SELECT
     * @param string $id id/name de l'élément HTML SELECT
     * @param string $sql requête SQL de type SELECT
     * @param array $params tableau de paramètres pour requête préparée
     * @return string code HTML du SELECT/OPTIONS
     */
    public static function makeSelect(string $id, string $sql, array $params = array(), bool $multiple = false): string
    {
        try {
            // Requête SQL
            $qry = self::$cnn->prepare($sql);
            $qry->execute($params);

            // Génère l'élément HTML SELECT
            $html = '';
            if ($qry->rowCount() > 0) {
                $html .= '<select class="form-control" id="' . $id . '" name="' . $id . '"' . ($multiple ? ' multiple size="3"' : '') . '>';
                while ($row = $qry->fetch(PDO::FETCH_NUM)) {
                    if ($qry->columnCount() === 1) {
                        $html .= '<option value="' . $row[0] . '">' . $row[0] . '</option>';
                    } else {
                        $html .= '<option value="' . $row[0] . '">' . $row[1] . '</option>';
                    }
                }
                $html .= '</select>';
            }
            return $html;
        } catch (PDOException $err) {
            throw new PDOException('Erreur PDO : ' . $err->getMessage());
        }
    }

    /**
     * Méthode qui génère un élément HTML FORM à partir d'une requête SELECT qui
     * renvoie UNE SEULE LIGNE
     * @param string $t table
     * @param string $k colonne clé primaire
     * @param string $v valeur de la clé primaire
     * @return string
     */
    public static function makeForm(string $t, string $k, string $v = null): string
    {
        $html = '';
        // Teste si create ou update
        if ($v) {
            $data = self::getData('SELECT * FROM ' . $t . ' WHERE ' . $k . '=?', array($v))[0];
        } else {
            $qry = self::$cnn->prepare('SELECT * FROM ' . $t . ' WHERE 1=2');
            $qry->execute();
            for ($i = 0; $i < $qry->columnCount(); $i++) {
                $meta = $qry->getColumnMeta($i);
                $data[$meta['name']] = null;
            }
        }

        // Génération dynamique du formulaire avec Bootstrap
        $html .= '<form method="post" action="save.php?t=' . $t . '&k=' . $k . '&v=' . $v . '">';
        foreach ($data as $key => $val) {
            $html .=
                '<div class="form-group">
                <label for="' . $key . '">' . strtoupper($key) . '</label>
                <input type="text" class="form-control" id="' . $key . '" name="' . $key . '" value="' . $val . '">
                </div>';
        }
        $html .= '<input type="submit" class="btn btn-primary" value="Enregistrer">';
        $html .= '</form>';
        return $html;
    }

    /**
     * Méthode qui renvoie TRUE si la table passée en paramètre existe
     * dans le schéma passé en paramètre, FALSE sinon 
     * @param string $table nom de la table
     * @param string $schema nom du schéma/bdd
     * @return bool
     */
    public static function tableExists(string $table, string $schema): bool
    {
        if (self::hasConfig()) {
            switch (self::$engine) {
                case self::MSSQL:
                    return (bool) self::getData("IF OBJECT_ID (N'?', N'U') IS NOT NULL SELECT 1 AS nb ELSE SELECT 0 AS nb", array($table))[0]['nb'];
                    break;
                case self::MYSQL:
                    return (bool) self::getData('select count(*) AS nb from information_schema.tables where table_schema=? and table_name=?', array($schema, $table))[0]['nb'];
                    break;
                case self::PGSQL:
                    return (bool) self::getData("SELECT to_regclass('?.?') AS nb", array($schema, $table))[0]['nb'];
                    break;
                default:
                    throw new Exception('Erreur ' . __CLASS__ . ' : Moteur de BDD non spécifié');
            }
        }
    }
}

// IF OBJECT_ID (N'mytablename', N'U') IS NOT NULL SELECT 1 AS res ELSE SELECT 0 AS res;
// SELECT to_regclass('schema_name.table_name');