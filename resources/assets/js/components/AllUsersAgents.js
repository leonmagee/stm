import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

export default class AllUsersAgents extends Component {
    constructor(props) {
        super(props);
        const { users } = this.props;
        this.state = {
            users: JSON.parse(users),
            count: 0,
        };
    }

    componentDidMount() {
        const { users } = this.state;
        this.setState({
          count: users.length,
        })
    }

    render() {
        const {
            users,
            count
        } = this.state;

        const allUsers = users.map((item, key) => {
                const linkUrl = `/dealer/${item.id}`;
                const balance = item.balance ? '$' + item.balance.toFixed(2) : '$0.00';
                return (
                    <div className="allUsersItem" key={key}>
                        <div className="divider" />
                        <div className="detail">
                            <a href={linkUrl}>{item.company}</a>
                        </div>
                        <div className="divider" />
                        <div className="detail name">{item.name}</div>
                        <div className="divider hide-mobile" />
                        <div className="detail email hide-mobile">{item.email}</div>
                        <div className="divider hide-mobile" />
                        <div className="detail phone hide-mobile">{item.phone}</div>
                        <div className="divider hide-mobile" />
                        <div className="detail balance">{balance}</div>
                    </div>
                );
        });

        return (
            <div className="form-wrapper">
              <div className="form-wrapper-inner">
                <h3>Total Dealers Assigned: <span>{count}</span></h3>
                <div className="padding-wrap">
                  <div className="allUsersList">{allUsers}</div>
                </div>
              </div>
            </div>
        );
    }
}

if (document.getElementById('allUsersAgents')) {
  const allUsers = document.getElementById('allUsersAgents');
    const users = allUsers.getAttribute('users');
    ReactDOM.render(
      <AllUsersAgents users={users} />,
      document.getElementById('allUsersAgents')
    );
}
