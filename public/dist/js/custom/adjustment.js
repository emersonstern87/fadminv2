    'use strict';
    var typeValue = '';
    var stack = [];
    if ($('.main-body .page-wrapper').find('#adjustment-add,#card-with-header-buttons').length) {
      $(".js-example-basic-single").select2();
      $('#card-with-header-buttons select').prop('disabled', true);
    }

    $(function() {
      $("#transferTbl").DataTable({
        responsive: true,
        "language": {
          "url": app_locale_url
        },
        "paging": false,
        "searching": false,
        "bInfo": false,
        "ordering": false
      });
    });

    let preQuantity = 0;
    $(document).on("keydown", ".no_units", function(e) {
      preQuantity = $(this).val();
    });

    function deleteAddedRows() {
      $('.addedRow').each(function() {
        $(this).closest("tr").remove();
      });
    }

    $(function() {
      $(document).on('click', '#adjustment-add, #card-with-header-buttons', function(e) {
        if (e.target.id === 'no_div') {
          $('#no_div').hide();
        } else {
          $('#no_div').hide();
        }
      })
    });

    function in_array(search, array) {
      for (var i = 0; i < array.length; i++) {
        if (array[i] == search) {
          return true;
        }
      }
      return false;
    }

    $(function() {
      $('#datepicker').daterangepicker(dateSingleConfig(), function(start, end) {
        var startDate = moment(start, 'MMMM D, YYYY').format(dateFormat);
        $('#datepicker').val(startDate);
      });
    })

    $(document).ready(function() {
      $('.error').hide();
      $(window).keydown(function(event) {
        if (event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
    });

    // Delete item row
    $(document).ready(function(e) {
      $('#adjustment-add #transferTbl').on('click', '.delete_item', function() {
        var v = $(this).attr("id");
        stack = jQuery.grep(stack, function(value) {
          return value != v;
        });

        $(this).closest("tr").remove();
        var totalQty = calculateTotalQty();
        $('#total_qty').text(getDecimalNumberFormat(totalQty));
        $('#total_quantity').val(totalQty);
      });
    });

    $(document).ready(function(e) {
      $('#card-with-header-buttons #transferTbl').on('click', '.delete_item', function() {
        var v = $(this).attr("data-id");
        stack = jQuery.grep(stack, function(value) {
          return value != v;
        });
        stack.pop(v);
        $(this).closest("tr").remove();
        stack.splice($(this).attr("data-id"));
        totalQty = calculateTotalQty();
        $('#total_qty').text(getDecimalNumberFormat(totalQty));
        $('#total_quantity').val(getDecimalNumberFormat(totalQty));
      });
    });

    $(document).on('click', '#btnSubmit', function() {
      $("input[type=text]").each(function() {
        if ($(this).hasClass('error')) {
          $(this).focus();
          return false;
        }
      });
    });

    $(document).on('click', '.no_units', function(e) {
      $('.labelMindata-max').css('display', 'none');
    });

    $(document).on('click', function(event) {
      $('.labelMindata-max').css('display', 'none');
      $('.labelMindata-max').css('position', 'fixed');
    });

    $(document).on('keyup change input', '#adjustment-add .no_units', function(ev) {
      var qty = validateNumbers($(this).val());
      var id = $(this).attr("data-id");
      if ($("#type").val() == 'STOCKOUT') {
        $.ajax({
            method: "POST",
            url: SITE_URL + "/stock_adjustment/check-item-qty",
            data: {
              "item_id": id,
              "_token": token,
              source: $('#location').val()
            }
          })
          .done(function(data) {
            var data = JSON.parse(data);
            var maxQty = $("#qty_" + id).attr("data-max");
            if (Number(qty) > Number(maxQty)) {
              $("#qty_" + id).val(preQuantity);
              swal(data.qty + ' ' + jsLang('item(s) available in stock'), {
                icon: "error",
              });
              $("#qty_" + id).val(preQuantity);
              totalQty = calculateTotalQty();
              $('#total_qty').text(getDecimalNumberFormat(totalQty));
              return getDecimalNumberFormat(preQuantity);
            }
          });
      }
      var totalQty = calculateTotalQty();
      $('#total_qty').text(totalQty);
      $('#total_quantity').val(totalQty);
    });

    $(document).on('keyup change input', '#card-with-header-buttons .no_units', function(ev) {
      var qty = parseFloat(validateNumbers($(this).val()));
      var id = $(this).attr("data-id");
      var old_qty = parseFloat($(this).attr("old-qty") ? $(this).attr("old-qty") : 0);

      if ($("#type").val() == 'STOCKOUT') {
        $.ajax({
          method: "POST",
          url: SITE_URL + "/stock_adjustment/check-item-qty",
          data: {
            "item_id": id,
            "_token": token,
            source: $('#location').val()
          }
        }).done(function(data) {
          var data = JSON.parse(data);
          $("#qty_" + id).attr("data_max", (data_max > 0) ? data_max : (Number(old_qty) + Number(data.qty)));
          if (Number(qty) > Number(old_qty) + Number(data.qty)) {
            swal(getDecimalNumberFormat(data.qty) + ' ' + jsLang('item(s) available in stock'), {
              icon: "error",
              buttons: [false, jsLang('Ok')],
            });
            $("#qty_" + id).val(preQuantity);
            totalQty = calculateTotalQty();
            $('#total_qty').text(getDecimalNumberFormat(totalQty));
            return getDecimalNumberFormat(preQuantity);
          }
        });
      }
      totalQty = calculateTotalQty();
      $('#total_qty').text(getDecimalNumberFormat(totalQty));
      $('#total_quantity').val(getDecimalNumberFormat(totalQty));
    });

   if ($('.main-body .page-wrapper').find('#card-with-header-buttons').length) {
    $('#card-with-header-buttons #transferForm').validate({
      rules: {
        type: {
          required: true,
        },
        location: {
          required: true,
        },
        date: {
          required: true,
        },
        'item_quantity[]': {
          required: true,
        },
        'new_item_quantity[]': {
          required: true,
        }
      },
      // Checking if any item has been added before submit adn showing error
      submitHandler: function() {
        var x = document.getElementsByClassName("addedRow");
        if (x.length == 0) {
          swal(jsLang('Please select at least one item.'), {
            icon: "error",
            buttons: [false, jsLang('Ok')],
          });
          return false;
        }
        return true;
      }
    });
  }

    if ($('.main-body .page-wrapper').find('#adjustment-add').length) {
      $('#adjustment-add #transferForm').validate({
        rules: {
          type: {
            required: true,
          },
          location: {
            required: true,
          },
          date: {
            required: true,
          },
          'quantity[]': {
            required: true,
          }
        },
        messages: {
          'quantity[]': {
            required: "",
          }
        },
        // Checking if any item has been added before submit adn showing error
        submitHandler: function() {
          var x = document.getElementsByClassName("addedRow");
          if (x.length == 0) {
            swal({
              text: jsLang('Please select at least one item.'),
              icon: "error",
              buttons: [false, jsLang('Ok')],
            })
            return false;
          }
          return true;
        }
      });
    }

    function calculateTotalQty() {
      var total = 0;
      $('.no_units').each(function() {
        total += parseFloat($(this).val() ? validateNumbers($(this).val()) : 0);
      });
      if (total == 0) {
        swal(jsLang('Please select at least one item.'), {
          icon: "error",
          buttons: [false, jsLang('Ok')],
        });
        $('#btnSubmit').attr('disabled', 'true');
      } else if (total > 0) {
        $('#btnSubmit').removeAttr('disabled');
      }
      return total;
    }

    let global_source_id;
    let global_type;
    $("#adjustment-add #location").on("change", function() {
      stack = [];
      $('.error').hide();
      $("#errorMessage").text(' ');
      var location = $('#location').val();
      var source = $(this).val();
      if (global_source_id != null && $('#transferTbl tr').hasClass('addedRow') == true) {
        swal({
            title: jsLang('Are you sure?'),
            text: jsLang('Change of location will reset added products/services, please confirm you really want to do this.'),
            icon: "warning",
            buttons: [jsLang('Cancel'), jsLang('Ok')],
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              global_source_id = $("#location").val();
              $('.closeRow').trigger('click');
              deleteAddedRows();
              $('#total_qty').text('0');
            } else {
              $("#location").val(global_source_id);
              $("#location").trigger('change.select2');
            }
          });
      } else {
        global_source_id = $("#location").val();
      }

      if (global_source_id != "") {
        $("#source-error").css("display", 'none');
      }
      if ($("#type").val() && $('#location').val()) {
        $('#error_message').html('');
      }
    });

    $("#adjustment-add #type").on("change", function() {
      stack = [];
      $('.error').hide();
      $("#errorMessage").text(' ');
      typeValue = $('#type').val();
      if (global_type != null) {
        swal({
            title: jsLang('Are you sure?'),
            text: jsLang('Change of location will reset added products/services, please confirm you really want to do this.'),
            icon: "warning",
            buttons: [jsLang('Cancel'), jsLang('Ok')],
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              global_type = $("#type").val();
              $('.closeRow').trigger('click');
              deleteAddedRows();
              $('#total_qty').text('0');
            } else {
              $("#type").val(global_type);
              $("#type").trigger('change.select2');
            }
          });
      } else {
        global_type = $("#type").val();
      }
      if (global_type != "") {
        $("#type-error").css("display", 'none');
      }
    });

    $(document).on("click", "#csv, #pdf", function(event){
      event.preventDefault();
      window.location = SITE_URL+"/stock/adjustment-" + this.id + "?to=" + $('#endto').val() + "&from=" + $('#startfrom').val() + "&trans_type=" + $('#trans_type').val() + "&location=" + $('#destination').val();
    });

    $('.list-container #dataTableBuilder').addClass('stock-transfer-list');

    if ($('.main-body .page-wrapper').find('#adjustment-add').length) {
    // For adding search
    $("#adjustment-add #search").autocomplete({
    delay: 500,
    position: { my: "left top", at: "left bottom", collision: "flip" },
    source: function(request, response) {
      var type_id = $('#type').val();
      var source_id = $('#location').val();
      if (!type_id) {
        $('#error_message').html(jsLang('Please select Type and Source'));
        $('#type').select2('open');
        if (type_id) {
          $('#location').select2('open');
          $('#error_message').html('');
        }
        $('html, body').animate({
          scrollTop: 0
        }, 500);
        return false;
      } else {
        $('#error_message').html('');
      }
      if (type_id && !source_id ) {
        $('#error_message').html(jsLang('Please select Source'));
        $('#location').select2('open');
        return false;
      }
      $.ajax({
        url: SITE_URL+'/adjustment/search',
        type: "post",
        dataType: "json",
        data: {
          _token:token,
          search: request.term,
          location: source_id
        },
        success: function(data){
          //Start
          if(data.status_no == 1){
            $("#val_item").html();
            var data = data.items;
            $('#no_div').css('display','none');
            response( $.map( data, function( item ) {
              return {
                id: item.id,
                value: item.name,
                available: item.available,
                is_stock_managed: item.is_stock_managed
              }
            }));
          } else {
            $('.ui-menu-item').remove();
            $("#no_div").css('display','block');
          }
          //end
        }
      })
    },
    select: function(event, ui) {
      var e = ui.item;
      if(e.id) {
        if (e.is_stock_managed == 1 &&  e.available <= 0 && $('#type').val()=='STOCKOUT') {
          swal(e.available + ' ' +  jsLang('item(s) available in stock'), {
            icon: "error",
            buttons: [false, jsLang('Ok')],
          });
          return false;
        }
        if(!in_array(e.id, stack)) {
          var new_row = '<tr class="addedRow" id="rowid'+e.id+'">'+
                          '<td class="text-center">'+ e.value + '</div>' + '<input type="hidden" name="description[]" value="'+e.value+'"><input type="hidden" name="stock[]" value="'+e.id+'"></td>'+
                          '<td><input class="form-control text-center no_units positive-float-number" stock-id="'+e.id+'" id="qty_'+e.id+'" data-id="'+e.id+'" type="text" name="quantity[]" value="1">'
                          
                          + '<label id="qty_'+e.id+'-error" class="error labelMindata-max" for="qty_'+e.id+'"></label>' +
                          '<div id="errorMessage-'+e.id+'"'+' class="color_red f-bold"><input type="hidden" name="id[]" value="'+e.id+'"></td>'+
                          '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="feather icon-trash-2"></i></button></td>'+
                        '</tr>';
          if (stack.length <= 0) {
            $(".dataTables_empty").parent().remove();
          }
          $("#item-body").append(new_row);
          stack.push(e.id);
        } else {
          $('#qty_'+e.id).val( function(i, oldval) {
            oldval = validateNumbers(oldval);
            if ($("#type").val() == 'STOCKOUT') {
              if (parseFloat(e.available) < parseFloat(oldval) + 1) {
                swal(e.available + ' ' + jsLang('item(s) available in stock'), {
                  icon: "error",
                  buttons: [false, jsLang('Ok')],
                });
                return (getDecimalNumberFormat(oldval))
              }
              if (Number.isInteger(parseFloat(oldval))) {
                $('#qty_'+e.id).trigger("change");
                return parseFloat(++oldval);
              } else {
                $('#qty_'+e.id).trigger("change");
                return getDecimalNumberFormat(++oldval);
              }
            } else {
              if (Number.isInteger(parseFloat(oldval))) {
                $('#qty_'+e.id).trigger("change");
                return parseFloat(++oldval);
              } else {
                $('#qty_'+e.id).trigger("change");
                return getDecimalNumberFormat(++oldval);
              }
            }
          });
        }
        $(this).val('');
        // Check item Quantity Location-Wise
        if ($("#type").val() == 'STOCKOUT'){
          $.ajax({
            method: "POST",
            url: SITE_URL+"/stock_adjustment/check-item-qty",
            data: { "item_id": e.id,"_token":token,source:$('#location').val() }
          })
          .done(function( data ) {
            var data = JSON.parse(data);
            $("#qty_"+data.id).attr("data-max", data.qty);
            var addedQty = $("#qty_"+e.id).val();
            if (data.qty < Number(addedQty)) {
              $("#qty_"+data.id).attr("data-max", data.qty);
              $('#qty_'+e.id).trigger("change");
              $("#errorMessage").html(data.message);
              var totalQty = calculateTotalQty();
              $('#total_qty').text(getDecimalNumberFormat(totalQty));
            }
          });
        }

        // End ehcking quantity
        var totalQty = calculateTotalQty();
        $('#total_qty').text(getDecimalNumberFormat(totalQty));
        $('#total_quantity').val(totalQty);
        return false;
      }
    },
    minLength: 1,
    autoFocus: true
  }).on('focus', function(){ $(this).autocomplete("search"); } )
  .autocomplete( "instance" )._renderItem = function( ul, item ) {
    var available;
    if (item.is_stock_managed == 1) {
      available = item.available;
    } else {
      available = "-";
    }
    return $( "<li>" )
    .append( "<div>" + item.value + "<br>" + jsLang('Available') + " : " + available + "</div>" )
    .appendTo( ul );
  };
}

if ($('.main-body .page-wrapper').find('#card-with-header-buttons').length) {
    let preQty = 0;
    var totalQty = 0;
    var oldQuantity = 0;
    var data_max = 0;

  // Edit autocomplete
      $("#card-with-header-buttons #search").autocomplete({
        delay: 500,
        position: { my: "left top", at: "left bottom", collision: "flip" },
        source: function(request, response) {
            var typeValue = $('#type').val();
            var source_id = $('#location').val();
            $.ajax({
                url: SITE_URL+'/adjustment/search',
                type: "post",
                dataType: "json",
                data: {
                    _token:token,
                    adjustment_id: adjustmentId,
                    type: adjustmentType,
                    search: request.term,
                    location: source_id
                },
                success: function(data){
                  //Start
                    if(data.status_no == 1){
                    $("#val_item").html();
                    var data = data.items;
                        $('#no_div').css('display','none');
                        response( $.map( data, function( item ) {
                            return {
                                id: item.id,
                                value: item.name,
                                available: item.available,
                                is_stock_managed: item.is_stock_managed
                            }
                        }));
                    } else {
                        $('.ui-menu').remove();
                        $("#no_div").css('display','block');
                    }
                }
            })
        },

        select: function(event, ui) {
            var e = ui.item;
            if(e.id) {
                if ($("#type").val() == 'STOCKOUT') {
                    if (e.is_stock_managed == 1 &&  e.available <= 0) {
                        swal(e.available + ' ' + jsLang('item(s) available in stock'), {
                            icon: "error",
                            buttons: [false, jsLang('Ok')],
                        });
                        return false;
                    }
                }
                if(!in_array(e.id, stack))
                {
                    var new_row = '<tr class="addedRow" id="rowid' + e.id + '">' +
                                      '<td class="text-center">'+ e.value + '<input type="hidden" name="new_description[]" value="' + e.value + '"><input type="hidden" name="new_stock[]" value="' + e.id + '"></td>' + 
                                      '<td> <input class="form-control text-center no_units positive-float-number" data-id="' + e.id + '" data-rate="' + e.price + '" type="text" id="qty_' + e.id + '" name="new_item_quantity[]" value="1">' +
                                      '<label id="qty_'+e.id+'-error" class="error labelMindata-max" for="qty_'+e.id+'"></label>'
                                       + '<div id="errorMessage-' + e.id + '"' + 'class="color_red f-bold"></div>' + '<input type="hidden" name="new_item_id[]" value="' + e.id + '"></td>' +
                                      '<td class="text-center"><button id="' + e.id + '" class="btn btn-xs btn-danger delete_item"><i class="feather icon-trash-2"></i></button></td>' +
                                    '</tr>';
                    $("#item-body").append(new_row);
                    stack.push(e.id);
                } else {
                    var availableItem = $('#qty_'+e.id).attr("data-max");
                    var quantity = validateNumbers($('#qty_'+e.id).val());
                    if (e.is_stock_managed == 1 && availableItem < parseFloat(quantity) + 1) {
                        swal(availableItem + ' ' + jsLang('item(s) available in stock'), {
                            icon: "error",
                            buttons: [false, jsLang('Ok')],
                        });
                    }
                    else if (Number.isInteger(parseFloat(quantity))) {
                        $('#qty_'+e.id).val(parseInt(++quantity));
                    } else {
                        $('#qty_'+e.id).val(getDecimalNumberFormat(++quantity));
                    }
                }
                $(this).val('');
                var totalQty = calculateTotalQty();
                $('#total_qty').text(getDecimalNumberFormat(totalQty));
                $('#total_quantity').val(getDecimalNumberFormat(totalQty));
                return false;
            }
        },
        minLength: 1,
        autoFocus: true
    }).on('focus', function(){ $(this).autocomplete("search"); } )
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        var available;
        if (item.is_stock_managed == 1) {
          available = item.available;
        } else {
          available = "-";
        }
        return $( "<li>" )
        .append( "<div>" + item.value + "<br>" + jsLang('Available') + " : " + available + "</div>" )
        .appendTo( ul );
    };
}

if ($("#stock-details-container").find("#dataTableBuilder").length) {
    $(function () {
        $("#dataTableBuilder").DataTable({
            responsive: true,
            "language": {
                "url": app_locale_url
              },
            "paging": false,
            "searching": false,
            "bInfo" : false,
            "ordering": false
        });
    });
  }