<?php


namespace BT;


class ProductController extends Controller {

    private $products;

    public function __construct(Site $site, &$session, $post) {
        parent::__construct($site);

        $this->products = new ProductTable($site);

        if(isset($post['qty']) && ($post['qty'] > 0)) {
            $product_code = $this->products->getByCode($post['product_code']);

            $price = $product_code['price']*5;
            $prduct_ary = array($product_code["code"] => array('name' => $product_code["name"], 'code' => $product_code["code"], 'qty' => $post['qty'], 'price' => $price, 'url' => $post['url']));

            if(!empty($session["cart_item"])) {
                if(in_array($product_code['code'], array_keys($session['cart_item']))) {
                    foreach ($session['cart_item'] as $k => $v) {
                        if($product_code['code'] == $k) {
                            if(empty($session['cart_item'][$k]['qty'])) {
                                $session['cart_item'][$k]['qty'] = 0;
                            }
                            $session['cart_item'][$k]['qty'] += $post['qty'];
                        }
                    }
                } else {
                    $session['cart_item'] = array_merge($session['cart_item'], $prduct_ary);
                }
            } else {
                $session['cart_item'] = $prduct_ary;
            }
        }
        $this->result = json_encode(["ok" => true]);
    }

}