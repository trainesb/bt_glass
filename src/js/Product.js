import $ from 'jquery';
import {parse_json} from './parse_json';

export const Products = function() {

    $("form#add-to-cart input[name='qty']").change(function (event) {
       event.preventDefault();

       var qty = $(this).val();
       var price = $('#add-to-cart > fieldset > p:nth-child(2) > span').attr('class').split(' ')[1];
       price = price * qty;
       $('#add-to-cart > fieldset > p:nth-child(2) > span').text(price);
    });

    $("div.slide-wrapper div.thumbnail div.slide").click(function (event) {
       event.preventDefault();

       var src = $('p > img', this).attr('src');
       var num = $('div.numbertext', this).text();

       $("div.slide-wrapper div.thumbnail div.slide.active").removeClass('active');
       $(this).addClass('active');
       $("div.slide-wrapper div.main-slide div.slide p > img").attr('src', src);
       $("div.slide-wrapper div.main-slide div.slide div.numbertext").text(num);
    });

    $("form#add-to-cart").submit(function(event) {
        event.preventDefault();

        var qty = $("input[name='qty']").val();
        var product_code = $('body > div > div > div:nth-child(3) > p > span').text();
        var url = $(location).attr('href');

        $.ajax({
            url: "post/product.php",
            data: {"url" : url, "qty" : qty, "product_code" : product_code},
            method: "POST",
            success: function(data) {
                var json = parse_json(data);

                if(json.ok) {
                    alert(product_code + " added to cart - qty:" + qty);
                }
            },
            error: function(xhr, status, error) {
                console.log("ERROR");
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });

    });
};