<template>
    <footer :class="'page-footer ' + cor">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">{{ logo || 'Site' }}</h5>
                    <p class="grey-text text-lighten-4">{{ descricao || 'Sua Descrição' }}</p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <slot></slot>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © {{ ano || currentYear() }} {{ logo || 'Site' }}
                <a class="grey-text text-lighten-4 right" href="#!">More Links</a>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        name: "FooterVue",
        props: ['cor', 'logo', 'descricao', 'ano'],
        data () {
            return {

            }
        },
        methods: {
            currentYear() {
                let year = new Date();
                let ano = year.getFullYear();
                return ano;
            }
        }
    }
</script>

<style scoped>

</style>