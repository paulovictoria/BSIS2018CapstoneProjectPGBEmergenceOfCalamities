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
	<div class="body-padding" v-if="isAdmin">
		<md-progress-bar md-mode="indeterminate" v-if="isLoading" height="50px"/>
		<p class="md-headline" v-if="isLoading">
			Loading Data....
		</p>
		<div class="mdl-grid" v-if="showObject">
			<p style="display:none;">Time check: {{datenow}}</p>
			<div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
				<div class="mdl-grid no-grid">
					<div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone mdl-color--white md-elevation-1">	
						<div class="mdl-center">
								<radial-progress-bar :diameter="150"
												:completed-steps="2"
												:total-steps="circle.totalSteps"
												:startColor="circle.startColor"
												:stopColor="circle.stopColor"
												:strokeWidth="circle.strokeWidth">
									<p class="md-headline md-radial-font--size">{{tideHeights[0]}}</p>	
								</radial-progress-bar>
						</div>
						<p class="mdl-typography--text-center md-headline">{{tideTypes[0]}} TIDE</p>
						<p class="mdl-typography--text-center md-caption">*in Meters</p>
						<p class="mdl-typography--text-center md-headline">Time: {{tideTime[0]}}</p>
					</div>
					<!--next-->
					<div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone mdl-color--white md-elevation-1">	
							<div class="mdl-center">
								<radial-progress-bar :diameter="150"
												:completed-steps="3"
												:total-steps="circle.totalSteps"
												:startColor="circle.startColor"
												:stopColor="circle.stopColor"
												:strokeWidth="circle.strokeWidth">
									<p class="md-headline md-radial-font--size">{{tideHeights[1]}}</p>	
								</radial-progress-bar>
						</div>
						<p class="mdl-typography--text-center md-headline">{{tideTypes[1]}} TIDE</p>
						<p class="mdl-typography--text-center md-caption">*in Meters</p>
						<p class="mdl-typography--text-center md-headline">Time: {{tideTime[1]}}</p>
					</div>
				</div>
			</div>
			<!--divide-->
			<div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--8-col-tablet mdl-cell--12-col-phone md-xsmall-hide ">
				<h4 class="mdl-typography--text-center md-headline">Tide Monitoring</h4>
				<div class="date-picker-holder">
					<md-button class="md-fab md-primary"
										@click="openDatePicker">
						<md-icon>&#xE916;</md-icon>
            <md-tooltip md-direction="left">Show Timeline</md-tooltip>
					</md-button>
				</div>
          <md-datepicker v-model="selectedDate" 
                          :md-open-on-focus="false"
                          class="date-picker--small"
                          :md-override-native = "override"
                          v-if="hasClicked">
            <button class="search-btn mdl-button mdl-js-button mdl-button--raised mdl-button--colored"
                    @click="tideHistory(newDate)">
              Search
            </button>
          </md-datepicker>
				<chartjs-line :beginzero="boolean"
											:datasets="lineChart.mydatasets"
											:labels="lineChart.mylabels"
											:option="lineChart.myoption"
											:bind="true"/>
				<div class="mdl-grid">
					<div class="mdl-cell">
						<!-- <p class="">Legend:</p> -->
					</div>
				</div>							
			</div>
			<sweet-modal ref="tideHistory" 
                    v-if="modalHere" 
                    :icon="warning"
                    :enable-mobile-fullscreen=false>
        <div class="md-layout md-gutter md-alignment-center-center"
            v-if="hasTideError">
            <p class="mdl-typography--text-center md-headline">
							Error: No data found!
						</p>
        </div>
				<div class="md-layout md-gutter md-alignment-center-center" 
              v-if="hasTideHistory">
					<div class="md-layout-item md-size-50">
						<p class="mdl-typography--text-center md-headline">
							{{pastTideType[pastTideType.length - 1]}} TIDE REPORT
						</p>
						<h2 class="mdl-typography--text-center md-display-2">
							<i class="material-icons modal-icon">&#xE8E5;</i>
							{{pastTideHeight[pastTideHeight.length - 1]}} M
						</h2>
						<p class="mdl-typography--text-center md-headline">
						Last {{convertTime(pastTideTime[pastTideTime.length - 1])}}
						</p>
					</div>
					<div class="md-layout-item md-size-50">
						<p class="mdl-typography--text-center md-headline">
							{{pastTideType[pastTideType.length - 2]}} TIDE REPORT
						</p>
						<h2 class="mdl-typography--text-center md-display-2">
							<i class="material-icons modal-icon">&#xE8E3;</i>
							{{pastTideHeight[pastTideHeight.length - 2]}} M
						</h2>
						<p class="mdl-typography--text-center md-headline">
						Last {{convertTime(pastTideTime[pastTideTime.length - 2])}}
						</p>
					</div>
				</div>
			</sweet-modal>
			<sweet-modal ref="warn" :enable-mobile-fullscreen=false>
				<audio controls style="display:none;" id="audio" ref="audio">
					<source :src="source" type="audio/mp3">      
				</audio> 
				<div class="md-layout">
					<div class="md-layout-item">
						<p class="md-display-1"><i class="material-icons">&#xE002;</i>WARNING!</p>
						<p class="md-title">Municipalities near coastal areas are advised to stay alert!</p>
						<div class="md-layout">
							<div class="md-layout-item md-large-size-50">
																	<div class="md-title">Affected Areas:</div>
									<div class="md-subheading">Calumpit</div>
																	<div class="md-subheading">Hagonoy</div>
																	<div class="md-subheading">City of Malolos</div>
																	<div class="md-subheading">Paombong</div>
																	<div class="md-subheading">Bulacan</div>
																	<div class="md-subheading">Bocaue</div>
																	<div class="md-subheading">Marilao</div>
																	<div class="md-subheading">Meycauayan</div>
																	<div class="md-subheading">Obando</div>
		</div>
							<div class="md-layout-item md-large-size-50">
								<p class="md-headline">
									{{tideTypes[0]}} TIDE:
								</p>
								<p class="md-title">
									Height: {{tideHeights[0]}} M 
								</p>
								<p class="md-title">
									Time: {{tideTime[0]}} 
								</p>
								<p class="md-headline">
									{{tideTypes[1]}} TIDE:
								</p>
								<p class="md-title">
									Height: {{tideHeights[1]}} M 
								</p>
								<p class="md-title">
									Time:  {{tideTime[1]}}
								</p>
							</div>
						</div>
					</div>
				</div>
			</sweet-modal>
		</div>
	</div>
</div>
</template>

<script>
import RadialProgressBar from 'vue-radial-progress'
import moment from 'moment'
export default {
  name: 'Tides',
  props: {},
  data() {
    return {
      circle: {
        strokeWidth: 20,
        startColor: '#448aff',
        stopColor: '#5e99fb',
        completedSteps: 2,
        totalSteps: 5
      },
      isAdmin: false,
      isNotAdmin: true,
      showObject: false,
      isLoading: true,
      parsedItem: '',
      selectedDate: null,
      boolean: true,
      adminUser: document.getElementById('municipalOffice').textContent,
      apiKeys: {
        wwo: ' your key'
      },
      source: 'sounds/panic_sound.mp3',
      datenow: '',
      tideTime: [],
      tideTypes: [],
      timeSeries: [],
      tideHeights: [],
      requestedDate: [],
      modalHere: true,
      hasClicked: false,
      override: false,
      autoplay: false,
      loop: false,
      pastTideType: [],
      pastTideHeight: [],
      pastTideTime: [],
      newDate: '',
      hasTideHistory: true,
      hasTideError: false,
      warning: 'warning',
      lineChart: {
        mylabels: [],
        mydatasets: [
          {
            label: 'Tide Updates',
            backgroundColor: ['rgba(255, 3, 132, 0.2)'],
            borderColor: ['rgba(255,3,132,1)'],
            borderWidth: 1,
            data: []
          }
        ],
        myoption: {
          responsive: true,
          maintainAspectRatio: true,
          title: {
            display: true,
            position: 'bottom',
            text: 'Source: NAMRIA'
          },
          tooltips: {
            titleFontSize: 20,
            bodyFontSize: 20
          },
          scales: {
            yAxes: [
              {
                display: true,
                ticks: {
                  beginAtZero: true,
                  fontSize: 20
                }
              }
            ],
            xAxes: [
              {
                display: true,
                ticks: {
                  fontSize: 15
                }
              }
            ]
          }
        }
      }
    }
  },
  methods: {
    convertTime(value) {
      return moment(value).format('MMMM Do YYYY, h:mm a')
    },
    checkAuth() {
      if (this.adminUser == 'Administrator' || this.adminUser == 'Bulacan') {
        this.isAdmin = true
        this.isNotAdmin = false
        this.getTideUpdate()
        this.saveLocaleTime()
        document.onreadystatechange = () => {
          if (document.readyState === 'complete') {
            this.isLoading = false
            this.showObject = true
          }
        }
      } else {
        this.isAdmin = false
        this.isNotAdmin = true
      }
    },
    getTideUpdate() {
      this.$http
        .jsonp(
          `https://api.worldweatheronline.com/premium/v1/marine.ashx?key=${
            this.apiKeys.wwo
          }&q=14.683333,120.933333&tide=yes&format=json`
        )
        .then(
          response => {
            this.isLoading = false
            this.showObject = true
            this.lineChart.mylabels = []
            this.lineChart.mydatasets[0].data = []
            const weather = response.data.data.weather
            weather.forEach(result => {
              result.tides[0].tide_data.forEach(element => {
                this.tideTime.push(element.tideTime)
                this.tideTypes.push(element.tide_type)
                this.timeSeries.push(element.tideDateTime)
                this.tideHeights.push(element.tideHeight_mt)
                this.lineChart.mylabels.push(element.tideDateTime)
                this.lineChart.mydatasets[0].data.push(element.tideHeight_mt)
              })
            })
          },
          response => {}
        )
    },
    tideHistory(date) {
      if (this.newDate !== '') {
        this.$http
          .jsonp(
            `https://api.worldweatheronline.com/premium/v1/past-marine.ashx?key=${
              this.apiKeys.wwo
            }&q=14.683333,120.933333&date=${date}&tide=yes&format=json`
          )
          .then(response => {
            this.$refs.tideHistory.open()
            if (response.data.data.weather == undefined) {
              this.hasTideHistory = false
              this.hasTideError = true
              this.warning = 'warning'
            } else {
              this.warning = ''
              this.hasTideHistory = true
              this.hasTideError = false
              response.data.data.weather[0].tides[0].tide_data.forEach(
                result => {
                  this.pastTideType.push(result.tide_type)
                  this.pastTideHeight.push(result.tideHeight_mt)
                  this.pastTideTime.push(result.tideDateTime)
                }
              )
            }
          })
          .catch(error => {
            this.$refs.tideHistory.open()
            this.hasTideError = true
            this.hasTideHistory = false
          })
      }
    },
    openDatePicker() {
      if (this.hasClicked == false) {
        this.hasClicked = true
        this.override = false
        this.newDate = ''
      } else {
        this.hasClicked = false
        this.override = true
        this.newDate = ''
      }
    },
    saveLocaleTime() {
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
      this.parsedItem = JSON.parse(itemed)
    },
    time() {
      this.datenow = moment().format('h:mm:ss A')
      if (this.parsedItem.includes(this.datenow)) {
        this.$refs.audio.play()
        this.$refs.warn.open()
        this.getTideUpdate()
      }
    }
  },
  created() {},
  mounted() {
    this.checkAuth()
    this.interval = setInterval(this.time, 1000)
  },
  beforeDestroy() {
    clearInterval(this.interval)
  },
  components: {},
  watch: {
    selectedDate() {
      const dateObj = new Date(this.selectedDate)
      const momentObj = moment(dateObj)
      const momentString = momentObj.format('YYYY-MM-DD')
      this.newDate = momentString
    }
  },
  components: {
    RadialProgressBar
  }
}
</script>

<style lang="scss" scoped>
.tide-caption {
  font-size: 1.6em;
  padding-left: 10px;
}

.tide-report--padding {
  padding: 20px;
}

.size {
  font-size: 2em;
}

.date-picker-holder {
  width: 70px;
  max-width: 100%;
  position: absolute;
  right: 0;
  top: 10px;
}

.date-picker--small {
  width: 320px;
  right: 5%;
  position: absolute;
  z-index: 20;
  background-color: white;
  border-radius: 10px;
  margin-top: 15px;
  padding: 5px;
  top: 10px;
}

.mdl-icons {
  font-size: 45px !important;
  margin-right: 15px;
}

.mdl-center {
  display: flex;
  width: 230px;
  margin: 0 auto;
}

.no-grid {
  padding: 0px;
}

.md-radial-font--size {
  font-size: 33px;
  margin-top: 10px;
}

.modal-icon {
  font-size: 1em;
}
</style>