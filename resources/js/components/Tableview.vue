<template>
  <v-container fluid>
    <div class="fixed-div">
      <v-row align="center">
        <v-col cols="3"></v-col>
        <v-col cols="6">
          <v-scroll-y-reverse-transition>
            <v-text-field
              v-scroll="onScroll"
              v-show="search2"
              v-model="search"
              append-icon="mdi-magnify"
              label="Поиск"
              single-line
              solo
              dense
            ></v-text-field>
          </v-scroll-y-reverse-transition>
        </v-col>
        <v-col cols="3"></v-col>
      </v-row>
    </div>

    <v-dialog v-model="progressdialog" max-width="500px">
      <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
    </v-dialog>

    <v-data-table
      :headers="headers"
      :items="items"
      :search="search"
      :footer-props="{'items-per-page-options':[30, 50, 100, -1]}"
      sort-by="number_personnel"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat color="white">
          <v-toolbar-title>
            Все сотрудники
            <v-btn icon @click="upd">
              <v-icon>mdi-cached</v-icon>
            </v-btn>
          </v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Поиск"
            single-line
            hide-details
          ></v-text-field>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2" v-on="on" v-if="authenticated && user">Новый</v-btn>
              <v-spacer v-else></v-spacer>
            </template>

            <v-card>
              <v-card-title>
                <span class="headline" v-if="authenticated && user">{{ formTitle }}</span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-card class="mx-auto" max-width="434" tile>
                    <v-img height="100%" src="https://tabmagi.net/images/intro_bg.png">
                      <v-row align="end" class="fill-height">
                        <v-col align-self="start" class="pa-0">
                          <v-avatar class="profile" color="grey" size="164" tile>
                            <template>
                              <v-img :src="editedItem.image_url">
                                <v-file-input
                                  v-if="authenticated && user"
                                  v-model="files"
                                  :rules="rules"
                                  accept="image/jpeg"
                                  prepend-icon="mdi-camera"
                                  class="pl-4 pt-0 ma-0"
                                  @change="submitFile"
                                ></v-file-input>
                              </v-img>
                            </template>
                          </v-avatar>
                        </v-col>

                        <v-col cols="6">
                          <!-- <v-list-item-content>
                            <v-list-item-title class="title"></v-list-item-title>
                          </v-list-item-content>-->
                        </v-col>
                        <v-col class="py-0">
                          <v-list-item color="rgba(0, 0, 0, .4)">
                            <v-list-item-content>
                              <v-list-item-subtitle></v-list-item-subtitle>
                              <v-list-item-subtitle>[00000{{editedItem.number_personnel}}]</v-list-item-subtitle>
                              <v-list-item-title
                                class="title"
                              >{{editedItem.last_name}} {{editedItem.first_name}} {{editedItem.middle_name}}</v-list-item-title>
                              <v-list-item-subtitle>{{editedItem.position}}</v-list-item-subtitle>
                            </v-list-item-content>
                          </v-list-item>
                        </v-col>
                      </v-row>
                    </v-img>
                  </v-card>
                  <v-row v-if="authenticated && user">
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.number_personnel" label="Табельный номер"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.last_name" label="Фамилия"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.first_name" label="Имя"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.middle_name" label="Отчетсво"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.position" label="Должность"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-autocomplete
                        v-model="editedItem.сhief_num"
                        :items="chiefs"
                        label="Начальник"
                        item-text="name"
                        item-value="number_personnel"
                      >
                        <template v-slot:selection="data">
                          <v-chip
                            v-bind="data.attrs"
                            :input-value="data.selected"
                            @click="data.select"
                          >
                            <v-avatar left>
                              <v-img :src="data.item.image_url"></v-img>
                            </v-avatar>
                            {{ data.item.number_personnel }}
                          </v-chip>
                        </template>
                        <template v-slot:item="data">
                          <template v-if="typeof data.item !== 'object'">
                            <v-list-item-content v-text="data.item"></v-list-item-content>
                          </template>
                          <template v-else>
                            <v-list-item-avatar size="36">
                              <img :src="data.item.image_url" />
                            </v-list-item-avatar>
                            <v-list-item-content>
                              <v-list-item-title
                                v-html="data.item.last_name+' '+data.item.first_name"
                              ></v-list-item-title>
                              <v-list-item-subtitle v-html="data.item.number_personnel"></v-list-item-subtitle>
                            </v-list-item-content>
                          </template>
                        </template>
                      </v-autocomplete>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                    </v-col>

                    <!-- <v-col cols="12" lg="6">
                      <v-menu
                        ref="menu1"
                        v-model="menu1"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="dateFormatted"
                            label="Date"
                            hint="MM/DD/YYYY format"
                            persistent-hint
                            prepend-icon="event"
                            @blur="date = parseDate(dateFormatted)"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="date" no-title @input="menu1 = false"></v-date-picker>
                      </v-menu>
                    </v-col>-->

                    <v-col cols="12" sm="6" md="4">
                      <!--  <v-text-field v-model="editedItem.date_start_work" label="Дата приема"></v-text-field>
                      </v-col>-->
                      <v-menu
                        ref="menu"
                        v-model="datemenu"
                        :close-on-content-click="false"
                        :return-value.sync="editedItem.date_start_work"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="editedItem.date_start_work"
                            label="Дата приема"
                            readonly
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="editedItem.date_start_work" no-title scrollable>
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="menu = false">Закрыть</v-btn>
                          <v-btn text color="primary" @click="$refs.menu.save(date)">Принять</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-col>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field v-model="editedItem.payday" label="Зарплата"></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Закрыть</v-btn>
                <v-btn
                  color="blue darken-1"
                  text
                  @click="save"
                  v-if="authenticated && user"
                >Сохранить</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>

      <template v-slot:item.actions="{ item }" v-if="authenticated && user">
        <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
        <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
      </template>
      <template v-slot:item.actions="{ item }" v-else>
        <v-icon small class="mr-2" @click="editItem(item)">mdi-folder</v-icon>
      </template>
      <template v-slot:item.avatar="{ item }">
        <v-avatar class="profile" color="grey" size="40">
          <template>
            <v-img :src="item.image_url"></v-img>
          </template>
        </v-avatar>
      </template>
    </v-data-table>
    <v-snackbar
      v-model="snackbar"
      :timeout="timeoutsnack"
      :color="colorsnack"
      right
    >{{ snackbartext }}</v-snackbar>
  </v-container>
</template>
<style>
.v-avatar .v-input__control {
  display: none;
}
.fixed-div {
  position: fixed;
  top: 10px;
  width: 100%;
  z-index: 999999;
}
</style>
<script>
export default {
  data() {
    return {
      rules: [
        value =>
          !value ||
          value.size < 2000000 ||
          "Изображение не должно быть более 2 MB!"
      ],
      snackbar: false,
      search2: false,
      authenticated: auth.check(),
      user: auth.user,
      snackbartext: "",
      colorsnack: "",
      date: new Date().toISOString().substr(0, 10),
      datemenu: false,
      timeoutsnack: 2000,
      progressdialog: false,
      files: [],
      jopa: "dsadasdsad",
      file: "",
      dialog: false,
      headers: [
        //   {
        //     text: "",
        //     align: "start",
        //     sortable: false,
        //     value: "name"
        //  },

        { text: "Номер", value: "number_personnel" },
        { text: "Фото", value: "avatar", sortable: false },
        { text: "Фамилия", value: "last_name" },
        { text: "Имя", value: "first_name" },
        { text: "Отчество", value: "middle_name" },
        { text: "Должность", value: "position" },
        { text: "Дата приёма", value: "date_start_work", sortable: false },
        { text: "Зарплата", value: "payday" },
        { text: "Действия", value: "actions", sortable: false }
      ],
      items: [],
      chiefs: [],
      search: "",
      editedIndex: -1,
      editedItem: {
        last_name: "",
        first_name: "",
        middle_name: "",
        position: "",
        date_start_work: "",
        payday: 0,
        email: "",
        chief_num: 0,
        number_personnel: 0
      },
      defaultItem: {
        number_personnel: 0,
        last_name: "",
        first_name: "",
        middle_name: "",
        position: "",
        date_start_work: "",
        payday: 0,
        email: "",
        chief_num: 0
      }
    };
  },

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Новый" : "Изменить";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },
  mounted() {
    Event.$on("userLogOut", () => {
      this.authenticated = false;
      this.user = null;
    });
  },
  created() {
    this.initialize();
  },

  methods: {
    onScroll(e) {
      if (typeof window === "undefined") return;
      const top = window.pageYOffset || e.target.scrollTop || 0;
      this.search2 = top > 20;
    },
    upd() {
      this.progressdialog = true;
      setTimeout(() => (this.progressdialog = false), 2000);
      this.items = [];
      this.initialize();

      // this.progressdialog=false;
    },
    submitFile() {
      let formData = new FormData();
      formData.append("file", this.files);
      formData.append("item", this.editedItem.number_personnel);
      axios
        .post("api/fileUpd", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          this.initialize();

          // console.log(response);
        })
        .catch(error => console.log(error));
    },

    initialize() {
      this.progressdialog = true;
      axios.get("api/users/").then(response => {
        response.data.forEach(function(item, index, array) {
          item.children = [];
        });
        this.items = response.data;
        var chiefsobj = this.items.filter(item => item.chief == true);
        var chiefs = new Array();
        chiefsobj.forEach(function(item, index, array) {
          chiefs.push(item.number_personnel);
        });
        this.chiefs = chiefsobj;
        //  console.log(chiefs);
        this.progressdialog = false;
        return response.data;
      });
    },
    editItem(item) {
      this.editedIndex = this.items.indexOf(item);

      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.items.indexOf(item);

      confirm("Вы точно хотите удалить запись?") &&
        this.items.splice(index, 1) &&
        axios
          .delete("api/users/" + item.id)
          .then(response => {
            this.snackbarInit("Данные удалены", "info");
          })
          .catch(error => {
            this.snackbarInit("Ошибка удаления", "error");
            console.log(error);
          });
    },

    close() {
      this.dialog = false;
      this.editedItem = Object.assign({}, this.defaultItem);
      this.editedIndex = -1;
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.items[this.editedIndex], this.editedItem);
        axios
          .put("api/users/" + this.editedItem.id, this.editedItem)
          .then(response => {
            this.snackbarInit("Данные обновлены", "info");
          })
          .catch(error => {
            this.snackbarInit("Ошибка обновления", "error");
            console.log(error);
          });
      } else {
        this.items.push(this.editedItem);
        console.log(this.editedItem.number_personnel);
        axios
          .post("api/users/", this.editedItem)
          .then(response => {
            this.snackbarInit("Данные добавлены", "info");
          })
          .catch(error => {
            this.snackbarInit("Ошибка добавления", "error");
            console.log(error);
          });
      }
      this.close();
    },
    snackbarInit(text, color) {
      this.colorsnack = color;
      this.snackbartext = text;
      this.snackbar = true;
    }
  }
};
</script>

