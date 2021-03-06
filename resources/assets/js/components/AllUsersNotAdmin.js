import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

export default class AllUsersNotAdmin extends Component {
    constructor(props) {
        super(props);
        const { users, sites, current } = this.props;
        this.state = {
            users: JSON.parse(users),
            sites: JSON.parse(sites),
            roleId: parseInt(current),
            selectedRoleId: false,
            userMatrix: false,
            selectedUsers: [],
            usersCount: [],
        };
    }

    componentDidMount() {
      const { users, usersCount } = this.state;
      const userMatrix = {};
      users.map(user => {
        userMatrix[user.id] = user.role_id;
        let currentCount = usersCount[user.role_id] ? usersCount[user.role_id] : 0;
        //console.log(user.name, user.role_id);
        usersCount[user.role_id] = parseInt(currentCount) + 1;
      });
      this.setState({
        usersCount,
        userMatrix,
      });
    }

    setUserType(roleId) {
        this.setState({
            roleId,
            selectedRoleId: false,
            selectedUsers: [],
        });
    }

    updateUserSites() {
        const { selectedUsers, selectedRoleId, userMatrix } = this.state;
        $('.stm-absolute-wrap#loader-wrap').css({
            display: 'flex',
        });

        axios({
            method: 'post',
            url: '/update-user-sites',
            data: {
                selectedUsers,
                roleId: selectedRoleId,
            },
        })
            .then(response => {
                $('.stm-absolute-wrap#loader-wrap').css({
                    display: 'none',
                });

                response.data.map(id => {
                    userMatrix[id] = parseInt(selectedRoleId);
                });

                this.setState({
                    userMatrix: { ...userMatrix },
                });
            })
            .catch(error => {
                console.error('errorzz', error);
                $('.stm-absolute-wrap#loader-wrap').css({
                    display: 'none',
                });
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

    selectSite(event) {
        this.setState({
            selectedRoleId: event.target.value,
        });
    }

    render() {
        const {
            users,
            sites,
            roleId,
            selectedUsers,
            selectedRoleId,
            userMatrix,
            usersCount,
        } = this.state;

        /**
         * So instead of just matching the item.role_id to the current roleId... what I need to do
         * I loop through once first to make an array of key value pairs for
         */

        const allUsers = users.map((item, key) => {
            if (userMatrix[item.id] === roleId) {
                let checkboxClass = '';
                if (selectedUsers.includes(item.id)) {
                    checkboxClass = 'fake-checkbox selected';
                } else {
                    checkboxClass = 'fake-checkbox';
                }
                const linkUrl = `/users/${item.id}`;
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
            }
            return false;
        });

        let updateButton = <div />;
        if (selectedRoleId) {
            updateButton = (
                <button
                    type="button"
                    onClick={() => this.updateUserSites()}
                    className="button is-primary"
                >
                    Update
                </button>
            );
        } else {
            updateButton = (
                <button type="button" disabled className="button is-primary">
                    Update
                </button>
            );
        }

        const nav = sites.map((item, key) => {
            if (item.role_id !== roleId) {
                return (
                    <button
                        className={`button is-primary button_${item.role_id}`}
                        type="button"
                        onClick={() => this.setUserType(item.role_id)}
                        key={key}
                    >
                    {item.name}<span className="user-separator">-</span><span className="user-number">{usersCount[item.role_id] || 0}</span>
                    </button>
                );
            }
            return (
                <button
                    className="button is-danger disabled"
                    type="button"
                    key={key}
                >
                  {item.name}<span className="user-separator">-</span><span className="user-number">{usersCount[item.role_id] || 0}</span>
                </button>
            );
        });

        let siteForm = <div />;

        if (selectedUsers.length) {
            siteForm = (
                <form method="post" className="changeSiteForm">
                    <div className="select">
                        <select
                            onChange={this.selectSite.bind(this)}
                            id="siteSelect"
                            name="site"
                        >
                            <option>Change Site</option>
                            {sites.map((item, key) => {
                                if (item.role_id !== this.state.roleId) {
                                    return (
                                        <option key={key} value={item.role_id}>
                                            {item.name}
                                        </option>
                                    );
                                }
                            })}
                        </select>
                    </div>
                    {updateButton}
                </form>
            );
        }

        return (
            <div>
                <div className="allUserToggle">
                    {nav} {siteForm}
                </div>
                <div className="allUsersList">{allUsers}</div>
            </div>
        );
    }
}

if (document.getElementById('allUsersNotAdmin')) {
    const allUsers = document.getElementById('allUsersNotAdmin');
    const users = allUsers.getAttribute('users');
    const sites = allUsers.getAttribute('sites');
    const current = allUsers.getAttribute('current');
    ReactDOM.render(
        <AllUsersNotAdmin users={users} sites={sites} current={current} />,
        document.getElementById('allUsersNotAdmin')
    );
}
