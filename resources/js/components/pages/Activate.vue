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
                <v-toolbar-title>Internet Status</v-toolbar-title>
                <v-spacer />
              </v-toolbar>
              <v-card-text>
                <v-form>
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
                <v-btn color="primary" v-on:click="">Activate</v-btn>
                <v-btn color="error" v-on:click="">Deactivate</v-btn>
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
    data () {
      return {
        loop: null
      }
    },
    computed: {
        time() { return this.$store.getters.timer }
    },
    mounted () {
      this.startTimer();
      this.$store.commit('isLoading', false);
    },
    methods: {
      startTimer() {
        this.loop = setInterval(this.countDown, 1000);    
      },
      countDown() {
        if(this.$store.getters.seconds > 0) this.$store.commit('decreaseTime');
        else clearInterval(this.loop);
      }
    }
  }
</script>
