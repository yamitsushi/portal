<template>
  <v-app id="inspire">
    <v-content>
      <v-container
        class="fill-height"
        fluid
      >
        <v-row
          align="center"
          justify="center"
        >
          <v-col
            cols="12"
            sm="8"
            md="4"
          >
            <v-card class="elevation-12">
              <v-toolbar
                color="primary"
                dark
                flat
              >
                <v-toolbar-title>Payment Center</v-toolbar-title>
                <v-spacer />
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field
                    label="Total Amount"
                    name="amount"
                    type="text"
                    :value="pulse"
                  />

                  <v-text-field
                    label="Time Equivalent"
                    name="time"
                    type="text"
                    :value="time"
                  />
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn color="primary" v-on:click="rent">Register</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  export default {
    computed: {
        pulse() { return this.$store.getters.amount; },
        time() { return this.$store.getters.time },
        count() { return this.$store.getters.timer }
    },
    created () {
      if(this.$store.getters.isFirst) this.$router.push({ name: 'index' });
      this.$store.commit('timer', 60);
      this.startTimer();
      Echo.channel('portal')
        .listen('PulseMessage', (e) => {
            this.$store.commit('timer', 60);
            this.$store.commit('pulseIncrement');
        });
    },
    mounted () {
      this.$store.commit('isLoading', false);
    },
    methods: {
      startTimer() {
        this.loop = setInterval(this.countDown, 1000);
      },
      countDown() {
        if(this.$store.getters.seconds > 0) this.$store.commit('decreaseTime');
        else {
          clearInterval(this.loop);
          this.rent();
        }
      },
      rent: function () {
        this.$store.commit('isLoading', true);
        axios.post('./register', {
        }).then((response) => {
          clearInterval(this.loop);
          this.$store.commit('message', 'Registration Successful.');
          this.$store.commit('isLoading', false);
          this.$router.push({ name: 'message' });
        }).catch((error) => {
          clearInterval(this.loop);
          this.$store.commit('message', 'Error Found, try again later.');
          this.$store.commit('isLoading', false);
          this.$router.push({ name: 'message' });
        });
      }
    }
  }
</script>
