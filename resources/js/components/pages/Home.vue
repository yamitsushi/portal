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
                      <td>{{ (item.time/60) }} minutes</td>
                    </tr>
                  </tbody>
                </v-simple-table>
                <div class="text-center">
                  <v-btn x-large color="primary" v-on:click="rent">Rent Internet</v-btn>
                  <v-btn x-large color="success" v-on:click="activate">Activate Internet</v-btn>
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
          { cost: 1, time: 300 },
          { cost: 5, time: 1800 },
          { cost: 10, time: 3600 }
        ],
      }
    },
    methods: {
      rent: function () {
        this.$store.commit('isLoading', true);
        axios.post('./check', {
        }).then((response) => {
          this.$router.push({ name: 'portal' });
        }).catch((error) => {
          alert('Error Found, try again later.');
          this.$store.commit('isLoading', false);
        });
      },
      activate: function () {
        this.$store.commit('isLoading', true);
        axios.post('./tag', {
        }).then((response) => {
          this.$store.commit('timer', response['time']);
          this.$router.push({ name: 'activate' });
        }).catch((error) => {
          alert('Error Found, try again later.');
          this.$store.commit('isLoading', false);
        });
      }
    },
    mounted () {
      this.$store.commit('isLoading', false);
    }
  }
</script>
