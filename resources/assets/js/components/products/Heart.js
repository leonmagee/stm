import React, { Component } from 'react';

export default class Heart extends Component {
    render() {
        const { fav, toggle } = this.props;

        let heartTooltip = 'Add To Wish List';
        let favClass = '';
        if (fav) {
            favClass = 'fav';
            heartTooltip = 'Remove From Wish List';
        }
        return (
            <a
                className={`product__footer--right product__footer--right-favorite ${favClass}`}
                data-tooltip={heartTooltip}
                onClick={toggle}
            >
                <i className="fas fa-heart" />
            </a>
        );
    }
}
