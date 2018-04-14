<template>
<div class="final">
			<audio controls style="display:none;" id="audio" ref="newReport">
				<source :src="source.newReport" type="audio/wav">      
			</audio> 
  <div v-if="isMap">
    <div class="mdl-color--grey-50 legend">
        <p class="mdl-typography--text-center mdl-typography--subhead mdl-typography--font-bold padding">
          Legend:
        </p>
        <div class="legend-holder">
          <img src="images/undone.png">
          <p class="margin mdl-typography--font-bold">Undone</p>
        </div>
        <div class="legend-holder">
          <img src="images/ongoing.png">
          <p class="margin mdl-typography--font-bold">Ongoing</p>
        </div>
    </div>
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect grid-button mdl-color--white"
            @click="showReportView">
      Report view
    </button>
   <md-list class="md-triple-line report-tooltip md-elevation-1" v-if="tooltip">
      <md-list-item>
        <md-avatar>
          <i class="fas fa-map-marker-alt"></i>
        </md-avatar>
        <div class="md-list-item-text">
          <span>Incident Preview!</span>
          <span>{{hoverData.type}} Incident</span>
          <span>{{hoverData.name}}</span>
          <p>{{hoverData.address}}</p>
          <p>near {{hoverData.landmark}}</p>
          <p>{{timeAgo(hoverData.time)}}</p>
          <span>Click the circle to show all reports.</span>
        </div>
      </md-list-item>
    </md-list>
    <md-list class="md-triple-line report-tooltip" v-if="isRescueLocation">
      <md-list-item>
        <md-avatar>
          <i class="fas fa-map-marker-alt"></i>
        </md-avatar>
        <div class="md-list-item-text">
          <span>Rescuer Location:</span>
          <span>{{formattedAddress}}</span>
        </div>
      </md-list-item>
    </md-list>
    <gmap-map
      :center="gmap.center"
      :zoom="gmap.zoom"
      map-type-id="hybrid"
      style="width: 100%; height: 100vh"
      ref="map">

        <gmap-marker
          :key="notYet.created_at"
          v-for="notYet in undone.data"
          :position="notYet.coord"
          :clickable="true"
          :draggable="false"
          @click="checkPlots(notYet, 'Undone')"
          @mouseover="seeDetails(notYet)"
          @mouseout="tooltip = false"
          :icon="`images/undone.png`"/>
        <gmap-marker
          :key="recent.created_at"
          v-for="recent in ongoing.data"
          :position="recent.coord"
          :clickable="true"
          :draggable="false"
          @click="checkPlots(recent, 'OnGoing')"
          @mouseover="seeDetails(recent)"
          @mouseout="tooltip = false"
          :icon="`images/ongoing.png`"/>

            <gmap-polyline :draggable="false"
                            :editable="false"
                            :path="polyline"
                            :deepWatch="false"
                            @mouseover="showRescuerLocation(polyline[polyline.length - 1])"
                            @mouseout="isRescueLocation = false"
                            :options="polyOptions">

            </gmap-polyline>
      </gmap-map> 
    <sweet-modal ref="plots" :enable-mobile-fullscreen=false>
      <div class="mdl-typography--text-center mdl-typography--headline padding">Report List</div>
      <div class="mdl-grid">  
        <div class="mdl-cell mdl-cell--12-col mdl-shadow--4dp report-holder"
              v-for="query in queriedAddress"
              :key="query.id">
              <div><i class="fas fa-ambulance report-modal--icon"></i></div> 
              <div class="mdl-typography--headline">{{query.type}} Report</div>
              <div class="mdl-typography--body">{{query.fullName}}</div>
              <div class="mdl-typography--body">{{query.address}}</div>
              <div class="mdl-typography--body">near {{query.landmark}}</div>
              <div class="mdl-typography--body">{{timeAgo(query.reportedDate)}}</div>
              <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"
                      @click="showImage(query.image)">
                View Image
              </button>
        </div>
      </div>
    </sweet-modal>
    <sweet-modal ref="imageData">
      <div v-if="isMessage">
        <p class="mdl-typography--text-center">
          No image found!
        </p>
      </div>
      <div v-if="hasImage">
        <img :src="`storage/reports/${imageSrc}`">
        <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored margin-top"
                      @click="closeImage">
                Close
        </button>
      </div>
    </sweet-modal>
</div>
<!--grid-->
  <div class="report-content" v-if="isGrid">
    <div class="mdl-typography--text-center mdl-typography--headline">Today's Report</div>
    <div class="mdl-typography--text-center mdl-typography--headline">{{theTime}}</div>
      <md-speed-dial md-event="click" md-direction="bottom" class="fixed-btn">
        <md-speed-dial-target class="md-primary">
          <md-icon>&#xE869;</md-icon>
          <md-tooltip md-direction="left">Options</md-tooltip>
        </md-speed-dial-target>

        <md-speed-dial-content>
          <md-button class="md-icon-button" @click="showStats">
            <md-icon>&#xE01D;</md-icon>
            <md-tooltip md-direction="left">Data Charts</md-tooltip>
          </md-button>

          <md-button class="md-icon-button" @click="showReportView">
            <md-icon>&#xE55B;</md-icon>
            <md-tooltip md-direction="left">Map View</md-tooltip>
          </md-button>
        </md-speed-dial-content>
      </md-speed-dial>
      <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--12-col select--width">
          <md-field>
            <label for="status">Sort Status..</label>
            <md-select v-model="status" name="status" id="status" md-dense>
              <md-option value="OnGoing">On Going</md-option>
              <md-option value="Undone">Undone</md-option>
              <md-option value="Finished">Finished</md-option>
              <md-option value="Fraud">Fraud</md-option>
            </md-select>
          </md-field>
        </div>
    </div>
<!--grids-->
    <div class="mdl-grid notDone" v-if="notDone">
      <div class="mdl-cell mdl-cell--4-col mdl-shadow--4dp mdl-color--white" 
            v-for="report in allReports"
            :key="report.id">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--12-col">
              <i class="far fa-newspaper mdl-typography--text-center icon--font"></i>
              <div class="mdl-typography--text-center mdl-typography--display-1">
                {{report.type}} Report!
              </div>
              <div class="mdl-typography--text-center mdl-typography--body-1">
                {{timeAgo(report.reportedDate)}}
              </div>
              <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{report.fullName}}
               </div>
               <div class="mdl-typography--text-center mdl-typography--body-1">
                 {{report.address}} near {{report.landmark}}
               </div>
               <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{checkContacts(report.contactNumber, 'No Cellphone Number!')}}
               </div>
                <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{checkContacts(report.landline, 'No Landline number!')}}
               </div>
               <div>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"
                        @click="confirmModal(report.id, 'OnGoing')">
                  {{buttonMsg}} 
                </button>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent"
                        @click="showRoutes(adminLocation, report.address)">
                  View Routes
                </button>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent mdl-color--red-A700"
                        @click="confirmModal(report.id, 'Fraud')">
                  Fraud
                </button>
               </div>
            </div>
        </div>
      </div>
    </div>
    <!--ongoing-->
    <div class="mdl-grid onGoing" v-if="onGoing">
      <div class="mdl-cell mdl-cell--4-col mdl-shadow--4dp mdl-color--white" 
            v-for="report in allReports"
            :key="report.id">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--12-col">
              <i class="fas fa-spinner mdl-typography--text-center icon--font"></i>
              <div class="mdl-typography--text-center mdl-typography--display-1">
                {{report.type}} Report!
              </div>
              <div class="mdl-typography--text-center mdl-typography--body-1">
                {{timeAgo(report.respondTime)}}
              </div>
              <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{report.fullName}}
               </div>
               <div class="mdl-typography--text-center mdl-typography--body-1">
                 {{report.address}} near {{report.landmark}}
               </div>
               <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{checkContacts(report.contactNumber, 'No Cellphone Number!')}}
               </div>
                <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{checkContacts(report.landline, 'No Landline number!')}}
               </div>
               <div>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--green-500"
                        @click="confirmModal(report.id, 'Finished')">
                  Finish
                </button>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent"
                        @click="showRoutes(adminLocation, report.address)">
                  View Routes
                </button>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent mdl-color--red-A700"
                        @click="confirmModal(report.id, 'Fraud')">
                  Fraud
                </button>
               </div>
            </div>
        </div>
      </div>
    </div>
    <!--end-->
    <div class="mdl-grid finished" v-if="finished">
      <div class="mdl-cell mdl-cell--4-col mdl-shadow--4dp mdl-color--white" 
            v-for="report in allReports"
            :key="report.id">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--12-col">
              <i class="fas fa-clipboard-check mdl-typography--text-center icon--font"></i>
              <div class="mdl-typography--text-center mdl-typography--display-1">
                {{report.type}} Report!
              </div>
              <div class="mdl-typography--text-center mdl-typography--body-1">
                {{timeAgo(report.rescuedTime)}}
              </div>
              <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{report.fullName}}
               </div>
               <div class="mdl-typography--text-center mdl-typography--body-1">
                 {{report.address}} near {{report.landmark}}
               </div>
               <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{checkContacts(report.contactNumber, 'No Cellphone Number!')}}
               </div>
                <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{checkContacts(report.landline, 'No Landline number!')}}
               </div>
            </div>
        </div>
      </div>
    </div>
    <!--finished-->
    <!--grids-->
    <div class="mdl-grid fraud" v-if="fraud">
      <div class="mdl-cell mdl-cell--4-col mdl-shadow--4dp mdl-color--white" 
            v-for="report in allReports"
            :key="report.id">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--12-col">
              <i class="fas fa-exclamation-circle mdl-typography--text-center icon--font"></i>
              <div class="mdl-typography--text-center mdl-typography--display-1">
                {{report.type}} Report!
              </div>
              <div class="mdl-typography--text-center mdl-typography--body-1">
                {{timeAgo(report.reportedDate)}}
              </div>
              <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{report.fullName}}
               </div>
               <div class="mdl-typography--text-center mdl-typography--body-1">
                 {{report.address}} near {{report.landmark}}
               </div>
               <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{checkContacts(report.contactNumber, 'No Cellphone Number!')}}
               </div>
                <div class="mdl-typography--text-center mdl-typography--body-1">
                   {{checkContacts(report.landline, 'No Landline number!')}}
               </div>
               <div>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--red-500"
                        @click="confirmModal(report.id, 'Undone')">
                  False Positive
                </button>
               </div>
            </div>
        </div>
      </div>
    </div>
    <!--grid-->
    <div class="mdl-grid">
      <div class="mdl-cell mdl-cell--12-col">
        <pagination :data="laravelData" v-on:pagination-change-page="getReports">
            <span slot="prev-nav">&lt; Previous</span>
            <span slot="next-nav">Next &gt;</span>
        </pagination>
      </div>
    </div>
  <sweet-modal ref="routes" :enable-mobile-fullscreen=false>
    <md-progress-spinner md-mode="indeterminate" v-if="isLoad"></md-progress-spinner>
      <md-list v-show="hasResults">
            <p class="md-headline">Suggested Directions:</p>
            <p class="md-body-1">via Google Maps</p>
            <md-list-item v-for="routeData in routesData"
                          :key="routeData.direction">
              <md-icon class="md-primary">&#xE52E;</md-icon>
              <div class="md-list-item-text">
                <span>{{routeData.direction}}</span>
              </div>
            </md-list-item>
      </md-list>
  </sweet-modal>
  <sweet-modal ref="stats" 
              :enable-mobile-fullscreen=false
              @open="hideSelect">
      <div class="mdl-grid no-blur">
        <div class="mdl-cell mdl-cell--12-col no-margin">
          <p class="mdl-typography--text-center mdl-typography--headline">
                Incident Analysis
          </p>
          <div class="form-padding">
            <md-datepicker v-model="selectedDate" 
                          class="md-width">
              <label>Select Date From:</label>
            </md-datepicker> 
            <md-field class="no-margin md-width">
              <label for="incidentType">Incident Type:</label>
              <md-select v-model="incidentType" name="incidentType" id="incidentType" md-dense>
                <md-option value="Fire">Fire</md-option>
                <md-option value="Emergency">Emergency</md-option>
                <md-option value="Rescue">Rescue</md-option>
                <md-option value="Landslide">Landslide</md-option>
                <md-option value="Accident">Accident</md-option>
                <md-option value="Weather">Weather</md-option>
              </md-select>
            </md-field>
            <md-field class="no-margin md-width" 
                      v-if="isAnAdmin">
              <label for="municipality">Municipality</label>
              <md-select v-model="municipality" name="municipality" id="municipality" md-dense>
                <md-option :value="city.name" 
                            v-for="city in cities"
                           :key="city.name">{{city.name}}</md-option>
              </md-select>
            </md-field>
          </div>
          <div>
            <md-button class="md-primary no-margin btn-new--color"
                      @click="checkFields(newDate, incidentType)">Search</md-button>
            <md-button class="md-accent no-margin btn-new--red" 
                        @click="closeStats">Cancel</md-button>
                        <p class="mdl-typography--text-center mdl-typography--body-1 mdl-color-text--red-500"
                            v-if="isSelected">
                          Please select the fields!
                        </p>
          </div>
        </div>
      </div>
  </sweet-modal>
  <sweet-modal ref="chart" 
              :enable-mobile-fullscreen=false
              @close="emptyChart">
            <p class="mdl-typography--text-center mdl-typography--title"
                v-if="notReport">
                No reports!
            </p>
      <sweet-modal-tab title="Total per Barangay" 
                        id="perBarangay">
        <p v-if="hasReports" class="report-title--size">{{incidentType}} Report from {{formatDate(newDate)}} up to present.</p>
        <chartjs-horizontal-bar :option="lineChart.myoption" 
                      :labels="lineChart.labels"
                      :datasets="lineChart.datasets" 
                      :bind="true"
                      :width="700"
                      :height="300"
                      :beginzero="true"
                      v-if="hasReports"/>
      </sweet-modal-tab>
	    <sweet-modal-tab title="Barangay Per day" 
                        id="perDay">
          <p class="mdl-typography--text-center mdl-typography--title"
                v-if="hasReports">
                Filter Reports by Date
          </p>
          <md-field class="no-margin md-width" v-if="hasReports">
            <label for="filteredDate">Filter Date:</label>
            <md-select v-model="filteredDate" name="filteredDate" id="filteredDate" md-dense>
                <md-option v-for="filtered in filteredDateList"
                          :value="filtered"
                          :key="filtered">{{formatDate(filtered)}}</md-option>
             </md-select>
          </md-field>
          <chartjs-horizontal-bar v-if="hasReports"
                                  :datalabel="barChart.datalabel"
                                  :labels="barChart.labels"
                                  :data="barChart.data"
                                  :option="lineChart.myoption"
                                  :beginzero="true"
                                  :bind="true"/>
      </sweet-modal-tab>
      <sweet-modal-tab title="Total Count"
                      id="count">
          <p class="mdl-typography--text-center mdl-typography--title"
                v-if="hasReports">
                Total Reports: {{getTotal}}
          </p>         
        <chartjs-pie :beginzero="true"
                      :bind="true"
                      :option="pieChart.option"
                      :data="pieChart.data"
                      :labels="pieChart.labels"
                      :scalesdisplay="false"
                      v-if="hasReports"/>
      </sweet-modal-tab>
  </sweet-modal>
  <sweet-modal icon="warning"
                ref="confirm"
                @close="theId = '', theType = ''">
    <p>Are you sure?</p>
  <md-button class="md-primary no-margin btn-new--color"
                @click="toOnGoing(theId, theType)">Confirm</md-button>
  </sweet-modal>
  </div>
 </div> 
</template>

<script>
import moment, { now } from "moment";
import pagination from "laravel-vue-pagination";
import timeago from "timeago.js";
import cities from "./../../json/coords.json";
export default {
  name: "ReportTest",
  data() {
    return {
      theId: "",
      theType: "",
      isMoved: false,
      filteredDate: "",
      filteredDateList: [],
      source: {
        newReport: "sounds/newReport.wav",
        newFraud: "sounds/newFraud.wav"
      },
      undone: {
        data: []
      },
      ongoing: {
        data: []
      },
      isRescueLocation: false,
      polyOptions: {
        strokeColor: "#FF0000",
        strokeOpacity: 0.5,
        strokeWeight: 15
      },
      gmap: {
        center: {
          lat: 14.796128,
          lng: 120.877419
        },
        zoom: 11
      },
      polyline: [],
      hoverData: {
        address: "",
        name: "",
        type: "",
        time: "",
        landmark: ""
      },
      rescuers: [],
      isAnAdmin: false,
      imageSrc: "",
      notDone: true,
      onGoing: false,
      finished: false,
      fraud: false,
      theTime: "",
      status: "",
      queriedAddress: [],
      hasImage: false,
      isMessage: true,
      tooltip: false,
      reportPlots: [],
      isStats: false,
      isGrid: false,
      isMap: true,
      allReports: "",
      laravelData: {},
      municipalLocation: document.getElementById("municipalOffice").textContent,
      adminLocation: document.getElementById("municipalAddress").textContent,
      routesData: [],
      hasResults: false,
      isLoad: true,
      selectedDate: null,
      newDate: null,
      incidentType: "",
      isSelected: false,
      hasReports: false,
      notReport: true,
      municipality: "",
      cities: cities,
      buttonMsg: "Respond",
      formattedAddress: "",
      selectedType: "",
      noCoords: [],
      getTotal: 0,
      pieChart: {
        data: ["3", "6", "9"],
        labels: [],
        option: {
          tooltips: {
            titleFontSize: 20,
            bodyFontSize: 20
          },
          responsive: true,
          maintainAspectRatio: true,
          title: {
            display: true,
            position: "bottom"
          }
        }
      },
      barChart: {
        datalabel: "Daily count",
        labels: [],
        data: []
      },
      lineChart: {
        labels: [],
        datasets: [
          {
            label: "Incident Count",
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            data: [],
            spanGaps: false
          }
        ],
        myoption: {
          tooltips: {
            titleFontSize: 20,
            bodyFontSize: 20
          },
          scales: {
            yAxes: [],
            xAxes: [
              {
                barThickness: 20,
                maxBarThickness: 30,
                display: true,
                ticks: {
                  fontSize: 15,
                  callback: function(value) {
                    if (value % 1 === 0) {
                      return value;
                    }
                  }
                }
              }
            ]
          }
        }
      }
    };
  },
  methods: {
    checkContacts(type, string) {
      return type ? type : string;
    },
    confirmModal(id, type) {
      this.$refs.confirm.open();
      (this.theId = id), (this.theType = type);
    },
    emptyChart() {
      this.pieChart.data = this.pieChart.labels = this.barChart.data = this.barChart.labels = this.filteredDateList = this.lineChart.labels = this.lineChart.datasets[0].data = this.filteredDateList = [];
      this.filteredDate = "";
    },
    getReportTotals(date, type) {
      this.$http
        .get(`/reports/total/${date}/${type}/${this.municipality}`)
        .then(response => {
          this.pieChart.data = this.pieChart.labels = [];
          this.pieChart.data = response.data.totals;
          this.pieChart.labels = response.data.status;
          this.getTotal = response.data.allReports;
        })
        .catch(error => {
          console.log(error);
        });
    },
    formatDate(string) {
      return moment(string).format("LL");
    },
    hideSelect() {
      if (
        this.municipalLocation == "Bulacan" ||
        this.municipalLocation == "Administrator"
      ) {
        this.isAnAdmin = true;
      } else {
        this.isAnAdmin = false;
      }
    },
    closeImage() {
      this.$refs.imageData.close();
    },
    showImage(image) {
      if (image == "" || image == null) {
        this.isMessage = true;
        this.hasImage = false;
        this.$refs.imageData.open();
      } else {
        this.imageSrc = image;
        this.isMessage = false;
        this.hasImage = true;
        this.$refs.imageData.open();
      }
    },
    showRescuerLocation(location) {
      this.$http
        .get(`/rescue/locate/${location.lat}/${location.lng}`)
        .then(response => {
          this.isRescueLocation = true;
          this.formattedAddress = response.data.formatted_address;
        })
        .catch(error => {
          console.log(error);
        });
    },
    changeStatus() {
      if (this.status == "Undone") {
        (this.onGoing = false),
          (this.finished = false),
          (this.notDone = true),
          (this.fraud = false);
        this.getReports();
      } else if (this.status == "OnGoing") {
        (this.onGoing = true),
          (this.finished = false),
          (this.notDone = false),
          (this.fraud = false);
        this.getReports();
      } else if (this.status == "Finished") {
        (this.onGoing = false),
          (this.finished = true),
          (this.notDone = false),
          (this.fraud = false);
        this.getReports();
      } else {
        (this.onGoing = false),
          (this.finished = false),
          (this.notDone = false),
          (this.fraud = true);
        this.getReports();
      }
    },
    toOnGoing(id, type) {
      this.$http
        .put(
          `/reports/status/update/${type}/${id}`,
          {
            status: type
          },
          {
            headers: {
              "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content")
            }
          }
        )
        .then(response => {
          this.getReports();
          this.theId = this.theType = "";
          this.$refs.confirm.close();
        })
        .catch(error => {
          console.log(error);
          this.theId = this.theType = "";
        });
    },
    getReports(page) {
      if (typeof page === "undefined" && this.status == "") {
        page = 1;
        this.status = "Undone";
      }
      this.$http
        .get(
          `/reports/status/all/${this.status}/${
            this.municipalLocation
          }?page=${page}`
        )
        .then(response => {
          this.allReports = response.data.data;
          return response.json();
        })
        .then(data => {
          this.laravelData = data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    timeAgo(value) {
      return timeago().format(value);
    },
    checkPlots(report, type) {
      this.$refs.plots.open();
      this.queriedAddress = [];
      this.$http
        .get(`/reports/${report.address}/${type}`)
        .then(response => {
          response.data.forEach(result => {
            this.queriedAddress.push(result);
          });
        })
        .catch(error => {
          console.log(error);
        });
    },
    listenForNewReport() {
      Echo.private("sent-reports")
        .listen("SendReportEvent", e => {
          if (e.reports.status == "Undone") {
            this.$refs.newReport.play();
          }
          this.getAll();
          this.allReports.unshift(e.reports);
          this.allReports.pop();
          this.getReports();
        })
        .listen("RescuerLocationEvent", e => {
          console.log(e);
          const poly = {
            lat: parseFloat(e.location.lat),
            lng: parseFloat(e.location.lng)
          };
          if (e.location.municipality == this.municipalLocation) {
            if (e.location.lat == "") {
              this.polyline = [];
            } else {
              this.polyline.push(poly);
            }
          }
        });
    },
    showReportView() {
      if (this.isGrid == false) {
        this.getReports();
        this.isGrid = true;
        this.isMap = false;
      } else {
        this.getAll();
        this.isGrid = false;
        this.isMap = true;
      }
    },
    seeDetails(report) {
      this.tooltip = true;
      this.hoverData.name = report.fullName;
      this.hoverData.address = report.address;
      this.hoverData.type = report.type;
      this.hoverData.time = report.reportedDate;
      this.hoverData.landmark = report.landmark;
    },
    checkFields(date, type) {
      if (this.isAnAdmin == false) {
        this.municipality = this.municipalLocation;
      }
      if (
        this.incidentType.length == 0 ||
        this.selectedDate.length == 0 ||
        this.municipality.length == 0
      ) {
        this.isSelected = true;
      } else {
        this.isSelected = false;
        this.showCharts(date, type);
        this.getReportTotals(date, type);
      }
    },
    showRoutes(origin, destination) {
      this.$refs.routes.open();
      this.hasResults = false;
      this.isLoad = true;
      let itemsProcessed = 0;
      this.$http
        .get(`/directions/${origin}/${destination}`)
        .then(response => {
          if (response.status == 200) {
            this.routesData = [];
            const legs = response.data.routes[0].legs[0].steps;
            legs.forEach(result => {
              itemsProcessed++;
              this.routesData.push({
                direction: result.html_instructions.replace(/<\/?[^>]+>/gi, "")
              });
              if (itemsProcessed == legs.length) {
                this.isLoad = false;
                this.hasResults = true;
              }
            });
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    showStats() {
      this.$refs.stats.open();
      this.clearAll();
    },
    closeStats() {
      this.$refs.stats.close();
    },
    showCharts(date, type) {
      this.selectedType = type;
      this.$refs.chart.open();
      this.$http
        .get(`/reports/range/${date}/${this.municipality}/${type}/`)
        .then(response => {
          if (response.data.totalIncidentCount != 0) {
            this.filteredDateList = [];
            this.filteredDateList = response.data.datesCovered;
            this.lineChart.labels = [];
            this.lineChart.datasets[0].data = [];
            this.notReport = false;
            this.hasReports = true;
            const incidents = response.data.incidents;
            const count = incidents.reduce((a, c) => {
              a[c.address] = (a[c.address] || 0) + 1;
              return a;
            }, {});
            Object.keys(count).forEach(key => {
              this.lineChart.labels.push(key);
            });
            Object.values(count).forEach(data => {
              this.lineChart.datasets[0].data.push(data);
            });
          } else {
            this.notReport = true;
            this.hasReports = false;
          }
        })
        .catch(error => {
          console.log(error);
        });
    },
    renderChartHistory(type) {
      this.$http
        .get(
          `/reports/orderby/${this.filteredDate}/${type}/${this.municipality}/`
        )
        .then(response => {
          this.barChart.data = this.barChart.labels = [];
          response.data.count.forEach(result => {
            this.barChart.data.push(result);
          });
          const replace = response.data.addresses.replace(/\'/g, '"');
          const arrayAddress = JSON.parse(replace);
          this.barChart.labels = arrayAddress;
        })
        .catch(error => {
          console.log(error);
        });
    },
    clearAll() {
      this.newDate = "";
      this.municipality = "";
      this.incidentType = "";
    },
    showDate() {
      this.theTime = moment().format("LL LTS");
    },
    getUndoneReports(type, name) {
      this.$http
        .get(`/reports/summary/get/${this.municipalLocation}/${type}`)
        .then(response => {
          name.data = [];
          response.data.forEach(reports => {
            const newlyReported = {
              address: reports.address,
              contactNumber: reports.contactNumber,
              fullName: reports.fullName,
              id: reports.id,
              landmark: reports.landmark,
              coord: {
                lat: parseFloat(reports.lat),
                lng: parseFloat(reports.lng)
              },
              reportedDate: reports.reportedDate,
              type: reports.type,
              municipality: reports.municipality,
              rescuedTime: reports.rescuedTime,
              respondTime: reports.respondTime
            };
            name.data.push(newlyReported);
          });
        })
        .catch(error => {
          console.log(error);
        });
    },
    getAll() {
      this.getUndoneReports("Undone", this.undone),
        this.getUndoneReports("OnGoing", this.ongoing);
    }
  },
  watch: {
    selectedDate(newValue) {
      const dateObj = new Date(this.selectedDate);
      const momentObj = moment(dateObj);
      const momentString = momentObj.format("YYYY-MM-DD");
      this.newDate = momentString;
    },
    status() {
      this.changeStatus();
    },
    filteredDate() {
      this.renderChartHistory(this.selectedType);
    },
    isMoved() {
      return this.isMoved;
    }
  },
  computed: {},
  mounted() {
    this.getAll();
    setInterval(this.showDate, 1000);
  },
  beforeDestroy() {
    clearInterval(this.interval);
  },
  created() {
    this.listenForNewReport();
    this.theTime;
  },
  components: {
    pagination
  }
};
</script>

<style lang="scss" scoped>
.slider-holder {
  max-width: 300px;
  margin: 0 auto;
}
.margin-top {
  margin-top: 20px;
}
.legend-holder {
  display: flex;
}
.report-content {
  display: block;
  text-align: center;
  font-size: 16px;
  padding-top: 20px;
  padding-bottom: 64px;
}
.icon--font {
  font-size: 35px;
}
.select--width {
  width: 250px;
  margin: 0 auto;
}

.no-blur {
  padding: 0px;
}

.no-margin {
  margin: 0px;
}

.form-padding {
  margin-bottom: 16px;
}

.report-title--size {
  font-size: 1.5em;
}
.report-tooltip {
  width: 350px;
  height: 150px;
  position: absolute;
  right: 0;
  z-index: 10;
  bottom: 100px;
}

.report-holder {
  width: 60%;
  margin: 0 auto;
  margin-bottom: 15px;
  padding: 10px;
}

.grid-button {
  position: absolute;
  right: 0;
  z-index: 100;
  margin-top: 10px;
  margin-right: 10px;
}

.map-button {
  position: absolute;
  bottom: 0px;
  right: 0;
  margin-right: 10px;
  margin-bottom: 10px;
}

.padding {
  padding: 10px;
}

.margin {
  margin: 10px;
}
.legend {
  width: 125px;
  height: 165px;
  position: absolute;
  z-index: 10;
  right: 0;
  margin-top: 55px;
  margin-right: 10px;
}
@media all and (min-width: 320px) and (max-width: 375px) {
  .md-field {
    width: 200px !important;
  }
}
</style>
