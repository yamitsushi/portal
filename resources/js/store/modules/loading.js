const state = {
  isLoading: true,
  isFirst : true,
  message : ""
}

const getters = {
  isFirst : state => { return state.isFirst },
  message : state => { return state.message }
}

const actions = {}

const mutations = {
  isLoading (state, status) {
    state.isLoading = status
  },
  inUsed (state) {
    state.isFirst = false
  },
  message (state, message) {
    state.message = message
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
