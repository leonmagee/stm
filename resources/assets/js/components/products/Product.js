import React, { Component } from 'react';
import ReactStars from 'react-rating-stars-component';
import Attributes from './Attributes';
import Price from './Price';
import ImageDiv from './ImageDiv';
import Starz from './Starz';

export default class Product extends Component {

  constructor(props) {
    super(props);
    this.state = {
      animate: false,
      favorite: props.favorite,
    }
  }

  toggleFavorite() {

    const favorite = !this.state.favorite;
    axios({
      method: "post",
      url: "/toggle-favorite",
      data: {
        id: this.props.id
      }
    }).then(res => {
      if(res.data === 'favorited') {
        this.setState({
            favorite: true
        });
      } else if(res.data === 'un-favorited') {
        this.setState({
            favorite: false
        });
      }
    }).catch(err => {
      console.log('error', err);
    });
  }

  animateOff() {
    this.setState({
      animate: false,
    })
  }

  animateOn() {
    this.setState({
      animate: true,
    })
    setTimeout(function() {
      this.animateOff();
    }.bind(this)
    , 1100);
  }

  addToCart(id) {
    axios({
      method: "post",
      url: "/add-to-cart-axios",
      data: {
        id
      }
    }).then(res => {
      //console.log('worked. res:', res);
      this.animateOn();
    }).catch(err => {
      console.log('error', err);
    });
  }

  render() {

    const { id, img_url, discount, name, attributes, price, orig_price, rating, stock } = this.props;

    const { animate, favorite } = this.state;

    let animatePane = <div></div>;
    if (animate) {
      animatePane = <div className="product__cart_hover"><i className="fas fa-check"></i></div>;
    }

    let addToCartButton = <div></div>;
    if(stock) {
                  addToCartButton = (
                      <a
                          className="product__footer--right product__footer--right-cart"
                          data-tooltip="Add To Cart"
                          onClick={() => this.addToCart(id)}
                      >
                          <i className="fas fa-cart-plus"></i>
                      </a>
                  );
    } else {
                  addToCartButton = (
                      <a
                          className="product__footer--right product__footer--right-cart"
                          data-tooltip="Out of Stock"
                      >
                          <i className="fas fa-cart-plus"></i>
                      </a>
                  );
    }

    let favClass = favorite ? 'fav' : '';
        return (
            <div className="product">
                {animatePane}
                <a className="product__link" href={"/products/" + id}>
                    <ImageDiv
                        img_url={img_url}
                        discount={discount}
                        stock={stock}
                    />
                    <div className="product__rating">
                        <Starz value={rating} />
                    </div>
                    <div className="product__title">{name}</div>
                    <Attributes attributes={attributes} />
                </a>
                <div className="product__footer">
                    <Price
                        price={price}
                        orig_price={orig_price}
                        discount={discount}
                    />
                    <a
                        className={'product__footer--right product__footer--right-favorite ' + favClass}
                        data-tooltip="Add To Favorites"
                        onClick={() => this.toggleFavorite()}
                    >
                        <i className="fas fa-heart"></i>
                    </a>
                    {addToCartButton}
                </div>
            </div>
        );
  }
}
