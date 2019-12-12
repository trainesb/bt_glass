<?php


namespace BT;


class HomeView extends View {

    private $topCat;
    private $subCat;
    private $mapCat;
    private $topList;

    public function __construct(Site $site) {
        parent::__construct($site);
        $this->topCat = $this->getTop();
        $this->subCat = $this->getCategories();
        $this->mapCat = $this->getMap();

        $this->topList = $this->topCat->getAll();

        $this->setTitle("BT Glass Home");

    }

    public function present() {
        $this->presentCategories();
    }

    public function presentCategories() {

        echo "<div class='sub-categories'>";

        foreach ($this->topList as $name) {
            $top_id = $this->topCat->getIdByName($name);
            $sub_ids = $this->mapCat->getSub($top_id);

            $subs = [];
            foreach ($sub_ids as $id) {
                array_push($subs, $this->getCategories()->getById($id));
            }

            foreach ($subs as $sub) {
                echo '<div class="sub-category card" value="'.$sub["id"].'">';
                echo '<h3>'.$sub["name"].'</h3>';
                echo'<p><img src="'.$sub["img"].'" alt="'.$sub["name"].'"></p>';
                echo '</div>';
            }

        }
        echo "</div>";
    }


}