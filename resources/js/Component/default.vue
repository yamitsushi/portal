<template>
	<v-app id="inspire">
		<v-main>
			<v-container class="fill-height" fluid>
				<v-row align="center" justify="center">
					<v-col cols="12" sm="8" md="4">
						<v-card class="elevation-12">
							<v-card class="text-center">
								<p class="text-body-2">Welcome</p>
								<p class="text-subtitle1">Time Remaining</p>
								<p class="text-overline">{{ timer }}</p>
								<v-row justify="center" class="mx-5">
									<v-col>
										<Insert/>
									</v-col>
								</v-row>
								<v-row justify="center" class="mx-5">
									<v-col>
										<Timer/>
									</v-col>
								</v-row>
								<v-row justify="center" class="mx-5">
									<v-col>
										<Rates/>
									</v-col>
								</v-row>
							</v-card>
						</v-card>
					</v-col>
				</v-row>
			</v-container>
		</v-main>
	</v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Insert from './insert'
import Timer from './timer'
import Rates from './rates'

export default {
	components: {
		Insert,
		Timer,
		Rates
	},

	computed: {
		...mapGetters( 'client', ['timer', 'active', 'countdown', 'pulse'])
	},
	methods: {
		...mapActions('client', ['fetchClient', 'fetchRates','decreaseTime', 'decreaseCountdown', 'forceStop'])
	},
	mounted: function() {
		this.fetchClient()
		this.fetchRates()
		window.setInterval(() => {
			this.active ? this.decreaseTime() : ""
			this.active && this.timer == "Please Reload" ? this.updateStatus() : ""
			this.countdown ? this.decreaseCountdown() : this.pulse > 0 ? this.forceStop() : ""
		}, 1000)
	}
};
</script>

<style>
#inspire {
	background-color: gray;
}
</style>