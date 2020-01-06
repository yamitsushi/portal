import Vue from 'vue'
import VueRouter from 'vue-router'

import Portal from '../components/pages/Portal.vue'
import Home from '../components/pages/Home.vue'

Vue.use(VueRouter)

const routes = [
  { path: '/', name: 'index', component: Home },
  { path: '/portal', name: 'portal', component: Portal },
  { path: '*', redirect: { name: 'index' } }
]

export default new VueRouter({
  mode: 'history',
  routes
})
