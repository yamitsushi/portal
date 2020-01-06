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
    data() {
      return {
        test:'test'
      }
    },
    computed: {
        pulse() { return this.$store.getters.amount; },
        time() { return this.$store.getters.time }
    },
    created () {
      Echo.channel('portal')
        .listen('PulseMessage', (e) => {
            this.$store.commit('pulseIncrement');
        });
    },
    mounted () {
      this.$store.commit('isLoading', false);
      console.log(this.test);
    },
    methods: {
      rent: function () {
        this.$store.commit('isLoading', true);
        axios.get('./start', {
          timer: this.$store.getters.amount
        }).then((response) => {
          console.log(response);
        }).catch((error) => {
          console.log(error);
        });
      }
    }
  }
</script>
