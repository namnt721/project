<template>
  <div class="content">
    <div class="col-md-12">
      <form @submit.prevent="addProduct" enctype="multipart/form-data">
        <md-card>
          <md-card-header :data-background-color="dataBackgroundColor">
            <h4 class="title">Thêm mới sản phẩm</h4>
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
                  <img  id="output"  style="max-width: 200px;display: none;"/>
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
                <md-button class="md-raised md-success" type="submit">Thêm mới</md-button>
              </div>
            </div>
          </md-card-content>
        </md-card>
      </form>
    </div>
  </div>
</template>
<script>
import {axios, Swal, baseUrl} from '../index.js';
export default {
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
      categories: [],
      errors: {}
    };
  },
  mounted(){
    this.getCategory()
  },
  methods:{
    getCategory(){
      axios.get(baseUrl + '/api/product/create')
          .then(response => {
            response.data.forEach((value) => {
              this.categories.push(value);
            });
          })
          .catch(error => {
            if(error.response.data.errors){
              this.errors = error.response.data.errors;
            }
          })
    },
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
    addProduct: function (){
      const config = {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      };
      const formData = new FormData();
      ['name', 'category_id','quantity', 'price'].forEach(file => {
        formData.append(file, this.product[file]);
      })
      formData.append('file', this.product.feature_image_path);

      axios.post(baseUrl + '/api/product/store', formData, config)
          .then(response => {
            if(response.data.code === 200){
                this.$router.push({name:'product'});
                Swal.fire({
                icon: 'success',
                title: 'Thêm mới sản phẩm thành công',
                showConfirmButton: false,
                timer: 1500
              })
            }
          })
          .catch(error =>{
            if(error.response.data.errors){
              this.errors = error.response.data.errors;
            }
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
