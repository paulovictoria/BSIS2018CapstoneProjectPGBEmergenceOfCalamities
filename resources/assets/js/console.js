import Vue from 'vue'
import VueMaterial from 'vue-material'
import VueRouter from 'vue-router'
import router from './routes'
import VueResource from 'vue-resource'
import SweetModal from 'sweet-modal-vue/src/plugin.js'
import Echo from 'laravel-echo'
import 'material-design-lite/material.min.css'
import 'material-design-lite/material.js'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'
import './mdl-ext.min.js'
import '../sass/mdl-ext.min.css'
window.Pusher = require('pusher-js')

require('./bootstrap')
Vue.use(SweetModal)
Vue.use(VueRouter)
Vue.use(VueResource)
Vue.use(VueMaterial)

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'your_key',
  cluster: 'your_key',
  encrypted: true
})

const report = new Vue({
  el: '#app',
  router,
  data: {},
  http: {
    root: '/',
    headers: {
      'X-CSRF-TOKEN': document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content')
    }
  }
})
