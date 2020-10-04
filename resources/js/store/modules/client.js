import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  rates: {},
  ip: null,
  mac: null,
  timer: "Please Wait",
  active: false,
  pulse: 0,
  time: 0,
  countdown: 0
}

// getters
export const getters = {
  rates: state => state.rates,
  ip: state => state.ip,
  mac: state => state.mac,
  timer: state => refactor.humanTime(state.timer) || "Empty Balance",
  active: state => state.active,
  pulse: state => state.pulse,
  time: state => refactor.humanTime(state.time) || "Insert Coin",
  countdown: state => state.countdown
}

// mutations
export const mutations = {
  [types.FETCH_CLIENT] (state, { ip, mac, timer, active }) {
    state.ip = ip
    state.mac = mac
    state.timer = timer
    state.active = active
  },

  [types.FETCH_RATE] (state, payload) {
    state.rates = payload
  },

  [types.DECREASE_TIME] (state) {
    state.timer--
  },

  [types.UPDATE_STATUS] (state, { timer, active }) {
    state.timer = timer
    state.active = active
  },

  [types.UPDATE_PULSE] (state, { pulse , time, timeout}) {
    state.pulse = pulse
    state.time = time
    state.countdown = timeout
  },

  [types.CLEAN_PULSE] (state) {
    state.pulse = 0
    state.time = 0
    state.countdown = 0
  },

  [types.DECREASE_COUNTDOWN] (state) {
    state.countdown--
  }
}

// actions
export const actions = {
  async fetchClient ({ commit }) {
    try {
      const { data } = await axios.get('/api/client')

      commit(types.FETCH_CLIENT, data)
    } catch (e) {
        alert("System Error. Please Refresh Website")
    }
  },

  async fetchRates ({ commit }) {
    try {
      const { data } = await axios.get('/api/rates')

      commit(types.FETCH_RATE, data)
    } catch (e) {
        alert("System Error. Please Refresh Website")
    }
  },

  decreaseTime ({ commit }) {
    commit(types.DECREASE_TIME)
  },

  async updateStatus ({ commit }) {
    try {
      const { data } = await axios.post('/api/update')

      commit(types.UPDATE_STATUS, data)
    } catch (e) {
        alert("System Error. Please Refresh Website")
    }
  },

  receivePulse ({ commit }, payload) {
    commit(types.UPDATE_PULSE, payload)
  },

  decreaseCountdown ({ commit }) {
    commit(types.DECREASE_COUNTDOWN)
  },

  cleanPulse ({ commit }) {
    commit(types.CLEAN_PULSE)
  },

  async forceStop ({ commit }) {
    try {
      const { data } = await axios.post('/api/submit')
      commit(types.UPDATE_PULSE, data)
      Echo.leave('InsertCoin')
      this.dialog = false
    } catch(e) {
        alert("System Error. Please Refresh Website")
    }
  }
}

const refactor = {
  humanTime(sec) {
    var d = Math.floor(sec / 86400)
    var h = Math.floor(sec % 86400 / 3600)
    var m = Math.floor(sec % 86400 % 3600 / 60)
    var s = Math.floor(sec % 86400 % 3600 % 60)

    var dDisplay = d > 0 ? d + (d == 1 ? " day" : " days") : h > 0 && d ? ", " : ""
    var hDisplay = h > 0 ? (d && h ? ", " : "") + h + (h == 1 ? " hour" : " hours") : m > 0 && h ? ", " : ""
    var mDisplay = m > 0 ? ((d || h) && m ? ", " : "") + m + (m == 1 ? " minute" : " minutes") : s > 0 && m ? ", " : ""
    var sDisplay = s > 0 ? ((d || h || m) && s ? ", " : "") + s + (s == 1 ? " second" : " seconds") : ""

    return (dDisplay + hDisplay + mDisplay + sDisplay) || sec

  }
}