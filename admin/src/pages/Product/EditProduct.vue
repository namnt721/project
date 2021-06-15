<template>
  <div class="content">
    <div class="col-md-12">
      <form @submit.prevent="updateProduct" enctype="multipart/form-data">
        <md-card>
          <md-card-header :data-background-color="dataBackgroundColor">
            <h4 class="title">Sửa sản phẩm</h4>
          </md-card-header>

          <md-card-content>
            <div class="md-layout">

              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Tên sản phẩm <span class="error">(*)</span><span class="error" v-if="errors.name"> {{ errors.name[0] }}</span></label>
                  <md-input v-model="product.name" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Danh mục sản phẩm <span class="error">(*)</span><span class="error" v-if="errors.category"> {{ errors.category[0] }}</span></label>
                  <md-select v-model="product.category_id" >
                    <md-option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <img :src="baseUrl + product.feature_image_path" id="output"  style="max-width: 200px;"/>
                  <label>Ảnh sản phẩm </label>
                  <md-file @change="onFileChange" type="file" ></md-file>
                </md-field>

              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Số lượng <span class="error">(*)</span><span class="error" v-if="errors.quantity"> {{ errors.quantity[0] }}</span></label>
                  <md-input v-model="product.quantity" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Giá <span class="error">(*)</span><span class="error" v-if="errors.price"> {{ errors.price[0] }}</span></label>
                  <md-input v-model="product.price" type="text"></md-input>
                </md-field>
              </div>

              <div class="md-layout-item md-size-100 text-right">
                <md-button class="md-raised md-success" type="submit">Cập nhật</md-button>
              </div>
            </div>
          </md-card-content>
        </md-card>
      </form>
    </div>
    <div class="col-md-12">
      <router-link :to="{ name: 'product'}" class="btn btn-success float-right">Quay lại</router-link>
    </div>
  </div>
</template>
<script>
import {axios, Swal, baseUrl} from '../index.js';

export default {
  name: "edit-profile-form",
  props: {
    dataBackgroundColor: {
      type: String,
      default: "green"
    }
  },
  data() {
    return {
      product:{
        name: null,
        category_id: null,
        feature_image_path: '',
        quantity: null,
        price: null
      },
      baseUrl,
      categories: [],
      errors: {}
    };
  },
  mounted(){
    this.getProduct()
  },
  methods:{
    onFileChange(e) {
      let theReader = new FileReader();
      theReader.onload = function() {
        var output = document.getElementById("output");
        output.src = theReader.result;
      };
      theReader.readAsDataURL(e.target.files[0]);
      document.getElementById("output").style.display = 'block'
      this.product.feature_image_path = e.target.files[0]
    },
    getProduct(){
     const url = this.$router.history.current.path
     axios.get(baseUrl + '/api' + url)
         .then(response => {
           this.product.name = response.data.product.name;
           this.product.category_id = response.data.product.category_id;
           this.product.feature_image_path = response.data.product.feature_image_path;
           this.product.quantity = response.data.product.quantity;
           this.product.price = response.data.product.price;
           this.categories = response.data.category

         })
         .catch(error => {
           console.log(error);
         });
   },
    updateProduct(){
      const id = this.$router.history.current.params.id
      const config = {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      };

      const formData = new FormData;
      ['name', 'category_id', 'quantity', 'price'].forEach(file => {
        formData.append(file, this.product[file] )
      })
      formData.append('file', this.product.feature_image_path)
      axios.post(baseUrl + '/api/product/update/' + id, formData, config)
          .then(response => {
            if(response.data.code === 200){
              Swal.fire({
                icon: 'success',
                title: 'Cập nhật danh mục thành công',
                showConfirmButton: false,
                timer: 1500
              })
            }
          })
          .catch(error => {
            Swal.fire({
              icon: 'error',
              title: 'Cập nhật danh mục thất bại',
              showConfirmButton: false,
              timer: 1500
            })
          });
    }
  }
};
</script>
<style>
.error{
  color: red
}
</style>
