import $ from 'jquery';
import {parse_json} from './parse_json';

export const Login = function() {

    $("#login").submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: "post/login.php",
            data: $("#login").serialize(),
            method: "POST",
            success: function(data) {
                console.log("Success");
                var json = parse_json(data);
                console.log(json);

                if(json.ok) {
                    // Login was successful
                    if(json.staff) {
                        console.log('Go to admin.php');
                        window.location.assign("./admin.php");
                    } else {
                        window.location.assign("./");
                    }

                } else {
                    if(json.logout) {
                        window.location.assign("./login.php?x");
                    }
                    // Login failed, a message is in json.message
                    $("form#login .message").html("<p>" + json.message + "</p>");
                }
            },
            error: function(xhr, status, error) {
                console.log("ERROR");
                console.log(xhr);
                console.log(status);
                console.log(error);
                // An error!
                $("form#login .message").html("<p>Error: " + error + "</p>");
            }
        });

    });
};