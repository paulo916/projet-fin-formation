<?php

/**
 * Mini-framework :
 * Classe permettant de se connecter à une BDD MySQL, PostgreSQL ou SQL Server
 */

class Database
{
    // Attributs privés
    private $engine;
    private $host;
    private $port;
    private $dbname;
    private $user;
    private $pass;
    private $cnn;
    private $dsn;
    private $connected = false;

    // Constantes de classe
    const MYSQL = 'MY';
    const MSSQL = 'MS';
    const PGSQL = 'PG';

    // Constructeur
    public function __construct(string $newEngine, string $newHost, int $newPort, string $newDbname, string $newUser, string $newPass)
    {
        // Assigne la valeur des paramètres aux attributs
        $this->setEngine($newEngine);
        $this->setHost($newHost);
        $this->setPort($newPort);
        $this->setDbname($newDbname);
        $this->setUser($newUser);
        $this->setPass($newPass);

        // Tente une connexion à la BDD passée en paramètre
        try {
            // Selon le moteur utilisé
            switch ($this->getEngine()) {
                case self::MSSQL:
                case self::MYSQL:
                    $this->cnn = new PDO(sprintf($this->dsn, $this->getHost(), $this->getPort(), $this->getDbname()), $this->getUser(), $this->getPass());
                    break;
                case self::PGSQL:
                    $this->cnn = new PDO(sprintf($this->dsn, $this->getHost(), $this->getPort(), $this->getDbname(), $this->getUser(), $this->getPass()));
                    break;
                default:
                    throw new PDOException('Erreur PDO : connexion impossible');
            }

            // Attributs de connexion
            $this->cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->cnn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->connected = true;
        } catch (PDOException $err) {
            throw new PDOException('Erreur PDO : ' . $err->getMessage());
        }
    }

    // Accesseurs
    public function getEngine(): string
    {
        return $this->engine;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getDbname(): string
    {
        return $this->dbname;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function getCnn()
    {
        return $this->cnn;
    }

    public function getConnected(): bool
    {
        return $this->connected;
    }

    // Mutateurs
    public function setEngine(string $newEngine)
    {
        switch (strtoupper($newEngine)) {
            case self::MSSQL:
                $this->engine = self::MSSQL;
                $this->dsn = 'sqlsrv:Server=%s,%d;Database=%s';
                break;
            case self::MYSQL:
                $this->engine = self::MYSQL;
                $this->dsn = 'mysql:host=%s;port=%d;dbname=%s;charset=utf8';
                break;
            case self::PGSQL:
                $this->engine = self::PGSQL;
                $this->dsn = 'pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s;charset=utf8';
                break;
            default:
                throw new Exception('Utiliser les valeurs suivantes : ' . self::MSSQL . ', ' . self::MYSQL . ', ' . self::PGSQL);
        }
    }

    public function setHost(string $newHost)
    {
        $this->host = $newHost;
    }

    public function setPort(int $newPort)
    {
        $this->port = $newPort;
    }

    public function setDbname(string $newDbname)
    {
        $this->dbname = $newDbname;
    }

    public function setUser(string $newUser)
    {
        $this->user = $newUser;
    }

    public function setPass(string $newPass)
    {
        $this->pass = $newPass;
    }

    // Méthodes publiques de la classe
    public function disconnect()
    {
        unset($this->cnn); // OU BIEN $this->cnn = null;
        $this->connected = false;
    }

    /**
     * Méthode qui renvoie le résultat d'une requête SELECT sous
     * la forme d'un tableau associatif
     */
    public function getData(string $sql, array $params = array()): array
    {
        try {
            $qry = $this->getCnn()->prepare($sql);
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
    public function getJSON(string $sql, array $params = array()): string
    {
        $data = $this->getData($sql, $params);
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
    public function makeTable(string $id, string $sql, array $params = array(), array $crud = array()): string
    {
        try {
            // Teste si requête SQL commence par SELECT ou SHOW
            $html = '';
            $stmt = explode(' ', strtolower($sql));
            if ($stmt[0] === 'select' || $stmt[0] === 'show') {
                // Requête SQL
                $qry = $this->getCnn()->prepare($sql);
                $qry->execute($params);

                // Génère l'élément HTML TABLE
                $html .= '<table id="' . $id . '" class="table table-striped table-hover">';
                // En-tête du tableau HTML
                $html .= '<thead class="thead-dark"><tr>';
                for ($i = 0; $i < $qry->columnCount(); $i++) {
                    $meta = $qry->getColumnMeta($i);
                    $html .= '<th>' . strtoupper($meta['name']) . '</th>';
                    $types[$meta['name']] = $meta['native_type']; // Type des colonnes
                }
                if (!empty($crud)) {
                    $html .= '<th>&nbsp;</th>';
                }
                $html .= '</tr></thead><tbody>';
                // Corps du tableau HTML
                while ($row = $qry->fetch()) {
                    $html .= '<tr>';
                    foreach ($row as $key => $val) {
                        if ($types[$key] === 'BLOB') {
                            if (strpos($val, 'data:image/') === 0) {
                                $html .= '<td><img src="' . $val . '" style="height:5rem"/></td>';
                            } else {
                                $html .= '<td>&nbsp;</td>';
                            }
                        } else {
                            // $html .= '<td>' . $val . '</td>';
                            $html .= "<td>$val</td>";
                        }
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
     * @param bool $multiple TRUE si le SELECT est multiple, FALSE sinon
     * @return string code HTML du SELECT/OPTIONS
     */
    public function makeSelect(string $id, string $sql, array $params = array(), bool $multiple = false): string
    {
        try {
            // Requête SQL
            $qry = $this->getCnn()->prepare($sql);
            $qry->execute($params);

            // Génère l'élément HTML SELECT
            $html = '';
            if ($qry->rowCount() > 0) { 
                $html .= '<select class="form-control" id="' . $id . '" name="' . $id . '" ' . ($multiple ? ' multiple size="3"' : '') . '>';
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
     * Méthode qui renvoie TRUE si la table passée en paramètre existe
     * dans le schéma passé en paramètre, FALSE sinon (MySQL/MariaDB seulement)
     * @param string $table nom de la table
     * @param string $schema nom du schéma/bdd
     * @return bool
     */
    public function tableExists(string $table, string $schema): bool
    {
        // $sql = 'select count(*) AS nb from information_schema.tables where table_schema=? and table_name=?';
        // $params = array($schema, $table);
        // $data = $this->getData($sql, $params);
        // return (bool) $data[0]['nb'];

        // Solution factorisée : 
        return (bool) $this->getData('select count(*) AS nb from information_schema.tables where table_schema=? and table_name=?', array($schema, $table))[0]['nb'];
    }

    /**
     * Méthode qui génère un élément HTML FORM à partir d'une requête SELECT qui
     * renvoie UNE SEULE LIGNE
     * @param string $t table
     * @param string $k colonne clé primaire
     * @param string $v valeur de la clé primaire
     * @return string
     */
    public function makeForm(string $t, string $k, string $v = null): string
    {
        $html = '';
        // Teste si create ou update
        if ($v) {
            $data = $this->getData('SELECT * FROM ' . $t . ' WHERE ' . $k . '=?', array($v))[0];
        } else {
            $qry = $this->getCnn()->prepare('SELECT * FROM ' . $t . ' WHERE 1=2');
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
}