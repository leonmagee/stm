/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('datatables.net');

require('chart.js');

require('axios');

require('bulma-tooltip');

require('jquery-zoom');

// require('jquery-ui');

require('jquery-ui/ui/widgets/sortable');

require('@rateyo/jquery/lib/cjs/jquery.rateyo.js');

require('./jquery.datetimepicker.full');

require('./components/AllUsers');

require('./components/AllUsersNotAdmin');

require('./components/AllUsersAgents');

require('./components/Products');

require('./components/ProductsCarousel');

require('./components/Timer');

// sortable list
// $(document).ready(function() {
//     console.log('ready!');
//     // const sortable = $('#sortable-list');
//     const sortable = document.getElementById('#sortable-list');
//     new Sortable(sortable, {
//         animation: 200,
//     });
// });

// imei lookup
// const imeiUrl = 'https://www.imei.info/api/checkimei';
// const imeiUrl = 'https://api.chucknorris.io/jokes/random';

// fetch(imeiUrl, {
//     method: 'post',
//     // mode: 'cors',
//     body: {
//         key: 'bb31213cd934cecdd3546016528a8ee26770f10d9ad4b8711f0d0ce0d6cbd179',
//         imei: '353331072816483',
//     },
// })
//     .then(res => res.json())
//     .then(data => {
//         console.log(data);
//     })
//     .catch(err => {
//         console.log(err);
//     });

// const imeiSettings = {
//     async: true,
//     crossDomain: true,
//     // url: 'https://ismaelc-imei-info.p.rapidapi.com/checkimei',
//     url: 'https://www.imei.info/api/checkimei',
//     method: 'POST',
//     headers: {
//         'cache-control': 'no-cache',
//         'content-type':
//             'multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW',
//         // 'x-rapidapi-host': 'ismaelc-imei-info.p.rapidapi.com',
//         // 'x-rapidapi-key': '7f92af3009mshfe041a55ab2ecf1p14ef7ejsn8f081578ce1e',
//         // 'content-type': 'application/x-www-form-urlencoded',
//     },
//     data: {
//         // imei: "355136052818864",
//         imei: '353331072816483',
//         // key: '7f92af3009mshfe041a55ab2ecf1p14ef7ejsn8f081578ce1e',
//         key: 'bb31213cd934cecdd3546016528a8ee26770f10d9ad4b8711f0d0ce0d6cbd179',
//     },
// };
// console.log('fetch testing');
// $.ajax(imeiSettings).done(function(response) {
//     console.log(response);
// });

// sortable
$('#sortable-list').sortable({
    update(event, ui) {
        const productId = ui.item.attr('id');
        const productIndex = ui.item.index() + 1;
        axios({
            method: 'post',
            url: '/product-update-order',
            data: {
                productId,
                productIndex,
            },
        }).then(response => {
            //
        });
        // console.log('order has been updated');
    },
});

$('.list-group-sort#preview_images').sortable({
    update(event, ui) {
        const slideId = ui.item.attr('id');
        const slideIndex = ui.item.index() + 1;
        axios({
            method: 'post',
            url: '/slider-update-order',
            data: {
                slideId,
                slideIndex,
            },
        }).then(response => {
            //
        });
    },
});

// $(selector).sortable({
//     start: function(event, ui) {
//         ui.item.data("start_pos", ui.item.index());
//     },
//     stop: function(event, ui) {
//         var start_pos = ui.item.data("start_pos");
//         if (start_pos != ui.item.index()) {
//             // the item got moved
//         } else {
//             // the item was returned to the same position
//         }
//     },
//     update: function(event, ui) {
//         $.post("/reorder", $(selector).sortable("serialize")).done(function() {
//             alert("Updated");
//         });
//     }
// });

// slide nav
const num_slides = $('.stm-slider__inner > .image-div').length;

function changeSlide(num) {
    const id = $('.stm-slider__inner .image-div.active').attr('index_id');
    let new_id = parseInt(id) + 1;
    if (new_id >= num) {
        new_id = 0;
    }
    updateSlide(new_id);
}

function updateSlide(id) {
    $('.stm-slider__inner .image-div.active').fadeOut(400, function() {
        $(this).removeClass('active');
        $(`.stm-slider__inner .image-div#slide-${id}`)
            .fadeIn(600)
            .addClass('active');
        $('.stm-slider__nav .slide-dot.active').removeClass('active');
        $(`.stm-slider__nav .slide-dot#dot-${id}`).addClass('active');
    });
}

function changeSlidePrev(num) {
    const id = $('.stm-slider__inner .image-div.active').attr('index_id');
    let new_id = parseInt(id) - 1;
    if (new_id < 0) {
        new_id = num - 1;
    }
    updateSlide(new_id);
}

$('.stm-slider__nav .slide-dot').click(function() {
    clearInterval(timerInterval);
    const id = $(this).attr('index_id');
    updateSlide(id);
    startTimer();
});

$('#prevNav').click(function() {
    changeSlidePrev(num_slides);
    clearInterval(timerInterval);
    startTimer();
});

$('#nextNav').click(function() {
    changeSlide(num_slides);
    clearInterval(timerInterval);
    startTimer();
});

let timerInterval;
const startTimer = function() {
    timerInterval = setInterval(function() {
        changeSlide(num_slides);
    }, 4000);
};
startTimer();

// quantity toggle (single)
const max_quantity = $('input#quantity-input').attr('max_quantity');
function change_input_value(max) {
    $('input#quantity-input').change(function() {
        if (parseInt($(this).val()) < 1) {
            $(this).val('');
        }
        if (parseInt($(this).val()) > max) {
            $(this).val(max);
        }
    });
}

change_input_value(max_quantity);

$('select#variation-select').change(function() {
    const quantity = $('option:selected', this).attr('quantity');
    $('input#quantity-input').attr('max_quantity', quantity);
    $('input#quantity-input').attr('placeholder', `${quantity} Max`);
    $('input#quantity-input').val('');
    $('input#quantity-input').off('change');
    change_input_value(quantity);
});

// cart save on change
$('select.variation-select').change(function() {
    $(this)
        .parent()
        .parent()
        .parent()
        .parent()
        .submit();
});
$('input.quantity-input').change(function() {
    $(this)
        .parent()
        .parent()
        .parent()
        .submit();
});

// thumbnail
$('.rate_yo_thumbnail').each(function() {
    const rating = $(this).attr('rating');
    $(this).rateYo({
        rating,
        readOnly: true,
        starWidth: '17px',
        spacing: '2px',
        halfStar: true,
        // ratedFill: "#D5BE48",
        ratedFill: '#ffc43d',
    });
});

// single modal
const rating = $('#rateYo').attr('rating');
$('#rateYo')
    .rateYo({
        rating,
        fullStar: true,
        starWidth: '27px',
        spacing: '2px',
        // ratedFill: "#D5BE48",
        ratedFill: '#ffc43d',
    })
    .on('rateyo.set', function(e, data) {
        const { rating } = data;
        const product_id = $(this).attr('product_id');
        $(this)
            .next()
            .text(rating);

        axios({
            method: 'post',
            url: '/update-user-rating',
            data: {
                stars: rating,
                product_id,
            },
        }).then(response => {
            //
        });
    });

// single top
const ratingDisplay = $('#rateYoDisplay').attr('rating');
$('#rateYoDisplay').rateYo({
    rating: ratingDisplay,
    readOnly: true,
    starWidth: '23px',
    spacing: '2px',
    ratedFill: '#ffc43d',
});

// single reviews
$('.rate_yo_review').each(function() {
    const rating = $(this).attr('rating');
    $(this).rateYo({
        rating,
        readOnly: true,
        starWidth: '25px',
        spacing: '2px',
        // ratedFill: "#D5BE48",
        ratedFill: '#ffc43d',
    });
});

/**
 * Set Defaults
 */
const number_images = 6;
const tab_number_videos = 2;
const tab_number_images = 8;

/**
 * Image hover switch
 */
$('.product-single__images--item').hover(function() {
    const image_id = $(this).attr('image_id');
    $('.product-single__images--url .active')
        .removeClass('active')
        .addClass('hidden');
    $(`.product-single__images--url .hidden.img_url_${image_id}`)
        .removeClass('hidden')
        .addClass('active');
});

/**
 * Search Form Submit
 */
$('a#user-search-form-submit').click(function() {
    $('#user-search-form').submit();
});
$('a#user-search-form-mobile-submit').click(function() {
    $('#user-search-form-mobile').submit();
});

/**
 * JQuery Zoom
 */
for (let i = 1; i < number_images + 1; ++i) {
    this[`img_src_${i}`] = $(`.product-single__images--url-item_${i}`)
        .find('img')
        .attr('src');
    $(`.product-single__images--url-item_${i}`).zoom({
        url: this[`img_src_${i}`],
    });
}

/**
 * Main Image Preview (edit page)
 */
for (let i = 1; i <= number_images + 1; ++i) {
    $(`#preview_images input#product_upload_image_${i}`).change(function() {
        const id_name = `output_${i}`;
        const output = document.getElementById(id_name);
        const file = event.target.files[0];
        $(`#preview_images .preview-image__image.output_${i}`).removeClass(
            'hide_img'
        );
        $(`#preview_images .preview-image__default_${i}`).addClass('hide');
        output.src = URL.createObjectURL(file);
        output.onload = function() {
            URL.revokeObjectURL(output.src); // free memory
        };
    });
}

/**
 * Main Image Preview Remove (edit page)
 */
$('#preview_images .preview-image__image i.remove').click(function() {
    const img_id = $(this).attr('img_id');
    $(`#preview_images .preview-image__image.output_${img_id}`).addClass(
        'hide_img'
    );
    $(`#preview_images .preview-image__default_${img_id}`).removeClass('hide');
    $(`#preview_images input[name='img_url_${img_id}']`).val('');
});

/**
 * Video Preview Tabs
 */
for (let i = 1; i <= tab_number_videos; ++i) {
    $(`#tab_preview_videos input#tab_product_upload_video_${i}`).change(
        function() {
            $(
                `#tab_preview_videos .preview-image__default--video.preview-image__default_tab_${i}`
            ).addClass('video');
        }
    );
}

/**
 * Tab Video Preview Remove (edit page)
 */
$('#tab_preview_videos .preview-image__image i.remove-video').click(function() {
    const img_id = $(this).attr('img_id');
    $(`#tab_preview_videos .preview-image__image.output_${img_id}`).addClass(
        'hide_img'
    );
    $(`#tab_preview_videos .preview-image__default_tab_${img_id}`).removeClass(
        'hide'
    );
    $(`#tab_preview_videos input[name='tab_video_url_${img_id}']`).val('');
});

/**
 * Tab Image Preview (edit page)
 */
for (let i = 1; i <= tab_number_images; ++i) {
    $(`#tab_preview_images input#tab_product_upload_image_${i}`).change(
        function() {
            const id_name = `tab_output_${i}`;
            const output = document.getElementById(id_name);
            $(
                `#tab_preview_images .preview-image__image.tab_output_${i}`
            ).removeClass('hide_img');
            $(`#tab_preview_images .preview-image__default_tab_${i}`).addClass(
                'hide'
            );
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src); // free memory
            };
        }
    );
}

/**
 * Tab Image Preview Remove (edit page)
 */
$('#tab_preview_images .preview-image__image i.remove-tab').click(function() {
    const img_id = $(this).attr('img_id');
    $(
        `#tab_preview_images .preview-image__image.tab_output_${img_id}`
    ).addClass('hide_img');
    $(`#tab_preview_images .preview-image__default_tab_${img_id}`).removeClass(
        'hide'
    );
    $(`#tab_preview_images input[name='tab_img_url_${img_id}']`).val('');
});

/**
 * Zoom Icon Dissapear
 */
$('.product-single__images--url').hover(
    function() {
        $('.product-single__images--url-icon').hide();
    },
    function() {
        $('.product-single__images--url-icon').show();
    }
);

/**
 * Categories Toggle
 */
$('.category-area input').click(function() {
    const id = $(this).attr('cat_num');
    $(`.sub-category-${id}`).toggleClass('active');
});

/**
 * Date Time Picker
 */
jQuery.datetimepicker.setLocale('en');
jQuery('#due_date, #available_on, #starting_date, #ending_date').datetimepicker(
    {
        timepicker: false,
        format: 'M d, Y',
    }
);

jQuery('#expiration_date').datetimepicker({
    timepicker: true,
    format: 'M d, Y g:ia',
});

/**
 * Quill Submit
 */
$('#email-blast-form').on('submit', function(e) {
    e.preventDefault();
    const quill_text = $('#quill_editor .ql-editor').html();
    $('#quill_text').val(quill_text);
    $(this)[0].submit();
});

$('#product-form').on('submit', function(e) {
    e.preventDefault();
    const quill_text = $('#quill_editor .ql-editor').html();
    $('textarea#description').val(quill_text);
    // clear last input value for repeater field
    $('#repeater-field-wrap .entry:last input').val('');
    // submit form
    $(this)[0].submit();
});

/**
 * Commission Tabs
 */
$('#commission-tabs li').click(function() {
    $(this)
        .parent()
        .find('.is-active')
        .removeClass('is-active');
    $(this).addClass('is-active');
    const tab = $(this).attr('tab');
    $('.tabs-content .tab-item.active').removeClass('active');
    $(`.tabs-content .tab-item#${tab}`).addClass('active');
});

/**
 * Product Tabs
 */
$('#product-tabs li').click(function() {
    $(this)
        .parent()
        .find('.is-active')
        .removeClass('is-active');
    $(this).addClass('is-active');
    const tab = $(this).attr('tab');
    $('.tabs-content .tab-item.active').removeClass('active');
    $(`.tabs-content .tab-item#${tab}`).addClass('active');
});

/**
 * Credit payment choices
 */
$('.form-wrap .credit-redeem-choices .item').click(function() {
    const type_name = $(this).attr('name');
    const company = $('input#hidden-user-company').val();
    if (
        type_name === 'h2o-direct-portal' ||
        type_name === 'lyca-direct-portal' ||
        type_name === 'gs-posa-portal'
    ) {
        $('input#account_entry').val(company);
    } else {
        const account = $('input#account_entry').val();
        if (account === company) {
            $('input#account_entry').val('');
        }
    }

    $('#redeem-credit input#type').val(type_name);
    $(this)
        .parent()
        .find('.active')
        .removeClass('active');
    $(this).addClass('active');
});

$('.redeem-credit-modal').click(function() {
    const balance = $('input#hidden-user-balance').val();

    if (balance && balance > 0) {
        // modal shouldn't trigger if it's not set...
        const account = $('input#account_entry').val();
        const type = $('#redeem-credit input#type').val();

        const type_no_dash = type.replace(/-/g, ' ');
        $('.modal-account-id span').html(account);
        $('.modal-payment-type span').html(type_no_dash);

        $('input#account').val(account);
        if (account && type) {
            $('.modal#layout-modal').toggleClass('is-active');
        } else if (type) {
            const notification =
                '<div class="notification is-half is-danger"><button class="delete"></button><div>You must provide account information.</div></div>';
            $('div#content').prepend(notification);
            $('.notification .delete').click(function() {
                $(this)
                    .parent()
                    .fadeOut();
            });
        } else if (account) {
            const notification =
                '<div class="notification is-half is-danger"><button class="delete"></button><div>You must choose a payment type.</div></div>';
            $('div#content').prepend(notification);
            $('.notification .delete').click(function() {
                $(this)
                    .parent()
                    .fadeOut();
            });
        } else {
            const notification =
                '<div class="notification is-half is-danger"><button class="delete"></button><div>You must choose a payment type and provide account information.</div></div>';
            $('div#content').prepend(notification);
            $('.notification .delete').click(function() {
                $(this)
                    .parent()
                    .fadeOut();
            });
        }
    } else {
        const notification =
            '<div class="notification is-half is-danger"><button class="delete"></button><div>You must have credit to proceed.</div></div>';
        $('div#content').prepend(notification);
        $('.notification .delete').click(function() {
            $(this)
                .parent()
                .fadeOut();
        });
    }
});

/**
 * Repeater Field for Attributes
 */
$(document)
    .on('click', '.add-attribute', function(e) {
        e.preventDefault();

        const attribute = $(this)
            .parents('.entry:first')
            .find('input.name')
            .val();
        const matches = $('#repeater-field-wrap .entry.input-group').length;

        if (attribute !== '' && matches <= 4) {
            const controlForm = $('#repeater-field-wrap:first');
            const currentEntry = $(this).parents('.entry:first');
            const newEntry = $(currentEntry.clone()).appendTo(controlForm);
            newEntry.find('input').val('');
            controlForm
                .find('.entry:not(:last) .add-attribute')
                .removeClass('is-primary add-attribute')
                .addClass('is-danger remove-attribute')
                .find('i')
                .removeClass('fa-plus')
                .addClass('fa-times');
        }
    })
    .on('click', '.remove-attribute', function(e) {
        e.preventDefault();
        $(this)
            .parents('.entry:first')
            .remove();
        return false;
    });

/**
 * Repeater Field for Variations
 */
$(document)
    .on('click', '.add-variation', function(e) {
        e.preventDefault();

        const variation = $(this)
            .parents('.entry:first')
            .find('input.name')
            .val();
        const quantity = $(this)
            .parents('.entry:first')
            .find('input.quantity')
            .val();
        // var matches = $("#repeater-field-wrap .entry.input-group").length;

        if (variation !== '' && quantity !== '') {
            const controlForm = $('#repeater-field-wrap-variation:first');
            const currentEntry = $(this).parents('.entry:first');
            const newEntry = $(currentEntry.clone()).appendTo(controlForm);
            newEntry.find('input').val('');
            controlForm
                .find('.entry:not(:last) .add-variation')
                .removeClass('is-primary add-variation')
                .addClass('is-danger remove-variation')
                .find('i')
                .removeClass('fa-plus')
                .addClass('fa-times');
        }
    })
    .on('click', '.remove-variation', function(e) {
        e.preventDefault();
        $(this)
            .parents('.entry:first')
            .remove();
        return false;
    });

/**
 * Fade out notification on click
 */
$('.notification .delete').click(function() {
    $(this)
        .parent()
        .fadeOut();
});

// $('form#order_sims_form input, form input[type="number"]').keydown(function (e) {
//   if (!((e.keyCode > 95 && e.keyCode < 106)
//     || (e.keyCode > 47 && e.keyCode < 58)
//     || e.keyCode == 8) && e.keyCode !== 190) {
//       return false;
//     }
// });

/**
 * Email Blast Toggle
 */
$('#all-users-radio').click(function() {
    $('#exclude-sites-wrap').addClass('active');
});

$('.one-site-radio').click(function() {
    $('#exclude-sites-wrap').removeClass('active');
});

/**
 * Modals
 */
$(
    '.modal-open, #layout-modal .modal-close, #layout-modal .modal-close-button'
).click(function() {
    $('.modal#layout-modal').toggleClass('is-active');
});

$(
    '.modal-open-2, #layout-modal-2 .modal-close, #layout-modal-2 .modal-close-button'
).click(function() {
    console.log('clickz...');
    $('.modal#layout-modal-2').toggleClass('is-active');
});

$(
    '.modal-open-transfer-1, #layout-modal-transfer-1 .modal-close, #layout-modal-transfer-1 .modal-close-button'
).click(function() {
    $('.modal#layout-modal-transfer-1').toggleClass('is-active');
});

$('.modal-open-email-blast, .modal-email-close, .modal-close').click(
    function() {
        $('#email-blast-modal').toggleClass('is-active');
    }
);

$(
    '.modal-open-rma-approve, .modal-rma-approve-close, #modal-close-rma-approve-icon'
).click(function() {
    $('#rma-approve-modal').toggleClass('is-active');
});

$(
    '.modal-open-rma-reject, .modal-rma-reject-close, #modal-close-rma-reject-icon'
).click(function() {
    $('#rma-reject-modal').toggleClass('is-active');
});

$('.modal-open-review, .modal-review-close, .modal-close').click(function() {
    $('#review-modal').toggleClass('is-active');
});

$(
    '.modal-open-transfer-2, #layout-modal-transfer-2 .modal-close, #layout-modal-transfer-2 .modal-close-button'
).click(function() {
    $('.modal#layout-modal-transfer-2').toggleClass('is-active');
});

$(
    '.modal-open-exclude-users, #layout-modal-exclude-users .modal-close, #layout-modal-exclude-users .modal-close-button'
).click(function() {
    $('.modal#layout-modal-exclude-users').toggleClass('is-active');
});

/**
 * Modal for deleting note and email
 */
$('.modal-delete-open, .modal-delete-close, .modal-delete-close-button').click(
    function() {
        const itemId = $(this).attr('item_id');
        $(`.modal#delete-item-modal-${itemId}`).toggleClass('is-active');
    }
);

/**
 * Modal for deleting note and email
 */
$(
    '.modal-2-delete-open, .modal-2-delete-close, .modal-2-delete-close-button'
).click(function() {
    const itemId = $(this).attr('item_id');
    $(`.modal#delete-item-modal-2-${itemId}`).toggleClass('is-active');
});

/**
 * Modal for resending email
 */
$('.modal-resend-open, .modal-resend-close, .modal-resend-close-button').click(
    function() {
        const itemId = $(this).attr('item_id');
        $(`.modal#resend-item-modal-${itemId}`).toggleClass('is-active');
    }
);

/**
 * Modal for deleting order
 */
$('.modal-delete-open, .modal-delete-close, .modal-delete-close-button').click(
    function() {
        const orderId = $(this).attr('order_id');
        $(`.modal#delete-order-modal-${orderId}`).toggleClass('is-active');
    }
);

$('.menu-modal-open, #menu-modal .menu-modal-close').click(function() {
    $('.modal#menu-modal').toggleClass('is-active');
});

$('#modal_delete_sims').click(function() {
    $('#delete_sims_form').submit();
});

/**
 * Toggle mobile menu
 */
$('.mobile-menu a.has-menu').click(function() {
    $(this)
        .parent()
        .toggleClass('active')
        .find('ul')
        .toggleClass('active');
});

/**
 * Activate data tables
 * Now handled by ajax
 */
// $('#sims_table').DataTable();

// $('#sims_table').DataTable({
//     "processing": true,
//     "serverSide": true,
//     "ajax": "{{ route('api.sims.index') }}",
//     "columns": [
//         { "data": "sim_number" },
//         { "data": "value" },
//         { "data": "activation_date" },
//         { "data": "mobile_number" },
//         { "data": "report_type_id" }
//     ]
// });

/**
 * Show spinner
 * This is linked to buttons that show the spinner prior to refreshing the page.
 */
$('button.call-loader, ul.sidebar-menu li a[href="/reports"]').click(
    function() {
        $('.stm-absolute-wrap#loader-wrap').css({ display: 'flex' });
    }
);

// loader for datatables processing
$('#sims_table').on('processing.dt', function(e, settings, processing) {
    if (processing === true) {
        $('.stm-absolute-wrap#loader-wrap').css({ display: 'flex' });
    } else {
        $('.stm-absolute-wrap#loader-wrap').css({ display: 'none' });
    }
});

// hide loader on input validation fail
$('form input').on('invalid', function(event) {
    if (event.type === 'invalid') {
        $('.stm-absolute-wrap#loader-wrap').css({ display: 'none' });
    }
});

/**
 * Add file name to inputs
 */
$('.upload-file-js').on('change', function() {
    if (this.files.length > 0) {
        $(this)
            .parent()
            .find('.file-name')
            .html(this.files[0].name);
    }
});

/**
 * Note delete form
 */
$('.delete-note-form i').click(function() {
    $(this)
        .parent()
        .submit();
});

/**
 * Scroll to top
 */
$('.scroll-up-link').click(function() {
    $('html, body').animate({ scrollTop: 0 }, 'slow');
});
$(window).bind('scroll', function() {
    if ($(this).scrollTop() > 1) {
        $('.scroll-up-link').fadeIn();
    } else {
        $('.scroll-up-link')
            .stop()
            .fadeOut();
    }
});
