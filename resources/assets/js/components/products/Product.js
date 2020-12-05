import React, { Component } from 'react';
import ReactStars from 'react-rating-stars-component';
import Attributes from './Attributes';
import Price from './Price';
import Heart from './Heart';
import ImageDiv from './ImageDiv';
import Starz from './Starz';

export default class Product extends Component {
    constructor(props) {
        super(props);
        // const { favorite } = props;
        // console.log(props);
        // console.log('count', favorite);
        this.state = {
            animate: false,
            // favorite,
        };
    }

    UNSAFE_componentWillReceiveProps(nextProps) {
        this.setState({
            favorite: nextProps.favorite,
        });
    }

    //     componentWillReceiveProps(nextProps){
    //     this.setState({ productdatail: nextProps.productdetailProps })
    // }

    toggleFavorite() {
        // const favorite = !this.state.favorite;
        const { id } = this.props;
        // console.log('toggz', id);

        axios({
            method: 'post',
            url: '/toggle-favorite',
            data: {
                id,
            },
        })
            .then(res => {
                if (res.data === 'favorited') {
                    this.setState({
                        favorite: true,
                    });
                } else if (res.data === 'un-favorited') {
                    this.setState({
                        favorite: false,
                    });
                }
            })
            .catch(err => {
                console.log('error', err);
            });
    }

    animateOff() {
        this.setState({
            animate: false,
        });
    }

    animateOn() {
        this.setState({
            animate: true,
        });
        setTimeout(
            function() {
                this.animateOff();
            }.bind(this),
            1100
        );
    }

    addToCart(id) {
        axios({
            method: 'post',
            url: '/add-to-cart-axios',
            data: {
                id,
            },
        })
            .then(res => {
                // console.log('worked. res:', res);
                this.animateOn();
            })
            .catch(err => {
                console.log('error', err);
            });
    }

    render() {
        const {
            id,
            img_url,
            discount,
            name,
            attributes,
            price,
            orig_price,
            rating,
            stock,
            // favorite,
        } = this.props;

        const { animate, favorite } = this.state;
        // const { animate } = this.state;
        // console.log(id, favorite);

        let animatePane = <div />;
        if (animate) {
            animatePane = (
                <div className="product__cart_hover">
                    <i className="fas fa-check" />
                </div>
            );
        }

        let addToCartButton = <div />;
        if (stock) {
            addToCartButton = (
                <a
                    className="product__footer--right product__footer--right-cart"
                    data-tooltip="Add To Cart"
                    onClick={() => this.addToCart(id)}
                >
                    <i className="fas fa-cart-plus" />
                </a>
            );
        } else {
            addToCartButton = (
                <a
                    className="product__footer--right product__footer--right-cart"
                    data-tooltip="Out of Stock"
                >
                    <i className="fas fa-cart-plus" />
                </a>
            );
        }

        // const favClass = favorite ? 'fav' : '';
        // console.log(favClass, id, price);
        return (
            <div className="product">
                {animatePane}
                <a className="product__link" href={`/products/${id}`}>
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
                    <Heart
                        fav={favorite}
                        toggle={() => this.toggleFavorite()}
                    />
                    {addToCartButton}
                </div>
            </div>
        );
    }
}
