import $ from 'jquery';
import {Login} from './Login';
import {ShowCategories} from "./Staff";
//import {SelectTop} from "./Home";
import {TopCategory} from "./TopCategory";
import {Category} from "./Category";
import {Register} from "./Register";
import {Products} from "./Product";
import {Cart} from "./Cart";
import {Checkout} from "./Checkout";

$(document).ready(function() {
    new Login();
    new ShowCategories('#show-categories');
    //new SelectTop();
    new TopCategory();
    new Category();
    new Products();
    new Register();
    new Cart();
    new Checkout();
});