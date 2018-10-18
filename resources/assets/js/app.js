/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('datatables.net');

require('chart.js');

require('axios');

/**
* Fade out notification on click
*/
$('.notification .delete').click(function() {
	$(this).parent().fadeOut();
});

/**
* Modals
*/
$('.modal-open, #layout-modal .modal-close, #layout-modal .modal-close-button').click(function() {
    $('.modal#layout-modal').toggleClass('is-active');
});

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
	$(this).parent().toggleClass('active').find('ul').toggleClass('active');
});


/**
* Activate data tables
* Now handled by ajax
*/
//$('#sims_table').DataTable();

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
$('button.call-loader').click(function() {
	$('.stm-absolute-wrap#loader-wrap').css({'display':'flex'});
});


// loader for datatables processing

$('#sims_table')
    .on( 'processing.dt', function ( e, settings, processing ) {
    	if(processing === true)
    	{
			$('.stm-absolute-wrap#loader-wrap').css({'display':'flex'});
    	}
    	else {
    		$('.stm-absolute-wrap#loader-wrap').css({'display':'none'});
    	}
} );

/**
* Add file name to inputs
*/
$('.upload-file-js').on('change', function() {
	if ( this.files.length > 0 ) {
		$(this).parent().find('.file-name').html(this.files[0].name);
	}
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

//window.Vue = require('vue');

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

//$('div').hide();