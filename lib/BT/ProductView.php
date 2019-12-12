<?php


namespace BT;


class ProductView extends View {

    private $product_code;
    private $product_imgs;
    private $product;

    public function __construct(Site $site) {
        parent::__construct($site);

        $this->product_code = explode("?", $_SERVER['REQUEST_URI'], 2)[1];
        $this->product = $this->getProducts()->getByCode($this->product_code);
        $this->product_imgs = $this->getProductImgs()->getByCode($this->product_code);


        $this->setTitle("Product");
    }

    public function presentProduct() {
        echo $this->presentCode();
        if(!$this->product['soldout']) {
            echo $this->presentPrice();
            echo $this->presentSoldOut();
        } else {
            echo $this->presentAddToCart();
        }
        echo $this->presentDescription();
        echo $this->presentVideo();
    }

    public function presentName() {
        echo '<h3>'.$this->product['name'].'</h3>';
    }

    public function presentCode() {
        echo "<p>Code: <span>".$this->product['code']."</span></p>";
    }

    public function presentSlide() {
        $total = sizeof($this->product_imgs);
        $i = 1;

        echo '<div class="slide-wrapper">';

        echo '<div class="main-slide">';
        echo '<div class="slide">';
        echo '<div class="numbertext">'.$i.'/'.$total.'</div>';
        echo '<p><img class="demo cursor" src="'.$this->product_imgs[0]['img'].'" alt="product img #'.$i.'"></p>';
        echo '</div>';
        echo '</div>';

        echo '<div class="thumbnail">';



        foreach ($this->product_imgs as $img) {


            if($i == 1) {
                echo '<div class="slide active">';
            } else {
                echo '<div class="slide">';
            }
            echo '<div class="numbertext">'.$i.'/'.$total.'</div>';
            echo '<p><img class="demo cursor" src="'.$img['img'].'" alt="product img #'.$i.'"></p>';
            echo '</div>';


            $i++;
        }

        echo '</div>';
        echo '</div>';
    }

    public function presentSlideBtns() {
        echo '<a class="prev">&#10094;</a>';
        echo '<a class="next">&#10095;</a>';
    }

    public function presentPrice() {
        $price = $this->product['price']*5;
        echo '<div class="product-price"><p>Price: $'.$price.'.00</p></div>';
    }

    public function presentSoldOut() {
        if(!$this->product['soldout']) {
            echo '<div class="product-soldout">';
            echo '<h2>Sold Out!</h2>';
            echo '</div>';
        }
    }

    public function presentDescription() {
        echo '<div class="product-description">';
        echo '<p>'.$this->product['description'].'</p>';
        echo '</div>';
    }

    public function presentVideo() {
        if($this->product['video']) {
            echo "<p><img src='".$this->product['video']."'></p>";
            echo "<p>VIDEO: ".$this->product['video_text']."</p>";
        }
    }

    public function presentAddToCart() {
        $price = number_format($this->product['price']*5, 2);
        echo '<div class="add-to-cart wrapper">';
        echo '<form id="add-to-cart" method="post" action="post\product.php">';
        echo '<fieldset><legend>Add to Cart:</legend>';
        echo '<p><input type="number" name="qty" value="1">&emsp;Price: $<span class="price '.$price.'">'.$price.'</span></p>';
        echo '<p><input type="submit" value="Add to Cart"></p>';
        echo '</fieldset></form></div>';
    }
}