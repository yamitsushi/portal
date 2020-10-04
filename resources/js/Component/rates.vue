<template>
	<div class="text-center">
		<v-dialog v-model="dialog" width="500">
			<template v-slot:activator="{ on, attrs }">
				<v-btn block rounded x-large color="primary" v-on="on">Wifi Rates</v-btn>
			</template>
			<v-card>
				<v-card-title class="headline grey lighten-2">
					Wifi Rates
				</v-card-title>
				<v-card-text>
					<br>
					<p v-for="rate in rates" class="text-md-body-1">
						{{ rate.pulse }} peso = {{ time(rate.time) }}
					</p>
				</v-card-text>
				<v-divider></v-divider>
			</v-card>
		</v-dialog>
	</div>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
	data () {
		return {
			dialog: false,
		}
	},
	computed: {
		...mapGetters( 'client', ['rates'])
	},
	methods: {
		time: function(sec) {
			var d = Math.floor(sec / 86400)
			var h = Math.floor(sec % 86400 / 3600)
			var m = Math.floor(sec % 86400 % 3600 / 60)
			var s = Math.floor(sec % 86400 % 3600 % 60)

			var dDisplay = d > 0 ? d + (d == 1 ? " day" : " days") : h > 0 && d ? ", " : ""
			var hDisplay = h > 0 ? (d && h ? ", " : "") + h + (h == 1 ? " hour" : " hours") : m > 0 && h ? ", " : ""
			var mDisplay = m > 0 ? ((d || h) && m ? ", " : "") + m + (m == 1 ? " minute" : " minutes") : s > 0 && m ? ", " : ""
			var sDisplay = s > 0 ? ((d || h || m) && s ? ", " : "") + s + (s == 1 ? " second" : " seconds") : ""

			return (dDisplay + hDisplay + mDisplay + sDisplay)
		}
	}
}
</script>
