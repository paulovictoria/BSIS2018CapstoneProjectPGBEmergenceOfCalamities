import Vue from 'vue'
import VueResource from 'vue-resource'
import VueGeolocation from 'vue-browser-geolocation'
import 'material-design-lite/material.min.css'
import 'material-design-lite/material.js'
import Echo from 'laravel-echo'
import GPS from './components/admin/GPS'
import SweetModal from 'sweet-modal-vue/src/plugin.js'
import VueChatScroll from 'vue-chat-scroll'
window.Pusher = require('pusher-js')
require('./bootstrap')
import * as VueGoogleMaps from 'vue2-google-maps'
Vue.use(VueGoogleMaps, {
  load: {
    key: 'your_key',
    libraries: 'places',
    v: '3'
  }
})
window.Echo = new Echo({
  broadcaster: 'pusher',
  key: 'your_key',
  cluster: 'your_cluster',
  encrypted: true
})
Vue.use(VueGeolocation)
Vue.use(VueResource)
Vue.use(SweetModal)
Vue.use(VueChatScroll)
const rescue = new Vue({
  el: '#app',
  data: {},
  components: {
    rescue: GPS
  },
  http: {
    root: '/',
    headers: {
      'X-CSRF-TOKEN': document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content')
    }
  }
})
