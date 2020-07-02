<template>
  <v-container fluid>
    <v-dialog v-model="progressdialog" max-width="500px">
      <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
    </v-dialog>
    <v-card class="mx-auto pb-2" max-width="400" v-if="!authenticated && !user">
      <v-img
        class="white--text align-end"
        height="100px"
        src="https://us.123rf.com/450wm/chaivit/chaivit1501/chaivit150100971/35518847-rode-achtergrond.jpg?ver=6"
      >
        <v-card-title>Вход в личный кабинет</v-card-title>
      </v-img>
      <v-form ref="form" v-model="valid" lazy-validation class="mr-2 ml-2 mt-1">
        <v-text-field
          v-model="name"
          :counter="10"
          :rules="nameRules"
          label="Табельный номер"
          required
        ></v-text-field>

        <v-text-field
          v-model="password"
          label="Пароль"
          required
          :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
          :type="show ? 'text' : 'password'"
          @click:append="show = !show"
        ></v-text-field>

        <!-- <v-select
          v-model="select"
          :items="items"
          :rules="[v => !!v || 'Item is required']"
          label="Item"
          required
        ></v-select>-->

        <!-- <v-checkbox
          v-model="checkbox"
          :rules="[v => !!v || 'You must agree to continue!']"
          label="Do you agree?"
          required
        ></v-checkbox> -->

        <v-btn :disabled="!valid" color="success" class="mr-4" @click="validate">Войти</v-btn>

        <!-- <v-btn color="warning" @click="resetValidation">Reset Validation</v-btn> -->
      </v-form>
    </v-card>
    <v-card class="mx-auto" max-width="344" outlined v-else>
      <v-list-item three-line>
        <v-list-item-content>
          <v-list-item-title class="headline mb-1">Вы уже вошли</v-list-item-title>
          <v-list-item-subtitle>{{user.last_name}} {{user.first_name}}</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </v-card>
  </v-container>
</template>
<script>
export default {
  data: () => ({
    progressdialog: false,
    password: "",
    show: false,
    valid: true,
    name: "",
    authenticated: auth.check(),
    user: auth.user,
    nameRules: [
      v => !!v || "Номер введен неправильно",
      v => /^[0-9]+$/.test(v) || "Могут быть только цифры"
    ],
    email: "",
    emailRules: [
      v => !!v || "E-mail is required",
      v => /.+@.+\..+/.test(v) || "E-mail must be valid"
    ],
    select: null,
    items: ["Item 1", "Item 2", "Item 3", "Item 4"],
    checkbox: false
  }),

  methods: {
    validate() {
      this.progressdialog = true;
      this.$refs.form.validate();
      let formData = new FormData();
      formData.append("num", this.name);
      formData.append("pas", this.password);
      axios
        .post("api/login", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(response => {
          console.log(response.data);
          let res = response.data;
          auth.login(res.token, res.user);
          this.$router.push("/table");
          this.progressdialog = false;
        })
        .catch(error => {
          console.log(error);
          this.progressdialog = false;
        });
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    }
  }
};
</script>
