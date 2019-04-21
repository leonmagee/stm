import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class AllUsers extends Component {
    constructor(props) {
        super(props);
        const { users, sites, current } = this.props;
        // console.log(JSON.parse(sites));
        // console.log('data from component', JSON.parse(users));
        this.state = {
            users: JSON.parse(users),
            sites: JSON.parse(sites),
            roleId: parseInt(current),
            selectedUsers: [],
        };
    }

    setUserType(roleId) {
        this.setState({
            roleId,
        });
    }

    selectUser(key) {
        const { selectedUsers } = this.state;
        if (selectedUsers.includes(key)) {
            const index = selectedUsers.indexOf(key);
            selectedUsers.splice(index, 1);
        } else {
            selectedUsers.push(key);
        }
        this.setState({
            selectedUsers: [...selectedUsers],
        });
    }

    render() {
        const { users, sites, roleId } = this.state;
        console.log(users);

        const allUsers = users.map((item, key) => {
            if (item.role_id === roleId) {
                let checkboxClass = '';
                if (this.state.selectedUsers.includes(key)) {
                    console.log('this is in the array!');
                    checkboxClass = 'fake-checkbox selected';
                } else {
                    checkboxClass = 'fake-checkbox';
                }
                const linkUrl = `/users/${item.id}`;
                return (
                    <div className="allUsersItem" key={key}>
                        <div className="detail-small">
                            <div className="fake-checkbox-wrap">
                                <div
                                    onClick={() => this.selectUser(key)}
                                    className={checkboxClass}
                                />
                            </div>
                        </div>
                        <div className="detail">
                            <a href={linkUrl}>{item.company}</a>
                        </div>
                        <div className="detail">{item.name}</div>
                        <div className="detail">{item.email}</div>
                        <div className="detail">{item.phone}</div>
                    </div>
                );
            }
            return false;
        });

        const nav = sites.map((item, key) => {
            if (item.role_id !== roleId) {
                return (
                    <button
                        className="button is-primary"
                        type="button"
                        onClick={() => this.setUserType(item.role_id)}
                        key={key}
                    >
                        {item.name}
                    </button>
                );
            }
            return (
                <button
                    className="button is-danger disabled"
                    type="button"
                    key={key}
                >
                    {item.name}
                </button>
            );
        });

        return (
            <div>
                <div className="allUserToggle">{nav}</div>
                <div className="allUsersList">{allUsers}</div>
            </div>
        );
    }
}

if (document.getElementById('allUsers')) {
    const allUsers = document.getElementById('allUsers');
    const users = allUsers.getAttribute('users');
    const sites = allUsers.getAttribute('sites');
    const current = allUsers.getAttribute('current');
    ReactDOM.render(
        <AllUsers users={users} sites={sites} current={current} />,
        document.getElementById('allUsers')
    );
}

// module.exports = AllUsers;
