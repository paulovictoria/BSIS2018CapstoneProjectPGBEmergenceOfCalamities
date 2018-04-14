import Vue from 'vue'
import VueMaterial from 'vue-material'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import Toasted from 'vue-toasted'
import router from './routes'
import municipalities from './json/municipality.list.json'
import SweetModal from 'sweet-modal-vue/src/plugin.js'
import VueChatScroll from 'vue-chat-scroll'
import Echo from 'laravel-echo'
import MessagesNotifications from './components/admin/notifications/messages/MessagesNotification.vue'
import TidesNotifications from './components/admin/notifications/tides/TidesNotifications'
import RescuerNotifications from './components/admin/notifications/rescuer/RescuerNotifications'
import VueGeolocation from 'vue-browser-geolocation'
import barangays from './barangays.js'
import Artyom from 'artyom.js'
import moment from 'moment'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'
import 'material-design-lite/material.min.css'
import 'material-design-lite/material.js'
import './mdl-ext.min.js'
import '../sass/mdl-ext.min.css'
import 'chart.js'
import 'hchs-vue-charts'
window.Pusher = require('pusher-js')
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
  key: 'your key',
  cluster: 'your cluster',
  encrypted: true
})
Vue.use(VueGeolocation)
Vue.use(VueResource)
Vue.use(SweetModal)
Vue.use(window.VueCharts)
Vue.use(VueMaterial)
Vue.use(VueRouter)
Vue.use(VueChatScroll)
Vue.use(Toasted)
require('./bootstrap')
const artyom = new Artyom()
const app = new Vue({
  el: '#app',
  router,
  data: {
    municipalities: municipalities,
    showNavigation: false,
    showSidepanel: false,
    allMessages: [],
    allUsers: [],
    id: '',
    unreads: '',
    barangays,
    user: document.getElementById('municipalOffice').textContent,
    lat: null,
    lng: null,
    weatherData: null,
    parsedItem: null,
    datenow: null,
    asOfTime: '',
    apiKeys: {
      wwo: 'your key'
    },
    tide1: '',
    tide2: ''
  },
  methods: {
    getsMessages() {
      axios
        .get('/messages')
        .then(response => {
          this.allMessages = response.data
        })
        .catch(response => {
          console.log(response)
        })
    },
    listenForEvents() {
      window.Echo.join('chat')
        .here(users => {
          this.allUsers = users
        })
        .joining(user => {
          this.allUsers.push(user)
        })
        .leaving(user => {
          this.allUsers = this.allUsers.filter(u => u != user)
        })
    },
    listenForDeactivation() {
      window.Echo.private('block').listen('BlockAUserEvent', e => {
        if (e.admin.municipality == this.user) {
          this.logoutUser()
        }
      })
    },
    logoutUser() {
      this.$http
        .get('/logout')
        .then(response => (window.location.href = '/login'))
    },
    getForCoords() {
      if (this.user == 'Bulacan' || this.user == 'Administrator') {
        this.lat = 14.8559
        this.lng = 120.8162
        console.log('Yay!')
        this.remindForWeather()
        this.getTides()
      } else {
        this.municipalities.forEach(result => {
          if (result.name == this.user) {
            this.lat = result.coord.lat
            this.lng = result.coord.lng
            console.log('Yay!')
            this.remindForWeather()
            this.getTides()
          }
        })
      }
    },
    remindForWeather() {
      this.$http.get(`/weather/get/${this.lat}/${this.lng}`).then(response => {
        this.weatherData = response.data
        this.asOfTime = moment().format('LT')
        this.speakNow(`Weather Update as of ${this.asOfTime}`)
        this.speakNow(this.weatherData.hourly.summary)
        this.speakNow(
          `The current temperature is about ${
            this.weatherData.currently.temperature
          } degree celcius.`
        )
        this.speakNow(
          `The rain probability is ${
            this.weatherData.currently.precipProbability
          } percent.`
        )
        this.speakNow(
          `The related humidity is about ${
            this.weatherData.currently.humidity
          } percent.`
        )
        this.speakNow(
          `Also wind speed is about ${
            this.weatherData.currently.windSpeed
          } kilometer per hour.`
        )
        this.speakNow(
          'Warning. Municipalities near coastal areas are advised to stay alert!'
        )
        this.speakNow('Especially Calumpit, Hagonoy, City of Malolos, Paombong')
        this.speakNow('Bulakan, Bocaue, Marilao, Meycauayan, Obando')
        this.speakNow(`${this.tide1.tide_type} Tide Schedule.`)
        this.speakNow(`at ${this.tide1.tideTime}.`)
        this.speakNow(
          `The elevation will be ${this.tide1.tideHeight_mt} meters.`
        )
        this.speakNow(`${this.tide2.tide_type} Tide Schedule.`)
        this.speakNow(`at ${this.tide2.tideTime}.`)
        this.speakNow(
          `The elevation will be ${this.tide2.tideHeight_mt} meters.`
        )
        this.speakNow('Thank you for listening!')
        this.asOfTime = ''
      })
    },
    getTides() {
      this.$http
        .jsonp(
          `https://api.worldweatheronline.com/premium/v1/marine.ashx?key=${
            this.apiKeys.wwo
          }&q=14.683333,120.933333&tide=yes&format=json`
        )
        .then(response => {
          this.tide1 = response.data.data.weather[0].tides[0].tide_data[0]
          this.tide2 = response.data.data.weather[0].tides[0].tide_data[1]
        })
    },
    initializeVoice() {
      artyom
        .initialize({
          lang: 'en-US',
          continuous: false,
          listen: false,
          debug: true,
          speed: 1
        })
        .then(() => {
          console.log('Ready to speak!')
        })
    },
    speakNow(msg) {
      artyom.say(msg, {
        onStart: () => {
          console.log('The text is being readed')
        },
        onEnd: () => {
          console.log('Finished!')
        }
      })
    },
    getLocaleTime() {
      const itemed = localStorage.getItem('intervals')
      this.parsedItem = JSON.parse(itemed)
    },
    showTime() {
      this.datenow = moment().format('h:mm:ss A')
      if (this.parsedItem.includes(this.datenow)) {
        this.getForCoords()
      }
    }
  },
  mounted() {
    this.initializeVoice()
    this.getLocaleTime()
    this.interval = setInterval(this.showTime, 1000)
  },
  created() {
    this.getsMessages()
    this.listenForEvents()
    this.listenForDeactivation()
  },
  beforeDestroy() {
    clearInterval(this.interval)
  },
  components: {
    'messages-notifications': MessagesNotifications,
    'tides-notifications': TidesNotifications,
    'rescuer-notifications': RescuerNotifications
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
