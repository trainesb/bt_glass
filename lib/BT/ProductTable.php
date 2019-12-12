<?php


namespace BT;


class ProductTable extends Table {

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "product");
    }

    public function getByCode($code) {
        $sql = "SELECT * FROM ".$this->tableName." WHERE code = ?";
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([$code]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}