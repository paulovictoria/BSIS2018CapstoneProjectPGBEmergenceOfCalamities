<template>
<div>
  <md-list class="md-triple-line log--height" v-chat-scroll>
         <chat-message v-for="message in messages" 
                    :key="message.id"
                    :message="message.message"
                    :user="message.user.name"
                    :municipality="message.user.municipality"></chat-message>
  </md-list>
    <div class="empty" v-show="messages.length === 0">
      <p class="mdl-typography--text-center mdl-typography--body">
        No conversations found!
      </p>
    </div>
</div>
</template>

<script>
import ChatMessage from './ChatMessage';
export default {
  name: 'ChatLog',
  props: {
    messages: {
      type: Array
    }
  },
  data() {
    return {
      
    }
  },
  components: {
    'chat-message': ChatMessage
  }

}
</script>

<style scoped>
.log--height {
    height: 490px;
    max-height: 100vh;
    overflow: auto;
    background-color:#fafafa;
    margin-left: 10px;
}

/* .md-triple-line .log--height {
  background-color:#fafafa !important;
} */
</style>
