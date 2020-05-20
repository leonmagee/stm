import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Products extends Component {
    constructor(props) {
        super(props);
        this.state = {
          products: JSON.parse(props.products)
        }
    }

    render() {
        const products = this.state.products.map( (product, index) => {
          return <div key={index}>{product.name}</div>
        })
        return <div className="container">{products}</div>;
    }
}

if (document.getElementById('products')) {
  const products = document.getElementById('products').getAttribute('products');
    ReactDOM.render(
      <Products products={products} />,
      document.getElementById('products')
    );
}
