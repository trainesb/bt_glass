<?php


namespace BT;


class CategoryTable extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, 'category');
    }

    public function getAll() {
        $sql = "SELECT * FROM ".$this->tableName;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $rtrn = [];
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            array_push($rtrn, row['id'], $row['name'], $row['url'], $row['img']);
        }
        return $rtrn;
    }

    public function getById($id) {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE id = ?';
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}