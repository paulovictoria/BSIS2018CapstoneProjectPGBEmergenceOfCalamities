import Vue from 'vue'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css' // This line here
import 'material-design-lite/material.min.css';
import 'material-design-lite/material.js';
import './mdl-ext.min.js';
import '../sass/mdl-ext.min.css';
import './bootstrap';
import municipalities from './json/municipality.list.json';

Vue.use(VueMaterial);

const login = new Vue({
  el: '#app',
  data: {
    municipalities: municipalities
  }
});