import Vue from "vue";
import VueMaterial from "vue-material";
import VueRouter from "vue-router";
import router from "./routes";
import VueResource from "vue-resource";
import SweetModal from "sweet-modal-vue/src/plugin.js";
import "material-design-lite/material.min.css";
import "material-design-lite/material.js";
import "vue-material/dist/vue-material.min.css";
import "vue-material/dist/theme/default.css";
import "./mdl-ext.min.js";
import "../sass/mdl-ext.min.css";

/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require("./bootstrap");
Vue.use(SweetModal);
Vue.use(VueRouter);
Vue.use(VueResource);
Vue.use(VueMaterial);
const theApp = new Vue({
  el: "#app",
  router,
  data: {
    results: {
      imgsrc: {
        sunny: "images/clear.png",
        temp: "images/temperature.png",
        humid: "images/wet.png",
        wind: "images/humid.png",
        lightning: "images/cloud-lightning.png",
        partly: "images/partly-cloudy.png",
        rain: "images/rain.png",
        storm: "image/storm.png",
        typhoon: "images/stormy.png",
        windy: "images/windy.png",
        sunrise: "images/sunrise.png",
        sunset: "images/sunset.png",
        hightide: "images/high-tide.png",
        lowtide: "images/low-tide.png",
        internet: "images/internet.png",
        wifi: "images/wifi.png"
      }
    }
  },
  methods: {},
  http: {
    root: "/",
    headers: {
      "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    }
  }
});
