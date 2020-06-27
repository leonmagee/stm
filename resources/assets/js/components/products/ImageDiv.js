import React, { Component } from 'react';

export default class ImageDiv extends Component {

  render() {
    const { img_url, discount } = this.props;
    let img_div;
    let discount_div;
    if (discount) {
      discount_div = <div className="product__discount">{discount}% Off</div>
    } else {
      discount_div = '';
    }
    if (img_url) {
      img_div = <img src={img_url} />
    } else {
      img_div = <i className="far fa-image"></i>
    }
    let div_class = img_url ? 'product__image--url' : 'product__image--default';
    return (
      <div className={"product__image " + div_class}>
        {img_div}
        {discount_div}
      </div>
    )
  }
}
