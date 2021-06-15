<template>
  <div class="content">
<!--    <FormCategory></FormCategory>-->
    <div class="row" :class="{'display-none' : false}">
      <div class="col-md-12" >
        <router-link :to="{ name: 'createCategory'}" class="btn btn-success float-right">Thêm mới</router-link>
      </div>
      <div class="col-md-12" style="padding-top:20px;">
        <table class="table table-striped">
          <thead class="table-dark">
            <tr>
              <th width="50">#</th>
              <th>Tên danh mục</th>
              <th width="150">Chức năng</th>

            </tr>
          </thead>
          <tbody>

          <tr v-for="category in categories" :key="category.id">
            <td>{{ category.id }}</td>
            <td>{{ category.name }}</td>
            <td>
              <router-link :to="{name: 'updateCategory', params: { id: category.id }}" class="btn btn-success" style="margin-right:5px">Sửa</router-link>
              <button class="btn btn-danger" @click="deleteCategory(category.id)">Xoá</button>
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
// import FormCategory from './AddCategory.vue'
export default {
  name: 'Category',
  data(){
    return {
      categories: [],
      id: ''
    }
  },
  components:{
    // FormCategory
  },
  mounted() {
    this.getCategory()
  },
  methods:{
    getCategory(){
      axios.get(baseUrl + '/api/category')
          .then(response => {
             response.data.forEach((value) => {
               this.categories.push(value);
            });
          })
          .catch(error => {
            console.log(error);
          });
    },
    deleteCategory(id){
      Swal.fire({
        title: 'Bạn chắc chắn chứ',
        text: "Bạn có muốn xoá danh mục này không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xoá',
        cancelButtonText: 'Không',
      }).then((result) => {
        if (result.isConfirmed) {
          axios.get(baseUrl + '/api/category/delete/' + id)
              .then(response => {
                if(response.data.code === 200){
                  for (let i = 0; i < this.categories.length; i++) {
                    if (id === this.categories[i].id) {
                      this.categories.splice(i, 1)
                    }
                  }
                  Swal.fire({
                    icon: 'success',
                    title: 'Xoá tài khoản thành công',
                    showConfirmButton: false,
                    timer: 1500
                  })

                }
              })
              .catch(error =>{
                Swal.fire({
                  icon: 'error',
                  title: 'Xoá tài thất bại',
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
.display-none{
  display: none;
}
</style>
