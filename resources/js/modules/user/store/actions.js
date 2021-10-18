import axios from "axios"

export const fetchUsers = async ({ commit }) => {

    const { data } = await axios.get('/users')

    const users = data.data.map( ({ id, attributes }) => ({
        id,
        ...attributes,
        created_at: new Date(attributes.created_at).toLocaleDateString(),
        updated_at: new Date(attributes.updated_at).toLocaleDateString()
    }))


    commit('setUsers', users)

}

export const storeUser = async ({ commit }, user) => {

    const response = await axios.post('/users', user)
        .catch( ({ response }) => response )

    if( response.status === 409 ) return false

    const newUser = {
        id: data.data.id,
        ...data.data.attributes,
        created_at: new Date(data.data.attributes.created_at).toLocaleDateString(),
        updated_at: new Date(data.data.attributes.updated_at).toLocaleDateString()
    }

    commit('addUser', newUser)

    return true

}

export const fetchUser = async ({ commit }, id) => {

    const { data } = await axios.get(`/users/${ id }`)

    return {
        id: data.data.id,
        ...data.data.attributes,
        created_at: new Date(data.data.attributes.created_at).toLocaleDateString(),
        updated_at: new Date(data.data.attributes.updated_at).toLocaleDateString()
    }

}

export const updateUser = async ({ commit }, user) => {

    const userData = { 
        name: user.name,
        email: user.email,
        password: user.password,
    }

    const response = await axios.put(`/users/${ user.id }`, userData)
        .catch(({ response}) => response)

    const { data } = response

    const newUser = {
        id: data.data.id,
        ...data.data.attributes,
        created_at: new Date(data.data.attributes.created_at).toLocaleDateString(),
        updated_at: new Date(data.data.attributes.updated_at).toLocaleDateString()
    }

    if(response.status === 201)
        commit('updateUser', newUser)

}

export const deleteUser = async ({ commit }, id) => {

    const response = await axios.delete(`/users/${ id }`)

    commit('deleteUser', id)

}