import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ProductList from './products/ProductList';

export default class ProductsCarousel extends Component {
    constructor(props) {
        super(props);
        const products = JSON.parse(props.products);
        this.state = {
            products,
            i: 0,
            num: products.length > 1 ? 2 : 1,
        };
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
        const { products, num, i } = this.state;
        const { length } = products;
        const productsDisplay = [];
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
                {leftNav}
                <div className="products-inner-wrap">
                    <ProductList
                        products={productsDisplay}
                        display="carousel"
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
