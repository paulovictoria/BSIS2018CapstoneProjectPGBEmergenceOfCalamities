<template>
<div>
   <md-list-item v-if="isMessage" 
              @click="getItem">
    <md-avatar>
      <i class="fas fa-location-arrow"></i>
    </md-avatar>
    <div class="md-list-item-text">
      <span>{{rescuerName}} {{status}}</span>
      <span>Location: {{location}}</span>
      <span>{{timeAgo(time)}}</span>
      <span style="display:none">{{id}}</span>
    </div>
  </md-list-item>
  <sweet-modal ref="summary"
              @open="showInfo(id)">
    <div class="md-layout">
      <div class="md-layout-item md-size-50">
        <img :src="imgUrl" 
            class="img-holder"
            id="img"
            @click="openZoom">
        <div class="mdl-typography--text-center md-caption">
          Click the image to view in full size:
        </div>
      </div>
      <div class="md-layout-item md-size-50">
        <div class="mdl-typography--text-center md-title">
          Rescuer Name:
        </div>
        <div class="mdl-typography--text-center md-title">
         {{rescuerName}}
        </div>
        <div class="mdl-typography--text-center md-title margin">
          Reporter Name:
        </div>
        <div class="mdl-typography--text-center md-title">
         {{result.citizen_name}}
        </div>
        <div class="mdl-typography--text-center md-title margin">
          Incident type:
        </div>
        <div class="mdl-typography--text-center md-title">
         {{result.type}}
        </div>
        <div class="mdl-typography--text-center md-title margin">
          Location:
        </div>
        <div class="mdl-typography--text-center md-title">
         {{result.location}} near {{result.landmark}}
        </div>
        <div class="mdl-typography--text-center md-title margin">
          {{timeAgo(result.time)}}
        </div>
      </div>
    </div>
  </sweet-modal>
  <sweet-modal ref="zoom">
        <img :src="imgUrl" 
            style="width:100%; height:100%">
  </sweet-modal>
</div>
</template>

<script>
import timeago from "timeago.js";
export default {
  name: "RescuerItem",
  props: {
    id: {
      type: Number
    },
    rescuerName: {
      type: String
    },
    location: {
      type: String
    },
    landmark: {
      type: String
    },
    time: {
      type: String
    },
    status: {
      type: String
    }
  },
  data() {
    return {
      isMessage: false,
      imgUrl: null,
      result: ""
    };
  },
  methods: {
    openZoom() {
      this.$refs.zoom.open();
    },
    showInfo(id) {
      this.$http.get(`/rescue/name/${id}`).then(response => {
        this.imgUrl = response.data.image;
        this.result = response.data.result;
      });
    },
    getItem() {
      this.$refs.summary.open();
    },
    timeAgo(value) {
      return timeago().format(value);
    },
    checkMessages() {
      if (this.rescuerName) {
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

<style lang="scss" scoped>
.md-list-item {
  border-bottom: 1px solid #dddfe2;
  border-top: 1px solid #dddfe2;
}

.img-holder {
  max-width: 250px;
  max-height: 370px;
  cursor: pointer;
}

.margin {
  margin-top: 10px;
}
</style>
