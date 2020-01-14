import Vue from 'vue'
import Vuex from 'vuex'

import loading from './modules/loading'
import pulse from './modules/pulse'
import time from './modules/time'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    loading,
    pulse,
    time
  }
})
