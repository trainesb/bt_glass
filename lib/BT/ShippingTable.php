<?php


namespace BT;


class ShippingTable extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, "shipping");
    }

    public function add($order_num, $shipping) {
        $sql = 'INSERT INTO '.$this->tableName.' (order_num, first, last, mi, address, city, state, zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $statement = $this->pdo()->prepare($sql);
        $statement->execute([$order_num, $shipping['first'], $shipping['last'], $shipping['mi'], $shipping['address'], $shipping['city'], $shipping['state'], $shipping['zip']]);
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