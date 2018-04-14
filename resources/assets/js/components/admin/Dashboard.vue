<template>
<div>
  <div class="md-layout" v-if="isNotAdmin">
    <md-empty-state
      md-icon="close"
      class="md-accent"
      md-label="Oh noes.."
      md-description="Access denied! Better luck next time.">
    </md-empty-state>
  </div>
  <div class="md-layout" v-if="isAdmin">
      <div class="custom-tooltip md-elevation-1" v-if="isHover">
        <div class="md-layout">
          <div class="md-layout-item md-size-30">
            <i class="material-icons icon--padding">&#xE84F;</i>
          </div>
          <div class="md-layout-item md-size-70 name--padding">
            <p class="md-headline mdl-typography--text-center">
              {{hoveredAddress}}
            </p>
            <p class="md-body-1 mdl-typography--text-center">
              Click to show info!
            </p>
          </div>
        </div>
      </div>
      <md-button class="md-fab md-primary btn-position"
                  @click="viewSearch">
        <md-icon>search</md-icon>
         <md-tooltip md-direction="left">Barangay Search</md-tooltip>
      </md-button>
      <md-field md-inline class="md-textsearch" v-if="isVisible">
        <label>Search for a barangay..</label>
        <md-input v-model="typeLocation" 
                  class="md-input--margin"
                  @keyup="searchMunicipality"></md-input>
        <div class="results">
          <md-list v-for="matchWord in matchWords"
                  :key="matchWord">
            <md-list-item @click="getValue(matchWord)">
              <span>{{matchWord}}</span>
            </md-list-item>
          </md-list>
        </div>
      </md-field>
        <gmap-map :center="center"
                  :zoom="zoom"
                  map-type-id="terrain"
                  map-style="green"
                  :style="style">   
                <gmap-marker
                  :position="position"
                  :clickable="true"
                  :draggable="true"
                  @click="showInfo(position, location)">
                </gmap-marker>
                  <gmap-circle v-for="municipality in municipalities"
                              :key="municipality.coord.lat"
                              :center="{lat: parseFloat(municipality.coord.lat), lng: parseFloat(municipality.coord.lng)}"
                              :clickable="true"
                              :options="weatherSpots"
                              @click="showInfo(municipality.coord, municipality.name)"
                              @mouseover="showTooltip(municipality.name)"
                              @mouseout="isHover = false">
                  </gmap-circle>
    </gmap-map>
    <sweet-modal title="Weather Reports" ref="modal" :enable-mobile-fullscreen=false>
      <sweet-modal-tab title="Right Now!" id="tab1">
        <current-weather v-bind="{results, weather, location}"></current-weather>
      </sweet-modal-tab>
      <sweet-modal-tab title="Hourly" id="tab2">
         <chartjs-line  :datasets = "chartData.datasets"
                        :labels = "chartData.labels"
                        :beginzero ="chartData.config.boolean"
                        :bind="true"
                        :width="chartData.config.width"
                        :height="chartData.config.height"
                        :option="chartData.option"
                        style="chart--margin"/>
      </sweet-modal-tab>
      <sweet-modal-tab title="7 Day Forecast" id="tab3" >
            <everyday-weather v-bind="{results, weather}"></everyday-weather>
      </sweet-modal-tab>
    </sweet-modal>
    </div>
</div>
</template>

<script>
import municipalities from '../../json/municipality.list.json'
import CurrentWeather from './weather/CurrentWeather'
import EverydayWeather from './weather/EverydayWeather'
import moment from 'moment'
import barangays from './../../barangays'
export default {
  name: 'Dashboard',
  props: {
    results: {
      type: Object,
      default: () => {}
    },
    barangays: {
      type: Array
    }
  },
  data() {
    return {
      isAdmin: false,
      isNotAdmin: true,
      objectItem: null,
      weatherSpots: {
        strokeColor: '#009688',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#009688',
        fillOpacity: 0.35
      },
      position: null,
      typeLocation: '',
      isHover: false,
      isVisible: false,
      selectedBarangay: null,
      weather: [],
      hourly: [],
      matchWords: [],
      location: '',
      hoveredAddress: '',
      adminUser: document.getElementById('municipalOffice').textContent,
      url: 'https://api.darksky.net/forecast',
      apiKeys: {
        darkSky: 'your api key',
        google: 'your key'
      },
      municipalities: municipalities,
      center: {
        lat: 14.796128,
        lng: 120.877419
      },
      zoom: 11,
      style: {
        width: '100%',
        height: '100vh',
        'max-height': '100vh'
      },
      chartData: {
        labels: [],
        datasets: [
          {
            label: 'Temperature',
            data: [],
            backgroundColor: ['rgba(255, 99, 132, 0.2)'],
            borderColor: ['rgba(255,99,132,1)'],
            borderWidth: 1
          },
          {
            label: 'Humidity',
            data: [],
            backgroundColor: ['rgba(54, 162, 235, 0.2)'],
            borderColor: ['rgba(54, 162, 235, 1)'],
            borderWidth: 1
          },
          {
            label: 'Precipitation',
            data: [],
            backgroundColor: ['rgba(0, 137, 123, 0.2)'],
            borderColor: ['rgba(0, 137, 123, 1)'],
            borderWidth: 1
          }
        ],
        config: {
          width: 650,
          height: 400,
          boolean: true
        },
        option: {
          tooltips: {
            titleFontSize: 20,
            bodyFontSize: 20
          }
        }
      }
    }
  },
  methods: {
    showTooltip(name) {
      this.isHover = true
      this.hoveredAddress = name
    },
    getValue(value) {
      this.location = this.typeLocation = value
      this.geocodeIt(this.typeLocation)
      this.typeLocation = ''
      this.matchWords = []
    },
    showInfo(coord, name) {
      this.location = name
      this.getWeatherResults(coord.lat, coord.lng)
      this.$refs.modal.open()
    },
    getWeatherResults(lat, lng) {
      this.$http
        .jsonp(`${this.url}/${this.apiKeys.darkSky}/${lat},${lng}?units=ca`, {
          headers: {
            'Access-Control-Allow-Origin': '*',
            'Accept-Encoding': 'gzip'
          }
        })
        .then(response => {
          this.weather.push(response.data)
          const hourReports = this.weather[this.weather.length - 1].hourly.data
          this.getHourlyResults(hourReports)
        })
    },
    getHourlyResults(x) {
      x.map(result => {
        const hourlyWeather = moment.unix(result.time)
        this.chartData.labels.push(hourlyWeather.format('LLL'))
        this.chartData.datasets[0].data.push(result.temperature)
        this.chartData.datasets[1].data.push(result.humidity)
        this.chartData.datasets[2].data.push(result.precipProbability)
      })
    },
    viewSearch() {
      if (this.isVisible == false) {
        this.isVisible = true
      } else {
        this.isVisible = false
      }
    },
    checkAuth() {
      if (this.adminUser == 'Administrator' || this.adminUser == 'Bulacan') {
        this.isAdmin = true
        this.isNotAdmin = false
      } else {
        this.isAdmin = false
        this.isNotAdmin = true
      }
    },
    searchMunicipality(e) {
      this.autoComplete()
    },
    autoComplete() {
      this.matchWords = []
      for (let index = 0; index < this.barangays.length; index++) {
        if (
          this.barangays[index].match(this.typeLocation) ||
          this.barangays[index].match(
            this.typeLocation.charAt(0).toUpperCase() +
              this.typeLocation.slice(1)
          )
        ) {
          if (this.typeLocation.length !== 0) {
            this.matchWords.push(this.barangays[index])
          } else {
            this.matchWords = []
          }
        }
      }
    },
    geocodeIt(place) {
      if (this.typeLocation.length !== 0) {
        this.$http
          .get(
            `https://maps.googleapis.com/maps/api/geocode/json?address=${place}&key=${
              this.apiKeys.google
            }`
          )
          .then(response => {
            const geoCoordinates = response.data.results[0].geometry.location
            this.position = geoCoordinates
            //this.location = response.data.results[0].formatted_address;
          })
          .catch(error => {
            console.log(error)
          })
      }
    }
  },
  components: {
    'current-weather': CurrentWeather,
    'everyday-weather': EverydayWeather
  },
  computed: {},
  created() {},
  mounted() {
    this.checkAuth()
  },
  watch: {}
}
</script>

<style>
.map-size {
  width: 100%;
  height: 100%;
}

.chart--margin {
  margin: 0 auto;
}

.btn-position {
  position: absolute;
  right: 0;
}

.md-textsearch {
  position: absolute;
  z-index: 10;
  width: 300px;
  right: 0;
  margin-right: 6%;
  background-color: white;
}

.md-input--margin {
  margin-bottom: 14px;
}
.results {
  position: absolute;
  top: 60px;
  width: 300px;
  max-height: 200px;
  overflow: auto;
}

.custom-tooltip {
  position: absolute;
  z-index: 100;
  width: 350px;
  height: 100px;
  background-color: #f5f5f5;
  right: 0;
  bottom: 80px;
}

.icon--padding {
  font-size: 4em;
  padding: 22px;
}

.name--padding {
  padding: 10px;
}
</style>
