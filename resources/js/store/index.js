import axios from 'axios';
import Vue from 'vue'
import Vuex from 'vuex'

import productModule from '../modules/product/store'
import userModule from '../modules/user/store'
import shoppingCartModule from '../modules/shopping-cart/store'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {    
        isLoading: false,
    },
    mutations: {
        setIsLoading(state, value){
            state.isLoading = value
        }
    },
    actions: {
        async checkAuthentication(){

            const status = await axios.get('checkAuth')
                .then( response => response.status )
                .catch( ({response}) => response.status )

            return status === 204 ? true : false

        },
        async logout(){
            const response = await axios.post('/logout')

            return response.status === 204

        }
    },
    modules: {
        productModule,
        userModule,
        shoppingCartModule
    }
})

export default store
