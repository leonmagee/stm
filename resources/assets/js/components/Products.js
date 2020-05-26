import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Products extends Component {
    constructor(props) {
        super(props);
        this.state = {
          products: JSON.parse(props.products),
          productsDisplay: JSON.parse(props.products),
          categories: JSON.parse(props.categories),
          catsChecked: [],
          subCatsChecked: []
        }
    }

    catClick(id) {
     console.log('cat has been clicked' + id);
     const { catsChecked } = this.state;
     const catsCheckedNew = [...catsChecked, id];
     this.setState({
       catsChecked: catsCheckedNew
     })
    }

    render() {
      const { categories, catsChecked, products } = this.state;

        const catsBlock = categories.map( (category, i) => {
          let icon = <i className="far fa-square"></i>;
          return <div key={i} onClick={() => this.catClick(category.id)} className="product-cat"><span>{category.name}</span>{icon}</div>
        })

      const menu = <div className="product-cats">{catsBlock}</div>;

        const productsBlock = products.map( (product, i) => {
          let img_div = '';
          if(product.img_url) {
            img_div = <div className="product__image product__image--url"><img src={product.img_url} /></div>
          } else {
            img_div = <div className="product__image product__image--default"><i className="far fa-image"></i></div>
          }
          return (
            <div key={i} className="product">
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
        return <div className="products-outer">
            {menu}
            <div className="products">{productsBlock}</div>
          </div>;
    }
}

if (document.getElementById('products')) {
  const products = document.getElementById('products').getAttribute('products');
  const categories = document.getElementById('products').getAttribute('categories');
    ReactDOM.render(
      <Products products={products} categories={categories}/>,
      document.getElementById('products')
    );
}
