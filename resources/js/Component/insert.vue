<template>
	<div class="text-center">
		<v-btn block rounded x-large color="success" @click="startPulse">Insert Coins Now</v-btn>
		<v-dialog v-model="dialog" persistent width="500">
			<v-card>
				<v-card-title class="headline grey lighten-2">
					Insert Coin
				</v-card-title>
				<v-card-text class="text-center body-1">
					Total Time : {{ time }}<br>
					Countdown : {{ countdown }}
				</v-card-text>
				<v-divider></v-divider>
				<v-card-actions class="justify-center">
					<v-btn @click="submitPulse">
						Register
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'

export default {
	computed: {
		...mapGetters('client', ['mac', 'pulse', 'time', 'countdown'])
	},
	methods: {
		...mapActions('client', ['receivePulse', 'cleanPulse', 'fetchClient']),
		async startPulse () {
			try {
				const { data } = await axios.get('/api/start')

				this.dialog = true

				this.receivePulse(data)
				Echo.channel('InsertCoin')
				.listen('PulseMessage', (e) => {
					if(e.mac == this.mac)
						this.receivePulse(e)
				})
			} catch(e) {
				alert("System Error. Please Try Again Later")
				this.dialog = false
			}
		},

		async submitPulse () {
			try {
				const { data } = await axios.post('/api/submit')
				Echo.leave('InsertCoin')
				this.cleanPulse()
				this.fetchClient()
				this.dialog = false
			} catch(e) {
				alert("System Error. Please Try Again")
			}
		},
	},
	data () {
		return {
			dialog: false,
		}
	}
};
</script>
