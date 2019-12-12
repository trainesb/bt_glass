<?php


namespace BT;


class TopCategoryView extends View {

    private $top_id;
    private $top_category;
    private $map;

    public function __construct(Site $site) {
        parent::__construct($site);
        $this->top_id = explode("?", $_SERVER['REQUEST_URI'], 2)[1];
        $this->top_category = $this->getTop()->getById($this->top_id);
        $this->map = $this->getMap();

        $this->setTitle("BT Top-Category");
    }

    public function presentSubCategories() {
        $sub_ids = $this->map->getSub($this->top_id);
        $subs = [];
        foreach ($sub_ids as $id) {
            array_push($subs, $this->getCategories()->getById($id));
        }

        echo '<div class="top">';
        echo '<h1>'.$this->top_category['name'].'</h1>';
        echo '</div>';

        echo '<div class="sub-categories">';

        foreach ($subs as $sub) {
            echo '<div class="sub-category card" value="'.$sub["id"].'">';
            echo '<h3>'.$sub["name"].'</h3>';
            echo'<p><img src="'.$sub["img"].'" alt="'.$sub["name"].'"></p>';
            echo '</div>';
        }
        echo '</div>';
    }
}