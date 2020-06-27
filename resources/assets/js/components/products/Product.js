import React, { Component } from 'react';
import Attributes from './Attributes';
import Price from './Price';
import ImageDiv from './ImageDiv';

export default class Product extends Component {

  render() {

    const { id, img_url, discount, name, attributes, price, orig_price } = this.props;

    return (
      <div className="product">
        <a className="product__link" href={"/products/" + id}>
          <ImageDiv img_url={img_url} discount={discount} />
          <div className="product__title">{name}</div>
          <Attributes attributes={attributes} />
        </a>
        <div className="product__footer">
          <Price price={price} orig_price={orig_price} discount={discount} />
          <a
            className="product__footer--right product__footer--right-favorite"
            data-tooltip="Add To Favorites"
          >
            <i className="fas fa-heart"></i>
          </a>
          <a
            className="product__footer--right product__footer--right-cart"
            data-tooltip="Add To Cart"
          >
            <i className="fas fa-cart-plus"></i>
          </a>
        </div>
      </div>
    )
  }
}
