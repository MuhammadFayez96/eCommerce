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
    * Add To Cart Button
    **************************************************************************/
    var shoppingCartBox = $('#shopping-cart-box');
    function updateSoppingCart() {
        $.ajax({
            url: shoppingCartBox.data('url'),
        }).done(function (data) {
            console.log(data.cart_view);
            shoppingCartBox.html(data.cart_view);

        }).fail(function () {
            alert('Internal Server Error.');
        });
    }

    $(document).on('click', '.cart-btn', function (e) {
        e.preventDefault();
        var $this = $(this);
        var url = formData = null;
        var cartForm  = $this.closest('form.cart-form');

        if(cartForm.length){
            url = cartForm.attr('action');
            formData = new FormData(cartForm[0]);
            console.log(formData);

        }else{
            formData = csrf;
            url = $this.data('url');
            formData.append('quantity' , $this.data('quantity'));
        }

        request(url, formData, function (data) {
            updateSoppingCart();
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
            // location.reload();
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

    /***************************************************************************
    * Modal View Modal
    **************************************************************************/

    $(document).on('click', '.btn-modal-view', function () {
        var $this = $(this);
        var url = $this.data('url');
        var originalHtml = $this.html();
        $this.prop('disabled', true).html('انتظر...');
        request(url, null, function (data) {
            $this.prop('disabled', false).html(originalHtml);
            $('#common-modal').html(data).modal('toggle');
        }, function () {
            alert('Error');
        }, 'get');
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
    * Post Edit Modal
    **************************************************************************/

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
    * Post Add Modal
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
    /***************************************************************************
    * Form Contact Ajax Uploud Section
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
        ajaxSubmit.prop('disabled', true).html(altText);
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

        // request(url, formData, function (result) {
        //     notify(result.status, result.title, result.msg, notification);
        //     ajaxSubmit.prop('disabled', false).html(ajaxSubmitHtml);

        // }, function () {
        //     alert('Internal Server Error.');
        // });
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

    // function removeElement() {
    //     var elem = document.getElementById('remove-element');
    //     elem.parentNode.removeChild(elem);
    //     return false;
    // }
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
    var productsArea = $('#products-area');
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
    });
    /***************************************************************************
    * Ajax Filters For Products and wishlist Controller
    **************************************************************************/
    // $(document).on('change', '#menu-select , #menu-select2 ,input.first_limit', function (e) {

    //     alert('ddddd');
    //     var $this = $(this);
    //     var form = $this.closest('form');
    //     productsArea.show();
    //     $.ajax({
    //         url: form.attr('action'),
    //         data: form.serialize()
    //     }).done(function (data) {
    //         productsArea.html(data).hide();
    //     }).fail(function () {
    //         alert('Internal Server Error.');
    //     });
    // });

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
    /****************************************************************************
    * Generating and Deleting new input-list
    ***************************************************************************/

    $(document).on('click', '.input-list-btn-add', function () {
        var closestInputList = $(this).closest('.input-list');
        var newInputList = closestInputList.clone();
        newInputList.find('input').val('');
        closestInputList.after(newInputList);
    });
    $(document).on('click', '.input-list-btn-del', function () {
        if ($(this).closest('.box-body').find('.input-list').length > 1) {
            $(this).closest('.input-list').remove();
        }
    });

    /*******************************************************************************
    * Events Subscribe Buttons for the tables
    *******************************************************************************/
    $(document).on('click', '#btn-subscribe', function () {
        var $this = $(this);
        var form = $this.closest('form');
        var content = new FormData(form[0]);
        content.append('subscribe', tinymce.activeEditor.getContent());
        request(form.attr('action') + "/subscribe", content, function (data) {
            if (data.status === 'success') {
                swal({title: data.title, text: data.msg, type: "success"}, function () {
                    $('input[data-filter=all]').change();
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
    * Actions For View Buttons of the filtered table
    ***************************************************************************/

    var modalViewTemplate = $('#modal-view-template').html();
    var modalViewBody = $('#modal-view-body');
    $(document).on('click', '.btn-table-view', function () {
        var $this = $(this);
        var form = $(this).closest('form');
        var id = $this.data('id');
        request(form.attr('action') + '/view/' + id, csrf, function (data) {
            if (data) {
                var txt = modalViewTemplate;
                for (var key in data) {
                    txt = txt.replace(new RegExp('{' + key + '}', 'g'), data[key]);
                }
                modalViewBody.html(txt);
                modalViewBody.closest('#modal-view').modal('toggle');
            }
        }, function () {
            alert('Internal Server Error');
        });
    });


    /**
    * Show edit modal section
    */
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
        * Events For Global Delete Modal
        **************************************************************************/

        var commonModal = $('#common-modal');
        var deleteModalTemplate = $('#delete-modal-template').html();
        $(document).on('click', '.modal-delete-btn', function (e) {
            var url = $(this).attr('data-url');
            var txt = deleteModalTemplate;
            txt = txt.replace(new RegExp('{url}', 'g'), url);
            commonModal.html(txt).modal('toggle');
            e.preventDefault();
        });

        /***************************************************************************
        * Trigger File upload browsing Section
        **************************************************************************/

        $(document).on('click', '.file-btn', function () {
            $(this).closest('.file-box').find('input[type=file]').click();
        });
        $(document).on('change', '.file-box input[type=file]', function () {
            var fileBtn = $(this).closest('.file-box').find('.file-btn');
            if (validateImgFile(this)) {
                previewURL(fileBtn, this);
            }
        });
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
        * Custom logging function
        * @param mixed data
        * @returns void
        **************************************************************************/
        function _(data) {
            console.log(data);
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


        var AddModalBtn = $('.addBTN');
        var modelName = $('.add').attr('href');
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

        if (typeof tinymce !== "undefined") {
            /*Text area Editors
            =========================*/
            tinymce.init({
                selector: '.tiny-editor',
                height: 500,
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
