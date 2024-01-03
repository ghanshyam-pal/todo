(function($) {
  "use strict"

  var baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');

      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        
    });

    content('all');
      const inputBox = $("#input-box");
      const button = $("button");
      const list = $("#list-container");

      function addTask() {
        if (inputBox.val() === '') {
          Toast.fire({ icon: 'warning', title: 'Enter Some Task' });
        } else {
          var form = $('form');
          $.post(form.attr("action"), form.serialize(), function(res) {
            if (res.success) {
              Toast.fire({ icon: 'success', title: res.message });
              let li = $("<li class='' data-id='"+ res.id +"' data-controller='toggle-status' data-mark='all'></li>").html(inputBox.val());
              list.append(li);
              inputBox.val('');
              let span = $("<span data-id='"+ res.id +"' data-controller='delete'></span>").html("x");
              li.append(span);
            } else if (res.success == false && typeof res.message != 'object') {
                Toast.fire({ icon: 'warning', title: res.message });
            } else {
                var errorsHtml = '';
                $.each(res.message, function(key, value) {
                    errorsHtml += value[0] + '<br/>';
                });
                Toast.fire({ icon: 'warning', title: errorsHtml });
            }
          });
        }
        return false;
      }

      list.on("click", "li", function() {
        var _this = $(this);
        var id = $(this).data('id');
        var action = $(this).data('controller');
        var mark = $(this).data('mark');
        
        if (id != '') {
          $.post(action, { _token: _token, id: id }, function(res) {
              if (res.success) {
                  Toast.fire({ icon: 'success', title: res.message });
                  if(mark=='all'){
                    _this.toggleClass("checked");
                  }else{
                    _this.remove();
                  }
                  console.log(action);
                  
              } else { Toast.fire({ icon: 'warning', title: res.message }); }
          });
        }
        return false;
      });



      list.on("click", "span", function() {
        var _this = $(this);
        var id = _this.data('id');
        var action = _this.data('controller');
        if (id != '') {
            Swal.fire({
                title: 'Are you sure?',
                text: "Delete this data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                /* isConfirmed */
                if (result.isConfirmed) {
                    $.post(action, { _token: _token, id: id }, function(res) {
                        if (res.success) {
                            _this.parent().remove();
                            Toast.fire({ icon: 'success', title: res.message });
                        } else { Toast.fire({ icon: 'warning', title: res.message }); }
                    });
                }
            });
        }
        return false;
      });

      button.on("click", addTask);

      function content( type){
        var del = 'delete';
        var ctrl = 'toggle-status';
        // if(type=='all'){
        //   sts = type;
        // }
        // }else if(type=='completed'){
        //   url = type;
        // }else if(type=='incompleted'){
        //   url = type;
        if(type=='trash'){
          del = 'hard-delete';
          ctrl = 'restore'
        }
        $.ajax({
          type: 'GET',
          url: type, // Update this with the actual route URL
          success: function (data) {
              // Update your list-container with the received JSON data
              $('#list-container').html('');
              $.each(data, function (index, item) {
                  $('#list-container').append('<li class="' + (item.status ? 'checked' : '') + '" data-id="' + item.id + '" data-controller="'+ctrl+'" data-mark="'+type+'">' + item.task + '<span data-id="' + item.id + '" data-controller="'+del+'">x</span><span class="edit">E </span></li>');
              });
          },
          error: function (error) {
              console.log('Error:', error);
          }
      });
        // console.log(data);
      }

      $('p').on('click',function(){
        $('p').removeClass('p')
        if($(this).html()=='All'){
          content('all');
        }else if($(this).html()=='Completed'){
          content('completed');
        }else if($(this).html()=='Incompleted'){
          content('incompleted');
        }else if($(this).html()=='Trash'){
          content('trash');
        }
        $(this).addClass('p')
      });

      list.on("click", ".edit", function() {

        var _this = $(this);
        var id = _this.parent().data('id');
        var action = 'update';
        var pre = _this.parent().text().slice(0, -3);
        

        Swal.fire({
          title: "Enter New Value",
          input: "text",
          inputAttributes: {
            autocapitalize: "off",placeholder: pre
          },
          showCancelButton: true,
          confirmButtonText: "Update",
          
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
          if (result.isConfirmed) {
              $.post(action, { _token: _token, id: id, task: result.value }, function(res) {
                  if (res.success) {
                      $('li[data-id='+id+']').contents().filter(function() {
                        return this.nodeType === 3; // Node.TEXT_NODE
                    }).replaceWith(result.value);
                      Toast.fire({ icon: 'success', title: res.message });
                  } else { Toast.fire({ icon: 'warning', title: res.message }); }
              });
          }
        });
        return false;
      });



    })(jQuery);
