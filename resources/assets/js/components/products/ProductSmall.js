import React, { Component } from 'react';
import Attributes from './Attributes';
import Price from './Price';
import ImageDiv from './ImageDiv';

export default class ProductSmall extends Component {

  render() {

    const { id, img_url, discount, name, attributes, price, orig_price, rating, user_id } = this.props;
    console.log('small', id, user_id, rating);
    return (
      <div className="product product--small">
        <a className="product__link" href={"/products/" + id}>
          <ImageDiv img_url={img_url} discount={discount} />
          <div className="product__rating">
            <div className="rate_yo_thumbnail" rating={rating} id={id} user_id={user_id}></div>
          </div>
          <div className="product__title">{name}</div>
          <Attributes attributes={attributes} />
        </a>
        <div className="product__footer">
          <Price price={price} orig_price={orig_price} discount={discount} />
        </div>
      </div>
    )
  }
}
