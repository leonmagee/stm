import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Timer extends Component {
    constructor(props) {
        super(props);
        const { secondsLeft } = this.props;
        this.state = {
            time: {},
            // secondsLeft,
            seconds: parseInt(secondsLeft),
        };

        this.timer = 0;
        this.startTimer = this.startTimer.bind(this);
        this.countDown = this.countDown.bind(this);
    }

    componentDidMount() {
        const timeLeftVar = this.secondsToTime(this.state.seconds);
        this.setState({ time: timeLeftVar });
        this.startTimer();
    }

    secondsToTime(secs) {
        let days = Math.floor(secs / 86400);
        let hours = Math.floor(secs / (60 * 60));
        hours -= days * 24;

        if (days < 10) {
            days = `0${days}`;
        }

        if (hours < 10) {
            hours = `0${hours}`;
        }

        const divisor_for_minutes = secs % (60 * 60);
        let minutes = Math.floor(divisor_for_minutes / 60);
        if (minutes < 10) {
            minutes = `0${minutes}`;
        }

        const divisor_for_seconds = divisor_for_minutes % 60;
        let seconds = Math.ceil(divisor_for_seconds);
        if (seconds < 10) {
            seconds = `0${seconds}`;
        }

        const obj = {
            d: days,
            h: hours,
            m: minutes,
            s: seconds,
        };
        return obj;
    }

    startTimer() {
        const { seconds } = this.state;
        if (this.timer == 0 && seconds > 0) {
            this.timer = setInterval(this.countDown, 1000);
        }
    }

    countDown() {
        // Remove one second, set state so a re-render happens.
        const seconds = this.state.seconds - 1;
        if (seconds < 1) {
            // document.location.href = "/";
            this.submitVoting();
        }
        this.setState({
            time: this.secondsToTime(seconds),
            seconds,
        });

        // Check if we're at zero.
        if (seconds == 0) {
            clearInterval(this.timer);
        }
    }

    render() {
        const { time } = this.state;
        const countdownTimer = (
            <div className="promo-banner__timer">
                <div className="time days">
                    <div className="time-item">{time.d}</div>
                    <div className="time-desc">Days</div>
                </div>
                <div className="time-sep">:</div>
                <div className="time hours">
                    <div className="time-item">{time.h}</div>
                    <div className="time-desc">Hours</div>
                </div>
                <div className="time-sep">:</div>
                <div className="time minutes">
                    <div className="time-item">{time.m}</div>
                    <div className="time-desc">Minutes</div>
                </div>
                <div className="time-sep">:</div>
                <div className="time seconds">
                    <div className="time-item">{time.s}</div>
                    <div className="time-desc">Seconds</div>
                </div>
            </div>
        );

        return <div className="timer-wrapper">{countdownTimer}</div>;
    }
}

if (document.getElementById('countdownTimer')) {
    const timer = document.getElementById('countdownTimer');
    const secondsLeft = timer.getAttribute('secondsLeft');
    ReactDOM.render(
        <Timer secondsLeft={secondsLeft} />,
        document.getElementById('countdownTimer')
    );
}
