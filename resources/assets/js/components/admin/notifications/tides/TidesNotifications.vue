<template>
    <div>
        <audio controls style="display:none;" id="audio" ref="audio">
					<source :src="source" type="audio/mp3">      
				</audio> 
      <p style="display:none;" id="checkTime">Time check: {{theTime}}</p>
        <a class="mdl-navigation__link mdl-color-text--white cursor" @click="showNotifications">
          <span class="mdl-bold">
           <i class="fas fa-tint"></i>
          </span> 
          <span class="mdl-cell--hide-phone ">
           ({{newTideUpdates.length}}) 
          </span>
         </a>
         <div class="md-notifications md-elevation-1" v-if="notifications">
            <md-list class="fixed-notifications" @click="checkItems">
                <md-list-item v-if="isNone">
                <div class="md-list-item-text">
                  <span class="mdl-typography--text-center">No Tide Update!</span>
                </div>
                </md-list-item>
              <tides-item v-for="newTideUpdate in newTideUpdates"
                          :key="newTideUpdate.id"
                          :time="newTideUpdate.tideTime"
                          :type="newTideUpdate.tideType"
                          :dateGathered="newTideUpdate.date_gathered"
                          :height="newTideUpdate.tideHeight_mt"></tides-item>
            </md-list>
        </div>
  </div>
</template>

<script>
import moment from 'moment'
import TidesItem from './TidesItem'
export default {
  name: 'TidesNotifications',
  data() {
    return {
      notifications: false,
      newTideUpdates: [],
      theTime: '',
      newTideTime: [],
      newTideHeights: [],
      newTimeSeries: [],
      newTideTypes: [],
      parsedTime: '',
      apiKeys: {
        wwo: ' your key '
      },
      showNothing: true,
      isNone: true,
      source: 'sounds/beep.mp3'
    }
  },
  methods: {
    checkMessages() {
      if (this.newTideUpdates.length == 0) {
        this.isNone = true
      } else {
        this.isNone = false
      }
    },
    showNotifications() {
      if (this.notifications == false) {
        this.notifications = true
      } else {
        this.notifications = false
      }
    },
    listenToUpdates() {
      Echo.private('tide-updates').listen('TideUpdateEvent', e => {
        this.newTideUpdates.unshift(e.tideUpdates)
      })
    },
    getAllUpdates() {
      this.$http.get('/tides/timeseries').then(response => {
        response.data.forEach(element => {
          this.newTideUpdates.unshift(element)
        })
      })
    },
    showTime() {
      this.theTime = moment().format('h:mm:ss A')
      if (this.parsedTime.includes(this.theTime)) {
        this.$refs.audio.play()
        this.getNewUpdate()
      }
    },
    saveUpdate(number) {
      this.$http.post(
        '/tides/add',
        {
          date_gathered: moment()
            .toDate()
            .toUTCString(),
          tideTime: this.newTideTime[number],
          tideHeight_mt: this.newTideHeights[number],
          tideDateTime: this.newTimeSeries[number],
          tideType: this.newTideTypes[number]
        },
        {
          headers: {
            'X-CSRF-TOKEN': document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute('content')
          }
        }
      )
    },
    saveNewTime() {
      const locale = 'en'
      const hours = []
      moment.locale(locale)
      for (let hour = 0; hour < 24; hour++) {
        hours.push(moment({ hour }).format('h:mm:ss A'))
      }

      if (localStorage['intervals']) {
        console.log('No Local Storage Key Found!')
      } else {
        localStorage.setItem('intervals', JSON.stringify(hours))
      }
      const itemed = localStorage.getItem('intervals')
      this.parsedTime = JSON.parse(itemed)
    },
    getNewUpdate() {
      this.$http
        .jsonp(
          `https://api.worldweatheronline.com/premium/v1/marine.ashx?key=${
            this.apiKeys.wwo
          }&q=14.683333,120.933333&tide=yes&format=json`
        )
        .then(
          response => {
            const weather = response.data.data.weather
            weather.forEach(result => {
              result.tides[0].tide_data.forEach(element => {
                this.newTideTime.push(element.tideTime)
                this.newTideTypes.push(element.tide_type)
                this.newTimeSeries.push(element.tideDateTime)
                this.newTideHeights.push(element.tideHeight_mt)
              })
            })
            this.saveUpdate(0)
            this.saveUpdate(1)
          },
          response => {}
        )
    },
    checkItems() {
      if (this.newTideUpdates) {
        this.showNothing = false
      }
    }
  },
  watch: {
    newTideUpdates() {
      this.checkMessages()
    }
  },
  mounted() {
    Promise.all([
      this.listenToUpdates(),
      this.getAllUpdates(),
      this.saveNewTime(),
      this.checkItems(),
      this.checkMessages(),
      (this.interval = setInterval(this.showTime, 1000))
    ])
  },
  beforeDestroy() {
    clearInterval(this.interval)
  },
  components: {
    'tides-item': TidesItem
  }
}
</script>

<style lang="scss" scoped>
.md-notifications {
  width: 385px;
  background-color: white;
  height: 300px;
  position: absolute;
  z-index: 3;
  right: 0px;
  top: 65px;
  .fixed-notifications {
    max-height: 300px;
    overflow: auto;
    width: 100%;
  }
}

.cursor {
  cursor: pointer;
}
</style>
