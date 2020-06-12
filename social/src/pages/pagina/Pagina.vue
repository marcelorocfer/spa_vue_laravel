<template>
    <site-template>

        <span slot="menuesquerdo">
            <div class="row valign-wrapper">
                <grid-vue tamanho="4">
                    <router-link :to="'/pagina/'+donoPagina.id+'/'+$slug(donoPagina.name, {lower: true})">
                        <img :src="donoPagina.imagem" :alt="donoPagina.name" class="circle responsive-img"> <!-- notice the "circle" class -->
                    </router-link>
                </grid-vue>
                <grid-vue tamanho="8">
                    <span class="black-text">
                        <router-link :to="'/pagina/'+donoPagina.id+'/'+$slug(donoPagina.name, {lower: true})">
                            <h5>{{donoPagina.name}}</h5>
                        </router-link>
                    </span>
                </grid-vue>
            </div>
            <button v-if="exibeBtnSeguir" @click="amigo(donoPagina.id)" class="btn">{{textoBtn}}</button>
        </span>

        <span class="page" slot="menuesquerdoamigos">
            <h5>Seguindo</h5>
            <router-link v-for="item in amigos" :key="item.id" :to="'/pagina/'+item.id+'/'+$slug(item.name, {lower: true})">
                <li style="list-style: none">{{item.name}}</li>
            </router-link>
            <li style="list-style: none" v-if="!amigos.length">Nenhum Usuário</li>
        </span>

        <span class="page" slot="menuesquerdoseguidores">
            <h5>Seguidores</h5>
            <router-link v-for="item in seguidores" :key="item.id" :to="'/pagina/'+item.id+'/'+$slug(item.name, {lower: true})">
                <li style="list-style: none">{{item.name}}</li>
            </router-link>
            <li style="list-style: none" v-if="!seguidores.length">Nenhum Usuário</li>
        </span>

        <span slot="principal">
            <publicar-conteudo-vue />

            <card-conteudo-vue v-for="item in listaConteudos" :key="item.id"
                :id="item.id"
                :totalcurtidas="item.total_curtidas"
                :comentarios="item.comentarios"
                :curtiuconteudo="item.curtiu_conteudo"
                :usuarioid="item.user.id"
                :perfil="item.user.imagem"
                :nome="item.user.name"
                :data="item.data">

                <card-detalhe-vue
                    :img="item.imagem"
                    :titulo="item.titulo"
                    :txt="item.texto"
                    :link="item.link"
                >
                </card-detalhe-vue>
            </card-conteudo-vue>
            <button v-if="urlProximaPagina" @click="carregaPaginacao()" class="btn blue ">Mais...</button>
            <div v-scroll="handleScroll"></div>
        </span>

    </site-template>
</template>

<script>
    import CardConteudoVue from '@/components/social/CardConteudoVue'
    import CardDetalheVue from '@/components/social/CardDetalheVue'
    import PublicarConteudoVue from '@/components/social/PublicarConteudoVue'
    import SiteTemplate from '@/templates/SiteTemplate'
    import GridVue from '@/components/layouts/GridVue'

    export default {
        name: 'Pagina',
        data () {
            return {
                usuario: {imagem:'', name:''},
                urlProximaPagina: null,
                pararScroll: false,
                donoPagina: {imagem:'', name:''},
                exibeBtnSeguir: false,
                amigos: [],
                seguidores: [],
                amigosLogados: [],
                textoBtn: 'Seguir'
            }
        },
        created() {
            this.atualizaPagina();
        },
        components: {
            CardConteudoVue,
            CardDetalheVue,
            PublicarConteudoVue,
            SiteTemplate,
            GridVue
        },
        watch: {
            '$route': 'atualizaPagina'
        },
        methods: {
            atualizaPagina() {
                let usuarioAux = this.$store.getters.getUsuario;
                if (usuarioAux) {
                    this.usuario = this.$store.getters.getUsuario;

                    this.$http.get(this.$urlAPI + `conteudo/pagina/lista/${this.$route.params.id}`,
                        {"headers":{"authorization": "Bearer " + this.$store.getters.getToken}})
                        .then(response => {
                            // console.log(response.data.conteudos);
                            if(response.data.status) {
                                this.$store.commit('setConteudosLinhaTempo', response.data.conteudos.data);
                                this.urlProximaPagina = response.data.conteudos.next_page_url;
                                this.donoPagina = response.data.dono;
                                if(this.donoPagina.id !== this.usuario.id) {
                                    this.exibeBtnSeguir = true;
                                } else {
                                    this.exibeBtnSeguir = false;
                                }

                                this.$http.get(this.$urlAPI + `usuario/listaamigospagina/${this.donoPagina.id}`,
                                    {"headers":{"authorization": "Bearer " + this.$store.getters.getToken}})
                                    .then(response => {
                                        if(response.data.status) {
                                            // console.log(response.data);
                                            this.amigos = response.data.amigos;
                                            this.seguidores = response.data.seguidores;
                                            this.amigosLogados = response.data.amigoslogados;
                                            this.eAmigo();
                                        } else {
                                            alert(response.data.erro);
                                        }
                                    })
                                    .catch(e => {
                                        console.log(e)
                                        alert('Erro! Tente novamente mais tarde!')
                                    });
                            }
                        })
                        .catch(e => {
                            console.log(e)
                            alert('Erro! Tente novamente mais tarde!')
                        });
                }
            },
            eAmigo() {
                for(let amigo of this.amigosLogados) {
                    if(amigo.id === this.donoPagina.id) {
                        this.textoBtn = "Remover";
                        return;
                    }
                }
                this.textoBtn = "Seguir";
            },
            amigo(id) {
                this.$http.post(this.$urlAPI + `usuario/amigo`, {id},
                    {"headers":{"authorization": "Bearer " + this.$store.getters.getToken}})
                    .then(response => {
                        if (response.data.status) {
                            // console.log(response);
                            this.amigosLogados = response.data.amigos;
                            this.seguidores = response.data.seguidores;
                            this.eAmigo();
                        } else {
                            alert(response.data.erro);
                        }
                    })
                    .catch(e => {
                        console.log(e)
                        alert('Erro! Tente novamente mais tarde!')
                    });
            },
            handleScroll() {
                if(this.pararScroll) {
                    return;
                }
                if(window.scrollY >= document.body.clientHeight - 830) {
                    this.pararScroll = true;
                    this.carregaPaginacao();
                }
            },
            carregaPaginacao() {
                if(!this.urlProximaPagina) {
                    return;
                }
                this.$http.get(this.urlProximaPagina, {"headers":{"authorization": "Bearer " + this.$store.getters.getToken}})
                .then(response => {
                    // console.log(response);
                    if(response.data.status && this.$route.name === "Pagina") {
                        this.$store.commit('setPaginacaoConteudosLinhaTempo', response.data.conteudos.data);
                        this.urlProximaPagina = response.data.conteudos.next_page_url;
                        this.pararScroll = false;
                    }
                })
                .catch(e => {
                    console.log(e)
                    alert('Erro! Tente novamente mais tarde!')
                })
            }
        },
        computed: {
            listaConteudos() {
                return this.$store.getters.getConteudosLinhaTempo;
            }
        }
    }
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
