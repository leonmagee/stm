import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';

export default class AllUsers extends Component {
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
            modalActive: false,
            selectedUserEdit: null,
            creditAmount: '',
            subtractAmount: '',
            currentBalance: 0,
            note: ''
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
        //console.log('arrayz', usersCount);
    }

    setUserType(roleId) {
        this.setState({
            roleId,
            selectedRoleId: false,
            selectedUsers: [],
        });
    }

    openModal(id) {
      const { users } = this.state;
      let selectedUserEdit = null;
      users.map(user => {
        if(user.id === id) {
          selectedUserEdit = user;
        }
      });
      const currentBalance = selectedUserEdit.balance ? selectedUserEdit.balance : 0;
      //console.log(selectedUserEdit);
      this.setState({
        modalActive: true,
        selectedUserEdit,
        currentBalance
      })
    }

    closeModal() {
      this.setState({
        modalActive: false,
        selectedUserEdit: false,
        newBalance: false,
        creditAmount: '',
        subtractAmount: '',
        currentBalance: false,
        note: '',
      })
    }

    // updateBalanceInput(e) {
    //   this.setState({
    //     currentBalance: e.target.value
    //   });
    // }

    creditBalanceInput(e) {
      let value_new = e.target.value;
      if(e.target.value < 0) {
        value_new = Math.abs(e.target.value);
      }
      this.setState({
        creditAmount: value_new,
        subtractAmount: '',
      });
    }

    subtractBalanceInput(e) {
      let subtractAmount = e.target.value;
      if (e.target.value < 0) {
        subtractAmount = Math.abs(e.target.value);
      }
      const { currentBalance } = this.state;
      if (subtractAmount > currentBalance) {
        subtractAmount = currentBalance;
      }
      this.setState({
        subtractAmount,
        creditAmount: '',
      });
    }

    updateNoteValue(e) {
      this.setState({
        note: e.target.value
      })
    }

    updateBalance() {
      const { selectedUserEdit, creditAmount, subtractAmount, currentBalance, users, note } = this.state;
      //console.log(users);
      $('.stm-absolute-wrap#loader-wrap').css({
        display: 'flex',
      });
      //console.log('we have selected a user:', selectedUserEdit);
      const balance = selectedUserEdit.balance ? parseFloat(selectedUserEdit.balance) : 0;
      let updatedBalance = 0;
      let difference = 0;
      if(creditAmount) {
        updatedBalance = balance + parseFloat(creditAmount);
        difference = creditAmount;
      } else if (subtractAmount) {
        updatedBalance = balance - parseFloat(subtractAmount);
        difference = 0 - subtractAmount;
      } else {
        return;
      }

      axios({
        method: 'post',
        url: '/update-user-balance',
        data: {
          selectedUserEdit,
          difference,
          newBalance: updatedBalance,
          note
        }
      })
      .then(response => {
        let new_users = users.map(user => {
          if (user.id === response.data.id) {
            user.balance = response.data.balance;
          }
          return user;
        });
        //console.log(new_users);
        this.setState({
          users: [...new_users],
          modalActive: false,
          selectedUserEdit: false,
          creditAmount: '',
          subtractAmount: '',
          newBalance: false,
          currentBalance: false,
          note: '',
        });

        //console.log(new_users);
        //console.log(users);
        $('.stm-absolute-wrap#loader-wrap').css({
          display: 'none',
        });
      })
      .catch(error => {
        console.error('errorzz', error);
        $('.stm-absolute-wrap#loader-wrap').css({
          display: 'none',
        });
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
            selectedUserEdit,
            creditAmount,
            subtractAmount,
            currentBalance
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
                        <div className="detail-small">
                            <div className="fake-checkbox-wrap">
                                <div
                                    onClick={() => this.selectUser(item.id)}
                                    className={checkboxClass}
                                />
                            </div>
                        </div>
                        <div className="divider" />
                        <div className="detail">
                            <a href={linkUrl}>{item.company}</a>
                        </div>
                        <div className="divider" />
                        <div className="detail name">{item.name}</div>
                        <div className="divider hide-mobile" />
                        <div className="detail hide-mobile email">{item.email}</div>
                        <div className="divider hide-mobile" />
                        <div className="detail hide-mobile phone">{item.phone}</div>
                        <div className="divider hide-mobile" />
                        <div className="detail balance">
                          <a className="balance" onClick={() => this.openModal(item.id)}>{balance}</a>
                        </div>
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

      var allUsersModal = <div></div>;
        if(this.state.modalActive) {
          const balance = selectedUserEdit.balance ? selectedUserEdit.balance.toFixed(2) : 0;
          allUsersModal = <div className="allUserModal">
            <div className="allUserModalInner">
              <div className="title-line">
              <span>{selectedUserEdit.company}</span> / <span>{selectedUserEdit.name}</span>
              </div>
              <div className="current-balance">
                <label>Available Credit: <span>${balance}</span></label>
              </div>
              <form action="" className="update-balance">
                <div className="input-wrap">
                  <div className="control">
                    <label className="label">Credit Amount</label>
                    <input className="input" type="number" placeholder="Enter Value" onChange={e => this.creditBalanceInput(e)}  value={creditAmount} min="0" />
                    <label className="label label-2">Subtract Amount</label>
                    <input className="input" type="number" placeholder="Enter Value" onChange={e => this.subtractBalanceInput(e)}  value={subtractAmount} min="0" />
                  </div>
                  <div className="control">
                    <label className="label">Add Note</label>
                    <textarea className="textarea" onChange={e => this.updateNoteValue(e)} />
                  </div>
                </div>
                <a className="button is-primary call-loader" onClick={() => this.updateBalance()}>Update</a>
              </form>
              <a className="close-icon" onClick={() => this.closeModal()}><i className="fas fa-times-circle"></i></a>
            </div>
          </div>;
        }

        return (
            <div className="allUsersWrap">
                {allUsersModal}
                <div className="allUserToggle">
                    {nav} {siteForm}
                </div>
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
