import $ from 'jquery';
import {parse_json} from './parse_json';

export const Register = function() {

    $('#register').submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: 'post/register.php',
            data: $('#register').serialize(),
            method: "POST",
            success: function (data) {
                var json = parse_json(data);
                console.log(json);
                if(json.ok) {
                    if(json.message == "created") {
                        window.location('./login.php');
                    }
                } else {
                    if(json.message == 'Password') {
                        if($('#email').css('border')) {
                            $('#email').css('border', 'rgb(232, 240, 254)');
                        }
                        $('#password').css('border', 'solid thin red');
                        $('#password-valid').css('border', 'solid thin red');
                        alert("Passwords Don't Match!");
                    }
                    else if (json.message == 'Email exists') {
                        if($('#password').css('border')) {
                            $('#password').css('border', 'rgb(232, 240, 254)');
                            $('#password-valid').css('border', 'rgb(232, 240, 254)');
                        }
                        $("#email").css('border', 'solid thin red');
                        alert("Email Already Exists, Please Choose Another!")
                    }
                }
            },
            error: function (xhr, status, error) {
                console.log("Error");
            }
        })
    });
}