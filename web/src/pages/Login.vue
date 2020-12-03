<template>
  <q-layout class="fundo">
    <q-page-container>
      <q-page class="flex flex-center">
        <q-card :style="$q.screen.lt.sm?{'width': '80%'}:{'width':'25%'}">
          <q-card-section style="height: 5rem">
            <div class="text-center colorText">
              <div class="col text-h4 ellipsis ">
                Login
              </div>
            </div>
          </q-card-section>
          <q-card-section class="items-center">
            <q-form class="q-gutter-sm " ref="login">
              <q-input filled v-model="email" placeholder="E-mail" lazy-rules :rules="[ val => !!val || 'Informe o e-mail']">
                <template v-slot:prepend>
                  <q-icon class="colorText" name="fas fa-user"/>
                </template>
              </q-input>

              <q-input type="password" filled v-model="password" placeholder="Senha" lazy-rules :rules="[ val => !!val || 'Digite a senha']">
                <template v-slot:prepend>
                  <q-icon class="colorText" name="fas fa-lock" />
                </template>
              </q-input>


                <q-item-section class="colorText q-ml-none" align="right">
                  <a class="link" href="#">Esqueci Senha</a>
                </q-item-section>


              <div align="center" class="q-pa-lg q-gutter-md">
                <q-btn rounded type="button" to="/cadastrar" class="bg-negative">
                  <q-item class="q-pa-none">
                    <q-item-section class="q-pa-md q-ml-none" align="left">
                      <q-item-label class="text-subtitle1 text-white">Cadastrar</q-item-label>
                    </q-item-section>
                    <q-item-section side class="q-mr-md" align="right">
                      <q-icon color="white" name="fas fa-user-edit" size="20px"></q-icon>
                    </q-item-section>
                  </q-item>
                </q-btn>

                <q-btn rounded type="button" @click="login()" class="colorfundo">
                  <q-item class="q-pa-none">
                    <q-item-section class="q-pa-md q-ml-none" align="left">
                      <q-item-label class="text-subtitle1 text-white">Login</q-item-label>
                    </q-item-section>
                    <q-item-section side class="q-mr-md" align="right">
                      <q-icon color="white" name="fas fa-sign-in-alt" size="20px"></q-icon>
                    </q-item-section>
                  </q-item>
                </q-btn>
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>

  import axios from 'axios'
  import Constants from '../Constants'

  export default {
    data() {
      return {
        userLogado: null,
        email: null,
        password: null
      }
    },

    methods: {
      login(){
        this.$refs.login.validate().then(success => {
          if(success){
            this.$q.loading.show({ delay: 400 })

            const user = new FormData()
            user.append('email', this.email)
            user.append('password', this.password)

            axios.post(Constants.apiUrl + '/auth/login', user)
            .then(response => {
              const dataToken = {
                token: response.data.access_token,
                expires_in: response.data.expires_in
              }
              this.$store.commit('SET_API_TOKEN', dataToken)
              this.$store.commit('SET_USER', response.data.user)
              this.$router.replace('/Dashboard')
            }).catch(error => {
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
          }else{
            this.$q.notify({ type: 'negative',position: 'top-right', message: 'Prencha os campos obrigatórios' })
          }
        })
      }
    }
  }
</script>

<style>
  .q-card{
    box-shadow: 0 30px 60px 0 rgba(0,0,0,.3);
    border-radius: 10px 10px 10px 10px;
  }
  .q-btn{
  text-transform: none;
  font-weight: normal;
}
.fundo{
  background-image: url("../assets/fundo_login.png");
  background-repeat: no-repeat;
  background-size: 100%;
}
.colorText{
  color: #005b7c;
}

.colorfundo{
  background: #005b7c;
}

.link:link{
    color:  #005b7c;
    text-decoration: none;
    font-weight: bolder;
}

.link:visited{
    text-decoration: none;
    color:#005b7c;
}

.link:active{
  color:red;
}
</style>
