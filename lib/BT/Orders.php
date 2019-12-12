<?php


namespace BT;


class Orders extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, "orders");
    }

    public function getNxtOrderNum() {
        $sql = "SELECT MAX(order_num) AS num FROM ".$this->tableName;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute();
        if($statement->rowCount() === 0) {
            return 1;
        } else {
            return $statement->fetch(\PDO::FETCH_ASSOC)['num'] + 1;
        }
    }

    public function add($order_num, $cart) {
        if($cart) {
            foreach ($cart as $item) {
                $sql = 'INSERT INTO '.$this->tableName.' (order_num, product_code, qty) VALUES (?, ?, ?)';
                $statement = $this->pdo()->prepare($sql);
                $statement->execute([$order_num, $item['code'], $item['qty']]);
            }
        }
    }

    public function getByOrder($orderNum) {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE order_num = ?';
        $statement = $this->pdo()->prepare($sql);
        $statement->execute([$orderNum]);
        if($statement->rowCount() === 0) {
            return null;
        }
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}