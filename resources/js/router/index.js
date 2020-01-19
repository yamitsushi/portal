import Vue from 'vue'
import VueRouter from 'vue-router'

import Portal from '../components/pages/Portal.vue'
import Home from '../components/pages/Home.vue'
import Activate from '../components/pages/Activate.vue'
import Message from '../components/MessageScreen.vue'

Vue.use(VueRouter)

const routes = [
  { path: '/', name: 'index', component: Home },
  { path: '/portal', name: 'portal', component: Portal },
  { path: '/status', name: 'status', component: Activate },
  { path: '/report', name: 'message', component: Message },
  { path: '*', redirect: { name: 'index' } }
]

export default new VueRouter({
  mode: 'history',
  routes
})
