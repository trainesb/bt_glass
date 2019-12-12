<?php


namespace BT;


class CategoryController extends Controller {

    private $sub_id;
    private $sub;
    private $products = [];

    public function __construct(Site $site, $user, $session, $post) {
        parent::__construct($site);



        if(!isset($post['cnt'])) {
            $this->result = json_encode(["ok" => true, "code" => $post["product_code"]]);
        } else {
            $this->result = json_encode(["ok" => true, "category" => $post['category'], "cnt" => $post['cnt'], "view" => $post['view'], "page" => $post['page']]);
        }
    }

}