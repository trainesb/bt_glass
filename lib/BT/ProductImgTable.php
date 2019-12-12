<?php


namespace BT;


class ProductImgTable extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, 'imgs');
    }

    public function getByCode($code) {
        $sql = "SELECT * FROM ".$this->tableName." WHERE product_code = ?";
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([$code]);
        $rtrn = [];
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            array_push($rtrn, $row);
        }

        return $rtrn;
    }
}