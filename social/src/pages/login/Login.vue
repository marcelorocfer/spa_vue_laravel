<template>
    <login-template>

        <span slot="menuesquerdo">
            <img src="https://www.twccomunicacao.com.br/restrito/img/blog/29f464ef386c0c4c08f5e7fc5103d29e.png" class="responsive-img">
        </span>

        <span slot="principal">

            <h2>Login</h2>

            <input type="text" placeholder="E-mail" v-model="email">
            <input type="password" placeholder="Senha" v-model="password">
            <button class="btn" v-on:click="login()">Entrar</button>
            <router-link class="btn orange" to="cadastro">Cadastre-se</router-link>

        </span>

    </login-template>
</template>

<script>
    import LoginTemplate from '@/templates/LoginTemplate'

    export default {
        name: 'Login',
        data () {
            return {
                email: '', 
                password: ''
            }
        },
        components: {
            LoginTemplate
        },
        methods: {
            login() {
                this.$http.post(this.$urlAPI + `login`, {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    if (response.data.status) {
                        // console.log('Login com sucesso');
                        this.$store.commit('setUsuario', response.data.usuario);
                        sessionStorage.setItem('usuario', JSON.stringify(response.data.usuario));
                        this.$router.push('/');
                    } else if (response.data.status === false && response.data.validacao) {
                        console.log('Erros de validação')
                        let erros = '';
                        for (let erro of Object.values(response.data.erros)) {
                            erros += erro +" ";
                        }
                        alert(erros)
                    } else {
                        // console.log('Login não existe');
                        alert('Login inválido!')
                    }
                })
                .catch(e => {
                    console.log(e)
                    alert('Erro! Tente novamente mais tarde!')
                })
            }
        }
    }
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
