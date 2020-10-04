require('./bootstrap');

import Vue from 'vue';

import vuetify from './plugins/vuetify'
import store from './store'

import Component from './Component/default';

new Vue({
	vuetify,
	store,
	...Component
}).$mount('#app')