<template>
	<div class="mdl-grid--no-spacing">
    <gmap-map :center="map.center"
              map-type-id="terrain"
              map-style="green"
              :zoom="map.zoom"
              :style="map.style">

    </gmap-map>
  </div>
</template>

<script>
export default {
  name: "Config",
  data() {
    return {
      map: {
        center: {
          lat: 14.796128,
          lng: 120.877419
        },
        zoom: 11,
        style: {
          width: "100%",
          height: "100vh",
          "max-height": "100vh"
        }
      }
    };
  }
};
</script>

<style>

</style>
