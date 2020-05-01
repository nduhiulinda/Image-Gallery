$(document).ready(function(){
    // document.getElementById("delete").onclick = function(){
    //     document.getElementById("delete_popup").classList.remove("hidden")
    // }
    // document.getElementByClassName("yes_del").onclick = function(){
    //     document.getElementById("delete_popup").classList.add("hidden")
    //     document.getElementById("yes_confirm").classList.remove("hidden")
    //     setTimeout(function(){
    //         document.getElementById("yes_confirm").classList.add("hidden");
    //     }, 5000);
    // }

    // document.getElementByClassName("no_del").onclick = function(){
    //     document.getElementById("delete_popup").classList.add("hidden")
    // };

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
        } else{
            $("#new_form").removeClass("hidden");
        }
    });

    $(".existing_tag").on("click", function(){
        if ($("#existing_form").is(":hidden")){
            $("#existing_form").removeClass("hidden");
        } else{
            $("#existing_form").removeClass("hidden");
        }
    });

});
