import $ from 'jquery';
import {parse_json} from './parse_json';

export const Cart = function () {

    $('#checkout').click(function (event) {
        event.preventDefault();

        var total = $('#total td').text();
        total = total.slice(1, -3);
        if(total < 100) {
            alert("Order must be $100 or more!");
        } else {
            if(confirm('Continue to Checkout?')) {
                $('div.terms-wrapper').toggle();
                $('form#payment').toggle();
                $('div.shipping-option-wrapper').toggle();
                $('form#billing-address').toggle();
            }
        }
    });

    $('input.terms-chk').click(function (event) {
        event.preventDefault();


        $('div.finish-wrapper').toggle();
    });

    $('body > div > div > table > tbody > tr > td:nth-child(1) > i').click(function (event) {
        event.preventDefault();

        var code = $(this).parent().next().text();
        var name = $(this).parent().next().next().text();

        if(confirm("Are you sure you want to remove '" + name + "' from the cart?")) {
            $.ajax({
                url: "post/cart.php",
                data: {"code" : code, "remove" : true},
                method: "GET",
                success: function (data) {
                    var json = parse_json(data);
                    if(json.ok) {
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.log("error");
                    console.log(error);
                }
            });
        }
    });


    $('#clear-cart').click(function (event) {
       event.preventDefault();
        if(confirm('Are you sure you want to clear the cart?')) {
            $.ajax({
                url: "post/cart.php",
                data: {"clear" : true},
                method: "GET",
                success: function (data) {
                    var json = parse_json(data);

                    if(json.ok) {
                        window.location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.log("error");
                    console.log(error);
                }
            });
        }
    });

    $('#qty').change(function (event) {
        event.preventDefault();

        var qty = $(this).val();
        var code = $(this).parent().parent().prev().prev().text();

        $.ajax({
            url: "post/cart.php",
            data: {"qty" : qty, "code" : code},
            method: "GET",
            success: function (data) {
                var json = parse_json(data);

                if(json.ok) {
                    window.location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.log("error");
                console.log(error);
            }
        });
    });
};
