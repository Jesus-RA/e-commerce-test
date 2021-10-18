export const setUsers = ( state, users ) => {
    state.users = [ ...state.users, ...users ]
}

export const setSelectedUserId = (state, userId) => {
    state.selectedUserId = userId
}

export const addUser = (state, user) => {

    state.users = [ ...state.users, user ]

}

export const updateUser = (state, user) => {
    
    const users = state.users.map( u => {

        if( u.id === user.id )
            return { ...user }

        return { ...u }

    })

    state.users = users

}

export const deleteUser = (state, userId) => {

    const users = state.users.filter( user => user.id !== userId )

    state.users = users

}