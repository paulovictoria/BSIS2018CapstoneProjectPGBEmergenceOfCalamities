<template>
<div class="mdl-grid">
  <div class="mdl-cell mdl-cell--5-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
      <div class="register-holder mdl-shadow--2dp">
          <p class="mdl-typography--text-center mdl-typography--headline">Assign Team</p>
        <md-field>
              <label for="rescuerName">Team Leaders..</label>
              <md-select v-model="rescuerName" 
                        name="rescuerName" 
                        id="rescuerName" 
                        :disabled="disabled"
                         md-dense>
                <md-option v-for="searches in searched" 
                            :key="searches.id"
                            :value="searches.fullName">{{searches.fullName}}</md-option>
              </md-select>
        </md-field>
        <md-field>
              <label for="assignRoute">Assigned Route..</label>
              <md-select v-model="assignRoute" 
                          name="assignRoute" 
                          id="assignRoute" 
                          md-dense>
                <md-option v-for="matchedWord in matchedWords" 
                            :key="matchedWord"
                            :value="matchedWord">{{matchedWord}}</md-option>
              </md-select>
        </md-field>
        <md-field>
          <label>Password..</label>
          <md-input v-model="password" 
                    name="password" 
                    type="password" 
                    :disabled="disabled"></md-input>
        </md-field>
        <md-field>
          <label>Retype Password..</label>
          <md-input v-model="confirmPassword" 
                    name="password_confirmation" 
                    type="password" 
                    :disabled="disabled"></md-input>
        </md-field>
        <div class="button--holder">
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored custom--button"
                  @click="addRescuer"
                  v-if="isRegister">
            Register
          </button>
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored custom--button"
                  @click="updateUser"
                  v-if="isEdit">
            Update
          </button>
          <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent custom--button"
                 @click="clearFields">
            Cancel
          </button>
        </div>
      </div>
  </div>
  <!--table-->
  <div class="mdl-cell mdl-cell--7-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone ">
        <p class="mdl-typography--text-center mdl-typography--headline">
          List of Team Leaders
        </p>
        <div class="mdl-cell mdl-cell--12-col overflow--auto">
          <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp custom--font table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Team Lead</th>
                <th>Assign Route</th>
                <th>Municipality</th>
                <th>Action</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users"
                  :key="user.id">
                <td>{{user.id}}</td>
                <td>{{user.rescuerName}}</td>
                <td>{{user.assignRoute}}</td>
                <td>{{user.municipality}}</td>
                <td>
                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--teal-500 custom--button"
                          @click="editUser(user)">
                    Edit
                  </button>
                </td>
                <td>
                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--grey-900 custom--button"
                          @click="deleteUser(user.id)">
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="pagination-holder">
          <pagination :data="laravelData" 
                      v-on:pagination-change-page="showInTables" 
                      :limit="4">
            <span slot="prev-nav">&lt; Previous</span>
            <span slot="next-nav">Next &gt;</span>
          </pagination>
        </div>
      </div>
  </div>
</template>

<script>
import pagination from "laravel-vue-pagination";
import barangays from "../../barangays";
import municipalities from "../../json/municipality.list.json";
export default {
  name: "Assign",
  data() {
    return {
      municipalities: municipalities,
      barangays,
      disabled: false,
      notValidate: false,
      showSnackbar: false,
      duration: 4000,
      rescuerName: "",
      password: "",
      confirmPassword: "",
      assignRoute: "",
      users: [],
      errors: [],
      search: "",
      searched: "",
      laravelData: {},
      rescuerId: "",
      municipality: document.getElementById("municipalOffice").textContent,
      isEdit: false,
      isRegister: true,
      searched: "",
      matchedWords: []
    };
  },
  methods: {
    toastError(msg) {
      this.$toasted.show(msg, {
        theme: "primary",
        position: "top-center",
        duration: 2000,
        icon: "error",
        action: {
          text: "Close",
          onClick: (e, toastObject) => {
            toastObject.goAway(0);
          }
        }
      });
    },
    getSelectedBarangays() {
      if (
        this.municipality == "Bulacan" ||
        this.municipality == "Administrator"
      ) {
        this.municipalities.forEach(element => {
          this.matchedWords.push(element.name);
        });
      } else {
        for (let index = 0; index < this.barangays.length; index++) {
          const element = this.barangays[index];
          if (this.barangays[index].match(this.municipality)) {
            this.matchedWords.push(this.barangays[index]);
          }
        }
      }
    },
    getAllMembers() {
      this.$http
        .get(`/teams/get/${this.municipality}`)
        .then(response => {
          this.searched = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    addRescuer() {
      this.$http
        .post(
          "/rescue/members",
          {
            rescuerName: this.rescuerName,
            assignRoute: this.assignRoute,
            password: this.password,
            municipality: this.municipality,
            password_confirmation: this.confirmPassword
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
          this.clearFields();
          this.showInTables();
        })
        .catch(error => {
          let errorObject = error.data.errors;
          Object.keys(errorObject).forEach(key => {
            let value = errorObject[key];
            this.toastError(value.toString());
          });
        });
    },
    editUser(user) {
      this.isRegister = false;
      this.isEdit = true;
      this.disabled = true;
      this.rescuerName = user.rescuerName;
      this.assignRoute = user.assignRoute;
      this.password = user.password;
      this.rescuerId = user.id;
    },
    updateUser() {
      this.$http
        .put(
          `/rescue/members/${this.rescuerId}`,
          {
            rescuerName: this.rescuerName,
            assignRoute: this.assignRoute,
            password: this.password,
            municipality: this.municipality,
            password_confirmation: this.confirmPassword
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
          this.clearFields();
          this.showInTables();
        })
        .catch(error => {
          console.log(error);
          if (error.status == 422) {
            this.showSnackbar = true;
          }
        });
    },
    clearFields() {
      this.isRegister = true;
      this.isEdit = false;
      this.disabled = false;
      this.rescuerName = this.assignRoute = this.password = this.confirmPassword = this.rescuerId =
        "";
    },
    showInTables(page) {
      if (typeof page === "undefined") {
        page = 1;
      }
      this.$http
        .get(`/rescue/members/get/${this.municipality}?page=${page}`)
        .then(response => {
          this.users = response.data.data;
          this.laravelData = response.data;
        });
    },
    deleteUser(id) {
      this.$http
        .delete(`/rescue/members/${id}`, {
          headers: {
            "X-CSRF-TOKEN": document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute("content")
          }
        })
        .then(response => {
          console.log(response);
          this.showInTables();
        });
    }
  },
  mounted() {
  this.showInTables()
  this.getAllMembers()
  },
  created() {
    this.getSelectedBarangays();
  },
  components: {
    pagination
  }
};
</script>

<style scoped lang="scss">
.register-holder {
  width: 300px;
  margin: 0 auto;
  padding: 30px;
  .button--holder {
    margin: 0 auto;
    width: 215px;
  }
}

.table-holder {
  padding: 30px;
}
.custom--font {
  font-size: 1.2em;
}

.table {
  width: 100% !important;
  max-width: 100% !important;
  tr > td {
    text-align: center;
    .space {
      margin: 10px;
    }
  }

  tr > th {
    text-align: center;
    font-size: 1.2em;
  }
}

.overflow--auto {
  overflow: auto;
}

.pagination-holder {
  width: 200px;
  margin: 0 auto;
}

.custom--button {
  font-size: 16px;
  font-family: "Noto Sans";
  font-weight: 500;
}
</style>
