import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    apiToken: '',
    user: {}
  },
  mutations: {
    SET_API_TOKEN (state, token) {
      state.apiToken = token
    },
    SET_USER (state, user) {
      state.user = user
    },
    SET_LOGOUT (state) {
      state.apiToken = ''
      state.user = {}
    }
  },
  getters: {
    ApiToken: state => state.apiToken,
    user: state => state.user
  },
  modules: {},
  plugins: [createPersistedState()]
})
