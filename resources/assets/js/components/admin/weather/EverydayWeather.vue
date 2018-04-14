<template>
<md-steppers md-vertical>
  <md-step :id="convertTime(day.time, 'll')" 
          :md-label="convertTime(day.time, 'dddd')" 
          v-for="day in weather[weather.length - 1].daily.data"
          :key="day.time">
    <div class="md-layout md-layout-item">
      <div class="md-layout-item md-size-50">
        <div class="mdl-typography--headline">
          {{convertTime(day.time, 'll')}}
        </div>
        <div class="mdl-typography--subhead">
          {{day.summary}}
        </div>
        <div class="md-layout">
          <div class="mdl-image__holder">
            <img :src="`images/${day.icon}.png`" class="mdl-image__responsive">
          </div>
          <span class="degree-amount mdl-typography--display-2-color-contrast">
            {{day.temperatureMax}}<span>&#176;</span>C
          </span>
        </div>
      </div>
      <div class="md-layout-item md-size-50">
        <p class="mdl-typography--subhead">
          Precipitation: {{day.precipProbability}}%
        </p>
        <p class="mdl-typography--subhead">
          Humidity: {{day.humidity}}%
        </p>
        <p class="mdl-typography--subhead">
          Wind: {{day.windSpeed}}mph
        </p>
        <p class="mdl-typography--subhead">
          Sunrise: {{convertTime(day.sunriseTime, 'LT')}}
        </p>
        <p class="mdl-typography--subhead">
          Sunset: {{convertTime(day.sunsetTime, 'LT')}}
        </p>
        <p class="mdl-typography--caption">
          Powered by: <a href="https://darksky.net/poweredby/" class="mdl-typography--caption mdl-color-text--black">DarkSky</a> & 
          <a href="http://noah.up.edu.ph/" class="mdl-typography--caption mdl-color-text--black">Project NOAH</a>
        </p> 
      </div>
    </div>
  </md-step>
</md-steppers>
</template>

<script>
import moment from "moment";
export default {
  name: "EverydayWeather",
  props: {
    results: {
      type: Object,
      default: () => {}
    },
    weather: {
      type: Array,
      default: () => []
    }
  },
  methods: {
    convertTime(time, format) {
      const unix = moment.unix(time);
      return unix.format(format);
    }
  }
};
</script>

<style lang="scss" scoped>
.mdl-image__holder {
  width: 96px;
  max-width: 100%;
  .mdl-image__responsive {
    display: block;
    max-width: 100%;
    height: auto;
  }
}
.degree-amount {
  padding-top: 8%;
  padding-bottom: 8%;
}
</style>