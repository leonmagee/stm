import React, { Component } from 'react';
import Attributes from './Attributes';
import Price from './Price';
import Heart from './Heart';
import ImageDiv from './ImageDiv';
import Starz from './Starz';

export default class Product extends Component {
    constructor(props) {
        super(props);
        this.state = {
            animate: false,
            animateHeart: false,
            ownUpdate: false,
        };
    }

    static getDerivedStateFromProps(nextProps, prevState) {
        if (
            // nextProps.in_cart !== prevState.in_cart &&
            prevState.ownUpdate === false
        ) {
            return {
                favorite: nextProps.favorite,
                isInCart: nextProps.in_cart,
            };
        }
        return null;
    }

    toggleFavorite() {
        const { id } = this.props;
        this.setState({
            ownUpdate: true,
        });

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
                    this.animateHeartOn();
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

    animateHeartOff() {
        this.setState({
            animateHeart: false,
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

    animateHeartOn() {
        this.setState({
            animateHeart: true,
        });
        setTimeout(
            function() {
                this.animateHeartOff();
            }.bind(this),
            1100
        );
    }

    addToCart(id) {
        this.setState({
            ownUpdate: true,
        });
        const { isInCart } = this.state;
        if (isInCart) {
            axios({
                method: 'post',
                url: '/remove-from-cart-axios',
                data: {
                    id,
                },
            })
                .then(res => {
                    // this.animateOn();
                    this.setState({
                        isInCart: false,
                    });
                    $('#cart-number-of-items').html(res.data);
                })
                .catch(err => {
                    console.log('error', err);
                });
        } else {
            axios({
                method: 'post',
                url: '/add-to-cart-axios',
                data: {
                    id,
                },
            })
                .then(res => {
                    this.animateOn();
                    this.setState({
                        isInCart: true,
                    });
                    $('#cart-number-of-items').html(res.data);
                })
                .catch(err => {
                    console.log('error', err);
                });
        }
    }

    render() {
        const {
            id,
            img_url,
            discount,
            display,
            name,
            attributes,
            price,
            orig_price,
            rating,
            stock,
            toggleCompare,
            // favorite,
        } = this.props;

        const { animate, animateHeart, favorite, isInCart } = this.state;
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

        let animateHeartPane = <div />;
        if (animateHeart) {
            animateHeartPane = (
                <div className="product__cart_hover">
                    <i className="fas fa-heart" />
                </div>
            );
        }

        let addToCartButton = <div />;
        const inCartClass = isInCart ? 'is-in-cart' : '';
        const cartTooltip = isInCart ? 'Item In Cart' : 'Add To Cart';
        if (stock) {
            addToCartButton = (
                <a
                    className={`product__footer--right product__footer--right-cart ${inCartClass}`}
                    data-tooltip={cartTooltip}
                    onClick={() => this.addToCart(id)}
                >
                    <i className="fas fa-cart-plus" />
                </a>
            );
        } else {
            addToCartButton = (
                <a
                    className={`product__footer--right product__footer--right-cart ${inCartClass}`}
                    data-tooltip="Out of Stock"
                >
                    <i className="fas fa-cart-plus" />
                </a>
            );
        }

        let compare = <div />;
        if (display == 'basic') {
            compare = (
                <a
                    className="product__footer--right product__footer--right-compare"
                    data-tooltip="Compare Products"
                    onClick={() => toggleCompare(id)}
                >
                    <i className="fas fa-edit" />
                </a>
            );
        }

        // if (id == 95) {
        //     // const favClass = favorite ? 'fav' : '';
        //     console.log(favorite, id);
        // }
        return (
            <div className="product">
                {animatePane}
                {animateHeartPane}
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
                    {compare}
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
