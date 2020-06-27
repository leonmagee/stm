import React, { Component } from 'react';
//import Attributes from './Attributes';
import Price from './Price';
import ImageDiv from './ImageDiv';

export default class ProductSmall extends Component {

  render() {

    const { id, img_url, discount, name, attributes, price, orig_price } = this.props;

    return (
      <div className="product product--small">
        <a className="product__link" href={"/products/" + id}>
          <ImageDiv img_url={img_url} discount={discount} />
          <div className="product__title">{name}</div>
          {/* <Attributes attributes={attributes} /> */}
        </a>
        {/* <div className="product__footer">
          <Price price={price} orig_price={orig_price} discount={discount} />
        </div> */}
      </div>
    )
  }
}
