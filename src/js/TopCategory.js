import $ from 'jquery';
import {parse_json} from './parse_json';


export const TopCategory = function() {

    var sub_category = $("div.sub-categories > div.sub-category");
    sub_category.click(function(event) {
        event.preventDefault();

        var sub = $(this).text();
        var sub_id = $(this).attr("value");
        console.log(sub);
        console.log(sub_id);

        $.ajax({
            url: "post/top-category.php",
            data: {"sub_id" : sub_id},
            method: "POST",
            success: function (data) {
                var json = parse_json(data);
                console.log("Success");
                console.log(json);
                window.location.assign("./category.php?"+json+'?24-grid-1');
            },
            error: function (xhr, status, error) {
                // An Error!
                $("div.inner > a" + " .message").html("<p>Error: " + error + "</p>");
            }
        })

    });
};