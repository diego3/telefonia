var user = null;

$(document).one("app.loaded", function() {
    // /minhaconta page
    $(document).on("click", "#useredit", function(evt){
        $(".userdata").hide();
        $(".loginresiterrow").show();

        $("#name_id").val(user.username);
        $("#email_id").val(user.email);
        $("#userid").val(user.userid);
    });

    $(document).one("app.loggedin", function(evt, userId){

        //get and display the user data
        $.get("/api/user/"+userId, function(resp){
              var data = $.parseJSON(resp);
                  user = data.user;

              $("#userdatas")
                .append("<p>" + user.username + "</p>")
                .append("<p>" + user.email + "</p>");
        });

        //get and display all the phones for the logged user
        $.get("/api/phone/user", function(resp){
              var data = $.parseJSON(resp);
              var phones = data.phones;
              var str = " ";
              for(var i=0; i < phones.length; i++){
                  str += "<tr data-telid='"+phones[i].telefoneid+"' class='tr_phone'>";
                  str += "<td>#"+phones[i].telefoneid+"</td>";
                  str += "<td class='td_phonenum'>"+phones[i].phonenum+"</td>";
                  str += "<td><button class='btn btn-xs btn-primary edit_phone' type='button'>Editar</button> ";
                  str += "<button class='btn btn-xs btn-primary delete_phone' type='button'>Remover</button> ";
                  str += "<button class='btn btn-xs btn-primary update_phone' type='button'>Atualiza</button> </td>";
                  str += "</tr>";
              }
              $("#phone_table tbody").append(str);
        });
    });

    //adjust the table row allowing the user to update the phone number
    $(document).on("click", ".edit_phone", function(evt){
          var $del =   $(this).closest('tr').find(".delete_phone");
          var $update =   $(this).closest('tr').find(".update_phone");
          var phoneid   = $(this).closest('tr').data('telid');
          var $phonenum = $(this).closest('tr').find('.td_phonenum');
          var num = $phonenum.text();
                    $phonenum.text('');
          var input = "<input type='text' class='dynamic_input' value='"+num+"'> ";
          var addBtn = "";
          $phonenum.append(input);
          $update.show();
          $(this).hide();
          $del.hide();
    });

    //update the phone number
    $(document).on("click", ".update_phone", function(evt){
        var $this = $(this);
        var $del  = $(this).closest('tr').find(".delete_phone");
        var $edit = $(this).closest('tr').find(".edit_phone");
        var newphone = $(this).closest('tr').find('.dynamic_input').val();
        var id = $(this).closest('tr').data('telid');

        $.put("/api/phone/", {id:id, num: newphone}, function(resp){
             var json = $.parseJSON(resp);
             if(json.success){
                $del.show();
                $edit.show();
                $this.hide();
                $this.closest("tr").find(".td_phonenum").text(newphone);
                $this.closest("tr").find(".dynamic_input").remove();
             }
        });
    });

    //delete a phone
    $(document).on("click", ".delete_phone", function(evt){
        var $this = $(this);
        var id = $(this).closest('tr').data('telid');

        $.delete("/api/phone/"+id, function(resp){
             var json = $.parseJSON(resp);
             if(json.success){
                $this.closest("tr").remove();
             }
        });
    });

    //just update the user data
    $(document).on("click", "#update_user_btn", function(evt){
         var fields = $("form").serialize();
         var userid = $("#userid").val();

         $.put("/api/user", fields, function(resp){
              var json = $.parseJSON(resp);
              if(json.success){
                  $("#user_success_alert").show();
                  $("#user_danger_alert").hide();
              }
              else{
                  $("#user_success_alert").hide();
                  $("#user_danger_alert").show();
              }
         });
    });

    //create a new table row
    $(document).on("click", "#add_phone", function(evt){
        var str = "<tr class='tr_phone' >";
            str += "<td>#</td>";
            str += "<td class='td_phonenum'><input type='text' class='remove_me'></td>";
            str += "<td><button class='btn btn-xs btn-primary confirm_phone'>adiciona</button></td>";
            str += "</tr>";

        $("#phone_table tbody").append(str);
    });

    //confirm the phone insert
    $(document).on("click", ".confirm_phone", function(evt){
        var $this = $(this);
        var n = $(this).closest("tr").find(".remove_me").val();
        $.post("/api/phone", {number: n, user: user.userid}, function(resp){
            var json = $.parseJSON(resp);
            var $input = $this.closest("tr").find('.remove_me');
            var num = $input.val();
                $input.remove();
            $this.closest("tr").find(".td_phonenum").text(num);
            $this.closest("tr").attr("data-telid", json.last_id);

            var str = "<td><button class='btn btn-xs btn-primary edit_phone' type='button'>Editar</button> ";
            str += "<button class='btn btn-xs btn-primary delete_phone' type='button'>Remover</button> ";
            str += "<button class='btn btn-xs btn-primary update_phone' type='button'>Atualiza</button> </td>";

            $this.closest("tr").find(".td_phonenum").after(str);
            $this.remove();
        });
    });
});
