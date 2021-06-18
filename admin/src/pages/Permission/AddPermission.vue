<template>
  <div class="content">
    <div class="col-md-12">
      <form @submit.prevent="addPermission">
        <md-card>
          <md-card-header :data-background-color="dataBackgroundColor">
            <h4 class="title">Thêm mới quyền</h4>
          </md-card-header>

          <md-card-content>
            <div class="md-layout">
              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Module <span class="error">(*)</span><span class="error" v-if="errors.name"> {{ errors.name[0] }}</span></label>
                  <md-select v-model="dataPermission.name" >
                    <md-option v-for="(permission, id) in permissions" :key="id" :value="permission.name">{{ permission.name }}</md-option>
                  </md-select>
                </md-field>
                <div class="card text-white bg-success mb-3" style="color: #fff;">
                    <div class="card-header">Chức năng</div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-3">
                          <md-checkbox v-model="dataPermission.role" value="Danh sách"><span class="text-black">Danh sách</span></md-checkbox>
                        </div>
                        <div class="col-md-3">
                          <md-checkbox v-model="dataPermission.role" value="Thêm mới"><span class="text-black">Thêm mới</span></md-checkbox>
                        </div>
                        <div class="col-md-3">
                          <md-checkbox v-model="dataPermission.role" value="Cập nhật"><span class="text-black">Cập nhật</span></md-checkbox>
                        </div>
                        <div class="col-md-3">
                          <md-checkbox v-model="dataPermission.role" value="Xoá"><span class="text-black">Xoá</span></md-checkbox>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="md-layout-item md-size-100 text-right">
                  <md-button class="md-raised md-success" type="submit">Thêm mới</md-button>
                </div>
            </div>
          </md-card-content>
        </md-card>
      </form>
    </div>
    <div class="col-md-12">
      <div class="card text-white bg-success mb-3"
           style="color: #fff;"
           v-for="permission_data in permissions_data"
           :key="permission_data.id"
      >
        <div class="card-header">Module {{permission_data.name}}
          <button type="button"
                  class="close float-right"
                  aria-label="Close"
                  @click="deletePermission(permission_data.id)"
          >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3"
                 v-for="children in permission_data.roles_childrent"
                 :key="children.id"
            ><span class="text-black">{{ children.name }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {axios, Swal, baseUrl} from '../index.js';
export default{
  props: {
    dataBackgroundColor: {
      type: String,
      default: "green"
    }
  },
  data(){
    return {
      permissions: '',
      permissions_data: [],
      dataPermission: {
        name: '',
        role: []
      },
      errors: ''

    }
  },
  mounted() {
    this.getPermission()
    this.getRole()
  },
  methods:{
    getRole(){
      axios.get(baseUrl + '/api/role/create')
          .then(response => {
            response.data.forEach(value => {
              this.permissions_data.push(value)
            })
          })
    },
    getPermission(){
      axios.get(baseUrl + '/api/permission/get-permission')
          .then(response => {
            this.permissions = [
              { name: response.data.category },
              { name: response.data.product },
              { name: response.data.user },
              { name: response.data.role },
              { name: response.data.add_role },
            ]
          })
    },
    addPermission(){
      axios.post(baseUrl + '/api/permission/store', this.dataPermission)
          .then(response => {
            if(response.data.code === 200){
              this.permissions_data.push(response.data.data)
              this.errors = ''
              this.dataPermission.name = ''
              this.dataPermission.role = []
              Swal.fire({
                icon: 'success',
                title: 'Thêm mới chức năng thành công',
                showConfirmButton: false,
                timer: 1500
              })
            }
          })
          .catch(error => {
            if(error.response.data.errors){
              this.errors = error.response.data.errors;
            }
          })

    },

    deletePermission(id){
      Swal.fire({
        title: 'Bạn chắc chắn chứ',
        text: "Bạn có muốn xoá Module này không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xoá',
        cancelButtonText: 'Không',
      }).then((result) => {
        if (result.isConfirmed) {
          axios.get(baseUrl + '/api/permission/delete/' + id)
              .then(response => {
                if(response.data.code === 200){
                  for (let i = 0; i < this.permissions_data.length; i++) {
                    if (id === this.permissions_data[i].id) {
                      this.permissions_data.splice(i, 1)
                    }
                  }
                  Swal.fire({
                    icon: 'success',
                    title: 'Xoá Module thành công',
                    showConfirmButton: false,
                    timer: 1500
                  })
                }
              })
              .catch(error =>{
                Swal.fire({
                  icon: 'error',
                  title: 'Xoá Module thất bại',
                  showConfirmButton: false,
                  timer: 1500
                })
              });
        }
      })
    }
  }

}
</script>

<style>
.list-checkbox{
  float: left;
  list-style-type: none;
}
.text-white{
  color: #fff;
}
</style>
