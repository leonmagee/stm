// import React, { Component } from 'react';
// import Axios from 'axios';



//exports.doSomething = doSomething;



// toggleCompare(id) {

//     const { showCompareModal, relatedProducts } = this.state;

//     if (!showCompareModal) {

//     axios({
//         method: 'post',
//         url: '/get-related-products',
//         data: {
//             id,
//         },
//     }).then(res => {
//         if (res.data !== 'No Related') {
//             this.setState({
//                 compareArray: res.data,
//                 relatedProducts: true,
//             });
//             $('.stm-absolute-wrap#loader-wrap').css({ display: 'flex' });
//             setTimeout(() => {
//                 this.setState({
//                     showCompareModal: !showCompareModal,
//                 });
//                 $('.stm-absolute-wrap#loader-wrap').css({
//                     display: 'none',
//                 });
//             }, 300);
//         } else {
//             this.setState({
//                 relatedProducts: false,
//             });
//             $(
//                 `#product-${id} .product__footer--right.product__footer--right-compare`
//             )
//                 .attr('data-tooltip', 'No Related Products')
//                 .addClass('compare-icon');
//         }
//     });

//     } else {
//           $('.stm-absolute-wrap#loader-wrap').css({ display: 'none' });
//           this.setState({
//               compareArray: [],
//               showCompareModal: !showCompareModal,
//           });
//     }
// }
