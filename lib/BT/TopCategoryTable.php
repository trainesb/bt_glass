<?php


namespace BT;


class TopCategoryTable extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, "top_category");
    }

    public function getAll() {
        $sql = 'SELECT * FROM '.$this->tableName;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $rtrn = [];
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            array_push($rtrn, $row['name']);
        }

        return $rtrn;
    }

    public function getIdByName($name) {
        $sql = "SELECT id FROM ".$this->tableName." WHERE name = ?";
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([$name]);
        if($statement->rowCount() === 0) {
            return null;
        }

        return $statement->fetch(\PDO::FETCH_ASSOC)['id'];
    }

    public function getById($id) {
        $sql = "SELECT * FROM ".$this->tableName." WHERE id = ?";
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);

        if($statement->rowCount() == 0) {
            return null;
        }

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}