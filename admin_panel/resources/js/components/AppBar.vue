<template>
  <v-app-bar elevation="1" color="white" app flat dense>
    <v-app-bar-nav-icon @click="toggleDrawer" />
    <v-spacer />

    <v-btn icon>
      <v-badge content="5" borderd left color="red" overlap>
        <v-icon>mdi-bell</v-icon>
      </v-badge>
    </v-btn>
    
  </v-app-bar>
</template>

<script>
import { mapMutations, mapState } from "vuex";
export default {
  name: "AppBar",
  methods: mapMutations(["toggleDrawer"])
};
</script>

<style>
</style>