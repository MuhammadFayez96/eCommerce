(function () {

    /***************************************************************************
    * AJAX Setup for processing
    ***************************************************************************/
    //var baseUrl = '/iron';
    var csrf = new FormData($('#csrf')[0]);
    var loading = $('#loading').html();


    var addReview = $('#add_review');
    var reviewTemp = $('#review-template').html();
     $(document).on('click', '#add_review', function () {
        var $this = $(this);
        console.log(reviewTemp);
        $this.append(reviewTemp);
    });

    /*****************************************************88
     */

    /***************************************************************************
    * Show Edit General Modal
    **************************************************************************/
    var editModal = $('#edit-modal');
    $(document).on('click', '.edit-modal-btn', function () {
        var $this = $(this);
        var url = $this.data('url');
        request(url, csrf, function (data) {
            if (data.status === 'success') {
                editModal.find('.modal-content').html(data.content);
                editModal.modal('toggle');
            } else
            if (data.status === 'error') {
                swal(data.title, data.msg, "error");
            } else
            if (data.status === 'warning') {
                swal(data.title, data.msg, "warning");
            }
        }, function () {
            alert('Internal Server Error.');
        });
    });

    /***************************************************************************
    * Post Add  General Modal
    **************************************************************************/
    $(document).on('click', '#add-modal-submit', function () {
        var $this = $(this);
        var form = $this.closest('form');
        request(form.attr('action'), new FormData(form[0]), function (data) {
            if (data.status === 'success') {
                swal({title: data.title, text: data.msg, type: "success"}, function () {
                    location.reload(0);
                });
            } else
            if (data.status === 'error') {
                swal(data.title, data.msg, "error");
            } else
            if (data.status === 'warning') {
                swal(data.title, data.msg, "warning");
            }
        }, function () {
            alert('Internal Server Error.');
        });
    });

    $(document).on('click', '.edit-modal-submit', function () {
        var $this = $(this);
        var form = $this.closest('form');
        request(form.attr('action'), new FormData(form[0]), function (data) {
            if (data.status === 'success') {
                swal({title: data.title, text: data.msg, type: "success"}, function () {
                    location.reload(0);
                });
            } else
            if (data.status === 'error') {
                swal(data.title, data.msg, "error");
            } else
            if (data.status === 'warning') {
                swal(data.title, data.msg, "warning");
            }
        }, function () {
            alert('Internal Server Error.');
        });
    });
    /***************************************************************************
    * Modal View Modal
    **************************************************************************/

    $(document).on('click', '.btn-modal-view', function () {
        var $this = $(this);
        var url = $this.data('url');
        var originalHtml = $this.html();
        //$this.prop('disabled', true).html('loading...');
        request(url, null, function (data) {
            $this.prop('disabled', false).html(originalHtml);
            $('#common-modal').html(data).modal('toggle');
        }, function () {
            alert('Error');
        }, 'get');
    });
    /***************************************************************************
    * Form Add Ajax  submit buttons
    **************************************************************************/
    var AddModalBtn = $('.addBTN');
   // var modelName = $('.add').attr('href');
    AddModalBtn.on('click', function () {
        var AddModalForm = AddModalBtn.closest('form');
        var formData = new FormData(AddModalForm[0]);
        if (typeof tinymce !== "undefined" && tinymce.editors.length) {
            for (var i = 0; i < tinymce.editors.length; i++) {
                formData.append('content' + (i + 1), tinymce.editors[i].getContent());
            }
        }
        request(AddModalForm.attr('action'), formData,
        // on request success handler
        function (result) {
            if (result.status) {
                swal({title: "success.", text: result.data, type: "success"}, function () {
                    location.reload(true);
                });
            } else {
                swal('wrong.', result.data, 'error');
            }
        },
        // on request failure handler
        function () {
            alert('Internal Server Error.');
        });
    });

        /////////////////////login button ///////////////////////////////
    var AddModalBtn = $('.addBTN2');
    var modelName = $('.add').attr('href');
    AddModalBtn.on('click', function () {
        var AddModalForm = AddModalBtn.closest('form');
        var formData = new FormData(AddModalForm[0]);

        request(AddModalForm.attr('action'), formData,
        // on request success handler
        function (result) {
            if (result.status) {
                swal({title: "success.", text: result.data, type: "success"}, function () {
                    location.reload(true);
                });
            } else {
                swal('wrong.', result.data, 'error');
            }
        },
        // on request failure handler
        function () {
            alert('Internal Server Error.');
        });
    });

    /////////////////////// Categories And Menus  ///////////////////////
    /***************************************************************************
    * Edit Modal Button
    **************************************************************************/
    var usersBtnEdit = $('.users-edit-modal-btn');
    var usersEditModal = $('#users-edit-modal');
    var usersEditModalBody = $('#users-edit-modal-body');
    var usersEditModalTemplate = $('#users-edit-modal-template').html();

    usersBtnEdit.on('click', function(){
    $this = $(this);
    var usersInfoUrl = $this.data('url');

    request(usersInfoUrl,csrf,
        // on request success handler
        function(result){
            if (result.status) {
                var txt = usersEditModalTemplate;
                for (var key in result.data) {
                    txt = txt.replace(new RegExp('{' + key + '}', 'g'), result.data[key]);
                }
                // _(txt);

                usersEditModalBody.html(txt);
                usersEditModal.modal('toggle');

            }else{
                swal('Oops, Error',result.data,'error');
            }

        },
        // on request failure handler
        function(){
            alert('Internal Server Error.');
        });
    });

    /***************************************************************************
    * Show Change Type Modal and Events For it
    **************************************************************************/
    var changeCategoryTypeTemplate = $('#change-category-type-template').html();
    $(document).on('click', '.change-type-btn', function () {
        var $this = $(this);
        var url = $this.data('url');
        var type = $this.data('type');
        switch (type) {
            case 'main':
            var id = $this.data('id');
            var name = $this.data('name');
            var txt = changeCategoryTypeTemplate;
            txt = txt.replace(new RegExp('{name}', 'g'), name);
            txt = txt.replace(new RegExp('{id}', 'g'), id);
            editModal.find('.modal-content').html(txt);
            editModal.modal('toggle');
            break;
            case 'sub':
            request(url, csrf, function (data) {
                if (data.status === 'success') {
                    swal({title: data.title, text: data.msg, type: "success"}, function () {
                        location.reload(0);
                    });
                } else
                if (data.status === 'error') {
                    swal(data.title, data.msg, "error");
                } else
                if (data.status === 'warning') {
                    swal(data.title, data.msg, "warning");
                }

            }, function () {
                alert('Internal Server Error.');
            });
            break;
        }

    });
    /***************************************************************************
    * Menu Preview Dev
    **************************************************************************/
    $(document).on('change', 'select.menu-shape', function () {
        $(this).closest('.modal-body').find('.menu-preview').css('background-image', 'url(' + $(this).find('option:selected').data('img') + ')');
    }).change();

     /***************************************************************************
    * Ajax Pagination Controller
    **************************************************************************/
    var tableData = $('#ajax-table');
    $(document).on('click', '#ajax-table .pagination a', function (e) {
        var $this = $(this);
        tableData.html(loading);
        $.ajax({
            url: $this.attr('href'),
        }).done(function (data) {
            tableData.html(data);
        }).fail(function () {
            alert('Internal Server Error.');
        });
        e.preventDefault();
    });

    /***************************************************************************
    * Ajax Pagination For Products and wishlist Controller
    **************************************************************************/
    /*var productsArea = $('#products-area');
    $(document).on('click', '#products-area .pagination a', function (e) {
        e.preventDefault();
        var $this = $(this);
        productsArea.show();
        $.ajax({
            url: $this.attr('href'),
            data: $this.closest('form').serialize()
        }).done(function (data) {
            productsArea.html(data).hide();
        }).fail(function () {
            alert('Internal Server Error.');
        });
    });*/

    var productsArea = $('#products-area');
    $('#orderBy, #per, .first_limit, last_limit').on('change', function() {
        var orderBy = $("#orderBy").val();
        var per = $('#per').val();
        var first_limit = $('.first_limit').val();
        var last_limit = $('.last_limit').val();
        var filterForm = $(this).closest('form');
        var action = filterForm.attr('action');
        console.log(filterForm.serialize())

        $.ajax({
            url: action,
            data: filterForm.serialize(),
            method: 'POST',
            success: function(data) {
                productsArea.html(data);
            },
            error: function() {
                alert('internal server error');
            }
        });
    });
    /***************************************************************************
    * Search input events for filtered table
    **************************************************************************/
    var inputSearch = $('#input-search');
    $(document).on('click', '.btn-search', function () {
        var form = $(this).closest('form');
        var search = (inputSearch.val().length) ? "/" + inputSearch.val() : "";
        tableData.html(loading);
        request(form.attr('action') + "/search" + search, null, function (data) {
            tableData.html(data);
        }, function () {
            alert('Internal Server Error');
        }, 'get');
    });
    /**************************************************************************
    * Actions Of Filters Buttons
    ***************************************************************************/

    $(document).on('change', '.btn-filter', function () {
        var $this = $(this);
        var filter = $this.data('filter');
        tableData.html(loading);
        var form = $this.closest('form');
        request(form.attr('action') + "/filter/" + filter, null, function (data) {
            tableData.html(data);
        }, function () {
            alert('Internal Server Error.');
        }, 'get');
    });
    /**************************************************************************
    * Events Action Buttons for the tables
    **************************************************************************/

    $(document).on('click', '.btn-action', function (e) {
        var $this = $(this);
        var action = $this.data('action');
        var form = $this.closest('form');
        request(form.attr('action') + "/action/" + action, new FormData(form[0]), function (data) {
            if (data.status === 'success') {
                notify(data.status, data.title, data.msg, function () {
                    $('input[data-filter=all]').change();
                });
            } else {
                notify(data.status, data.title, data.msg);
            }
        }, function () {
            alert('Internal Server Error.');
        });
        e.preventDefault();
    });

    /***************************************************************************
    * Check ALL Button For Table Rows
    ***************************************************************************/

    $(document).on('click', '#chk-all', function () {
        $('.chk-box').prop('checked', this.checked);
    });
    /***************************************************************************
    * Common Ajax Delete Section
    **************************************************************************/

    $(document).on('click', ".ajax-delete", function (e) {
        e.preventDefault();
        var $this = $(this);
        var url = $this.data('url');
        var originalHtml = $this.html();
        var altText = loading;
        var notification = 'm';
        if ($this.data('loading') !== undefined) {
            altText = $this.data('loading');
        }
        $this.prop('disabled', true).html(altText);

        if ($this.data('notification') !== undefined) {
            notification = $this.data('notification');
        }

        request(url, csrf, function (result) {
            notify(result.status, result.title, result.msg, notification);
            $this.prop('disabled', false).html(originalHtml);
            $this.closest('.ajax-target').remove();

        }, function () {
            alert('Internal Server Error.');
        });
    });

    $('.btndelet').click(function (e) {

        var txt = $('#template-modal').html();
        var url = $(this).attr('data-url');
        txt = txt.replace(new RegExp('{url}', 'g'), url);
        $('#delete-modal .modal-dialog').html(txt);
        $('#delete-modal').modal('show');
        e.preventDefault()
    });

    var commonModal = $('#common-modal');
    var deleteModalTemplate = $('#delete-modal-template').html();
    $(document).on('click', '.modal-delete-btn', function (e) {
        var url = $(this).attr('data-url');
        var txt = deleteModalTemplate;
        txt = txt.replace(new RegExp('{url}', 'g'), url);
        commonModal.html(txt).modal('toggle');
        e.preventDefault();
    });

    /////////////////////// Categories And Menus  ///////////////////////

    $('#data_review').on('submit', ".ajax-form", function (e) {
        e.preventDefault();
        var $this = $(this);
        var url = $this.attr('action');
        var ajaxSubmit = $this.find('.ajax-submit');
        var ajaxSubmitHtml = ajaxSubmit.html();
        var altText = loading;
        var notification = 'm';
        if (ajaxSubmit.data('loading') !== undefined) {
            altText = ajaxSubmit.data('loading');
        }
        //ajaxSubmit.prop('disabled', true).html(altText);
        var formData = new FormData(this);
        if ($this.find('.tiny-editor').length) {
            for (var i = 0; i < tinymce.editors.length; i++) {
                formData.append('editor' + (i + 1), tinymce.editors[i].getContent());
            }
        }
        if ($this.data('url') !== undefined) {
            url = $this.data('url');
        }
        if ($this.data('notification') !== undefined) {
            notification = $this.data('notification');
        }

            $.ajax({
            url: url, //server script to process data
            type: 'POST',
             xhr: function () {  // custom xhr
                 myXhr = $.ajaxSettings.xhr();
                 if (myXhr.upload) { // if upload property exists
                     myXhr.upload.addEventListener('progress', function(event) {
                         var loaded = event.loaded;
                         var total = event.total;
                     }, false); // progressbar
                 }
                 return myXhr;
             },
            // Ajax events
            success: function(data){
                location.reload(true);
                // $('#view_review').append(data);
            },

            // Form data
            data: formData,
            // Options to tell jQuery not to process data or worry about the content-type
            cache: false,
            contentType: false,
            processData: false
        }, 'json');

    });


    ///////////////////////////////////// End Admin Panel Ajax  ////////////////////////////////////////

    //////////////////////////////////////// Site Ajax  //////////////////////////////////////////////////

    /***************************************************************************
    * Form Add Ajax  submit buttons
    **************************************************************************/

    $(document).on('submit', ".ajax-form", function (e) {
        e.preventDefault();
        var $this = $(this);
        var url = $this.attr('action');
        var ajaxSubmit = $this.find('.ajax-submit');
        var ajaxSubmitHtml = ajaxSubmit.html();
        var altText = loading;
        var notification = 'm';
        if (ajaxSubmit.data('loading') !== undefined) {
            altText = ajaxSubmit.data('loading');
        }
        //ajaxSubmit.prop('disabled', true).html(altText);
        var formData = new FormData(this);
        if ($this.find('.tiny-editor').length) {
            for (var i = 0; i < tinymce.editors.length; i++) {
                formData.append('editor' + (i + 1), tinymce.editors[i].getContent());
            }
        }
        if ($this.data('url') !== undefined) {
            url = $this.data('url');
        }
        if ($this.data('notification') !== undefined) {
            notification = $this.data('notification');
        }
        request(url, formData, function (result) {
            noty({
                text: result.msg,
                type: result.status,
                animation: {
                    open: 'animated bounceInLeft',
                    close: 'animated bounceOutLeft',
                    easing: 'swing',
                    speed: 500 // opening & closing animation speed
                }
            });
        }, function () {
            noty({
                text: 'Internal Server Error',
                type: 'error',
                animation: {
                    open: 'animated bounceInLeft',
                    close: 'animated bounceOutLeft',
                    easing: 'swing',
                    speed: 500 // opening & closing animation speed
                }
            });
        });
    });
    /***************************************************************************
    * Add To Cart Button
    **************************************************************************/
    // var shoppingCartBox = $('#shopping-cart-box');
    // function updateSoppingCart() {
    //     $.ajax({
    //         url: shoppingCartBox.data('url'),
    //     }).done(function (data) {
    //         console.log(url + 'dataaaaaa' + data.cart_view);
    //         shoppingCartBox.html(data.cart_view);
    //
    //     }).fail(function () {
    //         alert('Internal Server Error.');
    //     });
    // }

    $(document).on('click', '.cart-btn', function (e) {
        e.preventDefault();
        var $this = $(this);
        var url = formData = null;
        var cartForm  = $this.closest('form.cart-form');

        if(cartForm.length){
            url = cartForm.attr('action');
            formData = new FormData(cartForm[0]);

        }else{
            formData = csrf;
            url = $this.data('url');
            formData.append('quantity' , $this.data('quantity'));
        }
        var cartIndex = $('.cart-index');
        // cartIndex.LoadingOverlay('show');
        request(url, formData, function (data) {
            $('#shopping-cart-box').html(data.views.cart_view);
            // cartIndex.html(data.views.cart_index_view).LoadingOverlay("hide", true);
            cartIndex.html(data.views.cart_index_view);
            // $.ajax({
            //     url: $('#shopping-cart-box').data('url'),
            // }).done(function (data) {
            //      $('#shopping-cart-box').html(data.views.cart_view);
            //     if($('.cart-index').length != 0) {
            //         $('.cart-index').html(data.views.cart_index_view);
            //     }
            //
            // }).fail(function () {
            //     alert('Internal Server Error.');
            // });
            noty({
                text: data.msg,
                type: data.status,
                timeout: 3000,
                closeWith   : ['click'],
                maxVisible: 5,
                animation: {
                    open: 'animated bounceInLeft',
                    close: 'animated bounceOutLeft',
                    easing: 'swing',
                    speed: 100 // opening & closing animation speed
                },
            });
            // location.reload();
        }, function () {
            noty({
                text: 'Internal Server Error',
                type: 'error',
                animation: {
                    open: 'animated bounceInLeft',
                    close: 'animated bounceOutLeft',
                    easing: 'swing',
                    speed: 100 // opening & closing animation speed
                }
            });
        });
    });
    /***************************************************************************
    * Add To Wishlist Button
    **************************************************************************/
    var wishlistCount = $('#wishlist-count');
    $(document).on('click', '.wishlist-btn', function (e) {
        e.preventDefault();
        var $this = $(this);
        var url = $this.data('url');

        request(url, csrf, function (data) {
            wishlistCount.html(data.count);
            noty({
                text: data.msg,
                type: data.status,
                animation: {
                    open: 'animated bounceInLeft',
                    close: 'animated bounceOutLeft',
                    easing: 'swing',
                    speed: 500 // opening & closing animation speed
                }
            });
        }, function () {
            noty({
                text: 'Internal Server Error',
                type: 'error',
                animation: {
                    open: 'animated bounceInLeft',
                    close: 'animated bounceOutLeft',
                    easing: 'swing',
                    speed: 500 // opening & closing animation speed
                }
            });
        });
    });

//////////////////////////////////// End Site Ajax  //////////////////////////////////////////////////


























    /****************************************************************************
    * Function Preview Url for file
    * @param  Image btn   [description]
    * @param  Input input [description]
    * @return Src      [description]
    ***************************************************************************/
    function previewURL(btn, input) {

        if (input.files && input.files[0]) {

            // collecting the file source
            var file = input.files[0];
            // preview the image
            var reader = new FileReader();
            reader.onload = function (e) {
                var src = e.target.result;
                btn.attr('src', src);
            };
            reader.readAsDataURL(file);
        }
    }

    /***************************************************************************
    * mark active page
    **************************************************************************/
    $('a[href="' + window.location.href + '"],a[href="' + window.location.href + 'home"]').closest('li').addClass('active');
    /***************************************************************************
    * validating the file
    **************************************************************************/

    function validateImgFile(input) {
        if (input.files && input.files[0]) {

            // collecting the file source
            var file = input.files[0];
            // validating the image name
            if (file.name.length < 1) {
                alert("The file name couldn't be empty");
                return false;
            }
            // validating the image size
            // else if (file.size > 300000) {
            //     alert("The file is too big");
            //     return false;
            // }
            // validating the image type
            else if (file.type != 'image/png' && file.type != 'image/jpg' && file.type != 'image/gif' && file.type != 'image/jpeg') {
                alert("The file does not match png, jpg or gif");
                return false;
            }
            return true;
        }
    }

    /***************************************************************************
    * Custom Ajax request function
    * @param string url
    * @param mixed|FormData data
    * @param callable(data) completeHandler
    * @param callable errorHandler
    * @param callable progressHandler
    * @returns void
    **************************************************************************/
    function _(data) {
        console.log(data);
    }

    function request(url, data, completeHandler, errorHandler, progressHandler) {
        if (typeof progressHandler === 'string' || progressHandler instanceof String) {
            method = progressHandler;
        } else {
            method = "POST"
        }

        $.ajax({
            url: url, //server script to process data
            type: method,
            xhr: function () {  // custom xhr
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // if upload property exists
                    myXhr.upload.addEventListener('progress', progressHandler, false); // progressbar
                }
                return myXhr;
            },
            // Ajax events
            success: completeHandler,
            error: errorHandler,
            // Form data
            data: data,
            // Options to tell jQuery not to process data or worry about the content-type
            cache: false,
            contentType: false,
            processData: false
        }, 'json');
    }

    /***********************************************************************
    * Notify with a message in shape of fancy alert
    **********************************************************************/
    function notify(status, title, msg, type) {
        status = (status == 'error' ? 'danger' : status);
        var callable = null;
        var template = null;
        var icons = {
            'danger': 'fa-ban',
            'success': 'fa-check',
            'info': 'fa-info',
            'warning': 'fa-warning'
        };
        if ($.isFunction(type)) {
            callable = type;
            type = 'modal';
        }

        if (!type || type == 'm') {
            type = 'modal';
        } else if (type == 'f') {
            type = 'flash';
        }

        template = $("#alert-" + type).html();
        template = template.replace(new RegExp('{icon}', 'g'), icons[status]);
        template = template.replace(new RegExp('{status}', 'g'), status);
        template = template.replace(new RegExp('{title}', 'g'), title);
        template = template.replace(new RegExp('{msg}', 'g'), msg);
        switch (type) {
            case 'modal':
            var modal = $(template).modal('toggle');
            if ($.isFunction(callable)) {
                modal.on("hidden.bs.modal", callable);
            }
            return;
            default:
            $('#alert-box').html(template);
        }

    }

    /***********************************************************************
    * loading new file image
    **********************************************************************/

    $(document).on('click', '.file-generate', function () {
        var $this = $(this);
        var fileBox = $this.closest('.file-box');
        var newBox = $('div.file-box:first').clone();
        newBox.find('img').prop('src' , 'https://placeholdit.imgix.net/~text?txtsize=33&txt=290%C3%97180%20or%20larger&w=290&h=180');
        newBox.find('.caption').append('<button type="button" class="file-remove btn btn-danger"><i class="fa fa-minus fa-lg" aria-hidden="true"></i></button>');
        fileBox.after(newBox);

    });

    $(document).on('click', '.file-remove', function () {
        var $this = $(this);
        $this.closest('.file-box').remove();
    });


    $(document).on('click', '.file-btn', function () {
        $(this).closest('.file-box').find('input[type=file]').click();
    });
    $(document).on('change', '.file-box input[type=file]', function () {
        var fileBtn = $(this).closest('.file-box').find('.file-btn');
        if (validateImgFile(this)) {
            previewURL(fileBtn, this);
        }
    });
    /***************************************************************************
    * Select2 Plugin For tags
    **************************************************************************/
    if ((tagsList = $('#select-tags')).length) {
        tagsList.select2({
            tags: true,
            dir: "rtl",
            tokenSeparators: [',', ' '],
            theme: "classic",
            multiple: true,
            ajax: {
                url: tagsList.data('url'),
                type: "GET",
                dataType: "json",
                processResults: function (data, page) {
                    return {
                        results: data
                    };
                }
            }
        });
    }
    /***************************************************************************
    * identify Tinymce
    **************************************************************************/
    if (typeof tinymce !== "undefined") {
        /*Text area Editors
        =========================*/
        tinymce.init({
            selector: '.tiny-editor',
            height: 350,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc',
            ],
            toolbar: 'newdocument | bold | italic | underline | strikethrough | alignleft | aligncenter | alignright | alignjustify | styleselect | formatselect | fontselect | fontsizeselect | cut | copy | paste | bullist | numlist | outdent | indent | blockquote | undo redo | removeformat | subscript | superscript | link unlink | image | charmap | pastetext | print | anchor | pagebreak | spellchecker | searchreplace | save cancel | table | ltr rtl | emoticons | template | forecolor backcolor | insertfile | preview | hr | visualblocks | visualchars | code | fullscreen | insertdatetime | media | nonbreaking | inserttable tableprops deletetable cell row column | visualaid | selectall',
            image_advtab: true,
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ],
            fontsize_formats: "8pt 9pt 10pt 11pt 12pt 13pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 30pt 32pt 34pt 36pt 38pt 40pt 42pt 44pt 46pt 48pt 50pt 52pt 54pt 56pt 58pt 60pt 62pt 64pt 66pt 68pt 70pt 72pt 74pt 76pt 78pt 80pt 82pt 84pt 86pt 88pt 90pt 92pt 94pt 96pt 98pt 100pt 102pt 104pt 106pt 108pt 110pt",
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css'
            ]
        });
    }

})();

