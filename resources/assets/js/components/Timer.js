import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class Timer extends Component {
    constructor(props) {
        super(props);
        const { secondsLeft } = this.props;
        console.log('xxx', secondsLeft);
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
        const hours = Math.floor(secs / (60 * 60));

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
            <div className="voting__question--timer">
                <div className="time-span">
                    <span className="time1">Hours: {time.h}</span>
                    <span className="time-divider">:</span>
                    <span className="time2">Minutes: {time.m}</span>
                    <span className="time-divider">:</span>
                    <span className="time3">Seconds: {time.s}</span>
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
