<template>
  <div class="main-component">
    <!--grid-->
    <div class="mdl-grid five-day--forecast padding dirty-white  mdl-shadow--8dp ">
      <!--right-->
      <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone custom-padding mdl-color--white mdl-shadow--8dp">
        <h3 class="mdl-typography--text-center">
          Bulletin Reports as of
        </h3>
        <h3 class="mdl-typography--text-center">
         {{ recentDate}}
        </h3>
        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
          <div class="mdl-tabs__tab-bar">
              <a href="#undone" class="mdl-tabs__tab is-active">Undone Reports</a>
              <a href="#ongoing" class="mdl-tabs__tab">Ongoing Reports</a>
              <a href="#finished" class="mdl-tabs__tab">Finished Reports</a>
          </div>

          <div class="mdl-tabs__panel is-active report-data" id="undone">
              <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col mdl-shadow--2dp holder"
                    v-for="notDone in undone"
                    :key="notDone.id">
                  <div class="bulletin">
                    <div class="icon">
                      <i class="material-icons width icon--margin">&#xE873;</i>
                    </div>
                    <div class="message">
                      <span class="mdl-typography--subhead">
                        Report of {{notDone.fullName}} was received by  {{notDone.municipality}} Rescue Team.
                      </span>
                      <p class="mdl-typography--subhead">
                        {{timeAgo(notDone.reportedDate)}}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <!--ongoing-->
          <div class="mdl-tabs__panel report-data" id="ongoing">
              <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col mdl-shadow--2dp holder"
                    v-for="onTheGo in ongoing"
                    :key="onTheGo.id">
                  <div class="bulletin">
                    <div class="icon">
                      <i class="material-icons width icon--margin">&#xE558;</i>
                    </div>
                    <div class="message">
                      <span class="mdl-typography--subhead">
                         {{onTheGo.municipality}} Rescue Team is now preparing to respond {{onTheGo.fullName}}'s location.
                      </span>
                      <p class="mdl-typography--subhead">
                        {{timeAgo(onTheGo.respondTime)}}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <!--finished-->
          <div class="mdl-tabs__panel report-data" id="finished">
              <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--12-col mdl-shadow--2dp holder"
                      v-for="finish in finished"
                      :key="finish.id">
                  <div class="bulletin">
                    <div class="icon">
                      <i class="material-icons width icon--margin">&#xE86C;</i>
                    </div>
                    <div class="message">
                      <span class="mdl-typography--subhead">
                        The {{finish.type}} report of {{finish.fullName}} was accomplished by {{finish.municipality}} Rescue Team.
                      </span>
                      <p class="mdl-typography--subhead">
                        {{timeAgo(finish.rescuedTime)}}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <!--left-->
      <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone right-padding mdl-color--white mdl-shadow--8dp">
        <div>
          <h3 class="mdl-typography--text-center">
          Send your report!
          </h3>
            <form @submit.prevent="checkCode" class="mdl-form">
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" 
                        type="text" 
                        id="name" 
                        name="fullName"
                        v-model="name">
                <label class="mdl-textfield__label" for="name">Name...</label>
              </div>
              <!--select-->
              <div
                class="mdlext-selectfield mdlext-js-selectfield mdlext-selectfield--floating-label">
                <select
                  id="municipality"
                  class="mdlext-selectfield__select"
                  name="municipality"
                  @change="searchQuery"
                  v-model="selectedMunicipality">
                  <option value=""></option>
                  <option :value="city.name"
                           v-for="city in municipality"
                          :key="city.name">{{city.name}}</option>
                </select>
                <label
                  for="municipality"
                  class="mdlext-selectfield__label">Municipality</label>
              </div>
              <!--select-->
              <div
                class="mdlext-selectfield mdlext-js-selectfield mdlext-selectfield--floating-label">
                <select
                  id="barangay"
                  class="mdlext-selectfield__select"
                  name="address"
                  v-model="address">
                  <option value=""></option>
                  <option :value="matchWord" 
                            v-for="matchWord in matchWords"
                            :key="matchWord">{{matchWord.match(/([^,]+)/)[0].toString()}}</option>
                </select>
                <label
                  for="barangay"
                  class="mdlext-selectfield__label">Barangay</label>
              </div>
              <!--text-->
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" 
                        type="number" 
                        id="contactNumber" 
                        name="contactNumber"
                        v-model="contactNumber"
                        pattern="^(09|\+639)\d{9}$">
                <label  class="mdl-textfield__label" for="contactNumber">Contact Number - Format: (+63 / 09)</label>
              </div>
              <!--text-->
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" 
                        type="text" 
                        id="landline" 
                        name="landline"
                        v-model="landline"
                        pattern="^\+?(\(?[0-9]{3}\)?|[0-9]{3})[-\.\s]?[0-9]{3}[-\.\s]?[0-9]{4}$">
                <label  class="mdl-textfield__label" for="landline">Landline Number - Format: (044) 123-4567</label>
              </div>
              <!--cp-->
              <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                <input class="mdl-textfield__input" 
                        type="text" 
                        id="landmark" 
                        name="landmark"
                        v-model="landmark">
                <label class="mdl-textfield__label" for="landmark">Landmark...</label>
              </div>
              <!--select-->
              <div
                class="mdlext-selectfield mdlext-js-selectfield mdlext-selectfield--floating-label">
                <select
                  id="type"
                  class="mdlext-selectfield__select"
                  name="type"
                  v-model="type">
                  <option value=""></option>
                  <option v-for="rescueType in rescueTypes"
                          :value="rescueType"
                          :key="rescueType">{{rescueType}}</option>
                </select>
                <label
                  for="type"
                  class="mdlext-selectfield__label">Type of Incident..</label>
              </div>
              <!-- button -->
                <input class="mdl-textfield mdl-js-textfield mdl-typography--text-center code-style" 
                        type="text" 
                        disabled 
                        :value="`Type the Access Code: ${randomCode}`">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" 
                        type="text" 
                        id="code" 
                        name="code"
                        v-model="typedCode">
                <label class="mdl-textfield__label" for="landmark">Code...</label>
                </div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--file">
                  <input class="mdl-textfield__input" 
                        placeholder="File" 
                        type="text" 
                        id="uploadFile" 
                        :value="imageName"
                        readonly/>
                    <div class="mdl-button mdl-button--primary mdl-button--icon mdl-button--file">
                      <i class="material-icons">attach_file</i>
                                <input type="file" 
                                        id="uploadBtn"
                                        name="image"
                                        accept="image/*"
                                        @change="selectImage">
                  </div>
                </div>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">
                  Send
                </button>
            </form>
        </div>
      </div>
    </div>
    <sweet-modal icon="success" ref="sent" :enable-mobile-fullscreen=false> 
      Message Sent!
    </sweet-modal>
    <!--grid-->
    <sweet-modal ref="disclaimer" :enable-mobile-fullscreen=false>
        <div class="mdl-cell mdl-cell--12-col">
          <p class="mdl-typography--text-center mdl-typography--headline">
            Notice to the reporter:
          </p>
          <div class="disclaimer-content">
            <p class="mdl-typography--text-justify">
              Any information sent to our system, will check by our customer service representatives, to ensure the data integrity and identity.
              In accordance of REPUBLIC ACT NO. 10175, also known as "Cybercrime Prevention Act of 2012″.
            </p>
             <p class="mdl-typography--text-justify">
               Any misconduct to the said user, will fall under Section 4. Cybercrime Offenses. — The following acts constitute the offense of cybercrime punishable under this Act:
            </p>
            <p class="mdl-typography--text-justify">
              (b) Computer-related Offenses:
             </p> 
             <p class="mdl-typography--text-justify">
              (1) Computer-related Forgery. —
             </p>
             <p class="mdl-typography--text-justify">           
              (i) The input, alteration, or deletion of any computer data without right resulting in inauthentic 
              data with the intent that it be considered or acted upon for legal purposes as if it were authentic, regardless whether or not the data is directly readable and intelligible; or
              </p>
              <p class="mdl-typography--text-justify">   
                (ii) The act of knowingly using computer data which is the product of computer-related 
                forgery as defined herein, for the purpose of perpetuating a fraudulent or dishonest design.
              </p>
              <p class="mdl-typography--text-justify">
                (2) Computer-related Fraud. — The unauthorized input, alteration, or deletion of computer data or program or interference in the functioning of a computer system, causing damage thereby with fraudulent intent: Provided, That if no
                damage has yet been caused, the penalty imposable shall be one (1) degree lower.
              </p>
              <p class="mdl-typography--text-justify">
                (3) Computer-related Identity Theft. – The intentional acquisition, use, misuse, transfer, possession, alteration or deletion of identifying information belonging to another, whether natural or juridical, without right: Provided, That if no damage has yet been caused, the penalty imposable shall be one (1) degree lower.
              </p>
          </div>
          <div class="mdl-cell mdl-cell--12-col">
            <button class="mdl-button mdl-js-button mdl-button--raised button--right"
                    @click="closeDisclaimer">
              Close
            </button>
          </div>
        </div>
    </sweet-modal>
  </div>
</template>


<script>
import Vue from "vue";
import Vue2Filters from "vue2-filters";
import municipality from "../../json/coords.json";
import barangays from "../../barangays";
import Toasted from "vue-toasted";
import moment from "moment";
import timeago from "timeago.js";
import axios from "axios";
Vue.use(Toasted);
Vue.use(Vue2Filters);
export default {
  name: "SendReport",
  data() {
    return {
      landline: "",
      blocking: false,
      isLoad: true,
      isSent: false,
      today: moment().format("YYYY-MM-DD"),
      recentDate: moment().format("LL"),
      showSnackbar: false,
      position: "center",
      success: "success",
      duration: 4000,
      isRead: false,
      isDisclaim: true,
      municipality: municipality,
      barangays: barangays,
      keyword: "",
      matchWords: [],
      name: "",
      address: "",
      contactNumber: "",
      landmark: "",
      selectedMunicipality: "",
      type: "",
      rescueTypes: [
        "Fire",
        "Accident",
        "Weather",
        "Landslide",
        "Rescue",
        "Emergency",
        "Flood"
      ],
      randomCode: "",
      typedCode: "",
      isValid: false,
      undone: [],
      ongoing: [],
      finished: [],
      nameScore: "",
      imageName: "Upload an image (Optional)",
      image: "",
      targetImage: ""
    };
  },
  methods: {
    selectImage(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);
      this.targetImage = e.target.files[0];
      this.imageName = e.target.files[0].name;
    },
    createImage(file) {
      let reader = new FileReader();
      reader.onload = e => {
        this.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    openDisclaimer() {
      this.$refs.disclaimer.open();
    },
    closeDisclaimer() {
      this.$refs.disclaimer.close();
    },
    timeAgo(value) {
      return timeago().format(value);
    },
    getReportNotifications(type, dataStorage) {
      this.$http.get(`/reports/today/${type}/${this.today}`).then(response => {
        response.data.forEach(result => {
          dataStorage.unshift(result);
        });
      });
    },
    listenForNotifications() {
      Echo.private("sent-reports").listen("SendReportEvent", e => {
        this.undone = [];
        this.ongoing = [];
        this.finished = [];
        this.promised();
      });
    },
    checkMobileNumber() {
      if (this.contactNumber == "" && this.landline == "") {
        this.toastError("Pleae input you contact number!");
        this.isValid = false;
      } else if (
        this.contactNumber.match(/^(09|\+639)\d{9}$/) ||
        this.landline.match(
          /^\+?(\(?[0-9]{3}\)?|[0-9]{3})[-\.\s]?[0-9]{3}[-\.\s]?[0-9]{4}$/
        )
      ) {
        this.sendReport();
      } else {
        this.toastError("Invalid Cellphone Number!");
        this.isValid = false;
      }
    },
    searchQuery() {
      const select = document.getElementById("municipality");
      const strUser = select.options[select.selectedIndex].value;
      this.keyword = strUser;
      this.matchWords = [];
      for (let index = 0; index < barangays.length; index++) {
        const element = barangays[index];
        if (barangays[index].match(strUser)) {
          this.matchWords.push(barangays[index]);
        }
      }
    },
    sendReport() {
      const form = new FormData();
      form.append("fullName", this.name);
      form.append("address", this.address);
      form.append("contactNumber", this.contactNumber);
      form.append("landmark", this.landmark);
      form.append("type", this.type);
      form.append("municipality", this.selectedMunicipality);
      form.append("status", "Undone");
      form.append("image", this.targetImage);
      form.append("landline", this.landline);
      this.$http
        .post("/reports/add", form, {
          headers: {
            "X-CSRF-TOKEN": document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute("content"),
            "Content-type": "multipart/form-data"
          }
        })
        .then(response => {
          if (response.status == 200) {
            this.$refs.sent.open();
            this.landline = this.name = this.address = this.contactNumber = this.landmark = this.selectedMunicipality = this.type = this.typedCode = this.status =
              "";
            this.imageName = "Please upload an image!";
            this.image = null;
            document.getElementById("uploadBtn").value = null;
            this.generateCode();
          }
        })
        .catch(error => {
          let errorObject = error.data.errors;
          Object.keys(errorObject).forEach(key => {
            let value = errorObject[key];
            this.toastError(value.toString());
          });
        });
    },
    checkCode() {
      if (this.randomCode == this.typedCode) {
        this.checkMobileNumber();
      } else {
        this.toastError("Access Code Error!");
      }
    },
    toastError(msg) {
      this.$toasted.show(msg, {
        theme: "primary",
        position: "top-right",
        duration: 5000,
        icon: "error",
        action: {
          text: "Cancel",
          onClick: (e, toastObject) => {
            toastObject.goAway(0);
          }
        }
      });
    },
    generateCode() {
      let text = "";
      let possible =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      for (let i = 0; i < 5; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
        this.randomCode = text;
      }
    },
    promised() {
      this.getReportNotifications("Undone", this.undone),
        this.getReportNotifications("OnGoing", this.ongoing),
        this.getReportNotifications("Finished", this.finished);
    }
  },
  watch: {},
  mounted() {
    this.generateCode();
    this.openDisclaimer();
  },
  created() {
    this.promised();
    this.listenForNotifications();
  }
};
</script>


<style scoped lang="scss">
.mdl-button--file {
  input {
    cursor: pointer;
    height: 100%;
    right: 0;
    opacity: 0;
    position: absolute;
    top: 0;
    width: 300px;
    z-index: 4;
  }
}

.mdl-textfield--file {
  .mdl-textfield__input {
    box-sizing: border-box;
    width: calc(100% - 32px);
  }
  .mdl-button--file {
    right: 0;
  }
}

.bulletin {
  display: flex;
  .icon {
    margin-top: 5px;
  }
  .icon > .icon--margin {
    margin: 10px;
  }
  .icon > .width {
    font-size: 5em;
  }
  .message {
    margin-left: 15px;
    margin-top: 7px;
  }
}
.report-data {
  max-height: 520px;
  overflow: auto;
}
.full-select {
  width: 150px;
  margin: 0 auto;
}

.mdl-image__responsive {
  width: 100px;
  margin: 0 auto;
}

.mdl-form {
  width: 300px;
  margin: 0 auto;
}

.disclaimer-content {
  max-height: 300px;
  height: 300px;
  overflow: auto;
}

.button--right {
  float: right;
}

.code-style {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica,
    Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-style: italic;
  font-weight: 900;
  font-size: 1.4em;
}

.custom-padding {
  padding: 15px;
  margin-top: 20px;
  margin-bottom: 20px;
}
.right-padding {
  width: 400px;
  margin: 0 auto;
  margin-top: 22px;
  margin-bottom: 22px;
  padding: 20px;
}
a:hover {
  text-decoration: none;
}

/**media query*/
@media all and (max-width: 839px) and (min-width: 400px) {
  .custom-padding {
    width: 400px;
    margin: 0 auto;
    margin-top: 22px;
    margin-bottom: 22px;
    padding: 20px;
  }

  .holder {
    width: 340px;
  }
}

@media all and (max-width: 399px) and (min-width: 320px) {
  .custom-padding {
    width: 300px;
    margin: 0 auto;
    margin-top: 22px;
    margin-bottom: 22px;
    padding: 20px;
  }

  .mdl-form {
    width: 250px;
  }

  .holder {
    width: 340px;
  }

  .code-style {
    font-size: 1.2em;
  }
}
</style>

