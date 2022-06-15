import Vuex from 'vuex'
import axios from 'axios'

axios.defaults.baseURL = '/api'

export default new Vuex.Store({
  state: {
    user: null,
    authenticated: false,
  },

  mutations: {
    setUserData (state, userData) {
      state.user = userData
      localStorage.setItem('user', JSON.stringify(userData))
      axios.defaults.headers.common['Authorization'] = `Bearer ${userData.access_token}`
      state.authenticated = true
    },

    clearUserData () {
      localStorage.removeItem('user')
      this.state.authenticated = false
      location.reload()
    },

    removeUser () {
      localStorage.removeItem('user')
      this.state.authenticated = false
    },
  },

  actions: {
    login ({ commit }, credentials) {
      return axios
        .post('/auth/login', credentials)
        .then(({ data }) => {
          commit('setUserData', data)
        })
    },

    logout ({ commit }) {
      commit('clearUserData')
    },

    tokenNotValid ({ commit }) {
      commit('removeUser')
    },
  },
})
