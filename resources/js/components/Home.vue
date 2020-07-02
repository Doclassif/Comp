
<template>
  <div>
    <v-parallax src="/storage/images/homepage.jpg" height="1080">
      <v-row align="center" justify="center">
        <v-col class="text-center text1" cols="12">
          <h1 class="display-1 font-weight-thin mb-4">Vue + Laravel + SPA</h1>
          <h4 class="subheading">Онлайн каталог сотрудников</h4>
        </v-col>
      </v-row>
    </v-parallax>
    <v-parallax height="600">
      <v-row align="center" justify="center">
        <v-col class="text-center black--text" cols="12">
          <h1
            class="display-1 font-weight-thin mb-4"
          >Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h1>
        </v-col>
      </v-row>
    </v-parallax>
    <v-carousel hide-delimiters>
      <v-carousel-item v-for="(item,i) in items" :key="i" :src="item.src"></v-carousel-item>
    </v-carousel>
  </div>
</template>
<script>
export default {
  data() {
    return {
      items: [
        {
          src: "https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg"
        },
        {
          src: "https://cdn.vuetifyjs.com/images/carousel/sky.jpg"
        },
        {
          src: "https://cdn.vuetifyjs.com/images/carousel/bird.jpg"
        },
        {
          src: "https://cdn.vuetifyjs.com/images/carousel/planet.jpg"
        }
      ]
    };
  }
};
</script>
<style>
.text1 {
  opacity: 0.7;
  background-color: #272727;
}
</style>
