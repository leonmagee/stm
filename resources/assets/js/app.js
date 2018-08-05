/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('datatables');

require('chart.js');



$('#sims_table').DataTable();

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