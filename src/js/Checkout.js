import $ from 'jquery';
import {parse_json} from './parse_json';

export const Checkout = function () {

    $('#shipping-option').click(function (event) {
        event.preventDefault();

        $('#shipping').toggle();
    });

    $('input.first-name').change(function (event) {
       event.preventDefault();

       var name = $(this).val();
       if(!/^[a-zA-Z()]+$/.test(name)) {
           alert("Error with First Name");
       }
    });

    $('input.last-name').change(function (event) {
        event.preventDefault();

        var name = $(this).val();
        if(!/^[a-zA-Z()]+$/.test(name)) {
            alert("Error with Last Name");
        }
    });

    $('input.city').change(function (event) {
        event.preventDefault();

        var name = $(this).val();
        if(!/^[a-zA-Z()]+$/.test(name)) {
            alert("Error with City");
        }
    });

    $('input.state').change(function (event) {
        event.preventDefault();

        var name = $(this).val();
        if(!/^[a-zA-Z()]+$/.test(name)) {
            alert("Error with State");
        }
    });

    $('input.name').change(function (event) {
        event.preventDefault();

        var name = $(this).val();
        if(!/^[a-zA-Z()]+$/.test(name)) {
            alert("Error with Card Name");
        }
    });

    $('input.card-number').change(function (event) {
        event.preventDefault();

        var name = $(this).val();
        if(/^[a-zA-Z()]+$/.test(name)) {
            alert("Error with Card Number");
        }
    });

    $('input.exp').change(function (event) {
        event.preventDefault();

        var name = $(this).val();
        if(/^[a-zA-Z()]+$/.test(name)) {
            alert("Error with exp");
        }
    });

    $('input.cvv').change(function (event) {
        event.preventDefault();

        var name = $(this).val();
        if(/^[a-zA-Z()]+$/.test(name)) {
            alert("Error with cvv");
        }
    });

    $('input#finish').click(function (event) {
        event.preventDefault();

        var first = $('#billing-address > fieldset > p:nth-child(2) > input').val();
        var last = $('#billing-address > fieldset > p:nth-child(3) > input').val();
        var mi = $('#billing-address > fieldset > p:nth-child(4) > input').val();
        var address = $('#billing-address > fieldset > p:nth-child(5) > input').val();
        var city = $('#billing-address > fieldset > p:nth-child(6) > input').val();
        var state = $('#billing-address > fieldset > p:nth-child(7) > input').val();
        var zip = $('#billing-address > fieldset > p:nth-child(8) > input').val();
        var billing = {
            "first" : first,
            "last" : last,
            "mi" : mi,
            "address" : address,
            "city" : city,
            "state" : state,
            "zip" : zip
        };

        var name = $('#payment > fieldset > p:nth-child(2) > input').val();
        var card = $('#payment > fieldset > p:nth-child(3) > input').val();
        var exp = $('#payment > fieldset > p:nth-child(4) > input').val();
        var cvv = $('#payment > fieldset > p:nth-child(5) > input').val();
        var payment = {
            "name" : name,
            "card" : card,
            "exp" : exp,
            "cvv" : cvv
        };

        var sh_first = $('#shipping > fieldset > p:nth-child(2) > input').val();
        var sh_last = $('#shipping > fieldset > p:nth-child(3) > input').val();
        var sh_mi = $('#shipping > fieldset > p:nth-child(4) > input').val();
        var sh_address = $('#shipping > fieldset > p:nth-child(5) > input').val();
        var sh_city = $('#shipping > fieldset > p:nth-child(6) > input').val();
        var sh_state = $('#shipping > fieldset > p:nth-child(7) > input').val();
        var sh_zip = $('#shipping > fieldset > p:nth-child(8) > input').val();
        var shipping = {
            "first" : sh_first,
            "last" : sh_last,
            "mi" : sh_mi,
            "address" : sh_address,
            "city" : sh_city,
            "state" : sh_state,
            "zip" : sh_zip
        };

        $.ajax({
            url: "post/checkout.php",
            data: {"billing" : billing, "payment" : payment, "shipping" : shipping},
            method: "POST",
            success: function(data) {
                console.log("Success");
                var json = parse_json(data);
                console.log(json);
                if(!json.ok) {
                    if(json.message == "Invalid Address") {
                        alert("Invalid Address Given");
                    }
                    else if(json.message == "city") {
                        alert("Invalid City");
                    }
                    else if(json.message == "State") {
                        alert("Invalid State Given");
                    }
                    else if(json.message == "Card") {
                        alert("Card Number is Invalid");
                    }
                } else {
                    window.location.assign('./receipt.php?'+json.order);
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