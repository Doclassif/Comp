<template>

  <div>
    <v-fab-transition>
      <v-btn
        v-scroll="onScroll"
        v-show="fab"
        fab
        dark
        fixed
        bottom
        right
        color="primary"
        @click="toTop"
      >
        <v-icon>keyboard_arrow_up</v-icon>
      </v-btn>
    </v-fab-transition>
    <v-dialog v-model="progressdialog" max-width="500px">
      <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
    </v-dialog>
    <v-app-bar color="#272727" src="https://tabmagi.net/images/intro_bg.png">
      <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
      <v-toolbar-title
        class="d-none d-sm-flex d-md-flex d-lg-flex d-xl-flex"
      >Онлайн каталог сотрудников</v-toolbar-title>
      <v-toolbar-title class="d-flex d-xs-flex d-sm-none">Онлайн кат. сотр.</v-toolbar-title>
      <v-col class="text-center" cols="5"></v-col>

      <v-spacer></v-spacer>
      <v-slide-y-transition>
      <v-chip
        class="ma-2 d-none d-lg-flex d-xl-flex"
        color="#B71C1C"
        text-color="white"
        v-if="authenticated && user"
        @click="drawer = true"
      >
        Вход выполнен: {{user.last_name }} {{ user.first_name}}
        <v-avatar right>
          <img :src="user.image_url" v-if="authenticated && user" />
        </v-avatar>
      </v-chip>
      </v-slide-y-transition>
      <template v-slot:extension>
        <v-tabs v-model="model" align-with-title>
          <v-tab :href="`#/`" to="/" class="d-none d-md-flex d-lg-flex d-xl-flex">DEMO страница</v-tab>
          <v-tab :href="`#/`" to="/" class="d-flex d-sm-flex d-md-none">
            <v-icon>mdi-home</v-icon>
          </v-tab>

          <v-tab :href="`#/tree`" to="/tree" class="d-none d-md-flex d-lg-flex d-xl-flex">Дерево</v-tab>
          <v-tab :href="`#/tree`" to="/tree" class="d-flex d-sm-flex d-md-none">
            <v-icon>mdi-sort-variant</v-icon>
          </v-tab>

          <v-tab :href="`#/table`" to="/table" class="d-none d-md-flex d-lg-flex d-xl-flex">Таблица</v-tab>
          <v-tab :href="`#/table`" to="/table" class="d-flex d-sm-flex d-md-none">
            <v-icon>mdi-table</v-icon>
          </v-tab>
        </v-tabs>
      </template>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" absolute temporary>
      <template v-slot:prepend>
        <v-list-item two-line>
          <v-list-item-avatar>
            <!--  -->
            <img :src="user.image_url" v-if="authenticated && user" />
            <v-icon v-else>mdi-account</v-icon>
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title></v-list-item-title>
            <v-list-item-subtitle
              v-if="authenticated && user"
            >{{user.last_name }} {{ user.first_name}}</v-list-item-subtitle>
            <v-list-item-subtitle v-else>Вы не вошли</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </template>

      <v-divider></v-divider>
      <v-list nav dense>
        <v-list-item-group active-class="deep-purple--text text--accent-4">
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-exit-to-app</v-icon>
            </v-list-item-icon>
            <v-list-item-title v-if="authenticated && user" @click="logout">Выйти</v-list-item-title>
            <v-list-item-title @click="to" v-else>Войти</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>


<script>
export default {
  data: () => ({
    progressdialog: false,
    drawer: false,
    model: "",
    fab: false,
    authenticated: auth.check(),
    user: auth.user
  }),
  created() {
    this.model = window.location.pathname;
  },
  mounted() {
    Event.$on("userLoggedIn", () => {
      this.authenticated = true;
      this.user = auth.user;
    });

    Event.$on("userLogOut", () => {
      this.authenticated = false;
      this.user = null;
    });
  },
  methods: {
    onScroll(e) {
      if (typeof window === "undefined") return;
      const top = window.pageYOffset || e.target.scrollTop || 0;
      this.fab = top > 20;
    },
    toTop() {
      this.$vuetify.goTo(0);
    },
    to() {
      this.$router.push("/login");
    },
    logout() {
      this.progressdialog = true;
      axios
        .post("api/logout")
        .then(response => {
          auth.logout();
          this.authenticated = auth.check();
          this.user = auth.user;
          this.progressdialog = false;
        })
        .catch(error => {
          console.log(error);
          this.progressdialog = false;
        });
    }
  }
};
</script>

