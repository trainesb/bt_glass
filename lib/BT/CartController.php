<?php


namespace BT;


class CartController extends Controller {

    public function __construct(Site $site, &$session, $get) {
        parent::__construct($site);

        if(isset($get['remove'])) {
            if(!empty($session["cart_item"])) {
                foreach ($session["cart_item"] as $k => $v) {
                    if($get["code"] == $k) {
                        unset($session["cart_item"][$k]);
                    }
                    if(empty($session["cart_item"])) {
                        unset($session["cart_item"]);
                    }
                }
            }
            $this->result = json_encode(["ok" => true]);
        }

        if(isset($get['clear'])) {
            unset($session["cart_item"]);
            $this->result = json_encode(["ok" => true]);
        }

        if(isset($get['qty'])) {
            if(!empty($session["cart_item"])) {
                foreach ($session['cart_item'] as $k => $v) {
                    if($get["code"] == $k) {
                        $session["cart_item"][$k]['qty'] = $get['qty'];
                    }
                }
            }
            $this->result = json_encode(["ok" => true]);
        }


    }

    protected function validateAddress($input) {
        return preg_match('/^(?:\\d+ [a-zA-Z ]+, ){2}[a-zA-Z ]+$/', $input);
    }

}