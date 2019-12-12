<?php


namespace BT;


class BillingTable extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, "billing");
    }

    public function add($order_num, $billing) {
        $sql = 'INSERT INTO '.$this->tableName.' (order_num, first, last, mi, address, city, state, zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $statement = $this->pdo()->prepare($sql);
        $statement->execute([$order_num, $billing['first'], $billing['last'], $billing['mi'], $billing['address'], $billing['city'], $billing['state'], $billing['zip']]);
    }

    public function getByOrder($orderNum) {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE order_num = ?';
        $statement = $this->pdo()->prepare($sql);
        $statement->execute([$orderNum]);
        if($statement->rowCount() === 0) {
            return null;
        }
        return $statement->fetchAll(\PDO::FETCH_ASSOC)[0];
    }
}