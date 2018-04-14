<template>
  <div class="md-layout">
    <div class="md-layout-item md-size-50">
      <div class="mdl-typography--headline">
        {{location}}
      </div>
      <div class="mdl-typography--subhead">
        {{convertTime(weather[weather.length - 1].currently.time)}}
      </div>
      <div class="mdl-typography--subhead">
        {{weather[weather.length - 1].currently.summary}}
      </div>
      <div class="md-layout">
        <div class="mdl-image__holder">
          <img :src="`images/${weather[weather.length - 1].currently.icon}.png`" class="mdl-image__responsive">
        </div>
        <span class="degree-amount mdl-typography--display-2-color-contrast">
          {{weather[weather.length - 1].currently.temperature}}<span>&#176;</span>C
        </span>
      </div>
    </div>
    <div class="md-layout-item md-size-50">
      <p class="mdl-typography--subhead">
        Precipitation: {{weather[weather.length - 1].currently.precipProbability}}%
      </p>
      <p class="mdl-typography--subhead">
        Humidity:  {{weather[weather.length - 1].currently.humidity}}%
      </p>
      <p class="mdl-typography--subhead">
        Wind: {{weather[weather.length - 1].currently.windSpeed}}mph
      </p>
      <p class="mdl-typography--caption">
        Powered by: <a href="https://darksky.net/poweredby/" class="mdl-typography--caption mdl-color-text--black">DarkSky</a> & 
        <a href="http://noah.up.edu.ph/" class="mdl-typography--caption mdl-color-text--black">Project NOAH</a>
      </p>
      
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  name: "CurrentWeather",
  props: {
    results: {
      type: Object,
      default: () => {}
    },
    weather: {
      type: Array,
      default: () => []
    },
    location: {
      type: String,
      default: null
    }
  },
  data() {
    return {};
  },
  methods: {
    convertTime(time) {
      const unix = moment.unix(time);
      return unix.format("LLL");
    }
  },
  watch: {
    location() {
      return this.location;
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