<template>
   <md-list-item :to="theUrl" v-if="isMessage">
    <md-avatar>
      <i class="fas fa-exclamation-triangle"></i>
    </md-avatar>
    <div class="md-list-item-text">
      <span>{{type}} TIDE ADVISORY as of {{time}}!</span>
      <span>{{timeAgo(dateGathered)}}</span>
      <span>Height: {{height}} M</span>
    </div>
  </md-list-item>
</template>

<script>
import timeago from "timeago.js";
export default {
  name: "TidesItem",
  props: {
    time: {
      type: String
    },
    type: {
      type: String
    },
    dateGathered: {
      type: String
    },
    height: {
      type: String
    }
  },
  data() {
    return {
      theUrl: "",
      isMessage: false,
      showNothing: true
    };
  },
  methods: {
    checkMessages() {
      if (this.time) {
        this.isMessage = true;
      } else {
        this.isMessage = false;
      }
    },
    timeAgo(value) {
      return timeago().format(value);
    }
  },
  mounted() {
    this.checkMessages();
  }
};
</script>

<style lang="scss" scoped>
.md-list-item {
  border-bottom: 1px solid #dddfe2;
  border-top: 1px solid #dddfe2;
}
</style>
