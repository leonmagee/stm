import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ProductList from './products/ProductList';
import Starz from './products/Starz';

export default class ProductsCarousel extends Component {
    constructor(props) {
        super(props);
        const products = JSON.parse(props.products);
        this.toggleCompare = this.toggleCompare.bind(this);
        this.state = {
            products,
            i: 0,
            num: products.length > 1 ? 2 : 1,
            showCompareModal: false,
            compareArray: [],
        };
    }

    toggleCompare(id) {
        const { showCompareModal } = this.state;
        if (!showCompareModal) {
            axios({
                method: 'post',
                url: '/get-related-products',
                data: {
                    id,
                },
            }).then(res => {
                this.setState({
                    compareArray: res.data,
                    showCompareModal: !showCompareModal,
                });
            });
        } else {
            this.setState({
                compareArray: [],
                showCompareModal: !showCompareModal,
            });
        }
    }

    parseIndex(i, l) {
        let iNew = i;
        if (i < 0) {
            iNew = i + l;
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
        if (iNew == -products.length) {
            iNew = 0;
        }
        this.setState({
            i: iNew,
        });
    }

    render() {
        const { products, num, i, showCompareModal, compareArray } = this.state;
        const { length } = products;
        const productsDisplay = [];

        let compareModal = <div />;
        if (showCompareModal) {
            const modalBody = compareArray.map((product, i) => {
                let cartButton = '';
                if (product.stock) {
                    cartButton = (
                        <a
                            className="compare__item--button compare__item--add-to-cart"
                            href={`/add-to-cart-sav-fav/${product.id}`}
                        >
                            Add to Cart <i className="fas fa-cart-plus" />
                        </a>
                    );
                } else {
                    cartButton = (
                        <span className="compare__item--button compare__item--sold-out">
                            Out of Stock
                        </span>
                    );
                }
                return (
                    <div key={i} className="compare__row compare__row--top">
                        <div className="compare__item compare__item--img">
                            <img alt="Product" src={product.img_url_1} />
                        </div>
                        <div className="compare__item compare__item--name">
                            <a href={`/products/${product.id}`}>
                                {product.name}
                            </a>
                        </div>
                        <div className="compare__item">
                            ${product.orig_price}
                        </div>
                        <div className="compare__item compare__item--discount">
                            {product.discount}%
                        </div>
                        <div className="compare__item">
                            ${product.cost_format}
                        </div>
                        <div className="compare__item compare__item--rating-react">
                            <Starz value={product.rating} />
                        </div>
                        <div className="compare__item compare__item--action">
                            {cartButton}
                        </div>
                    </div>
                );
            });

            compareModal = (
                <div
                    className="modal modal-width-65 delete-item-modal is-active"
                    id="delete-item-modal-116"
                >
                    <div className="modal-background" />
                    <div className="modal-content">
                        <div className="modal-box full-width">
                            <h3 className="title full-width-title">
                                Compare Products
                            </h3>

                            <div className="compare">
                                <div className="compare__row compare__row--header">
                                    <div className="compare__item compare__item--img" />
                                    <div className="compare__item compare__item--name">
                                        Product Name
                                    </div>
                                    <div className="compare__item">
                                        Orig Price
                                    </div>
                                    <div className="compare__item compare__item--discount">
                                        Discount
                                    </div>
                                    <div className="compare__item">Cost</div>
                                    <div className="compare__item compare__item--rating">
                                        Rating
                                    </div>
                                    <div className="compare__item compare__item--action" />
                                </div>
                                {modalBody}
                            </div>
                            <a
                                className="button"
                                onClick={() => this.toggleCompare()}
                            >
                                Close
                            </a>
                        </div>
                    </div>
                </div>
            );
        }

        for (let x = 0; x < num; ++x) {
            const final = this.parseIndex(i + x, length);
            productsDisplay.push(products[final]);
        }
        let leftNav = (
            <i className="fas fa-chevron-circle-left products-nav products-nav--hidden" />
        );
        let rightNav = (
            <i className="fas fa-chevron-circle-right products-nav products-nav--hidden" />
        );
        if (length > 2) {
            leftNav = (
                <i
                    onClick={() => this.scroll(-1)}
                    className="fas fa-chevron-circle-left products-nav"
                />
            );
            rightNav = (
                <i
                    onClick={() => this.scroll(1)}
                    className="fas fa-chevron-circle-right products-nav"
                />
            );
        }

        return (
            <div className="products-outer products-outer--carousel">
                {compareModal}
                {leftNav}
                <div className="products-inner-wrap">
                    <ProductList
                        products={productsDisplay}
                        toggleCompare={this.toggleCompare}
                    />
                </div>
                {rightNav}
            </div>
        );
    }
}

if (document.getElementById('products-carousel')) {
    const products = document
        .getElementById('products-carousel')
        .getAttribute('products');
    ReactDOM.render(
        <ProductsCarousel products={products} />,
        document.getElementById('products-carousel')
    );
}

if (document.getElementById('products-carousel2')) {
    const products = document
        .getElementById('products-carousel2')
        .getAttribute('products');
    ReactDOM.render(
        <ProductsCarousel products={products} />,
        document.getElementById('products-carousel2')
    );
}

if (document.getElementById('products-carousel4')) {
    const products = document
        .getElementById('products-carousel4')
        .getAttribute('products');
    ReactDOM.render(
        <ProductsCarousel products={products} />,
        document.getElementById('products-carousel4')
    );
}

if (document.getElementById('products-carousel6')) {
    const products = document
        .getElementById('products-carousel6')
        .getAttribute('products');
    ReactDOM.render(
        <ProductsCarousel products={products} />,
        document.getElementById('products-carousel6')
    );
}
