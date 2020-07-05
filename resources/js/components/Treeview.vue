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
              @change="fetchData(search)"
            ></v-text-field>
          </v-scroll-y-reverse-transition>
        </v-col>
        <v-col cols="3"></v-col>
      </v-row>
    </div>
    <v-row>
      <v-col cols="2" class="d-none d-md-flex d-lg-flex d-xl-flex"></v-col>
      <v-col class="d-flex d-sm-flex d-md-flex d-lg-none">
        <div align-self="center">
          <v-card v-if="selected!=''" :key="selected.id" class="ma-0 pa-0" max-width="434" tile>
            <v-img height="100%" src="https://tabmagi.net/images/intro_bg.png">
              <v-row align="end" class="fill-height">
                <v-col align-self="start" class="pa-0" cols>
                  <v-avatar class="profile" color="grey" size="164" tile>
                    <template>
                      <v-img :src="selected.image_url"></v-img>
                    </template>
                  </v-avatar>
                </v-col>
                <v-col cols="4">
                  <v-list-item-content>
                    <v-list-item-title class="title"></v-list-item-title>
                  </v-list-item-content>
                </v-col>
                <v-col class="py-0">
                  <v-list-item color="rgba(0, 0, 0, .4)">
                    <v-list-item-content>
                      <v-list-item-subtitle>[00000{{selected.number_personnel}}]</v-list-item-subtitle>
                      <v-list-item-title
                        class="title"
                      >{{selected.last_name}} {{selected.first_name}} {{selected.middle_name}}</v-list-item-title>
                      <v-list-item-subtitle>{{selected.position}}</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                </v-col>
              </v-row>
            </v-img>
          </v-card>
        </div>
      </v-col>
      <v-col cols="2" class="d-none d-md-flex d-lg-flex d-xl-flex"></v-col>
    </v-row>
    <v-row>
      <v-dialog v-model="loading" max-width="500px">
        <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
      </v-dialog>
      <v-col cols="2" class="d-none d-md-flex d-lg-flex d-xl-flex"></v-col>
      <v-col cols="auto">
        <v-text-field
          v-model="search"
          label="Поиск"
          flat
          class="ma-1"
          single-line
          hide-details
          clearable
          clear-icon="mdi-close-circle-outline"
          @change="fetchData(search)"
        ></v-text-field>
        <!-- <v-treeview
        v-if="items"
        :items="items"
        :active.sync="active"
        :search="search"
        :open.sync="open"
        activatable
        transition
      >
        <template v-slot:prepend="{ item }">
          <v-icon
            v-if="item"
            v-text="`mdi-${item.children.length != 0 ? 'account-tie' : 'account-outline'}`"
          ></v-icon>
          <v-avatar v-if="item.image_url" class="profile" color="grey" size="40">
            <template>
              <v-img :src="item.image_url"></v-img>
            </template>
          </v-avatar>
          <v-avatar v-else class="profile" color="red" size="40">
            <span class="white--text headline">{{item.first_name[0]}}{{item.last_name[0]}}</span>
          </v-avatar>
        </template>
        <template v-slot:label="{ item }">
          <div :key="item.id" v-text=" item.name"></div>
        </template>
        <template v-slot:append="{ item }">
          <template
            v-if="item.children != null && item.children.length > 0"
          >{{ item.children.length }}</template>
        </template>
      </v-treeview>

        <v-divider></v-divider>-->
        <Tree :data="items" :draggable="checkUser()" cross-tree @drag="drag" @drop="drop">
          <div slot-scope="{data, store}">
            <template v-if="!data.isDragPlaceHolder && data.visible==true">
              <div @click="opencard(data)">
                <v-icon
                  v-if="data.children && data.children.length"
                  @click="store.toggleOpen(data); this.fetchDatanew(data.id)"
                  v-text="`mdi-${data.open ? 'chevron-down' : 'chevron-up'}`"
                ></v-icon>
                <v-icon
                  v-if="data"
                  v-text="`mdi-${data.children.length != 0 ? 'account-tie' : 'account-outline'}`"
                ></v-icon>
                <v-avatar v-if="data.image_url" class="profile" color="grey" size="25">
                  <template>
                    <v-img :src="data.image_url"></v-img>
                  </template>
                </v-avatar>
                <span>{{data.text}}</span>
              </div>
            </template>
          </div>
        </Tree>
      </v-col>
      <v-divider vertical class="d-none d-lg-flex d-xl-flex"></v-divider>

      <v-col class="d-none d-lg-flex d-xl-flex">
        <v-scroll-y-transition mode="out-in">
          <div
            v-if="selected==''"
            class="title grey--text text--lighten-1 font-weight-light"
            style="align-self: center;"
          >Выбор</div>
          <v-card v-else :key="selected.id" class="ma-0 pa-0" max-width="434" max-height="250" tile>
            <v-img height="100%" src="https://tabmagi.net/images/intro_bg.png">
              <v-row align="end" class="fill-height">
                <v-col align-self="start" class="pa-0" cols>
                  <v-avatar class="profile" color="grey" size="164" tile>
                    <template>
                      <v-img :src="selected.image_url"></v-img>
                    </template>
                  </v-avatar>
                </v-col>
                <v-col cols="4">
                  <v-list-item-content>
                    <v-list-item-title class="title"></v-list-item-title>
                  </v-list-item-content>
                </v-col>
                <v-col class="py-0">
                  <v-list-item color="rgba(0, 0, 0, .4)">
                    <v-list-item-content>
                      <v-list-item-subtitle>[00000{{selected.number_personnel}}]</v-list-item-subtitle>
                      <v-list-item-title
                        class="title"
                      >{{selected.last_name}} {{selected.first_name}} {{selected.middle_name}}</v-list-item-title>
                      <v-list-item-subtitle>{{selected.position}}</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                </v-col>
              </v-row>
            </v-img>
          </v-card>
        </v-scroll-y-transition>
      </v-col>
      <v-col cols="2" class="d-none d-md-flex d-lg-flex d-xl-flex"></v-col>
    </v-row>
    <v-snackbar
      v-model="snackbar"
      bottom
      color="info"
      right
      :timeout="timeoutsnack"
    >{{ snackbartext }}</v-snackbar>
  </v-container>
</template>

<script>
import { DraggableTree } from "vue-draggable-nested-tree";
import axios from "axios";
export default {
  components: { Tree: DraggableTree },
  data() {
    return {
      loading: false,
      items: [],
      error: null,
      snackbartext: null,
      colorsnack: null,
      timeoutsnack: 2000,
      snackbar: false,
      dialog: false,
      original: null,
      search: null,
      search2: false,
      selected: [],
      authenticated: auth.check(),
      user: auth.user,
      dragvalue: null,
      dropvalue: null,
      chiefIdArr: [1]
    };
  },
  computed: {},
  created() {
    this.fetchDataOriginal();
    this.fetchDataNew();
  },
  methods: {
    onScroll(e) {
      if (typeof window === "undefined") return;
      const top = window.pageYOffset || e.target.scrollTop || 0;
      this.search2 = top > 200;
    },
    checkUser() {
      if (this.authenticated && this.user) {
        return true;
      } else {
        return false;
      }
    },
    opencard(v) {
      this.selected = v;
    },

    drag(value) {
      this.dragvalue = value;
    },
    drop(value) {
      this.dropvalue = value;
      this.dragvalue.сhief_num = this.dropvalue.parent.number_personnel;
      var newdragvalue = {
        number_personnel: this.dragvalue.number_personnel,
        first_name: this.dragvalue.first_name,
        last_name: this.dragvalue.last_name,
        middle_name: this.dragvalue.middle_name,
        position: this.dragvalue.position,
        date_start_work: this.dragvalue.date_start_work,
        payday: this.dragvalue.payday,
        сhief_num: this.dragvalue.сhief_num,
        email: this.dragvalue.email
      };
      console.log("api/users/" + this.dragvalue.id);
      console.log(newdragvalue);
      console.log(this.dragvalue.id, this.dragvalue.number_personnel);
      axios
        .put("api/users/" + this.dragvalue.id, newdragvalue)
        .then(response => {
          this.snackbarInit(
            "Начальник работника " +
              this.dragvalue.last_name +
              " " +
              this.dragvalue.first_name +
              " изменен на " +
              this.dropvalue.parent.last_name +
              " " +
              this.dropvalue.parent.first_name,
            "indigo"
          );
        })
        .catch(error => {
          this.snackbarInit("Ошибка обновления", "error");
          console.log(error);
        });
    },
    fetchDataOriginal() {
      axios.get("api/users/").then(response => {
        response.data.forEach(function(item, index, array) {
          item.name =
            item.number_personnel +
            " " +
            item.last_name +
            " " +
            item.first_name +
            " " +
            item.middle_name +
            " " +
            item.position;
          item.children = [];
        });

        this.original = response.data;
      });
    },
    snackbarInit(text, color) {
      this.colorsnack = color;
      this.snackbartext = text;
      this.snackbar = true;
    },
    func(params) {
      
    },
    fetchDataNew(id) {
      var g = 1;
      var i = 0;
      var res;
      while (i != 5) {
        this.chiefIdArr.forEach(function(item, index, array) {
          axios.get("api/users/" + item).then(response => {
            console.log("api/users/" + item);
            response.data.forEach(function(item, index, array) {
              
            });
            console.log(chiefIdArr);
          });
          // this.items=res;
        });

        ++i;
      }
    },
    fetchData(search) {
      this.error = this.items = null;
      this.loading = true;
      axios.get("api/users/").then(response => {
        // обработка
        console.log(response.data);
        response.data.forEach(function(item, index, array) {
          item.text =
            item.number_personnel +
            " " +
            item.last_name +
            " " +
            item.first_name +
            " " +
            item.middle_name +
            " " +
            item.position;
          item.children = [];
          item.visible = true;
          item.open = false;
          if (item.chief == 1) {
            item.droppable = true;
          } else {
            item.droppable = false;
          }
          item.name = item.text;
        });
        if (search) {
          response.data.forEach(function(item, index, array) {
            if (item.number_personnel == search) {
              item.visible = true;
            } else {
              item.visible = false;
            }
          });
        }
        response.data.reverse();
        //распределение
        response.data.forEach(function(item1, index1, array1) {
          response.data.forEach(function(item2, index2, array2) {
            if (item2.сhief_num == item1.number_personnel) {
              item1.children.push(item2);
              delete array2[index2];
              // console.log(array2[index2]);
            }
          });
        });

        // response.data.forEach(function(item1, index1, array1) {
        //   response.data.forEach(function(item2, index2, array2) {
        //     if (item2.сhief_num == item1.number_personnel && item2.chief == 1) {
        //       item1.children.push(item2);
        //       delete array2[index2];
        //       // console.log(array2[index2]);
        //     }
        //   });
        // });
        response.data.reverse();

        response.data.forEach(function(item1, index1, array1) {
          response.data.forEach(function(item2, index2, array2) {
            if (item2.сhief_num == item1.number_personnel) {
              item1.children.push(item2);
              delete array2[index2];
              // console.log(array2[index2]);
            }
          });
        });
        this.items = response.data.filter(Boolean);
        this.loading = false;

        return response.data;
      });
    }
  }
};
// div .v-treeview-node__label .v-treeview-node__content
</script>
<style>
.fixed-div {
  position: fixed;
  top: 10px;
  width: 100%;
  z-index: 999999;
}
.tree-node-inner {
  cursor: pointer;
}
.tree-node-inner :hover {
  opacity: 0.9;
  background: #ebebeb;
  -webkit-transition: all 0.3s ease;
  -moz-transition: all 0.3s ease;
  -o-transition: all 0.3s ease;
  transition: all 0.3s ease;
}
.draggable-placeholder-inner {
  border: 1px dashed #0088f8;
  box-sizing: border-box;
  background: rgba(0, 136, 249, 0.09);
  color: #0088f9;
  text-align: center;
  padding: 0;
  display: flex;
  align-items: center;
}
</style>

