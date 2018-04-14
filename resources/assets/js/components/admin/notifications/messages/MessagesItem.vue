<template>
<div>
   <md-list-item to="/chat" v-if="isMessage">
  <md-avatar>
    <img :src="`/images/logos/${msg.user.municipality}.jpg`">
  </md-avatar>
    <div class="md-list-item-text">
      <span>{{msg.user.name}}:</span>
      <span>{{msg.message}}</span>
      <span>{{timeAgo(msg.messageDate)}}</span>
    </div>
  </md-list-item>
</div>
</template>

<script>
import timeago from "timeago.js";
export default {
  name: "MessagesItem",
  props: {
    msg: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      isMessage: false
    };
  },
  methods: {
    timeAgo(value) {
      return timeago().format(value);
    },
    checkMessages() {
      if (this.msg) {
        this.isMessage = true;
      } else {
        this.isMessage = false;
      }
    }
  },
  mounted() {
    this.checkMessages();
  }
};
</script>

<style scoped lang="scss">
.md-list-item {
  border-bottom: 1px solid #dddfe2;
  border-top: 1px solid #dddfe2;
}

.md-list-item-text {
  color: black !important;
}
</style>
