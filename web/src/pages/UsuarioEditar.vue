<template>
  <q-page class="bg-image q-pa-xl">
    <div class="row q-col-gutter-xl ">
      <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
        <q-card class="card-bg">
          <q-card-section class="text-blue-grey-7 text-h6 q-pa-lg">
            <div class="text-h6">Editar Perfil</div>
            <div class="text-subtitle2">Complete seu perfil</div>
          </q-card-section>
          <q-card-section class="q-pa-sm">
            <q-list class="row">
              <q-item class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <q-item-section side>
                  <q-avatar size="100px" class="shadow-10">
                    <q-icon color="indigo-7" name="fas fa-user"/>
                  </q-avatar>
                </q-item-section>
                <q-item-section >
                  <q-file v-model="user.imgPerfil" label="Adicionar Foto" counter>
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
                  <q-input class="text-dark" v-model="user.name" label="Nome"/>
                </q-item-section>
              </q-item>

              <q-item class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <q-item-section>
                  <q-input v-model="user.email" label="E-mail"/>
                </q-item-section>
              </q-item>

            </q-list>
          </q-card-section>

          <q-card-section class=" text-blue-grey-7 text-h6 q-pa-lg">
            <div class="text-h6">Mudar Senha</div>
          </q-card-section>
          <q-card-section class="q-pa-sm row">
            <q-item class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <q-item-section>
                <q-input type="password" v-model="user.password" label="Senha Atual"/>
              </q-item-section>
            </q-item>
            <q-item class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <q-item-section>
                <q-input type="password" v-model="user.novaPassword" label="Nova Senha"/>
              </q-item-section>
            </q-item>
            <q-item class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <q-item-section>
                <q-input type="password" v-model="user.confNovaPasswor" label="Confirmar Nova Senha"/>
              </q-item-section>
            </q-item>
          </q-card-section>
          <q-card-actions align="right" class="q-pa-lg">
            <q-btn padding="0.5rem 0.5rem" push class="text-capitalize bg-indigo-7 text-white">
              <q-item-section>
                <div class="text-white text-subtitle1 ">
                  Salvar Alteração
                </div>
              </q-item-section>
            </q-btn>
          </q-card-actions>
        </q-card>
      </div>

    </div>
  </q-page>
</template>

<script>
    export default {
        name: "UserProfile",
        data() {
          return {
            user:{
            }
          }
        },
        mounted(){
        this.user = this.$store.getters.user;
      }
    }
</script>

<style scoped>
  .q-card{
    box-shadow: 0 10px 20px 0 rgba(0,0,0,.3);
    border-radius: 10px 10px 10px 10px;
  }
</style>
