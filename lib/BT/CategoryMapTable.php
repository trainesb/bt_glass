<?php


namespace BT;


class CategoryMapTable extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, 'category_map');
    }

    public function getSub($id) {
        $sql = "SELECT sub_id FROM ".$this->tableName." WHERE top_id = ?";
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        if($statement->rowCount() === 0) {
            return null;
        }

        $rtrn = [];
        while($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            array_push($rtrn, $row['sub_id']);
        }

        return $rtrn;
    }

}