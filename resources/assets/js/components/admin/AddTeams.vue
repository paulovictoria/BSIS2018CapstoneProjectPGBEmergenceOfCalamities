<template>
<div class="md-layout md-gutter md-alignment-center">
	<div class="md-layout-item md-large-size-70 md-medium-size-50 md-small-size-100">
    <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header class="margin">
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Registered Team Leaders</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by full name..." v-model="search" @input="searchOnTable" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No users found"
        :md-description="`No team leader found for this '${search}' query. Try a different search term or create a team leader.`">
      </md-table-empty-state>

      <md-table-row slot="md-table-row" slot-scope="{ item }" @click="editMembers(item)">
        <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
        <md-table-cell md-label="Full Name" md-sort-by="fullName">{{ item.fullName }}</md-table-cell>
        <md-table-cell md-label="Contact Number" md-sort-by="contactNumber">{{ item.contactNumber }}</md-table-cell>
        <md-table-cell md-label="Address" md-sort-by="address">{{ item.address }}</md-table-cell>
      </md-table-row>
    </md-table>
	</div>
	<div class="md-layout-item md-large-size-30 md-medium-size-50 md-small-size-100">
		<div class="form-holder">
      <p class="md-headline mdl-typography--text-center">Add Team Leaders</p>
      <md-field class="field-margin">
        <label>Full Name..</label>
        <md-input v-model="fullName" 
                  name="fullName" 
                  type="text"
                  required></md-input>
        <span class="md-helper-text">* Required</span>
      </md-field>
      <md-field class="field-margin">
        <label>Contact Number..</label>
        <md-input v-model="contactNumber" 
                  name="contactNumber"
                  type="number"
                  required></md-input>
        <span class="md-helper-text">* Required</span>
      </md-field>
      <md-field class="field-margin">
        <label>Address..</label>
        <md-input v-model="address" 
                  name="address" 
                  type="text"
                  required></md-input>
        <span class="md-helper-text">* Required</span>
      </md-field>
      <div class="button-holder">
        <md-button class="md-primary btn-new--color"
                  @click="checkPattern"
                  v-if="isAdd">Add</md-button>
        <md-button class="md-primary btn-new--color"
                  @click="updateMember"
                  v-if="isEdit">Edit</md-button>
        <md-button class="md-accent btn-new--red"
                    @click="clearAll">Clear</md-button>
      </div>
    </div>
	</div>
</div>
</template>

<script>
const toLower = text => {
  return text.toString().toLowerCase();
};

const searchByName = (items, term) => {
  if (term) {
    return items.filter(item => toLower(item.fullName).includes(toLower(term)));
  }

  return items;
};

import Vue from "vue";
import Toasted from "vue-toasted";
Vue.use(Toasted);
export default {
  name: "AddTeams",
  data: () => ({
    fullName: null,
    contactNumber: null,
    address: null,
    id: null,
    search: null,
    searched: [],
    isAdd: true,
    isEdit: false,
    municipality: document.getElementById("municipalOffice").textContent,
    users: []
  }),
  methods: {
    checkPattern() {
      try {
        if (this.contactNumber.match(/^(09|\+639)\d{9}$/)) {
          this.addMembers();
        } else {
          this.launchToast("Invalid Cellphone Number!");
        }
      } catch (error) {
        this.launchToast("Invalid Cellphone Number!");
      }
    },
    updateMember() {
      try {
        if (this.contactNumber.match(/^(09|\+639)\d{9}$/)) {
          this.$http
            .put(
              `/teams/update/${this.id}`,
              {
                fullName: this.fullName,
                contactNumber: this.contactNumber,
                address: this.address
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
              if (response.status == 200) {
                this.clearAll();
                this.getAllMembers();
              }
            })
            .catch(error => {
              let errorObject = error.data.errors;
              Object.keys(errorObject).forEach(key => {
                let value = errorObject[key];
                this.launchToast(value.toString());
              });
            });
        } else {
          this.launchToast("Invalid Cellphone Number!");
        }
      } catch (error) {
        this.launchToast("Invalid Cellphone Number!");
      }
    },
    clearAll() {
      this.fullName = this.contactNumber = this.address = this.id = "";
      this.isAdd = true;
      this.isEdit = false;
    },
    launchToast(message) {
      let toast = this.$toasted.show(message, {
        theme: "primary",
        position: "top-right",
        duration: 3000,
        icon: "clear",
        action: {
          text: "Cancel",
          onClick: (e, toastObject) => {
            toastObject.goAway(0);
          }
        }
      });
    },
    editMembers(data) {
      this.isAdd = false;
      this.isEdit = true;
      this.fullName = data.fullName;
      this.contactNumber = data.contactNumber;
      this.address = data.address;
      this.id = data.id;
    },
    getAllMembers() {
      this.$http
        .get(`/teams/get/${this.municipality}`)
        .then(response => {
          this.searched = this.users = response.data;
        })
        .catch(error => {
          console.log(error);
        });
    },
    addMembers() {
      this.$http
        .post(
          "/teams/add",
          {
            fullName: this.fullName,
            contactNumber: this.contactNumber,
            address: this.address,
            municipality: this.municipality
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
          if (response.status == 200) {
            this.fullName = this.contactNumber = this.address = "";
            this.getAllMembers();
          }
        })
        .catch(error => {
          let errorObject = error.data.errors;
          Object.keys(errorObject).forEach(key => {
            let value = errorObject[key];
            this.launchToast(value.toString());
          });
        });
    },
    searchOnTable() {
      this.searched = searchByName(this.users, this.search);
    }
  },
  created() {
    this.getAllMembers();
  }
};
</script>

<style lang="scss" scoped>
.md-field {
  max-width: 250px;
}

.margin {
  margin-top: 15px;
  margin-left: 15px;
}

.form-holder {
  width: 255px;
  margin: 0 auto;
  margin-top: 20px;
  .button-holder {
    width: 205px;
    margin: 0 auto;
    margin-top: 25px;
  }
  .field-margin {
    margin-bottom: 20px;
  }
}
</style>