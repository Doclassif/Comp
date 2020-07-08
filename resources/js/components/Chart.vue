<template>
  <v-container fluid>
    <div>
      <v-row align="center">
        <v-col cols="12">
          <tree
            class="treechart"
            :data="tree"
            node-text="name"
            :zoomable=true
            layoutType="horizontal"
          ></tree>
        </v-col>
      </v-row>
    </div>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      tree: this.fetchDataNew()
    };
  },
  computed: {},
  created() {
    
  },
  methods: {
    parsData(arr, all) {
      arr.forEach(function(item, index, array) {
        var data = all.filter(user => user.сhief_num === item.number_personnel);
        data.forEach(function(item, index, array) {
          if (
            arr.find(user => user.number_personnel === item.number_personnel)
          ) {
          } else {
            arr.push(item);
          }
        });
      });
      return arr;
    },
    fetchDataNew() {
      var users = [];
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
        users = response.data;
        var chiefIdArr = new Array();
        chiefIdArr = users.filter(user => user.сhief_num === 1);
        var u1 = users.filter(user => user.id === 1);

        // test
        var i = 0;
        while (i < 255) {
          chiefIdArr = this.parsData(chiefIdArr, users);
          ++i;
        }

        chiefIdArr.reverse();
        u1.forEach(function(item, index, array) {
          chiefIdArr.push(item);
        });

        chiefIdArr.reverse();
        chiefIdArr = chiefIdArr.filter(user => user.chief === 1);

        chiefIdArr.reverse();
        //распределение
        chiefIdArr.forEach(function(item1, index1, array1) {
          chiefIdArr.forEach(function(item2, index2, array2) {
            if (item2.сhief_num == item1.number_personnel) {
              item1.children.push(item2);
              delete array2[index2];
            }
          });
        });

        chiefIdArr.reverse();

        this.tree = chiefIdArr[0];
       
      });
    }
  }
};
</script>
<style type="text/css">
.treechart {
  height: 1000px;
}
</style> 