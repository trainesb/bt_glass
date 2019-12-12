import $ from 'jquery';
import {parse_json} from './parse_json';

export const Category = function() {

    $("div.product-nav p.show-cnt span").click(function (event) {
        event.preventDefault();

        var category = window.location.href.split('?')[1];;

        var cnt = $(this).text();
        var view = $("div.product-nav p.view-type span.active").attr('class').split(' ')[0];
        var page = 1;

        $.ajax({
            url: "post/category.php",
            data: {"category" : category, "cnt" : cnt, "view" : view, "page" : page},
            method: "POST",
            success: function (data) {
                var json = parse_json(data);

                if(json.ok) {
                    window.location.assign('./category.php?'+json.category+'?'+json.cnt+'-'+json.view+'-'+json.page);
                }
            },
            error: function (xhr, status, error) {
                console.log("error");
                console.log(error);
            }
        })
    });

    $("div.product-nav p span.page-num").click(function (event) {
        event.preventDefault();

        var category = window.location.href.split('?')[1];;

        var cnt = $("div.product-nav p.show-cnt span.active").text();
        var view = $("div.product-nav p.view-type span.active").attr('class').split(' ')[0];
        var page = $(this).text();

        $.ajax({
            url: "post/category.php",
            data: {"category" : category, "cnt" : cnt, "view" : view, "page" : page},
            method: "POST",
            success: function (data) {
                var json = parse_json(data);

                if(json.ok) {
                    window.location.assign('./category.php?'+json.category+'?'+json.cnt+'-'+json.view+'-'+json.page);
                }
            },
            error: function (xhr, status, error) {
                console.log("error");
                console.log(error);
            }
        })
    });

    $("div.products div.product.card").click(function(event) {
        event.preventDefault();

        var product_code = $(this).attr("value");

        $.ajax({
            url: "post/category.php",
            data: {"product_code" : product_code},
            method: "POST",
            success: function (data) {
                var json = parse_json(data);

                if(json.ok) {
                    window.location.assign("./product.php?"+json.code);
                }
            },
            error: function (xhr, status, error) {
                // An Error!
                $("div.inner > a" + " .message").html("<p>Error: " + error + "</p>");
            }
        })

    });
};