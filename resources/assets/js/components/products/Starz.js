import React, { Component } from 'react';

export default class Starz extends Component {

  getStar(limit, val) {

    let starClass = '';
    if (val >= limit) {
        starClass = 'active';
    } else {
        starClass = 'inactive';
    }

    const svg = (
        <svg
            className={starClass}
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            x="0px"
            y="0px"
            viewBox="0 0 260 245"
        >
            <path d="M55,237L129,9l74,228L9,96h240" />
        </svg>
    );

    const svgHalf = (
        <svg
            className="half"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            x="0px"
            y="0px"
            viewBox="0 0 260 245"
        >
            <path d="M-61.888,6.257" />
            <g>
                <polygon
                    className="left"
                    points="9,96 83.249,149.964 100.763,96 	"
                />
                <polygon className="left" points="129,9 100.763,96 129,96 	" />
                <polygon
                    className="left"
                    points="55,237 129,183.217 83.249,149.964 	"
                />
                <polygon
                    className="left"
                    points="100.763,96 83.249,149.964 129,183.217 129,96 	"
                />
                <polygon points="174.752,149.964 129,183.217 203,237 	" />
                <polygon points="249,96 157.236,96 174.752,149.964 	" />
                <polygon points="157.236,96 129,96 129,183.217 174.752,149.964 	" />
                <polygon points="157.236,96 129,9 129,96 	" />
            </g>
        </svg>
    );

    if (val >= limit) {
      return svg;
    } else if (val >= limit - 1 + 0.5) {
      return svgHalf;
    } else {
      return svg;
    }

  }

  render() {
    const { value } = this.props;

    return (
        <div className="starzWrap">
            {this.getStar(1, value)}
            {this.getStar(2, value)}
            {this.getStar(3, value)}
            {this.getStar(4, value)}
            {this.getStar(5, value)}
        </div>
    );
  }
}
