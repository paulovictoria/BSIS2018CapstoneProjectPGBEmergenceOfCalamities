<template>
<div>
  			<audio controls style="display:none;" id="audio" ref="audio">
					<source :src="source" type="audio/mp3">      
				</audio> 
        <a class="mdl-navigation__link mdl-color-text--white cursor" @click="showNotifications">
          <span class="mdl-bold">
            <i class="fas fa-address-card"></i>
          </span> 
          <span class="mdl-cell--hide-phone">
           ({{results.length}}) 
          </span>
         </a>
         <div class="md-notifications md-elevation-1" v-if="notifications">
            <md-list class="fixed-notifications">
              <md-list-item v-if="isNone">
                <div class="md-list-item-text">
                  <span class="mdl-typography--text-center">No Rescuer Notifications!</span>
                </div>
              </md-list-item>
              <rescuer-item v-for="result in results"
                            :key="result.id"
                            :rescuerName="result.rescuer.rescuerName"
                            :location="result.location"
                            :landmark="result.landmark"
                            :time="result.time"
                            :status="result.status"
                            :id="result.id"
                            ref="item"/>
            </md-list>
        </div>
  </div>
</template>

<script>
import RescuerItem from "./RescuerItem";
export default {
  name: "RescuerNotifications",
  data() {
    return {
      notifications: false,
      results: [],
      isNone: true,
      source: "sounds/beep.mp3"
    };
  },
  methods: {
    getUpdates() {
      this.$http.get("/rescue/notifications").then(response => {
        this.results = [];
        response.data.forEach(e => {
          this.results.unshift(e);
        });
      });
    },
    showNotifications() {
      if (this.notifications == false) {
        this.notifications = true;
      } else {
        this.notifications = false;
      }
    },
    listenToNotifications() {
      Echo.private("results").listen("NotifyInSiteEvent", e => {
        this.$refs.audio.play();
        this.getUpdates();
      });
    },
    checkMessages() {
      if (this.results.length == 0) {
        this.isNone = true;
      } else {
        this.isNone = false;
      }
    }
  },
  watch: {
    results() {
      this.checkMessages();
    }
  },
  mounted() {
    Promise.all([
      this.listenToNotifications(),
      this.getUpdates(),
      this.checkMessages()
    ]);
  },
  components: {
    "rescuer-item": RescuerItem
  }
};
</script>

<style scoped lang="scss">
.md-notifications {
  width: 385px;
  background-color: white;
  height: 300px;
  position: absolute;
  z-index: 3;
  right: 0px;
  top: 65px;
  .fixed-notifications {
    max-height: 300px;
    overflow: auto;
    width: 100%;
  }
}

.cursor {
  cursor: pointer;
}
</style>
