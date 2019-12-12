<?php


namespace BT;


class CategoryView extends View {

    private $sub_id;
    private $sub;
    private $products = [];
    private $cnt;
    private $view;
    private $page;

    public function __construct(Site $site) {
        parent::__construct($site);

        $this->sub_id = explode("?", $_SERVER['REQUEST_URI'])[1];
        $pagesAttr = explode("-", explode("?", $_SERVER['REQUEST_URI'])[2]);
        $this->cnt = $pagesAttr[0];
        $this->view = $pagesAttr[1];
        $this->page = $pagesAttr[2];

        $this->sub = $this->getCategories()->getById($this->sub_id)['name'];

        foreach ($this->getCategoryProductMap()->getBySubId($this->sub_id) as $product) {
            array_push($this->products, $this->getProducts()->getByCode($product['product_code']));
        }

        $this->setTitle("BT Category view");
    }

    public function present() {

        echo '<div class="sub-category"><h1>'.$this->sub.'</h1></div>';

        echo '<div class="products">';

        echo $this->presentProductPage();

        $chunks = array_chunk($this->products, $this->cnt, true);

        echo $this->presentProducts($chunks[$this->page - 1]);

        echo "</div>";
    }

    public function presentProducts($products) {

        $x = 0;
        $y = 0;
        foreach ($products as $product) {
            if($x%3 == 0) {
              echo '<div class="row">';
              $y = 0;
            }
            $y++;

            echo '<div class="product card" value="'.$product["code"].'">';
            echo "<div class='container'>";

            $i = 0;
            foreach ($this->getProductImgs()->getByCode($product["code"]) as $img) {
                if($i == 0) {
                    echo "<p class='active'><img class='product-img' src='".$img['img']."'></p>";
                }else {
                    echo "<p><img class='product-img' src='".$img['img']."'></p>";
                }
                $i++;
            }

            if(!$product['soldout']) {
                echo '<div class="soldout"><h3>Sold Out</h3></div>';
            }

            $price = number_format($product["price"]*5, 2);

            echo '</div>';
            echo '<h3>'.$product["name"].'</h3><p>Price: $'.$price.'</p><p>'.$product["code"].'</p>';
            echo '</div>';
            if($y == 3) {
                echo '</div>';
            }
            $x++;
        }
    }

    public function presentProductPage() {
        $sz = count($this->products);
        $num = ($this->cnt * $this->page)+1;
        $strt = ($this->cnt * ($this->page-1)) + 1;

        $html = '<div class="product-nav">';
        if($num > $sz) {
            $html .= '<p>Items: '.$strt.' - '.$sz.' of '.$sz.' Total</p>';
        } else {
            $html .= '<p>Items: '.$strt.' - '.$num.' of '.$sz.' Total</p>';
        }
        $html .= $this->presentShow();
        $html .= $this->presentView();
        $html .= $this->presentPageNumbers();
        $html .= '</div>';
        return $html;
    }

    public function presentShow() {
        $html = '<p class="show-cnt">Show:&emsp;';

        if($this->cnt == 24) {
            $html .= <<<HTML
<span class="active">24</span>  
<span>48</span>  
<span>96</span>
HTML;
        }
        else if($this->cnt == 48) {
            $html .= <<<HTML
<span>24</span>  
<span class="active">48</span>  
<span>96</span>
HTML;
        } else {
            $html .= <<<HTML
<span>24</span>  
<span>48</span>  
<span class="active">96</span>
HTML;
        }
        $html .= '</p>';
        return $html;
    }

    public function presentView() {
        $html = '<p class="view-type">View:&emsp;';

        if($this->view == 'grid') {
            $html .= <<<HTML
<span class="grid active"><i class="fa fa-th-large" aria-hidden="true"></i></span>
<span class="list"><i class="fa fa-th-list" aria-hidden="true"></i></span>
HTML;
        } else {
            $html .= <<<HTML
<span class="grid"><i class="fa fa-th-large" aria-hidden="true"></i></span>
<span class="list active"><i class="fa fa-th-list" aria-hidden="true"></i></span>
HTML;
        }
        $html .= '</p>';
        return $html;
    }

    public function presentPageNumbers() {
        $sz = ceil(count($this->products)/$this->cnt);

        $html = '<p>';

        for($i=1; $i<=$sz; $i++) {
            if($i == $this->page) {
                $html .= '<span class="page-num active" value="'.$i.'">'.$i.'</span>';
            }

            else {
                $html .= '<span class="page-num" value="'.$i.'">'.$i.'</span>';
            }
            $html .= '  ';
        }
        $html .= '</p>';
        return $html;
    }
}