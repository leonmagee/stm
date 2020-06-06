import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Products extends Component {
    constructor(props) {
        super(props);
        this.state = {
            products: JSON.parse(props.products),
            productsDisplay: JSON.parse(props.products),
            categories: JSON.parse(props.categories),
            sub_cat_match: JSON.parse(props.sub_cat_match),
            sub_cats_array: JSON.parse(props.sub_cats_array),
            catsChecked: [],
            subCatsChecked: [],
            catsToggle: false
        };
    }

    toggleCats() {
      const { catsToggle } = this.state;
      this.setState({
          catsToggle: !catsToggle
      });
    }

    updateProducts() {
      const { products, catsChecked, subCatsChecked, sub_cat_match, sub_cats_array } = this.state;
      let productsUpdated = [];
      if (catsChecked.length) {
        productsUpdated = products.filter( product => {
          let match = false;
          product.cat_array.map(cat => {
            if(subCatsChecked.length) {
              let sub_cats = product.sub_cat_array[cat];
              if (sub_cats) {
                if(sub_cats.length) {
                  //let sub_cats_array = [2,3,4,6,7,8,9];
                  sub_cats_array.map(sub => {
                    sub_cats.map(sub_inner => {
                        if (subCatsChecked.includes(sub_inner)) {
                          match = true;
                        }
                    })
                    if (sub_cat_match[sub] !== cat) {
                      if (catsChecked.includes(cat)) {

                        let has_current_sub = false;
                        subCatsChecked.map(sub_inner => {
                          if (sub_cat_match[sub_inner] === cat) {
                            has_current_sub = true;
                          }
                        })
                        if(!has_current_sub) {
                        match = true;
                        }
                      }
                    }
                  })

                }
              }
              else if (catsChecked.includes(cat)) {
                let has_current = false;
                subCatsChecked.map(sub => {
                  if (sub_cat_match[sub] === cat) {
                    has_current = true;
                  }
                })
                if (!has_current) {
                match = true;
                }
              }
            } else if (catsChecked.includes(cat)) {
              match = true;
            }
          })
          if(match) {
            return true;
          } else {
            return false;
          }
        })
      } else {
        productsUpdated = products;
      }
      this.setState({
        productsDisplay: productsUpdated,
      })
    }

    catClick(id) {
      const { catsChecked, subCatsChecked } = this.state;
      let catsCheckedNew = [];
      if (catsChecked.includes(id)) {
        const catIndex = catsChecked.indexOf(id);
        catsChecked.splice(catIndex, 1);
        catsCheckedNew = catsChecked;
      } else {
        catsCheckedNew = [...catsChecked, id];
      }
      this.setState({
        catsChecked: catsCheckedNew
      }, function() {
        this.updateProducts()
      })
    }

  subCatClick(id) {
    const { subCatsChecked } = this.state;
    let subCatsCheckedNew = [];
    if (subCatsChecked.includes(id)) {
      const catIndex = subCatsChecked.indexOf(id);
      subCatsChecked.splice(catIndex, 1);
      subCatsCheckedNew = subCatsChecked;
    } else {
      subCatsCheckedNew = [...subCatsChecked, id];
    }
    this.setState({
      subCatsChecked: subCatsCheckedNew
    }, function () {
      this.updateProducts()
    })
  }

    render() {
      const { categories, catsChecked, productsDisplay, subCatsChecked, catsToggle } = this.state;

        const catsBlock = categories.map( (category, i) => {
          let icon = <i className="far fa-square"></i>;
          if(catsChecked.includes(category.id)) {
            icon = <i className="fas fa-check-square"></i>;
          }
          let subCats = <div></div>;
          if (catsChecked.includes(category.id)) {
          subCats = category.sub_categories.map( (subCat, j) => {
            let subIcon = <i className="far fa-square"></i>;
            if (subCatsChecked.includes(subCat.id)) {
              subIcon = <i className="fas fa-check-square"></i>;
            }
            const keyName = 'sub-' + j;
            return <div key={keyName} onClick={() => this.subCatClick(subCat.id)} className="product-cat product-cat--sub"><span>{subCat.name}</span>{subIcon}</div>
          })
          }
          return <div key={i}><div onClick={() => this.catClick(category.id)} className="product-cat"><span>{category.name}</span>{icon}</div>{subCats}</div>
        })

        const catsList = categories.map((category, i) => {
            let buttonClass = "button is-default is-small";
            if (catsChecked.includes(category.id)) {
              buttonClass = "button is-primary is-small";
            }

            return (
                <div key={i}>
                    <button
                        onClick={() => this.catClick(category.id)}
                        className={buttonClass}
                    >
                        {category.name}
                    </button>
                </div>
            );
        });

      const menu = (
          <div className="product-cats">
              <div className="product-cats__header">Categories</div>
              <div className="product-cats__body">
              {catsBlock}
              </div>
              <div className="product-cats__footer">
                  <i className="fas fa-times" onClick={() => this.toggleCats()}></i>
              </div>
          </div>
      );

        const productsBlock = productsDisplay.map( (product, i) => {
          let img_div = '';
          let discount = '';
          let orig_price = '';
          if(product.discount) {
            discount = <div className="product__discount">{product.discount}% Off</div>
            orig_price = <span className="product__footer--orig_price">${product.orig_price}</span>
          }
          if(product.img_url) {
            img_div = <div className="product__image product__image--url"><img src={product.img_url} />{discount}</div>
          } else {
            img_div = <div className="product__image product__image--default"><i className="far fa-image"></i>{discount}</div>
          }
          const attributes = product.attributes_array.map((attribute, k) => {
            return <div className="product__attributes--item" key={k}><i className="fas fa-circle"></i><span>{attribute}</span></div>;
          })
          return (
              <div key={i} className="product">
                  <a className="product__link" href={"/products/" + product.id}>
                      {img_div}
                      <div className="product__title">{product.name}</div>
                      {/* <div className="product__cost">${product.cost_format}</div> */}
                      <div className="product__attributes">{attributes}</div>
                  </a>
                  <div className="product__footer">
                      {/* <a className="product__footer--view" href={"/products/" + product.id}><i className="fas fa-eye"></i></a> */}
                      <div className="product__footer--cost">
                          ${product.cost_format}
                          {orig_price}
                      </div>
                      {/* <a href={"/products/edit/" + product.id}>Edit</a> */}
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
          );
        })
        const header = (
            <div className="products-header-wrap">
                <div className="products-header">
                    <div
                        className="products-header__left"
                        onClick={() => this.toggleCats()}
                    >
                        <i className="fas fa-sliders-h"></i>All Categories
                    </div>
                    <div className="products-header__right">{catsList}</div>
                </div>
            </div>
        );

        const menuToggled = catsToggle ? menu : '';
        return (
            <div className="products-outer">
                {menuToggled}
                <div className="products-inner-wrap">
                    {header}
                    <div className="products">{productsBlock}</div>
                </div>
            </div>
        );
    }
}

if (document.getElementById('products')) {
  const products = document.getElementById('products').getAttribute('products');
  const categories = document.getElementById('products').getAttribute('categories');
  const sub_cat_match = document.getElementById('products').getAttribute('sub_cat_match');
  const sub_cats_array = document.getElementById('products').getAttribute('sub_cats_array');
    ReactDOM.render(
      <Products products={products} categories={categories} sub_cat_match={sub_cat_match} sub_cats_array={sub_cats_array}/>,
      document.getElementById('products')
    );
}