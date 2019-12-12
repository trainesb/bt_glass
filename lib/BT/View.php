<?php

namespace BT;

/**
 * Base class for all views
 */
class View {

    private $title = "";	// The page title
    private $links = [];	// Links to add to the nav bar
    private $site;
    private $protectRedirect = null; /// Page protection redirect

    private $user;
    private $top;
    private $map;
    private $categories;
    private $categoryProductMap;
    private $products;
    private $productImgs;

    public function __construct(Site $site) {
        $this->site = $site;

        if(isset($_SESSION[User::SESSION_NAME])) {
            $this->user = $_SESSION[User::SESSION_NAME];
        }

        $this->top = new TopCategoryTable($this->site);
        $this->categories = new CategoryTable($this->site);
        $this->map = new CategoryMapTable($this->site);
        $this->categoryProductMap = new CategoryProductMapTable($this->site);
        $this->products = new ProductTable($this->site);
        $this->productImgs = new ProductImgTable($this->site);
    }


    /**
     * Set the page title
     * @param $title New page title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Create the HTML for the contents of the head tag
     * @return string HTML for the page head
     */
    public function head($style) {
        return <<<HTML
<meta charset="utf-8">
<title>$this->title</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="src/scss/$style">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="dist/main.js"></script>
HTML;
    }

    /**
     * Create the HTML for the page header
     * @return string HTML for the standard page header
     */
    public function header() {

        $html = <<<HTML
<nav>
    <ul class="left">
        <li><a href="./">BT Glass</a></li>
    </ul>
    <ul class="right">
HTML;

        if(count($this->links) > 0) {

            foreach($this->links as $link) {
                $html .= '<li><a href="' . $link['href'] . '">' . $link['text'] . '</a></li>';
            }
        }


        if(!$this->user) {
            $html .= '<li><a href="login.php">Login</a></li>';
        } else {

            if($this->user->isStaff()) {
                $html .= '<li><a href="./admin.php">Admin</a></li>';
            }

            $html .= '<li><a href="post\logout.php">Log Out</a></li>';
            $html .= '<li><a href="./user.php"><i class="fa fa-user" aria-hidden="true"></i></a></li>';
        }

        $html .= '<li><a class="shopping-cart" href="./cart.php"><i class="fa fa-shopping-cart"></i></a></li></ul></nav>';
        $html .= $this->presentTop();
        return $html;
    }

    public function presentTop() {
        $topList = $this->top->getAll();

        $topHtml = '';

        foreach ($topList as $name) {
            $top_id = $this->top->getIdByName($name);

            $topHtml .= <<<HTML
<div class='top-category'>
<p><a value='$top_id' href='./top-category.php?$top_id'>$name</a></p>
</div>
HTML;
        }

        return <<<HTML
<div class="topcat-wrapper">
    <div class="topcat">
        $topHtml
    </div>
</div>
<hr>
HTML;
    }

    public function presentTable($items) {
        echo '<div class="table-wrapper"><table>';
        $is_head = true;

        foreach ($items as $item) {

            if($is_head) {
                echo '<tr>';
                foreach ($item as $key => $attr) {
                    echo '<td>'.$key.'</td>';
                }
                echo '</tr>';
                $is_head = false;
            }

            echo '<tr>';

            foreach ($item as $attr) {
                echo '<td>'.$attr.'</td>';
            }
            echo '</td>';
        }
        echo '</div></table>';
    }

    /**
     * Create the HTML for the page footer
     * @return string HTML for the standard page footer
     */
    public function footer() {
        return '<footer><p>Copyright © 2019 BT Glass, Inc. All rights reserved.</p></footer><script src="https://www.google.com/recaptcha/api.js?render=reCAPTCHA_site_key"></script>';
    }

    /**
     * Add a link that will appear on the nav bar
     * @param $href What to link to
     * @param $text
     */
    public function addLink($href, $text) {
        $this->links[] = ["href" => $href, "text" => $text];
    }

    /**
     * Protect a page for staff only access
     *
     * If access is denied, call getProtectRedirect
     * for the redirect page
     * @param $site The Site object
     * @param $user The current User object
     * @return bool true if page is accessible
     */
    public function protect($site, $user) {

        if($user->isStaff()) {
            return true;
        }

        $this->protectRedirect = $site->getRoot() . "/";
        return false;
    }

    /**
     * Get any redirect page
     */
    public function getProtectRedirect() {
        return $this->protectRedirect;
    }

    /**
     * @return TopCategoryTable
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * @return CategoryTable
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return CategoryMapTable
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @return CategoryProductMapTable
     */
    public function getCategoryProductMap()
    {
        return $this->categoryProductMap;
    }

    /**
     * @return ProductTable
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return ProductImgTable
     */
    public function getProductImgs()
    {
        return $this->productImgs;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return ShoppingCart
     */
    public function getCart()
    {
        return $this->cart;
    }


}