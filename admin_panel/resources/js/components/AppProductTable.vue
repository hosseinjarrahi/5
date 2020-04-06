import Swal from "sweetalert2";
<template>
  <v-data-table :headers="headers" :items="desserts" sort-by="calories" class="elevation-1">
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>محصولات</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on }">
            <v-btn color="primary" dark class="mb-2" v-on="on">
              <v-icon>mdi-plus</v-icon>
              افزودن محصول
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row justify="center" align="center">
                  <v-col cols="12">
                    <v-img :src="editedItem.pic"></v-img>

                    <v-file-input
                      label="تغییر تصویر"
                      prepend-icon="mdi-camera"
                      ref="file"
                    ></v-file-input>

                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="editedItem.title" label="عنوان"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-textarea solo v-model="editedItem.desc" label="توضیحات"></v-textarea>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="editedItem.offer" label="تخفیف"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="editedItem.percentage" label="درصد تکمیل"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="editedItem.price" label="قیمت"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="editedItem.meta.keywords" label="کلمات کلیدی"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field v-model="editedItem.meta.title" label="عنوان صفحه"></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">لغو</v-btn>
              <v-btn color="blue darken-1" text @click="save">ذخیره</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
      <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
    </template>
    <template v-slot:no-data>
      <v-alert>موردی یافت نشد</v-alert>
    </template>
  </v-data-table>
</template>

<script>
export default {
  name: "AppProductTable",
  data: () => ({
    dialog: false,
    headers: [
      { text: "عنوان", align: "start", sortable: false, value: "title"},
      { text: "Actions", value: "actions", sortable: false }
    ],
    desserts: [],
    editedIndex: -1,
    editedItem: {
      title: "",
      desc: 0,
      pic: 0,
      percentage: 0,
      status: 0,
      price: 0,
      offer: 0,
      meta: {
          keywords:'',
          title:'',
      },
    },
    defaultItem: {
        id: -1,
        title: "",
        desc: 0,
        pic: 0,
        percentage: 0,
        status: 0,
        price: 0,
        offer: 0,
        meta: {
            keywords:'',
            title:'',
        },
    }
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "ایجاد" : "ویرایش";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
        axios.post('/manager/products')
        .then(res => {
          return res.data.data;
        })
        .catch(err => {

        })
        .then(p => {
            this.desserts = p;
        });
    },

    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.desserts.indexOf(item);
      confirm("Are you sure you want to delete this item?") &&
        this.desserts.splice(index, 1);
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.desserts[this.editedIndex], this.editedItem);
      } else {
        this.desserts.push(this.editedItem);
      }
      this.close();
    },

      uploadPic() {
          this.$store.state.load = true;
          this.file = this.$refs.file.files[0];

          let formData = new FormData();
          formData.append("file", this.file);

          axios.post("/manager/product/upload", {...formData,id:this.editedItem.id}, {
              headers: {
                  "Content-Type": "multipart/form-data"
              }
          })
              .then(function (response) {

              })
              .catch(function (error) {

              })
              .then(avatar => {

              });
      }
  }
};
</script>

<style>
</style>