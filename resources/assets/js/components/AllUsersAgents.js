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
                return (
                    <div className="allUsersItem" key={key}>
                        <div className="divider" />
                        <div className="detail">
                            <a href={linkUrl}>{item.company}</a>
                        </div>
                        <div className="divider" />
                        <div className="detail">{item.name}</div>
                        <div className="divider hide-mobile" />
                        <div className="detail hide-mobile">{item.email}</div>
                        <div className="divider hide-mobile" />
                        <div className="detail hide-mobile">{item.phone}</div>
                    </div>
                );
        });

        return (
            <div>
            <h2 className="dealersCount">Total Dealers Assigned: <span>{count}</span></h2>
            <div className="allUsersList">{allUsers}</div>
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
