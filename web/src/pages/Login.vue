<template>
  <q-layout class="fundo">
    <q-page-container>
      <q-page class="flex flex-center">
        <q-card :style="$q.screen.lt.sm?{'width': '80%'}:{'width':'25%'}">
          <q-card-section style="height: 6rem">
            <div class="text-center colorText">
              <div class="col text-h4 ellipsis ">
                Login
              </div>
            </div>
          </q-card-section>
          <q-card-section class="items-center">
            <q-form class="q-gutter-md ">
              <q-input filled v-model="email" placeholder="E-mail" lazy-rules>
                <template v-slot:prepend>
                  <q-icon class="colorText" name="fas fa-user"/>
                </template>
              </q-input>

              <q-input type="password" filled v-model="password" placeholder="Senha" lazy-rules>
                <template v-slot:prepend>
                  <q-icon class="colorText" name="fas fa-lock" />
                </template>
              </q-input>

              <div align="center" class="q-pa-lg">
                <q-btn to="/" rounded type="submit" class="colorfundo">
                  <q-item class="q-pa-none">
                    <q-item-section class="q-pa-md q-ml-none" align="left">
                      <q-item-label class="text-h6 text-white">Login</q-item-label>
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
    export default {
        data() {
            return {
                email: 'user@teste.com',
                password: '123456'
            }
        },
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
</style>
