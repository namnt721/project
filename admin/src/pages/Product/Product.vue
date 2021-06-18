<template>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <router-link :to="{ name: 'createProduct'}" class="btn btn-success float-right">Thêm mới</router-link>
      </div>
      <div class="col-md-12" style="padding-top:20px;">
        <table class="table table-striped">
          <thead class="table-dark">
            <tr>
              <th width="50">#</th>
              <th>Ảnh sản phẩm</th>
              <th>Tên sản phẩm</th>
              <th>Tên danh mục</th>
              <th>Số lượng</th>
              <th>Giá </th>
              <th width="150">Chức năng</th>
            </tr>
          </thead>
          <tbody>

          <tr v-for="product in products" :key="product.id">
            <td>{{ product.id }}</td>
            <td><img :src="baseUrl + product.feature_image_path" alt="" style="max-width: 100px"></td>
            <td>{{ product.name }}</td>
            <td>{{ product.category.name }}</td>
            <td>{{ product.quantity }}</td>
            <td>{{ Intl.NumberFormat().format(product.price) }} đ</td>
            <td>
              <router-link :to="{name: 'updateProduct', params: { id: product.id }}" class="btn btn-success" style="margin-right:5px">Sửa</router-link>
              <button class="btn btn-danger" @click="deleteProduct(product.id)">Xoá</button>
            </td>
          </tr>

          </tbody>
        </table>

      </div>
    </div>
  </div>
</template>

<script>
import {axios, Swal, baseUrl} from '../index.js';
export default {
  data(){
    return {
      products: [],
      baseUrl
    }
  },
  mounted() {
    this.getProduct()
  },
  methods:{
    getProduct(){
      axios.get(baseUrl + '/api/product')
          .then(response => {
             response.data.forEach((value) => {
               this.products.push(value);
            });
          })
          .catch(error => {
            console.log(error);
          });
    },
    deleteProduct(id){
      Swal.fire({
        title: 'Bạn chắc chắn chứ',
        text: "Bạn có muốn xoá sản phẩm này không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xoá',
        cancelButtonText: 'Không',
      }).then((result) => {
        if (result.isConfirmed) {
          axios.get(baseUrl + '/api/product/delete/' + id)
              .then(response => {
                if(response.data.code === 200){
                  for (let i = 0; i < this.products.length; i++) {
                    if (id === this.products[i].id) {
                      this.products.splice(i, 1)
                    }
                  }
                  Swal.fire({
                    icon: 'success',
                    title: 'Xoá sản phẩm thành công',
                    showConfirmButton: false,
                    timer: 1500
                  })
                }
              })
              .catch(error =>{
                Swal.fire({
                  icon: 'error',
                  title: 'Xoá sản phẩm thất bại',
                  showConfirmButton: false,
                  timer: 1500
                })
              });
        }
      })

    }
  }
};
</script>
<style>
.btn{
  color: #fff !important;
}
.btn:hover{
  color: #fff !important;
}

</style>
