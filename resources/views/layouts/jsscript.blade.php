<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
    $('#dtable').DataTable({});
  });

  $(document).off('click', '.view_menu');
  $(document).on('click', '.view_menu', function(e) {
    var menu = $(this).attr('link');
    $.ajax({
      type: 'GET',
      url: "{{ url('/') }}/" + menu,
      data: {
        menu: menu,
        kind: $(this).attr('kind')
      },
      dataType: 'JSON',
      success: function(response) {
        $('#menu-content').html(response);
        $('#menu-content').attr('tbl', menu);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        //alert();
        if (xhr.status == '404') {
          Swal.fire({
            title: 'Modul is not available yet, Please contact IT Team!',
            confirmButtonText: 'OK',
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              window.location = "{{ url('/') }}";
            }
          })
        } else {
          Swal.fire({
            title: 'Your session has expired, please re-login!',
            confirmButtonText: 'OK',
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              window.location = "{{ url('/') }}";
            }
          })
        }
        // alert(xhr.status + "\n" + xhr.dataText + "\n" + thrownError);
      }
    });
  });

  //function untuk pilih karyawan
  $(document).off('change', '#ibs_employee_id');
  $(document).on('change', '#ibs_employee_id', function(e) {
    $('#username').val($(this).find(':selected').attr('emp_nik'));
    $('#fullname').val($(this).find(':selected').attr('emp_name'));
    $('#email').val($(this).find(':selected').attr('emp_email'));
  });

  //function untuk menambahkan item pada form
  $(document).off('click', '#add_item');
  $(document).on('click', '#add_item', function(e) {
    var tbl = $(this).attr('tbl');
    var c = 1;

    $('.counter').each(function() {
      c += 1;
    });

    if (tbl == "trouble_ticket") {
      $('#tbl_item tr:last').after('<tr id="trid' + c + '"><td class="counter"><input type="hidden" id="created_item_by[]" name="created_item_by[]" value="{{ auth()->user()->id }}">' + c + '</td><td><textarea name="description[]" id="description[]" cols="30" class="form-control"></textarea></td><td><input type="file" name="file[]" id="file[]" class="btn btn-default btn-block btn-sm" accept="image/*"></td><td><button onclick="$(this).parent().parent().remove();" class="btn btn-default btn-block btn-sm"><img src="{!! asset("assets/images/delete.png") !!}" style="width:20px;height:20px;"></button></td></tr>');
    }
  });

  $(document).off('click', '.view_modal');
  $(document).on('click', '.view_modal', function(e) {
    var tbl = $(this).attr('tbl');
    switch (tbl) {
      case 'trouble_ticket':
        var id = $(this).attr('id');
        var menu = 'it/' + tbl + '/' + id + '/edit';
        var number = $(this).attr('number');
        $.ajax({
          type: 'GET',
          url: "{{ url('/') }}/" + menu,
          // data: {
          //   // data: data
          //   // menu: '/it/trouble_ticket/' + id + '/edit',
          //   // kind: $(this).attr('kind')
          // },
          dataType: 'JSON',
          success: function(data) {
            console.log(data);
            $('.modal-title').html('Ticket : ' + number);
            $('.modal-body').html(data);
            $('#modal-ticket').modal('show');
          },
          error: function(xhr, ajaxOptions, thrownError) {
            if (xhr.status == '404') {
              Swal.fire({
                title: 'Modul is not available yet, Please contact IT Team!',
                confirmButtonText: 'OK',
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                  window.location = "{{ url('/') }}";
                }
              })
            } else {
              Swal.fire({
                title: 'Something wrong, Please contact IT Team!',
                confirmButtonText: 'OK',
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                  window.location = "{{ url('/') }}";
                }
              })
            }
          }
        });

        break;

      default:
        break;
    }
  });

  $(document).off('change', '#status');
  $(document).on('change', '#status', function(e) {
    var id = $("#id").val();
    var tbl = $(this).attr('tbl');
    // alert(id);
    switch (tbl) {
    case 'employee':
      $.ajax({
      type: 'GET',
      url: "{{ url('/') }}/hrd/employee/" + id + "/edit",
      contentType: "application/json",
      data: {
        kind: $(this).val(),
      },
      success: function(response) {
        $(".result").html(response);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        //alert();
        if (xhr.status == '404') {
          alert('404');
        } else {
          alert('200');
        }
        // alert(xhr.status + "\n" + xhr.dataText + "\n" + thrownError);
        }
      });
      break;
    default:
      break;
    }
    return false;
  });

  $(document).off('change', '#list_status');
  $(document).on('change', '#list_status', function(e) {
    var tbl = $(this).attr('tbl');
    // alert(id);
    switch (tbl) {
    case 'employee':
      $.ajax({
      type: 'GET',
      url: "{{ url('/') }}/hrd/employee",
      contentType: "application/json",
      data: {
        status: $(this).val()
      },
      success: function(response) {
        $('#menu-content').html(response);
        $('#menu-content').attr('tbl', menu);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        //alert();
        if (xhr.status == '404') {
          alert('404');
        } else {
          alert('200');
        }
        // alert(xhr.status + "\n" + xhr.dataText + "\n" + thrownError);
        }
      });
      break;
    default:
      break;
    }
    return false;
  });  

  $('.save').click(function(event) {
    var tbl = $(this).attr("tbl");
    var form = $(this).closest("form");
    event.preventDefault();
    switch (tbl) {
      case 'trouble_ticket':
        Swal.fire({
          title: 'Data will be updated!',
          text: "The status of the item that is changed to suspend will delete the file attachment of the item. And the file can't be recovered. Are you sure want to update this data ?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, updated it!'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        }) 
        break;
      case 'employee':
        var status = $("#status").val();
        if (status == 4) {
          var id = $("#id").val();
          var reason_status = $("#reason_of_status").val();
          var menu = 'hrd/' + tbl + '/' + id + '/edit';
          $.ajax({
            type: 'GET',
            url: "{{ url('/') }}/" + menu,
            contentType: "application/json",
            data: {
              id: id,
              detail_status: reason_status,
              status: status
            },
            dataType: 'JSON',
            success: function(data) {
              $('.modal-title').html('Employee Reassignment');
              $('.modal-body').html(data);
              $('#modal-employee').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
              //alert();
              if (xhr.status == '404') {
                Swal.fire({
                  title: 'Modul is not available yet, Please contact IT Team!',
                  confirmButtonText: 'OK',
                }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                    window.location = "{{ url('/') }}";
                  }
                })
              } else {
                Swal.fire({
                  title: 'Something wrong, Please contact IT Team!',
                  confirmButtonText: 'OK',
                }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                    window.location = "{{ url('/') }}";
                  }
                })
              }
            }
          });          
        } else {
          Swal.fire({
            title: 'Data will be updated!',
            text: "Are you sure want to update this data ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, updated it!'
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit();
            }
          })
        }

        break;
      default:
        Swal.fire({
          title: 'Data will be updated!',
          text: "Are you sure want to update this data ?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, updated it!'
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
            // window.location.href = "{{ url('/') }}";
          }
        })
        break;
    }
    return false;
  });

  $('#trouble_repair').change(function(event) {
    var kind = $(this).val();
    // alert(kind);
    if (kind == 'external') {
      $("#ibs_vendor_id").show();
    } else {
      $("#ibs_vendor_id").hide();
      $("#ibs_vendor_id").val();
    }
    return false;
  });
</script>