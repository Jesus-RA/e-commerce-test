<template>
    <div class="container vh-100">
        <div class="row d-flex h-75 justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="card shadow border-0 px-md-5 py-md-4">

                    <h2 class="text-center my-3">Login Form</h2>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input
                                type="email"
                                placeholder="example.webforcehq.com"
                                class="form-control"
                                :class="{ 'is-invalid' : $v.email.$error }"
                                v-model.trim="$v.email.$model"
                            >
                            <span v-if="!$v.email.email || $v.email.$error" class="d-block invalid-feedback">
                                Ingrese un email válido.
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input
                                type="password"
                                placeholder="Password"
                                class="form-control"
                                :class="{ 'is-invalid': $v.password.$error }"
                                v-model="$v.password.$model"
                                @keyup.enter="handleLogin"
                            >
                            <div v-if="$v.password.$error" class="d-block invalid-feedback">
                                Debes de ingresar una contraseña.
                            </div>
                        </div>

                        <div v-if="errorMessage" class="d-block invalid-feedback text-center">
                            {{ errorMessage }}
                        </div>

                        <button
                            class="btn btn-primary btn-block my-4"
                            @click="handleLogin"
                        >
                            Login
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { required, email } from 'vuelidate/lib/validators'
import store from '../../../store'

export default {
    data(){
        return {
            email: '',
            password: '',
            errorMessage: ''
        }
    },
    validations: {
        email: { required, email },
        password: { required }
    },
    methods: {
        async handleLogin(){

            if( this.$v.$invalid ){
                this.$v.$touch()
                return
            }
            
            const response = await axios.post('/login', { email: this.email, password: this.password })
                .catch( ({ response }) => {
                    const { error } = response.data

                    this.errorMessage = error.message
                })

            if(!response)
                return

            const { data } = response.data
            const user = { id: data.id, ...data.attributes }

            this.$router.push({ name: 'admin-users' })

        }
    },
}
</script>