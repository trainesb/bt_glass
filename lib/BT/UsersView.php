<?php


namespace BT;


/**
 * view class for the users page users.php
 */
class UsersView extends View {

    private $users;
    private $site;

    /**
     * Constructor
     * Sets the page title and any other settings.
     * @param Site $site The Site object
     */
    public function __construct(Site $site) {
        $this->site = $site;
        $this->users = new UsersTable($site);

        $this->setTitle("BT Glass UsersTable");

    }

    /**
     * Present the users form
     * @return string HTML
     */
    public function present() {
        $html = <<<HTML
<form class="table" method="post" action="post/users.php">
    <p>
    <input type="submit" name="add" id="add" value="Add">
    <input type="submit" name="edit" id="edit" value="Edit">
    <input type="submit" name="delete" id="delete" value="Delete">
    </p>

    <table>
        <tr>
            <th>&nbsp;</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
HTML;

        $all = $this->users->getAll();
        foreach ($all as $user) {
            $html .= '<tr><td><input type="radio" name="user"></td><td>'.$user["name"].'</td><td>'.$user["email"].'</td><td>'.$user["role"].'</td></tr>';
        }

        $html .= '</table></form>';

        return $html;
    }


}