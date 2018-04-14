<template lang="html">
<div>
	<div class="md-layout" v-if="isNotAdmin">
    <md-empty-state
      md-icon="close"
      class="md-accent"
      md-label="Oh noes.."
      md-description="Access denied! Better luck next time.">
    </md-empty-state>
  </div>
  <div class="md-layout md-gutter md-alignment-center" v-if="isAdmin">
    <div class="md-layout-item md-large-size-80 md-medium-size-80 md-small-size-80">
      <md-table v-model="searched" md-sort="name" md-sort-order="asc" md-card md-fixed-header class="margin">
        <md-table-toolbar>
          <div class="md-toolbar-section-start">
            <h1 class="md-title">List of Administrators</h1>
          </div>
          <md-field class="no-margin md-width md-toolbar-section-end">
              <label for="incidentType">Sort by:</label>
              <md-select v-model="accountStatus" 
                          name="accountStatus" 
                          id="accountStatus" 
                          md-dense>
                <md-option value="null">Active</md-option>
                <md-option value="1">Inactive</md-option>
              </md-select>
           </md-field>
        </md-table-toolbar>

        <md-table-empty-state
          md-label="No users found"
          :md-description="`No user found for this '${search}' query. Try a different search term or create a user account.`">
        </md-table-empty-state>

        <md-table-row slot="md-table-row" slot-scope="{ item }" @click="blockModal(item)">
          <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
          <md-table-cell md-label="Full Name" md-sort-by="name">{{ item.name }}</md-table-cell>
          <md-table-cell md-label="Contact Number" md-sort-by="usercontact">{{ item.usercontact }}</md-table-cell>
          <md-table-cell md-label="Administering Office" md-sort-by="municipality">{{ item.municipality }}</md-table-cell>
          <md-table-cell md-label="Municipal Address" md-sort-by="municipalAddress">{{ item.municipalAddress }}</md-table-cell>
        </md-table-row>
      </md-table>
	  </div>
    <sweet-modal ref="block"
                icon="warning">
      <div v-if="isActive">
        Are you sure to reactivate {{selectedName}}??
          <div class="md-layout md-alignment-center btn--margin">
            <md-button class="md-primary btn-new--color"
                        @click="showSuccess">Reactivate</md-button>
          </div>
       </div> 
      <div v-if="isInActive">
      Are you sure to deactivate {{selectedName}}??
        <div class="md-layout md-alignment-center btn--margin">
          <md-button class="md-primary btn-new--color"
                      @click="showSuccess">Confirm</md-button>
        </div>
       </div> 
    </sweet-modal>
    <sweet-modal ref="success"
                  icon="success"
                  @open="deactivateUser"
                  @close="closeAllModals">

      <div v-if="isInActive">
        Successfully deactivated!
      </div>
      <div v-if="isActive">
        Successfully reactivated!
      </div>
    </sweet-modal>
  </div>
</div>  
</template>

<script>
const toLower = text => {
  return text.toString().toLowerCase();
};

const searchByName = (items, term) => {
  if (term) {
    return items.filter(item => toLower(item.name).includes(toLower(term)));
  }

  return items;
};

export default {
  name: "AccessControl",
  data() {
    return {
      isActive: false,
      isInActive: true,
      search: null,
      searched: [],
      users: [],
      id: null,
      name: null,
      usercontact: null,
      municipality: null,
      municipalAddress: null,
      selectedName: null,
      selectedid: null,
      accountStatus: null,
      isBlock: "",
      adminUser: document.getElementById("municipalOffice").textContent,
      isAdmin: false,
      isNotAdmin: true
    };
  },
  methods: {
    checkAuth() {
      if (this.adminUser == "Administrator" || this.adminUser == "Bulacan") {
        this.isAdmin = true;
        this.isNotAdmin = false;
      } else {
        this.isAdmin = false;
        this.isNotAdmin = true;
      }
    },
    sortUsers() {
      this.$http.get(`/users/sort/${this.accountStatus}`).then(response => {
        this.searched = this.users = response.data;
      });
    },
    closeAllModals() {
      this.selectedName = this.selectedid = null;
      this.sortUsers();
    },
    deactivateUser() {
      this.$refs.block.close();
      if (this.isBlock == null) {
        this.isBlock = 1;
      } else {
        this.isBlock = null;
      }
      this.$http
        .put(
          `/users/${this.selectedid}`,
          {
            isBlock: this.isBlock
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
          console.log(response);
        });
    },
    showSuccess() {
      this.$refs.success.open();
    },
    blockModal(item) {
      this.isBlock = item.isBlock;
      this.selectedName = item.name;
      this.selectedid = item.id;
      this.$refs.block.open();
    },
    searchOnTable() {
      this.searched = searchByName(this.users, this.search);
    }
  },
  created() {
    this.sortUsers();
  },
  mounted() {
    this.checkAuth();
  },
  watch: {
    accountStatus() {
      if (this.accountStatus == 1) {
        this.sortUsers();
        (this.isActive = true), (this.isInActive = false);
      } else {
        this.sortUsers();
        (this.isActive = false), (this.isInActive = true);
      }
    }
  }
};
</script>

<style scoped lang="scss">
.md-field {
  max-width: 250px;
}

.margin {
  margin-top: 50px;
}
</style>
