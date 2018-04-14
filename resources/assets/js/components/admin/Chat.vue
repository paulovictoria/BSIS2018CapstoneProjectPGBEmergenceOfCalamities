<template>
	<div class="md-layout md-max-width">
		<div class="md-layout-item md-large-size-20 md-medium-size-20 md-small-size-30 chat-holder">
				<p class="md-headline mdl-typography--text-center">
					<span class="md-xsmall-hide">Online</span> ({{numberOfUsers.length}})
				</p>
				<md-list v-for="user in numberOfUsers" 
									:key="user.name"
									class="online-log">
					 <md-list-item>
						<md-avatar>
							<img :src="`/images/logos/${user.municipality}.jpg`" :alt="user.name">
						</md-avatar>
						<div class="md-list-item-text">
							<span class="md-xsmall-hide">{{user.name}}</span>
						</div>
					</md-list-item>
				</md-list>
		</div>
		<div class="md-layout-item md-large-size-80 md-medium-size-80 md-small-size-70 chat-holder chat-border">
				<p class="md-headline mdl-typography--text-center">
					PDRRMO Bulacan Chat
				</p>	
			<chat-log :messages="messages"></chat-log>
      <chat-composer v-on:message-sent="addMessage"
										 class="mdl-color--white composer--margin"></chat-composer>
		</div>
	</div>
</template>

<script>
import ChatLog from "./chat/ChatLog";
import ChatMessage from "./chat/ChatMessage";
import ChatComposer from "./chat/ChatComposer";
import axios from "axios";

export default {
  name: "Chat",
  props: {
    allMessages: {
      type: Array
    },
    allUsers: {
      type: Array
    }
  },
  components: {
    "chat-log": ChatLog,
    "chat-composer": ChatComposer
  },
  data() {
    return {
      messages: this.allMessages,
      numberOfUsers: this.allUsers
    };
  },
  methods: {
    addMessage(message) {
      axios
        .post("/messages", message)
        .then(response => console.log(response.data))
        .catch(response => console.log(response.data));
    },
    chat() {
      axios
        .get("/messages")
        .then(response => {
          this.messages = response.data;
        })
        .catch(response => {
          console.log(response);
        });
    },
    listenForOnline() {
      window.Echo.join("chat")
        .here(users => {
          this.numberOfUsers = users;
        })
        .joining(user => {
          this.numberOfUsers.push(user);
        })
        .leaving(user => {
          this.numberOfUsers = this.numberOfUsers.filter(u => u != user);
        })
        .listen("ChatEvent", e => {
          this.messages.push({
            message: e.message.message,
            user: e.user
          });
          Notification.requestPermission(permission => {
            let notification = new Notification(
              `New message from ${e.user.name}`,
              {
                body: e.message.message,
                icon: `/images/logos/${e.user.municipality}.jpg`
              }
            );
            notification.onclick = () => {
              window.open(window.location.href);
            };
          });
        });
    }
  },
  created() {
    this.chat();
    this.listenForOnline();
  }
};
</script>

<style lang="scss" scoped>
.chat-holder {
  height: 500px;
  max-height: 100vh;
  padding-top: 20px;
}

.chat-border {
  border-left: 1px solid rgba(0, 0, 0, 0.2) !important;
}

.online-log {
  background-color: #fafafa !important;
  max-height: 490px;
  overflow: auto;
}

.md-max-width {
  background-color: #fafafa;
}
</style>
