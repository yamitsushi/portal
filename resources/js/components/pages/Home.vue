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
            md="8"
          >
            <v-card class="elevation-12">
              <v-card-text>
                <p class="display-1 text-center">Wifi Portal</p>
                <v-simple-table>
                  <thead>
                    <th class="text-left">Pricing</th>
                    <th class="text-left">Time</th>
                  </thead>
                  <tbody>
                    <tr v-for="item in pricing" :key="item.price">
                      <td>{{ item.cost }} pesos</td>
                      <td>{{ (item.time/60) }} Minutes</td>
                    </tr>
                  </tbody>
                </v-simple-table>
                <div class="text-center">
                  <v-btn x-large color="primary" v-on:click="rent">Rent Internet</v-btn>
                  <v-btn x-large color="success" v-on:click="status">Internet Status</v-btn>
                </div>
              </v-card-text>
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
        pricing: [
          { cost: 1, time: 1800 },
        ],
      }
    },
    created () {
      this.$store.commit('inUsed');
    },
    methods: {
      rent: function () {
        this.$store.commit('isLoading', true);
        axios.post('./check', {
        }).then((response) => {
          this.$router.push({ name: 'portal' });
        }).catch((error) => {
          this.$store.commit('message', 'Error Found, try again later.');
          this.$store.commit('isLoading', false);
          this.$router.push({ name: 'message' });
        });
      },
      status: function () {
        this.$store.commit('isLoading', true);
        axios.post('./tag', {
        }).then((response) => {
          this.$store.commit('timer', response['data']['time']);
          this.$store.commit('isActive', response['data']['is_active'])
          this.$router.push({ name: 'status' });
        }).catch((error) => {
          this.$store.commit('message', 'Error Found, try again later.');
          this.$store.commit('isLoading', false);
          this.$router.push({ name: 'message' });
        });
      }
    },
    mounted () {
      this.$store.commit('isLoading', false);
    }
  }
</script>
