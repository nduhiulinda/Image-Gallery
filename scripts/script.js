// $(document).ready(function(){
    document.getElementById("delete").onclick = function(){
        document.getElementById("delete_popup").classList.remove("hidden")
    }
    document.getElementByClassName("yes_del").onclick = function(){
        document.getElementById("delete_popup").classList.add("hidden")
        document.getElementById("yes_confirm").classList.remove("hidden")
        setTimeout(function(){
            document.getElementById("yes_confirm").classList.add("hidden");
        }, 5000);
    }

    document.getElementByClassName("no_del").onclick = function(){
        document.getElementById("delete_popup").classList.add("hidden")
    };

    $("#ellipsis").on("click", function() {
        if ($("#edit_options").is(":hidden")) {
          $("#edit_options").removeClass("hidden");
          $("#ellipsis").addClass("hidden");
          $("#close").removeClass("hidden");
        }
      });

      $("#close").on("click", function() {
        if ($("#edit_options").is(":visible")) {
          $("#edit_options").addClass("hidden");
          $("#ellipsis").removeClass("hidden");
          $("#close").addClass("hidden");
      }
      });
// });
