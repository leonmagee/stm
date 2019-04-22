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
            selectedUsers: [],
        };
    }

    setUserType(roleId) {
        this.setState({
            roleId,
            selectedRoleId: false,
            selectedUsers: [],
        });
    }

    udateUserSites() {

        const { selectedUsers, selectedRoleId } = this.state;
        console.log("button clicked?", selectedUsers);
        $(".stm-absolute-wrap#loader-wrap").css({
            display: "flex"
        });

		  axios({
              method: "post",
              url: "/update-user-sites",
              data: {
                  selectedUsers,
                  roleId: selectedRoleId
              }
          })
              .then(response => {
                  console.log("here is the response", response);
                  $(".stm-absolute-wrap#loader-wrap").css({
                      display: "none"
                  });
              })
              .catch(error => {
                  console.error("errorzz", error);
                  $(".stm-absolute-wrap#loader-wrap").css({
                      display: "none"
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
          selectedRoleId: event.target.value
      });
    }

    //selectSite = e => this.setState({selectedRoleId: e.target.value})
    // selectSite() {
    //   return e => this.setState({ selectedRoleId: e.target.value });
    // }




    render() {
        const { users, sites, roleId, selectedUsers, selectedRoleId } = this.state;
        // console.log(users);

        const allUsers = users.map((item, key) => {
            if (item.role_id === roleId) {
                let checkboxClass = '';
                if (this.state.selectedUsers.includes(item.id)) {
                    //console.log('this is in the array!');
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
                                    onClick={() => this.selectUser(item.id)}
                                    className={checkboxClass}
                                />
                            </div>
                        </div>
                        <div className="detail">
                            <a href={linkUrl}>{item.company}</a>
                        </div>
                        <div className="divider" />
                        <div className="detail">{item.name}</div>
                        <div className="divider" />
                        <div className="detail">{item.email}</div>
                        <div className="divider" />
                        <div className="detail">{item.phone}</div>
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
                    onClick={() => this.udateUserSites()}
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

        // const siteOptions = sites.map((item, key) => (
        //     <option key={key} value={item.role_id}>
        //         {item.name}
        //     </option>
        // ));
        let siteForm = <div></div>;
if (selectedUsers.length) {
        siteForm = (
            <form method="post" className="changeSiteForm">
                {/* <label htmlFor="siteSelect">Change Site</label> */}
                <div className="select">
                    <select  onChange={this.selectSite.bind(this)} id="siteSelect" name="site">
                        <option>Change Site</option>
                        {sites.map((item, key) => {
                          if(item.role_id !== this.state.roleId) {
                              return (
                                <option key={key} value={item.role_id}>
                                    {item.name}
                                </option>
                            )
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
