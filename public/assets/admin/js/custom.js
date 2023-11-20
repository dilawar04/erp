(function ($) {
    $(document).ready(function () {

        $(window).resize(function() {
            /* Same as before */
            if($('.vertical-table').length > 0) {
                setTimeout(function () {
                    vertical_table();
                }, 200);
            }
        }).resize();


        function vertical_table() {
            $('.vertical-table table').each(function (i, ele) {
                let $table = $(ele);
                /*$table.css({'display' : 'table'});
                $('thead', $table).css({'display' : 'table-header-group'});
                $('thead tr', $table).css({'display' : 'table-row'});
                $('thead th,thead td', $table).css({'display' : 'table-cell'});*/
                // Change the selector if needed
                let $bodyCells = $table.find('thead tr:first').children(),
                    tableWidth = $table.width(),
                    colWidth;
                let children = $table.find('tbody tr td');

                if(children.length > 1) {
                    // Get the tbody columns width array
                    colWidth = $bodyCells.map(function () {
                        //return $(this).width();
                        return $(this).outerWidth();
                    }).get();

                    $('thead', $table).css({'display': 'block'});
                    $table.find('thead tr').children().each(function (i, v) {
                        $(v).width(colWidth[i]);//.attr('width', colWidth[i]);
                    });

                    $table.css({'display': 'block'});
                    $('tbody', $table).css({'display': 'block', 'overflow-y': 'auto', 'overflow': 'unset'});
                    let scrollWidth = 0;//$('tbody', $table).scrollWidth;
                    //$('tr', $table).width(tableWidth);
                    // Set the width of thead columns

                    children.each(function (i, v) {
                        if ($bodyCells.length % i) {
                            $(v).width(colWidth[i] - scrollWidth);
                        } else
                            $(v).width(colWidth[i]);//.attr('width', (colWidth[i]));
                    });
                }
            });
        }

        if($('#assign_data').length > 0) {
            $('#assign_data .table-responsive > br').remove()
        }

        $(document).on('click', '[kt-dropdown-persistent="1"]', function (e) {
            e.stopPropagation();
        });

        $(document).on('click', '[data-ktportlet-remove]', function (e) {
            e.preventDefault();
            $(this).closest($(this).data('ktportlet-remove')).remove();
        });
        $(document).on('click', '[data-ktportlet-toogle]', function (e) {
            e.preventDefault();
            $(this).closest($(this).data('ktportlet-remove')).remove();
        });

        let _copy_duplicate = [];
        $(document).on('click', '.same-as', function (e) {
            let _this = $(this);
            let dd = _this.closest('.input-group').find('.dropdown-menu');
            $('.json-c .new', dd).html('');

            $('tr.clone').each(function (i, ele) {
                let _json = {};
                $('[input]', ele).each(function (ii, ee) {
                    ee = $(ee);
                    console.log(ee);
                    let input =  ee.attr('input');
                    if($.inArray(input, Array('mobiles', 'phones', 'emails')) !== -1) {
                        _json[input] = [ee.val()];
                    }else {
                        _json[input] = ee.val();
                    }
                });

                console.log($.inArray(_json.name, _copy_duplicate), _copy_duplicate);
                if(_json.name.length > 0){
                    _copy_duplicate.push(_json.name);
                    $('.json-c .new', dd).append('<a class="dropdown-item copy-json" data-json=\''+JSON.stringify(_json)+'\'>'+ _json.name +'</a>');
                }
            });


        });


        $(document).on('click', 'a.copy-json', function (e) {
            e.preventDefault();
            let _this = $(this);
            let _data = _this.data();
            let j_data = _data.json;

            let tr = _this.closest('tr');
            $('input,select,textarea', tr).each(function (i, input) {
                let input_name = $(input).attr('input');
                let input_val = (j_data[input_name]);

                if(input_name === 'department') {
                    return true;
                }
                if($.inArray(input_name, Array('mobiles', 'phones', 'emails')) !== -1) {
                    if(typeof input_val === 'string'){
                        $(input).val($.parseJSON(input_val).join(','));
                    } else if(typeof input_val === 'object' && input_val !== null){
                        $(input).val(input_val.join(','));
                    }
                } else if($(input).hasClass('no-change')){
                    //$(input).val(input_val);
                } else {
                    $(input).val(input_val);
                }
            });

        });



        let tr_copy;
        $(document).on('click', '.tr-copy', function (e) {
            e.preventDefault();
            let _this = $(this);
            tr_copy = _this.closest('tr');
        });
        $(document).on('click', '.tr-paste', function (e) {
            e.preventDefault();
            let _this = $(this);
            let tr = _this.closest('tr');
            $('td', tr_copy).each(function (i, td) {
                let _td = $(td);
                let _input = tr.find("[input='"+_td.attr('input')+"']");
                if (_input.is('textarea')) {
                    tr.find("[input='"+_td.attr('input')+"']").val(_td.html());
                } else {
                    tr.find("[input='"+_td.attr('input')+"']").val(_td.html());
                }
            });
        });

        $(document).on('click', '.tr-clone', function (e) {
            e.preventDefault();
            let tbody = $(this).closest('tbody');
            let tr = $(this).closest('tr');
            tbody.append(tr.clone());
        });

        $(document).on('click', '.add_more,.add-more', function (e) {
            e.preventDefault();
            let _this = $(this);
            //console.log(_this);
            let callback = _this.attr('callback');

            let clone_container = false;
            let _closest = _this.attr('clone-closest');
            if(_closest === "true"){
                clone_container = _this.closest(_this.attr('clone-container'));
                console.log(clone_container);
            } else if(_closest !== 'true' && typeof _closest === 'string' && _closest.length > 0){
                clone_container = _this.closest(_closest).find(_this.attr('clone-container'));
                console.log(clone_container);
            } else {
                clone_container = $(_this.attr('clone-container'));
                console.log(clone_container);
            }

            if(!clone_container){
                clone_container = _this.parents('.clone_container');
            }

            let clone;
            if(_this.is('[clone]')){
                clone = $(_this.attr('clone') + ':last').clone();
            } else {
                clone = clone_container.find('.clone:last').clone();
            }
            console.log(clone, 'clone');

            clone.find('.close-btn').show();
            clone.find('input,textarea').not(':checked,:radio,button,submit,reset,.no-change').val('');
            clone.find(':checked,:radio').attr('checked', false).parent().removeClass('checked');
            clone.find('select > option').attr('selected', false);
            clone.find('select > option:eq(0)').attr('selected', true);
            clone_container.append(clone);

            var clone_len = clone_container.find('.clone').length;
            var clone_last = clone_container.find('.clone:last');
            clone_last.find('select,input,textarea').each(function () {
                var id = $(this).attr('id');
                $(this).attr('id', id + '_' + clone_len);

                if ($(this).hasClass('styled') && $(this).is("select")) {
                    $(this).parent('div[id^=uniform]').find('span').remove();
                    $(this).parent('div[id^=uniform]').find('select').unwrap().uniform();

                } else if ($(this).hasClass('select') && $(this).is("select")) {
                    console.log(clone_last, 'clone_last');
                    clone_last.find('.select2-container').remove();
                    clone_last.find('select').removeClass('select2-offscreen');
                    clone_last.find('select').select2();
                }
            });
            if (callback) {
                var fn = window[callback];

                if (typeof fn === 'function') {
                    fn(clone, clone_container);
                }
            }

        });

        $(document).on('click', '[remove-el]', function (e) {
            e.preventDefault();
            let _this = $(this);
            //remove-el=".parent_cls-.clone" | remove-el="parent-.clone" | remove-el=".clone"
            let callback = _this.attr('callback');

            let remove_limit = _this.attr('remove-limit') ?? 1;
            let remove_el = _this.attr('remove-el');
            let remove_el_ar = remove_el.split('-');
            console.log(remove_el_ar);

            if (!['', 'parents'].includes(remove_el_ar[0])) {
                if(_this.closest(remove_el_ar[0]).find(remove_el_ar[1]).length > remove_limit) {
                    _this.closest(remove_el_ar[1]).remove();
                } else
                    toastr.warning("Minimum (" + remove_limit + ") element required!")
            } else if (remove_el_ar[0] === 'parent') {
                if($(remove_el_ar[1]).length > remove_limit) {
                    _this.closest(remove_el_ar[1]).remove();
                } else
                    toastr.warning("Minimum (" + remove_limit + ") element required!")
            } else if (remove_el_ar[0] === '') {
                if($(remove_el_ar[1]).length > remove_limit) {
                    _this.closest(remove_el_ar[1]).remove();
                } else
                    toastr.warning("Minimum (" + remove_limit + ") element required!")
            } else {
                if($(remove_el_ar[0]).length > remove_limit) {
                    $(remove_el_ar[0]).remove();
                } else
                    toastr.warning("Minimum (" + remove_limit + ") element required!")
            }

            if (callback) {
                let fn = window[callback];
                if (typeof fn === 'function') {
                    fn(remove_el, remove_el_ar);
                }
            }

        });
        /*===============================*/
        var a = moment().subtract(29, "days"), t = moment();
        if($('.m_daterangepicker').length > 0){
            $('.m_daterangepicker').each(function () {
                let picker_ele = $(this);
                let _data = picker_ele.data();

                if(!_data.format){
                    _data.format = 'YYYY-MM-DD';
                }

                picker_ele.daterangepicker({
                    //buttonClasses: "m-btn btn",
                    applyClass: "btn-primary",
                    cancelClass: "btn-secondary",
                    autoUpdateInput : false,
                    /*startDate: a,
                    endDate: t,*/
                    locale: {
                        format: _data.format
                    },
                    ranges: {
                        Today: [moment(), moment()],
                        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                        "Last 7 Days": [moment().subtract(6, "days"), moment()],
                        "Last 30 Days": [moment().subtract(29, "days"), moment()],
                        "This Month": [moment().startOf("month"), moment().endOf("month")],
                        "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")],
                        "Three Month": [moment().subtract(3, "month").startOf("month"), moment().endOf("month")]
                    }
                }, function (start, end, n) {
                    picker_ele.val(start.format(_data.format) + " - " + end.format(_data.format));
                })
            })
        }

        function showRequest(Request, _form, options) {
            var config = _form.data();
            var _fn = window[config.beforesubmit];
            if(typeof _fn === 'function') {
                _fn(Request, _form, options);
            }
        }
        function showResponse(Response,statusText, xhr, _form) {
            var config = _form.data();
            var _fn = window[config.success];
            if(typeof _fn === 'function') {
                _fn(Response, statusText, xhr, _form);
            }
        }

        $('.ajax-form').submit(function() {

            var _form = $(this);
            var config = _form.data();

            var _default = {
                beforeSubmit:  showRequest,
                success:       showResponse
            };

            if(config.popup == 1){
                var popup_default = {title : 'Are you sure?', text: "You won't be able to do this!", type : 'warning', showcancelbutton: !0, confirmbuttontext: "Confirm!", cancelbuttontext: "Cancel!", reversebuttons: !0};
                var popup_op = $.extend(true, {}, popup_default, config.popup_config);
                swal.fire({
                    title: popup_op.title,
                    html: popup_op.text,
                    type: popup_op.type,
                    showCancelButton: popup_op.showcancelbutton,
                    confirmButtonText: popup_op.confirmbuttontext,
                    cancelButtonText: popup_op.cancelbuttontext,
                    reverseButtons: popup_op.reversebuttons,
                }).then(function (e) {
                    if(e.value){
                        _form.ajaxSubmit(_default);
                    }
                });
            } else{
                return true;
            }
            return false;
        });

        $(document).on('click', '.confirm-popup', function (e) {
            e.preventDefault();
            var _this = $(this);
            var config = _this.data();
            var _default = {title : 'Are you sure?',
                text: "You won't be able to do this!",
                type : 'warning',
                showcancelbutton: !0,
                confirmbuttontext: "Confirm!",
                cancelbuttontext: "Cancel!",
                reversebuttons: !0};
            var _op = $.extend(true, {}, _default, config);

            swal.fire({
                title: _op.title,
                html: _op.text,
                type: _op.type,
                showCancelButton: _op.showcancelbutton,
                confirmButtonText: _op.confirmbuttontext,
                cancelButtonText: _op.cancelbuttontext,
                reverseButtons: _op.reversebuttons,
            }).then(function (e) {
                if(e.value){
                    window.location = _this.attr('href');
                }
                return false;
            });

        });

        var _brake = true;
        $(document).on('submit', '.confirm-submit', function (e) {
            console.log(_brake);
            if(_brake){
                e.preventDefault();
            }
            var _this = $(this);
            var config = _this.data();
            var _default = {title : 'Are you sure?',
                text: "You won't be able to do this!",
                type : 'warning',
                showcancelbutton: !0,
                confirmbuttontext: "Confirm!",
                cancelbuttontext: "Cancel!",
                reversebuttons: !0};
            var _op = $.extend(true, {}, _default, config);

            swal.fire({
                title: _op.title,
                html: _op.text,
                type: _op.type,
                showCancelButton: _op.showcancelbutton,
                confirmButtonText: _op.confirmbuttontext,
                cancelButtonText: _op.cancelbuttontext,
                reverseButtons: _op.reversebuttons,
            }).then(function (e) {
                if(e.value){
                    _brake = false;
                    _this.submit();
                }

                return false;
            });

        });

        $(document).on('click', '.grid-table [type=submit]', function (e) {
            e.preventDefault();
            let table = $(this).closest('.grid-table');
            table.find('tbody input, tbody select, tbody textarea').attr('disabled', true);
            $(this).closest('form').submit();
        });
        // basic
        $(document).on('click', '.form-btns [action]:not(".self-action"), .grid-bluk-action [action]:not(".self-action")', function (e) {
            e.preventDefault();

            let _this = $(this);
            let action = $(this).attr('action');
            if(_this.hasClass('submit_grid')){
                action = 'submit_grid';
            }
            let form = _this.closest('form');
            console.log(action);
            let url = $(this).attr('href');
            switch (action){
                case 'edit':
                case 'update':
                case 'only_save':
                case 'save':
                case 'update_profile':
                    //console.log(_this.closest('form'));
                    _this.closest('form').submit();
                    break;
                case 'save_new':
                case 'save_close':
                    form.find('.__redirect').remove();
                    form.prepend('<input type="hidden" class="__redirect" name="__redirect" value="' + url + '">');
                    form.submit();
                    break;
                case 'update_grid':
                    if(url.indexOf('?') != -1){
                        url += '&' + $('input[name*=ids][type=checkbox]', form).serialize();
                    }else{
                        url += '?' + $('input[name*=ids][type=checkbox]', form).serialize();
                    }
                    let grid_bluk = $('.grid-bluk-action', form);
                    if ($('select[name=status]', grid_bluk).val() == '') {
                        swal.fire('Select a status!');
                        return false;
                    }
                    url += '&' + $('input,select,textarea', grid_bluk).serialize();
                    window.location = url;
                    break;
                case 'submit_grid':
                    if (url.indexOf('?') != -1) {
                        url += '&' + $('input[name*=ids][type=checkbox]', form).serialize();
                    } else {
                        url += '?' + $('input[name*=ids][type=checkbox]', form).serialize();
                    }
                    url += '&' + $('input,select,textarea', form).serialize();
                    window.location = url;
                    break;
                case 'delete':
                    form = _this.closest('form');
                    if($('.grid-table tbody input[name*=ids][type=checkbox]:checked', form).length == 0){
                        swal.fire({text: "Select one or more checkbox!", type: "warning",});
                        return false
                    }
                    swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to delete these!",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Confirm!",
                        cancelButtonText: "Cancel!",
                        reverseButtons: !0
                    }).then(function (e) {
                        if(e.value){
                            if(url.indexOf('?') != -1){
                                url += '&' + $('input[name*=ids][type=checkbox]', form).serialize();
                            }else{
                                url += '/?' + $('input[name*=ids][type=checkbox]', form).serialize();
                            }
                            console.log(url);
                            window.location = url;
                        }
                    });
                    break;

                case 'print':
                    //var form = _this.closest('.m-portlet');
                    $(".print-me").print({
                        globalStyles: true,
                        mediaPrint: false,
                        iframe: false,
                        noPrintSelector: $(".print-me").data('print-hide'),
                        prepend: '',
                        append: '',
                        deferred: $.Deferred().done(function () {
                            //console.log('Printing done', arguments);
                        })
                    });
                    break;
                default:
                    let _form = _this.closest('form.post');
                    if(_form.length > 0 && _form.attr('method').toLowerCase() == 'post'){
                        _form.submit();
                        return false;
                    } else {
                        window.location = url;
                    }
                    break;
            }
        });

        $(document).on('blur', '.grid-table input.ordering', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            if(url.indexOf('?') != -1){url += '&' + $(this).serialize()}
            else {url += '?' + $(this).serialize()}
            //console.log(url);
            $.get(url)
                .done(function () {
                    var notify = $.notify('Record has been updated!', {
                        type: 'success',
                        newest_on_top: true,
                        allow_dismiss: true,
                    });
                })
                .fail(function () {
                    var notify = $.notify('Some error occurred!', {
                        type: 'error',
                        newest_on_top: true,
                        allow_dismiss: true,
                    });
                });
        });

        $(document).on('click', '.gtd-grid_actions a[action]:not(".self-action")', function (e) {
            e.preventDefault();

            var _this = $(this);
            var action = $(this).attr('action');
            var url = $(this).attr('href');
            switch (action){
                case 'delete':
                    swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Confirm!",
                        cancelButtonText: "Cancel!",
                        reverseButtons: !0
                    }).then(function(e) {
                        console.log(e);
                        if(e.value){
                            window.location = url;
                        }
                    });
                    break;
                default:
                    window.location = url;
                    break;
            }
        });

        $(document).on('click', '[ajax-call]', function (e) {
            e.preventDefault();

            var _this = $(this);
            var action = $(this).attr('ajax-call');
            var url = $(this).attr('href');
            switch (action){
                case 'delete':
                case 'delete_img':
                    swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Confirm!",
                        cancelButtonText: "Cancel!",
                        reverseButtons: !0
                    }).then(function(e) {
                        if(e.value){
                            var notify = $.notify('<strong>Saving</strong> Do not close this page...', {
                                type: 'info',
                                newest_on_top: true,
                                allow_dismiss: false,
                                showProgressbar: true
                            });

                            $.ajax({
                                type: "GET",
                                dataType: "JSON",
                                url: url,
                                data: {},
                                complete: function (data) {
                                    var json = $.parseJSON(data.responseText);
                                    console.log(json);
                                    _this.closest('.thumbnail').remove();
                                    notify.update({'type': 'success', 'message': '<strong>Saving</strong> Page Data.'});
                                    notify.close();
                                }
                            });
                        }
                    });
                    break;
                default:

                    var notify = $.notify('<strong>Saving</strong> Do not close this page...', {
                        type: 'info',
                        newest_on_top: true,
                        allow_dismiss: false,
                        showProgressbar: true
                    });

                    $.ajax({
                        type: "GET",
                        dataType: "JSON",
                        url: url,
                        data: {},
                        complete: function (data) {
                            var json = $.parseJSON(data.responseText);
                            console.log(json);
                            notify.update('message', '<strong>Saving</strong> Page Data.');
                        }
                    });

                    break;
            }
        });

        $(document).on('change', '.ajax-checkbox', function (e) {
            e.preventDefault();

            let _this = $(this);
            let url = $(this).data('url');

            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: url,
                data: _this.serialize(),
                complete: function (data) {
                    let json = $.parseJSON(data.responseText);
                    console.log(json);
                    $.notify(json.message, {type: (json.status ? 'success' : 'error')});
                }
            });
        });

        $(document).on('click', '[remove-el]', function (e) {
            e.preventDefault();
            var _this = $(this);
            var ele = _this.attr('remove-el').split('.');
            var rm_name = _this.data('rm-name');
            var rm_value = _this.data('rm-value');
            if(rm_name != '') {
                _this.closest('form').append('<input type="hidden" name="' + rm_name + '" value="' + rm_value + '">');
            }

            if(ele[0] == 'parent' || ele[0] == 'parents' || ele[0] == 'closest'){
                _this.closest('.' + ele[1]).remove();
            } else if(ele[0] == ''){
                $('.' + ele[1]).remove();
            } else{
                ele = $(this).attr('remove-el').split('#');

                if(ele[0] == 'parent' || ele[0] == 'parents' || ele[0] == 'closest'){
                    _this.closest('#' + ele[1]).remove();
                } else if(ele[0] == ''){
                    $('#' + ele[1]).remove();
                }
            }
        });

        $(document).on('change', '.grid-table tbody input[name*=ids][type=checkbox]', function (e) {
            e.preventDefault();
            var p = $(this).closest('.m-portlet');

            var chk_lenght = $('tbody input[name*=ids][type=checkbox]:checked', p).length;
            if(chk_lenght > 0){
                $('.grid-bluk-action', p).show();
            }else{
                $('.grid-bluk-action', p).hide();
                $('.check-all', p).attr('checked', false).next('span').find(':after').remove();
            }
        });


        $(document).on("keyup", ".search-input", function() {
            var value = $(this).val().toLowerCase();
            var find_attr = $(this).attr('find-in');
            var find_container = $(this).attr('find-block');

            $(find_attr, find_container).filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $(document).on('change', '.check-all', function (e) {
            let _check = $(this).is(':checked');
            let _table = $(this).closest('table').find('tbody');
            if(!_check) {
                _table.checkboxes('uncheck');
            } else {
                _table.checkboxes('check');
            }
            e.preventDefault();
        });

        $(document).on('change', '[check_all]', function (e) {
            let _check = $(this).is(':checked');
            let _inputs = $(this).attr('check_all');
            if(!_check) {
                $(_inputs).prop('checked', false);
            } else {
                $(_inputs).prop('checked', true);
            }
            e.preventDefault();
        });

        $('.grid-table tbody, .range-checkboxes').checkboxes('range', true);

        $(document).on('change', '.chk-id', function (e) {
            if($('.chk-id:checked').length > 0){
                $(this).closest('form').find('.selection-box').css('visibility', 'visible');
            }else {
                $(this).closest('form').find('.selection-box').css('visibility', 'hidden');
            }
        });


        function format(state) {
            if (!state.id) return state.text; // optgroup
            var icon = $(state.element).data('icon');
            var img = $(state.element).data('img');
            if(icon && icon.length > 0){
                return "<i class='" + icon + "'></i> &nbsp;" + state.text;
            }else if(img && img.length > 0){
                return "<img class='option-img' src='" + img + "'/>&nbsp;&nbsp;" + state.text;
            }else{
                return state.text;
            }
            //return "<img class='flag' src='" + MyFILEPATH() + "flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
        }

        $('.m_selectpicker,.select').selectpicker();

        $('.m-select2, .kt-select2, .select2').select2();


        $(".m-select2-ajax").select2({
            ajax: {
                url: function (params) {
                    return $(this).data('url') + '/?term=' + params.term;
                },
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var postData = {
                        q: params.term, // search term
                        page: params.page
                    };
                    var formData = $($(this).data('data_ele')).serializeArray();
                    $.each(formData, function( index, e ) {
                        postData[e.name] = e.value
                    });
                    //console.log(postData);
                    return postData;
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            //dropdownParent: $('.modal'),
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: format,
            templateSelection: format,
        });

        $(document).on('click', '.delete-select-add', function (e) {
            let _this = $(this);
            let _input = _this.closest('.add-select-input');
            _input.prev('.select2-container').show(0).prev('select').show(0).attr('disabled', false);
            _input.remove();
        });

        $(document).on('change', 'select.add-new', function (e) {
            e.preventDefault();
            let _select = $(this);
            if(_select.val() == '-option-add-') {
                let _parent = _select.parent();
                _select.attr('disabled', 1);
                _select.hide(0);
                _select.next('.select2-container').hide(0);
                _parent.append('<div class="input-group add-select-input">' +
                    '<input type="text" name="' + _select.attr('name') + '-new" id="' + _select.attr('id') + '" placeholder="Enter new value" class="form-control"/>' +
                    '<div class="input-group-append"><span class="input-group-text delete-select-add" id="basic-addon2"><i class="la la-trash"></i></span></div>' +
                    '</div>');
            }
        });

        $(document).on('change', '[load-select]', function (e) {
            e.preventDefault();
            var _this = $(this);
            var next_select = $(_this.attr('load-select'));
            next_select.each(function (index, ele) {
                load_select(_this, $(ele));
            });
        });

        function load_select(ele, select_ele){

            var url = select_ele.attr('load-url');
            var selected_val = select_ele.val();
            select_ele.html('<option value="">Loading...</option>');

            $.get(url, {id : ele.val(), selected: selected_val})
                .done(function (data) {
                    select_ele.html(data);
                })
                .fail(function () {
                    var notify = $.notify('Record not found!', {type: 'danger', newest_on_top: true, allow_dismiss: true,});
                });
        }

        // tagging support
        $('.m_select2-tags').select2({
            placeholder: "Add a tag",
            tags: true
        });

        // loading remote data

        function formatRepo(repo) {
            if (repo.loading) return repo.text;
            var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";
            if (repo.description) {
                markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
            }
            markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
                "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
                "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
                "</div>" +
                "</div></div>";
            return markup;
        }

        function formatRepoSelection(repo) {
            return repo.full_name || repo.text;
        }


        $('.m_selectpicker,.selectpicker').selectpicker();


        $('.datetimepicker').datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            showMeridian: !0,
            todayHighlight: !0,
            autoclose: !0,
            pickerPosition: "bottom-left"
        });

        $('.datepicker').each(function (i, v) {

            var options = {
                format: "yyyy-mm-dd",
                todayHighlight: true,
                autoclose: true,
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            };

            options = get_options($(this).data(), options);

            $(this).datepicker(options);
        });

        $('.m_datepicker').each(function (i, v) {
            var options = {
                format: "yyyy-mm-dd",
                //todayBtn: "linked",
                autoclose: true,
                clearBtn: true,
                todayHighlight: true,
                rtl: mUtil.isRTL(),
                orientation: "bottom left",
                templates: {
                    leftArrow: '<i class="la la-angle-left"></i>',
                    rightArrow: '<i class="la la-angle-right"></i>'
                }
            };

            options = get_options($(this).data(), options);
            $(this).datepicker(options);
        });

        $('.timepicker').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false,
            snapToStep: true
        });


        $(".repeater").repeater({
            initEmpty: !1,
            isFirstItemUndeletable: true,
            /*defaultValues: {
                "text-input": "foo"
            },*/
            show: function() {
                let _data = $(this).data();
                $(this).find('[data-repeater-create]').remove();
                $(this).slideDown();
            },
            hide: function(e) {
                $(this).slideUp(e);
                //confirm("Are you sure you want to delete this element?") && $(this).slideUp(e)
            },
            ready: function (setIndexes) {

            }
        });

        $("[data-inputmask]").inputmask();

        $('.array-repeater').repeater({
            initEmpty: false,
            show: function () {
                $(this).slideDown();
                if($(this).find('.m-select2').length > 0){
                    $(this).find('select.m-select2').attr('id', 'select2-id_' + Math.random());
                    $(this).find('select.m-select2').select2();
                }
                $('input,select,textarea','.array-repeater').each(function (i, e) {
                    $(e).attr('name', $(e).data('name'));
                    $(e).prop('id', $(e).attr('id') + '_' + parseInt(Math.random() * 7777));
                });
                if($(this).find('.simple_editor').length > 0) {
                    let _t_id = 'simple_editor-id_' + parseInt(Math.random() * 7777);
                    $(this).find('.simple_editor').attr('id', _t_id);
                    simple_editor();
                }
            },
            hide: function (deleteElement) {
                /*if(confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }*/
                $(this).remove();
                //$(this).slideUp(deleteElement);
            },
            ready: function (setIndexes) {
                $('input,select,textarea','.array-repeater').each(function (i, e) {
                    $(e).attr('name', $(e).data('name'));
                })
            },
            isFirstItemUndeletable: true
        });

        $(".my-repeater").repeater({
            initEmpty: !1,
            isFirstItemUndeletable: true,
            show: function() {
                $(this).find('[data-repeater-create]').remove();
                $(this).slideDown();
                $('input, select, textarea', '.my-repeater').each(function (i, e) {
                    $(e).attr('name', $(e).attr('id') + '[]');
                })
            },
            hide: function(e) {
                $(this).slideUp(e);
                //confirm("Are you sure you want to delete this element?") && $(this).slideUp(e)
            },
            ready: function(e) {
                $('input, select, textarea', '.my-repeater').each(function (i, e) {
                    $(e).attr('name', $(e).attr('id') + '[]');
                });
            },
        });


        function upload_file(blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', site_url + 'assets/admin/vendors/tinymce/upload.php');
            xhr.onload = function () {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }
        /*======= TINY MCE EDITOR FULL =======*/
        function editor_tinymce(){

            tinymce.init({
                mode: 'specific_textareas',
                editor_selector: "editor",
                height: 450,
                //theme: 'modern',
                verify_html: false,
                forced_root_block : "",
                content_css: media_url + "css/editor.css",
                plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | image | fontselect | fontsizeselect | code',
                image_advtab: true,
                plugins: [
                    "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "table contextmenu directionality emoticons template textcolor paste "
                ],
                //images_upload_handler: upload_file,
                external_filemanager_path: asset_url + "admin/vendors/custom/tinymce/plugins/filemanager/",
                filemanager_title:"File Manager" ,
                //filemanager_access_key: fm_access_key,
                external_plugins: { "filemanager" : asset_url + "admin/vendors/custom/tinymce/plugins/filemanager/plugin.min.js"}
            });
        }
        editor_tinymce();
        /*===============================*/

        /*======= TINY MCE EDITOR FULL =======*/
        function simple_editor() {
            tinymce.init({
                mode: 'specific_textareas',
                editor_selector: "simple_editor",
                height: 250,
                //theme: 'modern',
                verify_html: false,
                forced_root_block: "",
                content_css: media_url + "css/editor.css",
                image_advtab: true,
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist | removeformat | image | fontselect | fontsizeselect | code',
                plugins: [
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "table directionality emoticons template textcolor paste "//contextmenu
                ],
                //images_upload_handler: upload_file,
                external_filemanager_path: asset_url + "admin/vendors/custom/tinymce/plugins/filemanager/",
                filemanager_title:"Filemanager" ,
                filemanager_access_key:"1cac38f9f36af9bb8bb885aa5858c058s" ,
                external_plugins: { "filemanager" : asset_url + "admin/vendors/custom/tinymce/plugins/filemanager/plugin.min.js"}
            });
        }
        simple_editor();
        /*===============================*/


    });

    function  get_options(data, options) {
        if(Object.keys(data).length > 0) {
            $.each(data, function (k, v) {
                options[k.substring(2)] = v;
            });
        }
        return options;
    }

    function toNumber(num) {
        return (isNaN(num) ? 0 : num);
    }
    function friendly_URL(url) {
        url.trim();
        var URL = url.replace(/\-+/g, '-').replace(/\W+/g, '-');// Replace Non-word characters
        if (URL.substr((URL.length - 1), URL.length) == '-') {
            URL = URL.substr(0, (URL.length - 1));
        }

        return URL.toLowerCase();
    }


    function parent_li(li) {
        var _li = li.closest('ul') .css('display', 'block')
            .closest('li') .addClass('kt-menu__item--expanded kt-menu__item--open');

        if (_li.length > 0) {
            parent_li(_li)
        }
    }
    parent_li($('.kt-aside-menu .kt-menu__nav li.kt-menu__item--active'));

})(jQuery);

