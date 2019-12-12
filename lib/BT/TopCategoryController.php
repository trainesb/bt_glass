<?php


namespace BT;


class TopCategoryController extends Controller {



    /**
     * TopCategoryController constructor.
     * @param Site $site Site object
     * @param $user The user ID
     * @param array $post $_POST
     * @param array $session $_SESSION
     */
    public function __construct(Site $site, array $post) {
        parent::__construct($site);
    }


}