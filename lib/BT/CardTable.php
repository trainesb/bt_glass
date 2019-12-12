<?php


namespace BT;


class CardTable extends Table {

    public function __construct(Site $site) {
        parent::__construct($site, "card");
    }

    public function add($order_num, $card) {
        $sql = 'INSERT INTO '.$this->tableName.' (order_num, name, number, exp, cvv) VALUES (?, ?, ?, ?, ?)';
        $statement = $this->pdo()->prepare($sql);
        $statement->execute([$order_num, $card['name'], $card['card'], $card['exp'], $card['cvv']]);
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