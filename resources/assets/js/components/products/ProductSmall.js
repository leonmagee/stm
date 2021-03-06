// import React, { Component } from 'react';
// import ReactStars from "react-rating-stars-component";
// import Attributes from './Attributes';
// import Price from './Price';
// import ImageDiv from './ImageDiv';

// export default class ProductSmall extends Component {

//   constructor() {
//     super();
//     this.state = {
//       animate: false,
//     }
//   }

//   animateOff() {
//     this.setState({
//       animate: false,
//     })
//   }

//   animateOn() {
//     this.setState({
//       animate: true,
//     })
//     setTimeout(function() {
//       this.animateOff();
//     }.bind(this)
//     , 1100);
//   }

//   addToCart(id) {
//     console.log('clicky - id: ', id);
//     axios({
//       method: "post",
//       url: "/add-to-cart-axios",
//       data: {
//         id
//       }
//     }).then(res => {
//       console.log('worked. res:', res);
//       this.animateOn();
//     }).catch(err => {
//       console.log('error', err);
//     });
//   }

//   render() {

//     const { id, img_url, discount, name, attributes, price, orig_price, rating } = this.props;

//     let animatePane = <div></div>;
//     if (this.state.animate) {
//         animatePane = (
//             <div className="product__cart_hover">
//                 <i className="fas fa-check"></i>
//             </div>
//         );
//     }

//     return (
//         <div className="product product--small">
//             {animatePane}
//             <a className="product__link" href={"/products/" + id}>
//                 <ImageDiv img_url={img_url} discount={discount} />
//                 <div className="product__rating">
//                     <ReactStars
//                         count={5}
//                         value={rating}
//                         size={20}
//                         edit={false}
//                         isHalf={true}
//                         activeColor="#ffc43d"
//                     />
//                 </div>
//                 <div className="product__title">{name}</div>
//                 <Attributes attributes={attributes} />
//             </a>
//             <div className="product__footer">
//                 <Price
//                     price={price}
//                     orig_price={orig_price}
//                     discount={discount}
//                 />
//                 <a
//                     className="product__footer--right product__footer--right-favorite"
//                     data-tooltip="Add To Favorites"
//                 >
//                     <i className="fas fa-heart"></i>
//                 </a>
//                 <a
//                     className="product__footer--right product__footer--right-cart"
//                     data-tooltip="Add To Cart" onClick={() => this.addToCart(id)}
//                 >
//                     <i className="fas fa-cart-plus"></i>
//                 </a>
//             </div>
//         </div>
//     );
//   }
// }
