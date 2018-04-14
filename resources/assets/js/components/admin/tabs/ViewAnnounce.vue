<template>
    <div>
      <md-card md-with-hover v-for="result in allResults"
                              :key="result.updated_at">
      <md-ripple>
        <md-card-header>
          <div class="md-title">SOS</div>
          <div class="md-subhead">{{result.fullName}}</div>
        </md-card-header>

        <md-card-content>
          {{result.address}}  
        </md-card-content>

        <md-card-actions>
          <md-button>View Location</md-button>
          <md-button>Archive</md-button>
        </md-card-actions>
      </md-ripple>
    </md-card>
  </div>
</template>

<script>
export default {
  name: 'ViewAnnounce',
  props: {
    allReports: {
      type: Array
    }
  }
}
</script>

<style>

</style>
