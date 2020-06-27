import React, { Component } from 'react';
import Product from './Product';

export default class ProductList extends Component {

  render() {
    const { products } = this.props;
    const productsBlock = products.map((product, i) => {
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
        />
      );
    })
    return (
      <div className="products">{productsBlock}</div>
    )
  }
}
