/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('datatables.net');

require('chart.js');

require('axios');

require('./components/AllUsers');

require('./components/AllUsersNotAdmin');

require('./components/AllUsersAgents');

/**
 * Quill Submit
 */
$("#email-blast-form").on("submit", function(e) {
    e.preventDefault();
    var quill_text = $("#quill_editor .ql-editor").html();
    $("#quill_text").val(quill_text);
    $(this)[0].submit();
});

/**
 * Commission Tabs
 */
$('#commission-tabs li').click(function() {
  $(this).parent().find('.is-active').removeClass('is-active');
  $(this).addClass('is-active');
  const tab = $(this).attr('tab');
  $('.tabs-content .tab-item.active').removeClass('active');
  $('.tabs-content .tab-item#' + tab).addClass('active');
});

/**
 * Credit payment choices
 */
$('.form-wrap .credit-redeem-choices .item').click(function() {
  const type_name = $(this).attr('name');
  const company = $('input#hidden-user-company').val();
  if ((type_name === 'h2o-direct-portal') || (type_name === 'lyca-direct-portal') || (type_name === 'gs-posa-portal')) {
    $('input#account_entry').val(company);
  } else {
    const account = $('input#account_entry').val();
    if (account === company) {
      $('input#account_entry').val('');
    }
  }


  $('#redeem-credit input#type').val(type_name);
  $(this).parent().find('.active').removeClass('active');
  $(this).addClass('active');
});

$('.redeem-credit-modal').click(function() {

  const balance = $('input#hidden-user-balance').val();

  if(balance && balance > 0) {

  // modal shouldn't trigger if it's not set...
  const account = $('input#account_entry').val();
  const type = $('#redeem-credit input#type').val();



  const type_no_dash = type.replace(/-/g, ' ');
  $('.modal-account-id span').html(account);
  $('.modal-payment-type span').html(type_no_dash);

  $('input#account').val(account);
  if(account && type) {
  $('.modal#layout-modal').toggleClass('is-active');

  } else if (type){
    const notification = '<div class="notification is-half is-danger"><button class="delete"></button><div>You must provide account information.</div></div>';
    $('div#content').prepend(notification);
    $('.notification .delete').click(function () {
      $(this)
        .parent()
        .fadeOut();
    });
  } else if (account) {
    const notification = '<div class="notification is-half is-danger"><button class="delete"></button><div>You must choose a payment type.</div></div>';
    $('div#content').prepend(notification);
    $('.notification .delete').click(function () {
      $(this)
        .parent()
        .fadeOut();
    });
  } else {
    const notification = '<div class="notification is-half is-danger"><button class="delete"></button><div>You must choose a payment type and provide account information.</div></div>';
    $('div#content').prepend(notification);
    $('.notification .delete').click(function () {
      $(this)
        .parent()
        .fadeOut();
    });
  }
  } else {
    const notification = '<div class="notification is-half is-danger"><button class="delete"></button><div>You must have credit to proceed.</div></div>';
    $('div#content').prepend(notification);
    $('.notification .delete').click(function () {
      $(this)
        .parent()
        .fadeOut();
    });
  }

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
  //console.log('workzzzzzzzz');
  $('#exclude-sites-wrap').addClass('active');
});

$('.one-site-radio').click(function () {
  //console.log('workzzzzzzzz');
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
  '.modal-open-transfer-1, #layout-modal-transfer-1 .modal-close, #layout-modal-transfer-1 .modal-close-button'
).click(function () {
  $('.modal#layout-modal-transfer-1').toggleClass('is-active');
});

$(
  '.modal-open-email-blast, .modal-email-close, .modal-close',
).click(function () {
  $('#email-blast-modal').toggleClass('is-active');
});

$(
  '.modal-open-transfer-2, #layout-modal-transfer-2 .modal-close, #layout-modal-transfer-2 .modal-close-button'
).click(function () {
  $('.modal#layout-modal-transfer-2').toggleClass('is-active');
});

$(
  '.modal-open-exclude-users, #layout-modal-exclude-users .modal-close, #layout-modal-exclude-users .modal-close-button'
).click(function () {
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
 * Modal for resending email
 */
$('.modal-resend-open, .modal-resend-close, .modal-resend-close-button').click(
  function () {
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
        // console.log('note id', noteId);
        $(`.modal#delete-order-modal-${orderId}`).toggleClass('is-active');
    }
);

$('.menu-modal-open, #menu-modal .menu-modal-close').click(function() {
    $('.modal#menu-modal').toggleClass('is-active');
});

$('#modal_delete_sims').click(function() {
    console.log('click worked new');
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

// var data = {
// 	labels: ['January', 'February', 'March'],
// 	datasets: [
// 		{
// 			data: [30, 122, 80],
// 			backgroundColor: 'rgba(0,210,255,0.3)',
// 			borderColor: 'rgba(0,210,255,1)',
// 			//borderWidth: 5,
// 		},
// 		{
// 			data: [20, 35, 110],
// 			backgroundColor: 'rgba(0,255,0,0.3)',
// 			borderColor: 'rgba(0,255,0,1)',
// 		}
// 	]
// }

// var context = document.querySelector('#graph').getContext('2d');

// var options = {
// 	//showLines: false,
// 	//borderColor: 'red',
// };

// //new Chart(context).Line(data, {});

// var myLineChart = new Chart(context, {
//     //type: 'bar',
//     type: 'line',
//     data: data,
//     options: options
// });

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });

// console.log('app.js is loading');

// $('#jquery-test.title').css({'color':'cornflowerblue'});

// $(document).ready(function() {
//     $('#example').DataTable();
// } );

// $('div').hide();
