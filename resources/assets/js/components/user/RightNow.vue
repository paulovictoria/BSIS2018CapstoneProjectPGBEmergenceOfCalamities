<template>
  <div class="main-component">
    <h3 class="mdl-typography--text-center mdl-color-text--white">Current Weather Report</h3>
    <div class="custom-margin mdl-grid">
      <!--card-->
      <div class="right-now mdl-cell mdl-cell--6-col-desktop mdl-cell--6-col-tablet mdl-cell--12-col-phone mdl-shadow--16dp mdl-color--white box-margin hvr-float">
        <p class="right-now__caption mdl-typography--text-center">Right Now!</p>
        <!-- Select with arrow-->
        <div class="full-select">
          <div class="mdlext-selectfield mdlext-js-selectfield mdlext-selectfield--floating-label">
            <select
              id="municipality"
              class="mdlext-selectfield__select"
              name="municipality"
              @change="selectMunicipality">
              <option value=""></option>
              <option v-for="municipality in municipalities" 
                      :value="municipality.formed" :key="municipality.name" selected>{{municipality.name}}</option>
            </select>
            <label for="municipality" class="mdlext-selectfield__label">Municipality</label>
          </div>
        </div>
        <!-- End Select with arrow-->
        <p class="place-to-be mdl-typography--text-center">{{forecast.description}}</p>
        <div class="mdl-image__responsive">
          <img 
            :src="`images/${forecast.icon}.png`"
            class="mdl-typography--text-center">
        </div>
        <h2 class="mdl-typography--text-center">
          {{forecast.temp}}<span>&#176;</span>C
        </h2>
        <p class="mdl-typography--text-center mdl-typography--caption">
          Powered by: <a href="https://darksky.net/poweredby" class="link-color">Darksky</a> and <a href="http://noah.up.edu.ph" class="link-color">NOAH</a>
        </p>
      </div>
      <div class="right-now mdl-cell mdl-cell--6-col-desktop mdl-cell--6-col-tablet mdl-cell--12-col-phone mdl-shadow--16dp mdl-color--white box-margin hvr-float">
        <!--grid-->
        <div class="mdl-grid">
          <div class="mdl-image__responsive-small">
            <img :src="results.imgsrc.humid">
          </div>
          <div class="right-block">
            <h2 class="mdl-typography--text-right">{{forecast.humidity}}<span>%</span></h2>
            <p class="mdl-typography--text-label mdl-typography--text-right">
              Humidity
            </p>
          </div>
        </div>
        <!--end grid-->
        <!--grid-->
        <div class="mdl-grid">
          <div class="mdl-image__responsive-small">
            <img :src="results.imgsrc.wind">
          </div>
          <div class="right-block">
            <h2 class="mdl-typography--text-right">{{forecast.wind.speed}}</h2>
              <h4 class="mdl-typography--text-right">kph</h4>
            <p class="mdl-typography--text-label mdl-typography--text-right">
              Wind Speed
            </p>
          </div>
        </div>
        <!--end grid-->
        <p class="mdl-typography--text-center mdl-typography--caption">
          Powered by: <a href="https://darksky.net/poweredby" class="link-color">Darksky</a> and <a href="http://noah.up.edu.ph" class="link-color">NOAH</a>
        </p>
      </div>
    </div>
    <!--card-->
    <div class="five-day--forecast mdl-grid mdl-grid--no-spacing">
      <!--weather bullet-->
      <div class="weather-bullet mdl-cell mdl-cell--2-col-desktop mdl-cell--4-col-tablet mdl-cell--12-col-phone hvr-float" 
            v-for="daily in forecast.dailyWeather.slice(0, 6)"
            :key="daily.date">
        <p class="mdl-typography--headline mdl-typography--text-center">
          {{daily.date}}
        </p>
        <div class="mdl-image__responsive">
          <img :src="`images/${daily.info}.png`">
        </div>
        <p class="mdl-typography--headline mdl-typography--text-center">
          {{daily.temp}}<span>&#176;</span>C
        </p>
        <p class="mdl-typography--subhead mdl-typography--text-center capitalize">
          {{daily.info.replace(/-/g, " ")}}
        </p>
      </div>
     </div>
			<div class="five-day--forecast mdl-grid mdl-grid--no-spacing">
				 <h4 class="margin-auto mdl-typography--text-center">
					 7-day Forecast
				 </h4>
			</div>
			<div class="five-day--forecast mdl-grid mdl-grid--no-spacing space">
				 <p class="margin-auto mdl-typography--text-caption">
					Powered by: <a href="https://darksky.net/poweredby" class="link-color">Darksky</a> and <a href="http://noah.up.edu.ph" class="link-color">NOAH</a>
				 </p>
			</div>
			<!--grid-->
			<div class="mdl-grid">
				<!--left-->
				<div class="right-now mdl-cell mdl-cell--6-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone mdl-shadow--16dp mdl-color--white box-margin hvr-float">
					<h4 class="mdl-typography--text-center">
						Sunrise / Sunset
					</h4>
					<div class="margin-auto mdl-cell mdl-cell--6-col">
						<div class="mdl-image__responsive">
							<img :src="results.imgsrc.sunrise">
							<p class="mdl-typography--title mdl-typography--text-center">
								{{forecast.sunrise}}
							</p>
						</div>
					</div>
					<div class="margin-auto mdl-cell mdl-cell--6-col">
						<div class="mdl-image__responsive">
							<img :src="results.imgsrc.sunset">
							<p class="mdl-typography--title mdl-typography--text-center">
                                {{forecast.sunset}}
							</p>
						</div>
					</div>
                    <p class="mdl-typography--text-center mdl-typography--caption">
                        Powered by: <a href="https://darksky.net/poweredby" class="link-color">Darksky</a> and <a href="http://noah.up.edu.ph" class="link-color">NOAH</a> 
                    </p>
				</div>
				<!--right-->
				<div class="right-now mdl-cell mdl-cell--6-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone mdl-shadow--16dp mdl-color--white box-margin hvr-float">
					<h4 class="mdl-typography--text-center">
						Tide Schedule
					</h4>
          <div class="mdl-grid">
              <div class="mdl-image__responsive-small">
                <img :src="results.imgsrc.lowtide">
              </div>
              <div class="right-block">
                <h2 class="mdl-typography--text-right">{{newTideUpdates.low.amount}} M</h2>
                <p class="mdl-typography--text-label mdl-typography--text-right">
                 Low Tide : {{newTideUpdates.low.time}}
                </p>
              </div>
          </div>
					<div class="mdl-grid">
              <div class="mdl-image__responsive-small">
                <img :src="results.imgsrc.hightide">
              </div>
              <div class="right-block">
                <h2 class="mdl-typography--text-right">{{newTideUpdates.high.amount}} M</h2>
                <p class="mdl-typography--text-label mdl-typography--text-right">
                 High Tide : {{newTideUpdates.high.time}}
                </p>
              </div>
          </div>
          <p class="mdl-typography--text-center mdl-typography--caption">
            Powered by: <a href="http://www.namria.gov.ph/" class="link-color">NAMRIA</a>
          </p>
				</div>
			</div>
			<!--grid-->
			<div class="five-day--forecast mdl-grid">
				<!--left-->
				<!--right-->
				<div class="margin-auto mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-table mdl-cell--12-col-phone">
					<div class="mdl-image__responsive">
					<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
     width="100" height="100"
     viewBox="0 0 252 252"
     style=";fill:#000000de;"
     class="icon icons8-wi-fi"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,252v-252h252v252z" fill="none"></path><g fill="#000000"><g id="surface1"><path d="M141.75,210c0,8.69531 -7.05469,15.75 -15.75,15.75c-8.69531,0 -15.75,-7.05469 -15.75,-15.75c0,-8.69531 7.05469,-15.75 15.75,-15.75c8.69531,0 15.75,7.05469 15.75,15.75z"></path><path d="M10.5,99.2168l18.6416,18.6416c53.95606,-52.02832 139.76074,-52.02832 193.7168,0l18.6416,-18.6416c-64.25098,-62.30274 -166.74902,-62.30274 -231,0z"></path><path d="M44.05078,132.76758l18.68262,18.70313c35.45801,-33.50977 91.0957,-33.50977 126.55371,0l18.68261,-18.70312c-45.77344,-43.78418 -118.16601,-43.78418 -163.91894,0z"></path><path d="M77.64258,166.37988l18.6416,18.64161c16.89844,-15.05274 42.5332,-15.03223 59.45215,0l18.62109,-18.64161c-27.23437,-25.30664 -69.50098,-25.28613 -96.71484,0z"></path></g></g></g></svg>
					</div>
					<h4 class="mdl-typography--text-center">
						Be Updated to the latest 
					</h4>
					<h4 class="mdl-typography--text-center">
						 weather report in our province!
					</h4>
					<p class="mdl-typography--text-center">
						Open with your computer, laptop, tablet or even phone.
					</p>
				</div>
			</div>
  </div>
</template>

<script>
import bulacan from '../../json/index.json'
import moment from 'moment'

export default {
  props: {
    results: {
      type: Object
    }
  },
  data() {
    return {
      newTideUpdates: {
        high: {
          amount: '',
          time: ''
        },
        low: {
          amount: '',
          time: ''
        }
      },
      municipalities: bulacan,
      apiKeys: {
        darkSky: 'your key'
      },
      currentTime: moment().format('MMMM DD YYYY, h:mm:ss a'),
      forecast: {
        icon: '',
        humidity: '',
        wind: {
          speed: '',
          degree: ''
        },
        temp: '',
        description: '',
        sunrise: '',
        sunset: '',
        dailyWeather: [],
        damUpdates: {
          angat: {
            amount: '',
            time: ''
          },
          ipo: {
            amount: '',
            time: ''
          },
          bustos: {
            amount: '',
            time: ''
          }
        },
        highTides: {
          amount: '',
          time: ''
        },
        lowTides: {
          amount: '',
          time: ''
        }
      }
    }
  },
  methods: {
    selectMunicipality() {
      this.forecast.dailyWeather = []
      const select = document.getElementById('municipality')
      const strUser = select.options[select.selectedIndex].value
      this.$http
        .jsonp(
          `https://api.darksky.net/forecast/${
            this.apiKeys.darkSky
          }/${strUser}?units=ca`
        )
        .then(response => {
          const daily = response.data
          const sunriseUnix = moment
            .unix(daily.daily.data[0].sunriseTime)
            .format('LT')
          const sunsetUnix = moment
            .unix(daily.daily.data[0].sunsetTime)
            .format('LT')
          this.forecast.sunrise = sunriseUnix
          this.forecast.sunset = sunsetUnix
          this.forecast.temp = daily.currently.temperature
          this.forecast.humidity = daily.currently.humidity
          this.forecast.wind.speed = daily.currently.windSpeed
          this.forecast.description = daily.currently.summary
          this.forecast.icon = daily.currently.icon
          const timeSeriesData = daily.daily.data
          for (let index = 1; index < timeSeriesData.length; index++) {
            const element = timeSeriesData[index]
            const timeUnix = moment.unix(element.time)
            const formattedDate = timeUnix.format('ddd')
            this.forecast.dailyWeather.push({
              temp: element.temperatureMin,
              date: formattedDate,
              info: element.icon
            })
          }
        })
        .catch(error => {
          console.log(error)
        })
    },
    getTideUpdates() {
      this.$http.get('/tides/latest').then(response => {
        this.newTideUpdates.high.amount = response.data[0].tideHeight_mt
        this.newTideUpdates.high.time = response.data[0].tideTime
        this.newTideUpdates.low.amount = response.data[1].tideHeight_mt
        this.newTideUpdates.low.time = response.data[1].tideTime
      })
    }
  },
  mounted() {
    this.selectMunicipality()
    this.getTideUpdates()
  }
}
</script>

<style scoped>
html,
body {
  font-family: 'Noto Sans', sans-serif;
  overflow: hidden;
}
.right-now {
  padding-left: 10px;
  padding-right: 10px;
  margin: 0 auto;
  width: 340px;
}

.place-to-be {
  font-size: 1.5em;
}

.right-now__caption {
  font-size: 2em;
  margin: 15px;
}

.mdl-image__responsive {
  margin: 0 auto;
  width: 102px;
}

.full-select {
  width: 125px;
  margin: 0 auto;
}
.mdl-typography--text-label {
  font-size: 1.3em;
}
.right-block {
  width: 200px;
}

.five-day--forecast {
  background-color: #fafafa;
}

.custom-margin {
  margin-bottom: 10px;
}

.margin-auto {
  margin: 0 auto;
}
.weather-bullet {
  padding-top: 10px;
}
.mdl-table__responsive {
  margin: 0 auto;
  width: 100%;
  overflow-y: hidden;
}

.custom-table {
  width: 100%;
  max-width: 100%;
}

.link-color {
  color: black;
  text-decoration: none;
}
.capitalize {
  text-transform: capitalize;
}

.box-margin {
  margin-top: 20px;
  margin-bottom: 20px;
}

.space {
  padding-bottom: 10px;
}
/*media query */
@media all and (max-width: 320px) {
  .right-block {
    width: 162px;
  }
}
</style>

