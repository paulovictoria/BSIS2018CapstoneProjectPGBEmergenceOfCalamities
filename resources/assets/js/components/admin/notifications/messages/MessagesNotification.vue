<template>
<div>
    		<audio controls style="display:none;" id="audio" ref="audio">
					<source :src="source" type="audio/mp3">      
				</audio> 
        <a class="mdl-navigation__link mdl-color-text--white cursor" @click="showNotifications">
          <span class="mdl-bold">
            <i class="fas fa-envelope"></i>
          </span> 
          <span class="mdl-cell--hide-phone">
           ({{allMessages.length}}) 
          </span>
         </a>
         <div class="md-notifications md-elevation-1" v-if="notifications">
            <md-list class="fixed-notifications">
              <md-list-item v-if="isNone">
                <div class="md-list-item-text">
                  <span class="mdl-typography--text-center">No Messages!</span>
                </div>
              </md-list-item>
              <messages-item v-for="msg in allMessages"
                              :key="msg.updated_at"
                              :msg="msg"></messages-item>
            </md-list>
        </div>
  </div>
</template>

<script>
import MessagesItem from "./MessagesItem";
export default {
  name: "MessagesNotification",
  data() {
    return {
      notifications: false,
      allMessages: "",
      isNone: true,
      source: "sounds/beep.mp3"
    };
  },
  methods: {
    showNotifications() {
      if (this.notifications == false) {
        this.notifications = true;
      } else {
        this.notifications = false;
      }
    },
    getsMessages() {
      axios
        .get("/messages")
        .then(response => {
          this.allMessages = response.data;
        })
        .catch(response => {
          console.log(response);
        });
    },
    listenForNewMessage() {
      Echo.private("NewMessages").listen("NewMessageEvent", e => {
        this.$refs.audio.play();
        this.allMessages.unshift(e);
      });
    },
    checkMessages() {
      if (this.allMessages == "" || this.allMessages == null) {
        this.isNone = true;
      } else {
        this.isNone = false;
      }
    }
  },
  watch: {
    allMessages() {
      this.checkMessages();
    }
  },
  mounted() {
    Promise.all([
      this.getsMessages(),
      this.checkMessages(),
      this.listenForNewMessage()
    ]);
  },
  components: {
    "messages-item": MessagesItem
  },
  computed: {
    reverse() {
      return this.allMessages.slice().reverse();
    }
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
