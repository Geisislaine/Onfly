<template>
  <q-layout>
    <q-header elevated>
      <q-toolbar class="bg-indigo-7" style="height: 5rem;">
        <q-btn flat dense round @click="drawer = !drawer" icon="menu" aria-label="Menu"/>

        <q-toolbar-title>
          <!--Quasar App-->
        </q-toolbar-title>

        <q-space/>

        <div class="q-gutter-sm row items-center no-wrap">
          <q-btn round dense flat color="white" :icon="$q.fullscreen.isActive ? 'fullscreen_exit' : 'fullscreen'"
            @click="$q.fullscreen.toggle()"
            v-if="$q.screen.gt.sm">
            <!--            <q-tooltip>Messages</q-tooltip>-->
          </q-btn>

          <q-btn-dropdown size="1.2rem" round flat icon="fas fa-user-circle">
            <q-list>
              <q-item clickable v-close-popup @click="logout()">
                <q-item-section avatar>
                  <q-avatar icon="logout" text-color="indigo-7"/>
                </q-item-section>
                <q-item-section>
                  <q-item-label>Sair</q-item-label>
                </q-item-section>
              </q-item>
              <q-item clickable v-close-popup>
                <q-item-section avatar>
                  <q-avatar icon="settings" text-color="indigo-7"/>
                </q-item-section>
                <q-item-section>
                  <q-item-label>Configurações</q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="drawer" show-if-above
        :mini="miniState"
        @mouseover="miniState = false"
        @mouseout="miniState = true"
        content-class="bg-indigo-7 text-white" >
      <q-scroll-area class="fit">
      <q-list padding>
        <q-item clickable v-ripple to="/Dashboard" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="dashboard"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Dashboard</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable v-ripple to="/Despesas" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="fas fa-hand-holding-usd"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Despesas</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable v-ripple to="/Profile" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="person"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Perfil</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable v-ripple active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="settings"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Configurações</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable v-ripple @click="logout()" active-class="q-item-no-link-highlighting">
          <q-item-section avatar>
            <q-icon name="logout"/>
          </q-item-section>
          <q-item-section>
            <q-item-label>Sair</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
      </q-scroll-area>
    </q-drawer>

    <q-page-container>
      <router-view/>
    </q-page-container>
  </q-layout>
</template>

<script>
    import EssentialLink from 'components/EssentialLink'

    export default {
      name: 'MainLayout',

      components: {
        EssentialLink
      },

      data() {
        return {
          drawer: false,
          miniState: true,
          usuario: {
            name: null
          },
        }
      },

      methods: {
        async logout() {
          this.$store.commit("SET_LOGOUT");
          this.$router.replace('/')
        }
      },
      mounted(){
        this.usuario = this.$store.getters.user;
      }
    }
</script>
<style scoped>
.colorfundo{
  background: #005b7c;
}
</style>
