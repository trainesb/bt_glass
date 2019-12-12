<?php


namespace BT;


class OrderUserMapTable extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, "order_user_map");
    }

    public function add($order_num, $user_id) {
        $sql = 'INSERT INTO '.$this->tableName.' (order_num, user_id) VALUES (?, ?)';
        $statement = $this->pdo()->prepare($sql);
        $statement->execute([$order_num, $user_id]);
    }
}