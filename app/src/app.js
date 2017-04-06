
jQuery.each(["put","delete"], function( i, method ) {
  jQuery[ method ] = function( url, data, callback, type ) {
    if ( jQuery.isFunction( data ) ) {
      type = type || callback;
      callback = data;
      data = undefined;
    }

    return jQuery.ajax({
      url: url,
      type: method,
      dataType: type,
      data: data,
      success: callback
    });
  };
});

window.onload = function(){

    var User = function(name, email, password){
        this.name = name;
        this.email = email;
        this.password = password || "";
        this.phones = [];
    };

    User.prototype.addPhone = function (Phone) {
        this.phones.push(Phone);
    };

    User.prototype.getPhones = function(){
        return this.phones;
    };

    var Phone = function(number){
        this.number = number;
        this.user = null;
    };

    Phone.prototype.setUser = function(User){
        this.user = User;
    };

    //UserForm
    $("#register_user").on("click", function(evt){
          var fields = $("form").serialize();

          // add new user
          $.post("/api/user", fields, function(resp){
                var json = $.parseJSON(resp);

                if(json.success){
                    $("#register_user_success_alert").show();
                }
                else{
                   $("#register_user_danger_alert").show();
                }
          }).fail(function(a, b){

          });
    });

    //login form
    $("#loginbtn").on("click", function(evt){
          var fields = $("form").serialize();

          $.post("/api/session/login", fields, function(resp){
                var json = $.parseJSON(resp);

                if(json.success){
                    $("#login_error_alert").hide();
                    $("#login_success_alert").show();
                    window.location = "/";
                }
                else{
                    $("#login_error_alert").show();
                    $("#login_success_alert").hide();
                }
          });
    });

    //are you already logged in ?
    $.get("/api/session/check", function(resp){
         var json = $.parseJSON(resp);
         if(json.logged){
             $(".showif_notlogged").hide();
             $(".showif_logged").show();

             $(document).trigger("app.loggedin", [json.id]);
         }
         else{
             $(".showif_notlogged").show();
             $(".showif_logged").hide();

             $(document).trigger("app.loggedout", [json]);
         }
    });

    $("#loggout_action").on("click", function(evt){
        $.get("/api/session/logout", function(resp){
            var json = $.parseJSON(resp);
            if(json.success){
                window.location = "/";
            }
        });
    });


    $("#search_btn").on("click", function(evt){
        var term = $("#search_text").val();
        $("#search_table tbody tr.result_line").remove();

        $.get("/api/phone/search", {q :term}, function(resp){
              var json = $.parseJSON(resp);
              if(json){
                  $("#search_row").show();
                  var phones = json.result;
                  var str = " ";
                  for(var i=0; i < phones.length; i++){
                      str += "<tr class='result_line'>";
                      str += "<td># "+phones[i].username+"</td>";
                      str += "<td class='td_phonenum'>"+phones[i].phonenum+"</td>";
                      str += "</tr>";
                  }
                  $("#search_table tbody").append(str);
              }
        })
        .fail(function(a, b){

        });
    });

    $(document).trigger("app.loaded");
};
