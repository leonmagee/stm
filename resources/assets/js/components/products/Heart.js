import React, { Component } from 'react';

export default class Heart extends Component {
    render() {
        const { fav, toggle } = this.props;

        let favClass = '';
        if (fav) {
            favClass = 'fav';
        }
        return (
            <a
                className={`product__footer--right product__footer--right-favorite ${favClass}`}
                data-tooltip="Add To Wish List"
                onClick={toggle}
            >
                <i className="fas fa-heart" />
            </a>
        );
    }
}
