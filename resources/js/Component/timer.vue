<template>
	<v-btn block rounded x-large :color="active ? 'error' : 'warning'" v-on:click="updateStatus">{{ active ? "Pause Time" : "Start Internet" }}</v-btn>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
	computed: {
		...mapGetters( 'client', ['active'])
	},
	methods: {
		...mapActions('client', ['updateStatus'])
	}
};
</script>