<?php
include_once('database.class.php');

final class Model extends Database
{
    // Attributs de la classe
    private $db = null;
    private $table = '';

    /**
     * Constructeur de la classe
     * @param string $engine moteur de la BDD : MY, MS ou PG
     * @param string $host serveur de la BDD
     * @param int $port port d'écoute du serveur de la BDD
     * @param string $dbname nom de la BDD
     * @param string $user utilisateur pour connexion
     * @param string $pass mot de passe pour connexion
     * @param string $table une table de la BDD
     */
    public function __construct(string $engine, string $host, int $port, string $dbname, string $user, string $pass, string $table)
    {
        $this->setTable($table);
        $this->db = new Database($engine, $host, $port, $dbname, $user, $pass);
    }

    /**
     * Accesseurs/Mutateurs
     */

    public function getTable(): string
    {
        return $this->table;
    }

    public function setTable(string $newTable)
    {
        $this->table = $newTable;
    }

    /**
     * Méthode qui renvoie toutes les lignes de la table
     * @return array résultat de la requête sous la forme d'un tableau associatif
     */
    public function getRows(): array
    {
        try {
            $sql = 'SELECT * FROM ' . $this->getTable();
            return $this->db->getData($sql);
        } catch (PDOException $err) {
            throw new PDOException('Erreur ' . __CLASS__ . ' : ' . $err->getMessage());
        }
    }

    /**
     * Méthode qui renvoie une seule ligne de la table
     * @param string $pk colonne clé primaire
     * @param string $id valeur de la clé primaire
     * @return array
     */

    public function getRow(string $pk, string $id): array
    {
        try {
            $sql = 'SELECT * FROM ' . $this->getTable() . ' WHERE ' . $pk . '=?';
            $params = array($id);
            return $this->db->getData($sql, $params);
        } catch (PDOException $err) {
            throw new PDOException('Erreur ' . __CLASS__ . ' : ' . $err->getMessage());
        }
    }

    /**
     * Méthode qui supprime toutes les lignes dont le code est passé en paramètre dans un array
     * @param string $pk colonne clé primaire
     * @param array $ids tableau des valeurs de PK à supprimer
     * @return int nb de lignes supprimées
     */
    public function delete(string $pk, array $ids = array()): int
    {
        try {
            if (!empty($ids)) {
                foreach ($ids as $key => $val) {
                    $ids[$key] = $this->db->getCnn()->quote($val);
                }
                $sql = 'DELETE FROM ' . $this->getTable() . ' WHERE ' . $pk . ' IN (' . implode(',', $ids) . ')';
                return $this->db->getCnn()->exec($sql);
            } else {
                throw new Exception('Erreur ' . __CLASS__ . ' : préciser la liste des IDs à supprimer');
            }
        } catch (PDOException $err) {
            throw new PDOException('Erreur ' . __CLASS__ . ' : ' . $err->getMessage());
        }
    }

    /**
     * Méthode qui met à jour les données dans la table à partir de la l'array passé en paramètre (U de CRUD)
     * @param array $data tableau associatif de type POST contenant les données à actualiser
     * @param string $pk colonne clé primaire
     * @param string $id valeur de la clé primaire
     * @return int nb de lignes modifiées
     */

    public function update(array $data, string $pk, string $id): int
    {
        try {
            // Remplit le tableau de paramètres
            foreach ($data as $key => $val) {
                $params[':' . $key] = htmlspecialchars($val);
                $assign[] = $key . '=:' . $key;
            }
            $params[':id'] = $id;
            // Prépare et exécute la requête SQL
            $sql = 'UPDATE ' . $this->getTable() . ' SET ' . implode(',', $assign) . ' WHERE ' . $pk . '=:id';
            $qry = $this->db->getCnn()->prepare($sql);
            $qry->execute($params);
            return $qry->rowCount();
        } catch (PDOException $err) {
            throw new PDOException('Erreur ' . __CLASS__ . ' : ' . $err->getMessage());
        }
    }

    /**
     * Méthode qui ajoute une nouvelle ligne dans la table (C de CRUD)
     * @param array $data tableau associatif de type POST contenant les données à insérer
     * @return int nb de lignes ajoutées
     */

    public function insert(array $data): int
    {
        try {
            // Remplit tableau de paramètres
            foreach ($data as $key => $val) {
                $params[':' . $key] = htmlspecialchars($val);
            }
            // Prépare et exécute la requête
            $sql = 'INSERT INTO ' . $this->getTable() . '(' . implode(',', array_keys($data)) . ') VALUES(' . implode(',', array_keys($params)) . ')';
            $qry = $this->db->getCnn()->prepare($sql);
            $qry->execute($params);
            return $qry->rowCount();
        } catch (PDOException $err) {
            throw new PDOException('Erreur ' . __CLASS__ . ' : ' . $err->getMessage());
        }
    }
}