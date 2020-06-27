import React, { Component } from 'react';

export default class Price extends Component {

  render() {
    const { discount, orig_price, price } = this.props;
    let orig_price_div = '';
    if (discount) {
      orig_price_div = <span className="product__footer--orig_price">${orig_price}</span>
    }
    return (
      <div className="product__footer--cost">
        ${price}
        {orig_price_div}
      </div>
    )
  }
}
