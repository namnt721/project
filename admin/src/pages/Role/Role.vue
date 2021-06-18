<template>
  <div class="content">
    <div class="row" >
      <div class="col-md-12" >
        <router-link :to="{ name: 'createRole'}" class="btn btn-success float-right">Thêm mới</router-link>
      </div>
      <div class="col-md-12" style="padding-top:20px;">
        <table class="table table-striped">
          <thead class="table-dark">
          <tr>
            <th width="50">#</th>
            <th>Tên chức năng</th>
            <th>Mô tả</th>
            <th width="150">Chức năng</th>

          </tr>
          </thead>
          <tbody>

          <tr v-for="role in roles" :key="role.id">
            <td>{{ role.id }}</td>
            <td>{{ role.name }}</td>
            <td>{{ role.display_name }}</td>
            <td>
              <router-link :to="{name: 'updateRole', params: { id: role.id }}" class="btn btn-success" style="margin-right:5px">Sửa</router-link>
              <button class="btn btn-danger" @click="deleteRole(role.id)">Xoá</button>
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
  name: 'FormCategory',
  props: {
    dataBackgroundColor: {
      type: String,
      default: "green"
    }
  },
  data() {
    return {
      roles:[],
    };
  },
  mounted(){
    this.getRole()
  },
  methods:{
    getRole(){
        axios.get(baseUrl + '/api/role')
          .then(response =>{
            response.data.forEach(value => {
              this.roles.push(value)
            })
          })

    },
    deleteRole(id){
      Swal.fire({
        title: 'Bạn chắc chắn chứ',
        text: "Bạn có muốn quyền này không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xoá',
        cancelButtonText: 'Không',
      }).then((result) => {
        if (result.isConfirmed) {
          axios.get(baseUrl + '/api/role/delete/' + id)
              .then(response => {
                if(response.data.code === 200){
                  for (let i = 0; i < this.roles.length; i++) {
                    if (id === this.roles[i].id) {
                      this.roles.splice(i, 1)
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

</style>
