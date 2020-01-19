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
                    label="Time Left"
                    name="time"
                    type="text"
                    :value="time"
                  />
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer />
                <v-btn color="primary" v-on:click="activate" :disabled="isActive">Activate</v-btn>
                <v-btn color="error" v-on:click="deactivate" :disabled="!isActive">Deactivate</v-btn>
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
        time() { return this.$store.getters.timer },
        isActive() { return !!this.$store.getters.isActive }
    },
    created() {
      if(this.$store.getters.isFirst) this.$router.push({ name: 'index' });
      if(this.isActive) this.startTimer();
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
        else this.deactivate();
      },
      activate() {
        this.$store.commit('isLoading', true);
        axios.post('./start', {
        }).then((response) => {
          this.$store.commit('isActive', true);
          this.$store.commit('message', 'Internet Activated.');
          this.$store.commit('isLoading', false);
          this.$router.push({ name: 'message' });
        }).catch((error) => {
          this.$store.commit('message', 'Error Found, try again later.');
          this.$store.commit('isLoading', false);
          this.$router.push({ name: 'message' });
        });
      },
      deactivate() {
        this.$store.commit('isLoading', true);
        axios.post('./stop', {
        }).then((response) => {
          clearInterval(this.loop);
          this.$store.commit('isActive', false);
          this.$store.commit('message', 'Internet Deactivated.');
          this.$store.commit('isLoading', false);
          this.$router.push({ name: 'message' });
        }).catch((error) => {
          clearInterval(this.loop);
          this.$store.commit('message', 'Error Found, try again later.');
          this.$store.commit('isLoading', false);
          this.$router.push({ name: 'message' });
        })
      }
    }
  }
</script>
