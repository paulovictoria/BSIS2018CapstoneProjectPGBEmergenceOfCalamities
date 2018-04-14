<template>
        <md-list-item>
					<md-avatar>
						<img :src="`/images/logos/${municipality}.jpg`" :alt="user">
					</md-avatar>
					<div class="md-list-item-text">
						<span>{{user}}</span>
						<p>{{message}}</p>
					</div>
      </md-list-item>
</template>

<script>
export default {
	name: 'ChatMessage',
  props: {
    message: {
      type: String
    },
    user: {
      type: String
		},
		municipality: {
      type: String
    }
  },
	data() {
		return {
			
		}
	}
}
</script>

<style>

</style>
