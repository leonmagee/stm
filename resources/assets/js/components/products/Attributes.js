import React, { Component } from 'react';

export default class Attributes extends Component {

  render() {
    const { attributes } = this.props;
    const list = attributes.map((attribute, k) => {
      return <div className="product__attributes--item" key={k}><i className="fas fa-circle"></i><span>{attribute}</span></div>;
    });
    return (
      <div className="product__attributes">{list}</div>
    )
  }
}
