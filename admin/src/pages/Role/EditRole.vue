<template>
  <div class="content">
    <div class="col-md-12">
      <form @submit.prevent="editRole">
        <md-card>
          <md-card-header :data-background-color="dataBackgroundColor">
            <h4 class="title">Cập nhật chức năng</h4>
          </md-card-header>

          <md-card-content>
            <div class="md-layout">

              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Tên chức năng <span class="error">(*)</span><span class="error" v-if="errors.name"> {{ errors.name[0] }}</span></label>
                  <md-input v-model="role.name" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Mô tả <span class="error">(*)</span><span class="error" v-if="errors.display_name"> {{ errors.display_name[0] }}</span></label>
                  <md-input v-model="role.display_name" type="text"></md-input>
                </md-field>
              </div>
            </div>
            <div class="card text-white bg-success mb-3"
                 style="color: #fff;"
                 v-for="permission in permissions"
                 :key="permission.id"
            >
              <div class="card-header">  Module {{permission.name}}</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3"
                       v-for="children in permission.roles_childrent"
                       :key="children.id"
                  >
                    <md-checkbox
                        v-model="role.data_children"
                        :value="children.id"
                    ><span class="text-black">{{ children.name }}</span></md-checkbox>
                  </div>
                </div>
              </div>
            </div>
            <div class="md-layout-item md-size-100 text-right">
              <md-button class="md-raised md-success" type="submit">Cập nhật</md-button>
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
  name: 'FormCategory',
  props: {
    dataBackgroundColor: {
      type: String,
      default: "green"
    }
  },
  data() {
    return {
      role:{
        name: null,
        display_name: null,
        data_children: []
      },
      permissions: [],
      errors: {}
    };
  },
  mounted(){
    this.getRole()
    this.getPermission()
  },
  methods:{
    getPermission(){
      const url = this.$router.history.current.path
      axios.get(baseUrl + '/api' + url)
          .then(response => {
            this.role.name = response.data.name
            this.role.display_name = response.data.display_name
            response.data.permissions.forEach(value => {
              this.role.data_children.push(value.id)
            })
          })
    },
    getRole(){
      axios.get(baseUrl + '/api/role/create')
          .then(response => {
            response.data.forEach(value => {
              this.permissions.push(value)
            })
          })
    },
    editRole: function (){
      const id = this.$router.history.current.params.id
      axios.post(baseUrl + '/api/role/update/' + id, this.role)
          .then(response => {
            if(response.data.code === 200){
              this.$router.push({name:'role'});
              Swal.fire({
                icon: 'success',
                title: 'Cập nhật quyền thành công',
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
.card-body{
  background: #fff;
  border: 1px solid #27a242;
  border-radius: 0 0 .25rem .25rem;
}
.text-black{
  color: #4b494c !important;
}
.card{
  border: 0;
}
</style>
