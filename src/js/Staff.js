import $ from 'jquery';

export const ShowCategories = function (sel) {

    console.log("Staff");

    var btn = $(sel);
    btn.click(function (event) {
        console.log("btn click");

       event.preventDefault();

       $.ajax({
           url: "post/admin.php",
           method: "POST",
           success: function (data) {
               console.log("Success");
               console.log(data);
           },
           error: function (xhr, status, error) {
               console.log("Error");
               console.log(xhr);
               console.log(status);
               console.log(error);
               // An error!
               $(sel + " .message").html("<p>Error: " + error + "</p>");
           }
       })
    });
}