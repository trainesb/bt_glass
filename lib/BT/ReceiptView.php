<?php


namespace BT;


class ReceiptView extends View {

    private $orderNum;
    private $orders;
    private $billing;
    private $card;
    private $shipping;

    public function __construct(Site $site) {
        parent::__construct($site);
        $this->orderNum = explode("?", $_SERVER['REQUEST_URI'], 2)[1];
        $this->orders = new Orders($site);
        $this->billing = new BillingTable($site);
        $this->card = new CardTable($site);
        $this->shipping = new ShippingTable($site);
    }

    public function present() {
        echo $this->presentOrder();
        echo $this->presentBilling();
        echo $this->presentPayment();
        echo $this->presentShipping();
    }

    public function presentOrder() {
        $html = <<<HTML
<h3>Thank You For Your Order - #$this->orderNum</h3>
HTML;
        $order = $this->orders->getByOrder($this->orderNum);
        print_r($order);
        return $html;
    }

    public function presentBilling() {
        $bill = $this->billing->getByOrder($this->orderNum);
        echo '<h3>Billing</h3>';
        echo '<p>'.$bill["first"].' '.$bill["mi"].' '.$bill["last"].'</p>';
        echo '<p>'.$bill["address"].' '.$bill["city"].''.$bill["state"].' '.$bill["zip"].'</p>';
    }

    public function presentPayment() {
        $payment = $this->card->getByOrder($this->orderNum);
        echo '<h3>Payment</h3>';
        echo '<p>'.$payment["name"].'</p>';
        echo '<p>'.$payment["number"].'</p>';
    }

    public function presentShipping() {
        $ship = $this->shipping->getByOrder($this->orderNum);
        if($ship) {
            echo '<h3>Shipping</h3>';
            echo '<p>'.$ship["first"].' '.$ship["mi"].' '.$ship["last"].'</p>';
            echo '<p>'.$ship["address"].' '.$ship["city"].''.$ship["state"].' '.$ship["zip"].'</p>';
        } else {
            echo '<h3>Shipping same as billing</h3>';
        }
    }
}