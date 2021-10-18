export const getUsers = (state) => {
    return state.users
}

export const getSelectedUser = (state) => {
    return state.selectedUser
}

export const getUserById = ({ users }) => ( id ) => {
    return { ...users.find( user => user.id == id) }
}