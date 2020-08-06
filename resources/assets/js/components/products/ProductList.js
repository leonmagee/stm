import React, { Component } from 'react';
import Product from './Product';
//import ProductSmall from './ProductSmall';

export default class ProductList extends Component {

  render() {
    //const { products, display, user_id } = this.props;
    const { products, user_id } = this.props;
    const productsBlock = products.map((product, i) => {
      //if(display === 'basic') {
      return (
        <Product
          key={i}
          id={product.id}
          img_url={product.img_url_1}
          discount={product.discount}
          name={product.name}
          attributes={product.attributes_array}
          price={product.cost_format}
          orig_price={product.orig_price}
          rating={product.rating}
          user_id={user_id}
          stock={product.stock}
        />
      );
      // } else {
      // return (
      //   <Product
      //     key={i}
      //     id={product.id}
      //     img_url={product.img_url_1}
      //     discount={product.discount}
      //     name={product.name}
      //     attributes={product.attributes_array}
      //     price={product.cost_format}
      //     orig_price={product.orig_price}
      //     rating={product.rating}
      //     user_id={user_id}
      //     stock={product.stock}
      //   />
      // );
      //}
    })
    return (
      <div className="products">{productsBlock}</div>
    )
  }
}
