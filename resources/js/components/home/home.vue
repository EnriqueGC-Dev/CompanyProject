<template>
  <div>
    <v-row>
        <v-col cols="4" class="home-container">
            <Home1></Home1>
        </v-col>
        <v-col cols="4" class="home-container">
            <Home1></Home1>
        </v-col>
        <v-col cols="4" class="home-container">
            <Home1></Home1>
        </v-col>
    </v-row>
  </div>
</template>

<script>

export default {
    
    name: 'HomePage',
    mounted() {
    }
};
</script>

<style scoped>
.home-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}
</style>