import Vue from 'vue'
import Vuex from 'vuex'

import loading from './modules/loading'
import pulse from './modules/pulse'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    loading,
    pulse
  }
})
