<?php


namespace BT;


class CategoryProductMapTable extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, "category_product_map");
    }

    public function getBySubId($sub_id) {
        $sql = "SELECT * FROM ".$this->tableName." WHERE category_id = ?";
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([$sub_id]);

        $rtrn = [];
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            array_push($rtrn, $row);
        }
        return $rtrn;
    }

}