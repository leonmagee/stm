import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class AllUsers extends Component {
    constructor(props) {
        super(props);
        const { users } = this.props;
        // console.log('data from component', JSON.parse(users));
        this.state = {
            users: JSON.parse(users),
            roleId: 3,
        };
    }

    setDealers() {
        this.setState({
            roleId: 4,
        });
    }

    render() {
        const { users, roleId } = this.state;
        console.log(users);

        const allUsers = users.map((item, key) => {
            if (item.role_id === roleId) {
                return (
                    <div className="allUsersItem" key={key}>
                        <div className="detail">{item.company}</div>
                        <div className="detail">{item.name}</div>
                        <div className="detail">{item.email}</div>
                        <div className="detail">{item.phone}</div>
                    </div>
                );
            }
            return false;
        });

        return (
            <div>
                <div className="allUserToggle">
                    <button type="button" onClick={() => this.setDealers()}>
                        See Dealers
                    </button>
                </div>
                <div className="allUsersList">{allUsers}</div>
            </div>
        );
    }
}

if (document.getElementById('allUsers')) {
    const data = document.getElementById('allUsers').getAttribute('users');
    ReactDOM.render(
        <AllUsers users={data} />,
        document.getElementById('allUsers')
    );
}

// module.exports = AllUsers;
