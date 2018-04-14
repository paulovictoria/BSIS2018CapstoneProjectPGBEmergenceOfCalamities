<template>
  <div class="md-layout space">
      <input type="text" v-model="message"
                         id="message"
                         @keyup.enter="sendMessage"
                         name="message"
                          class="text-composer"/>
      <!-- <div class="custom-textarea" contenteditable>I look like a textarea</div> -->
   </div>
</template>

<script>
export default {
  name: 'ChatComposer',
  data() {
    return {
      message: ''
    }
  },
  methods: {
    sendMessage() {
      if (this.message.length !== 0) {
        this.$emit('message-sent', {
            message: this.message, 
            user: {
						  name: document.querySelectorAll('.md-list-item-content .md-ripple .md-disabled').textContent 
            }
          });
          this.message = '';
      }
    }
  }

}
</script>

<style lang="scss" scoped>
.composer--margin {
  width: 95%;
  padding-left: 10px
}

.textfield--width {
  width: 95%;
}
.md-layout .space {
   background-color:#fafafa !important;
  .space {
    margin: 0 auto;
  }  
}

.text-composer {
  width: 100%;
    height: 40px;
    font-size: 16px;
    font-family: Noto Sans;
    border-radius: 3px;
    border: 1px solid rgba(0, 0, 0, 0.2) !important;
}
input:focus {outline: none; }
</style>
