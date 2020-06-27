import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ProductList from './products/ProductList';

export default class ProductsCarousel extends Component {
    constructor(props) {
        super(props);
        this.state = {
            products: JSON.parse(props.products),
            i: 0,
            num: 3,
        };
    }

    parseIndex(i, l) {
      let iNew = i;
      if (i < 0) {
        iNew = (i + l)
      } else if (i == l) {
        iNew = 0;
      } else if (i > l) {
        iNew = i - l;
      }
      return iNew;
    }

    scroll(d) {
      const { products, i } = this.state;
      let iNew = i + d;
      if (iNew == products.length) {
        iNew = 0;
      }
      if (iNew == -(products.length)) {
        iNew = 0;
      }
      this.setState({
        i: iNew
      });
    }

    render() {
      const { products, num, i } = this.state;
      const length = products.length;
      let productsDisplay = [];
      for ( let x = 0; x < num; ++x) {
        let final = this.parseIndex(i + x, length);
        productsDisplay.push(products[final])
      }

      return (
          <div className="products-outer products-outer--carousel">
              <i onClick={() => this.scroll(-1)} className="fas fa-chevron-circle-left products-nav"></i>
              <div className="products-inner-wrap">
                  <ProductList products={productsDisplay} display="carousel" />
              </div>
              <i onClick={() => this.scroll(1)} className="fas fa-chevron-circle-right products-nav"></i>
          </div>
      );
    }
}

if (document.getElementById('products-carousel')) {
  const products = document.getElementById('products-carousel').getAttribute('products');
    ReactDOM.render(
      <ProductsCarousel products={products} />,
      document.getElementById('products-carousel')
    );
}
