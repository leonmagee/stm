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
          let img_div = '';
          if(product.img_url) {
            img_div = <div className="product__image product__image--url"><img src={product.img_url} /></div>
          } else {
            img_div = <div className="product__image product__image--default"><i className="far fa-image"></i></div>
          }
          return (
            <div key={index} className="product">
              {img_div}
              <div className="product__title">{product.name}</div>
              <div className="product__cost">${product.cost_format}</div>
              <div className="product__footer">
                <a href={"/products/" + product.id}>View</a>
                {/* <a href={"/products/edit/" + product.id}>Edit</a> */}
                <a>Add To Cart</a>
              </div>
            </div>
          )
        })
        return <div className="products">{products}</div>;
    }
}

if (document.getElementById('products')) {
  const products = document.getElementById('products').getAttribute('products');
    ReactDOM.render(
      <Products products={products} />,
      document.getElementById('products')
    );
}
