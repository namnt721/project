<template>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <router-link :to="{ name: 'createUser'}" class="btn btn-success float-right">Thêm mới</router-link>
      </div>
      <div class="col-md-12" style="padding-top:20px;">
        <table class="table table-striped">
          <thead class="table-dark">
            <tr>
              <th width="50">#</th>
              <th>Họ và tên</th>
              <th>Email</th>
              <th>Số điện thoại</th>
              <th width="150">Chức năng</th>

            </tr>
          </thead>
          <tbody>

          <tr v-for="user in users" :key="user.id">
            <td>{{ user.id }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.phone }}</td>

            <td>
              <router-link :to="{name: 'updateUser', params: { id: user.id }}" class="btn btn-success" style="margin-right:5px">Sửa</router-link>
              <button class="btn btn-danger" @click="deleteUser(user.id)">Xoá</button>
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
      users: [],
      id: ''
    }
  },
  mounted() {
    this.getUser()
  },
  methods:{
    getUser(){
      axios.get(baseUrl + '/api/user')
          .then(response => {
             response.data.forEach((value) => {
               this.users.push(value);
            });
          })
          .catch(error => {
            console.log(error);
          });
    },
    deleteUser(id){
      Swal.fire({
        title: 'Bạn chắc chắn chứ',
        text: "Bạn có muốn xoá tài khoản này không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xoá',
        cancelButtonText: 'Không',
      }).then((result) => {
        if (result.isConfirmed) {
          axios.get(baseUrl + '/api/user/delete/' + id)
              .then(response => {
                if(response.data.code === 200){
                  for (let i = 0; i < this.users.length; i++) {
                    if (id === this.users[i].id) {
                      this.users.splice(i, 1)
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

</style>
