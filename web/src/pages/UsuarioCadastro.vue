
<template>
  <q-layout  class="fundo" >
    <q-page-container class="" >
      <q-page class="bg-image q-pa-xl flex flex-center">
            <q-card class="card-bg" style="width: 60rem; max-width: 80vw;">
              <q-card-section class="text-blue-grey-7 text-h6 q-pa-lg">
                <div class="text-h6">Cadastro</div>
                <div class="text-subtitle2">Preencha o formulario</div>
              </q-card-section>
              <q-card-section class="q-pa-sm">
                <q-list class="row">
                  <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <q-item-section side>
                      <q-avatar size="100px" class="shadow-10">
                        <img v-if="this.fotoCarregada" :src="fotoCarregada"
                          style="width: 100px; height: 100px;" alt="Foto escolhida"/>
                        <q-icon v-else color="indigo-7" name="fas fa-user"/>
                      </q-avatar>
                    </q-item-section>
                    <q-item-section >
                      <q-file clearable v-model="user.imgPerfil" label="Adicionar Foto" counter max-file-size="8388608" @rejected="erroArquivo()">
                        <template v-slot:prepend>
                          <q-icon color="indigo-7" name="cloud_upload" @click.stop/>
                        </template>
                        <template v-slot:hint>
                          Tamanha da imagem
                        </template>
                      </q-file>
                    </q-item-section>
                  </q-item>

                  <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <q-item-section>
                      <q-input class="text-dark" v-model="user.name" label="Nome *" :error="$v.user.name.$error"/>
                    </q-item-section>
                  </q-item>
                  <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <q-item-section>
                      <q-input v-model="user.email" label="E-mail *" :error="$v.user.email.$error"/>
                      <span class="float-right" style="color: red" v-if="!$v.user.email.email"> Formato valido: usuario@teste.com </span>
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-card-section>

              <q-card-section class="q-pa-sm row">
                <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <q-item-section>
                    <q-input type="password" v-model="user.password" label="Senha *" :error="$v.user.password.$error"/>
                    <span class="float-right" style="color: red" v-if="!$v.user.password.minLength"> A senha deve ter no mínimo {{$v.user.password.$params.minLength.min}} caracteres</span>
                  </q-item-section>
                </q-item>
                <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <q-item-section>
                    <q-input type="password" v-model="user.confirmarPassword" label="Confirmar Senha *" :error="$v.user.confirmarPassword.$error"/>
                    <span class="float-right" style="color: red" v-if="!$v.user.confirmarPassword.sameAsPassword"> As senhas estão divergentes</span>
                  </q-item-section>
                </q-item>
              </q-card-section>
              <q-card-actions align="right" class="q-pa-lg">
                <q-btn padding="0.5rem 0.5rem" push class="text-capitalize bg-indigo-7 text-white" @click="salvarUsuario()">
                  <q-item-section>
                    <div class="text-white text-subtitle1 ">
                      Cadastrar
                    </div>
                  </q-item-section>
                </q-btn>
              </q-card-actions>
            </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>

  import Todo from "../components/Todo"
  import IEcharts from 'vue-echarts-v3/src/full.js'
  import axios from 'axios'
  import Constants from '../Constants'
  import {required, minLength, sameAs, email} from  'vuelidate/lib/validators'

    export default {
      components: {
        Todo,
        IEcharts
      },

      validations: {
        user:{
          name: { required },
          email: { required, email },
          password: { required , minLength: minLength(6)},
          confirmarPassword: { sameAsPassword: sameAs('password')},
        }
      },

      data() {
        return {
          fotoCarregada: null,
          emailDuplicadoVar: null,
          user:{
            imgPerfil:null,
            name: null,
            email: null,
            password: null,
            confirmarPassword: null,
          }

        }
      },

      methods:{
        async emailDuplicado (value) {

          const response = axios.get(Constants.apiUrl + '/email-unique/' + value)
          .catch(error => {
            if(error.response.data){
              let errors = ''
              error.response.data.errors.forEach((element) => {
                errors = errors + element + '<br>'
              })
              this.$q.notify({ type: 'negative',position: 'top-right', message: errors })
            }
          })

          return response
        },

        async salvarUsuario() {
          this.$v.$touch()
          if(this.$v.$invalid){
            this.$q.notify({ type: 'negative',position: 'top-right', message: 'Preencha os campos corretamente!' })
          }else{
            this.$q.loading.show({ delay: 400 })

            if (this.user.email !== null && this.user.email !== '' && this.user.email !== 'undefined') {
              this.emailDuplicadoVar = await this.emailDuplicado(this.user.email)
            }
            if (this.emailDuplicadoVar == 1) {
              this.$q.loading.hide()
              this.$q.notify({ type: 'negative',position: 'top-right', message: 'E-mail já cadastrado!' })
              return false
            }

            const userFormDataitems = new FormData()

            userFormDataitems.append('name', this.user.name)
            userFormDataitems.append('email', this.user.email)
            userFormDataitems.append('password', this.user.password)
            userFormDataitems.append('fotoPerfil', this.user.imgPerfil)

            axios.post(Constants.apiUrl + '/cadastro/', userFormDataitems)
            .then(response => {
              if(response.data.data){
                this.$router.replace('/')
                this.$q.notify({ type: 'positive',position: 'top-right', message: 'Usuário cadastrado com sucesso!'})
              }
            }).catch(error => {
              console.log(error)
              if(error.response.data){
                let errors = ''
                error.response.data.errors.forEach((element) => {
                  errors = errors + element + '<br>'
                })
                this.$q.notify({ type: 'negative',position: 'top-right', message: errors })
              }
            }).then(response => {
              this.$q.loading.hide()
            })
          }
        },

        erroArquivo(){
          this.$q.notify({ type: 'negative',position: 'top-right', message: 'Arquivo é maior que o tamanho permitido!' })
        },
      },

    watch:{
      'user.imgPerfil' (value) {
        const foto = value
        if(value == null){
          this.fotoCarregada = null
        }else{
          this.fotoCarregada = URL.createObjectURL(foto)
        }
      }
    }
    }
</script>

<style scoped>
.fundo{
  background-image: url("../assets/fundo_login.png");
  background-repeat: no-repeat;
  background-size: 100%;
}
  .q-card{
    box-shadow: 0 10px 20px 0 rgba(0,0,0,.3);
    border-radius: 10px 10px 10px 10px;
  }
</style>
