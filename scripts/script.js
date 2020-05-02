$(document).ready(function(){

    $("#delete").on("click", function(){
        if ($("#popup").is(":hidden")){
            $("#popup").removeClass("hidden");
        } else{
            $("#popup").addClass("hidden");
        }
    });

    $(".yes_del").on("click", function(){
        $("#popup").addClass("hidden");
    });

    $(".no_del").on("click", function(){
        $("#popup").addClass("hidden");
    });



    $(".ellipsis").on("click", function() {
        if ($(".edit_options").is(":hidden")) {
          $(".edit_options").removeClass("hidden");
          $(".ellipsis").addClass("hidden");
          $(".close_img").removeClass("hidden");
        }
      });

    $(".close_img").on("click", function() {
        if ($(".edit_options").is(":visible")) {
        $(".edit_options").addClass("hidden");
        $(".ellipsis").removeClass("hidden");
        $(".close_img").addClass("hidden");
      }
      });

    $(".edit_tags").on("click", function(){
        if ($("#edit_tags").is(":hidden")){
            $("#edit_tags").removeClass("hidden");
        } else{
            $("#edit_tags").addClass("hidden");
        }
    });

    $(".new_tag").on("click", function(){
        if ($("#new_form").is(":hidden")){
            $("#new_form").removeClass("hidden");
            $("#existing_form").addClass("hidden");
        } else{
            $("#new_form").addClass("hidden");
        }
    });

    $(".existing_tag").on("click", function(){
        if ($("#existing_form").is(":hidden")){
            $("#existing_form").removeClass("hidden");
            $("#new_form").addClass("hidden");
        } else{
            $("#existing_form").addClass("hidden");
        }
    });

});
