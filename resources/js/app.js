/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

window.Vue = require('vue')
import router from './router'
import vuetify from './plugins/vuetify'
import store from './store'
import root from './components/Root'

const app = new Vue({
  el: '#application',
  router,
  vuetify,
  store,
  components: { root },
  template: '<root/>'
})
