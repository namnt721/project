<template>
  <div class="content">
    <div class="col-md-12">
      <form @submit.prevent="updateUser()">
        <md-card>
          <md-card-header :data-background-color="dataBackgroundColor">
            <h4 class="title">Cập nhật tài khoản</h4>
          </md-card-header>

          <md-card-content>
            <div class="md-layout">

              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Họ và tên <span class="error">(*)</span><span class="error" v-if="errors.name"> {{ errors.name[0] }}</span></label>
                  <md-input v-model="user.name" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Chức năng <span class="error">(*)</span><span class="error" v-if="errors.role_id"> {{ errors.role_id[0] }}</span></label>
                  <md-select v-model="user.role_id">
                    <md-option v-for="role in roles"
                               :key="role.id"
                               :value="role.id"
                    >
                      {{ role.name }}
                    </md-option>
                  </md-select>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Email <span class="error">(*)</span><span class="error" v-if="errors.email"> {{ errors.email[0] }}</span></label>
                  <md-input v-model="user.email" class="is-invalid" type="email" disabled></md-input>

                </md-field>
              </div>

              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Số điện thoại <span class="error">(*)</span><span class="error" v-if="errors.phone"> {{ errors.phone[0] }}</span></label>
                  <md-input v-model="user.phone" type="text"></md-input>
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
      <router-link :to="{ name: 'user'}" class="btn btn-success float-right">Quay lại</router-link>
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
      user: {
        name: '',
        email: '',
        phone: '',
        role_id: ''
      },
      roles: '',
      errors: {}
    };
  },
  mounted(){
    this.getUser()
    this.getRole()
  },
  methods:{
    getRole(){
      axios.get(baseUrl + '/api/user/create')
          .then(response =>{
            this.roles = response.data
          })
    },
   getUser(){
     const url = this.$router.history.current.path
     axios.get(baseUrl + '/api' + url)
         .then(response => {
           this.user.name = response.data.name;
           this.user.email = response.data.email;
           this.user.phone = response.data.phone;
           this.user.role_id = response.data.role_id;
         })
         .catch(error => {
           console.log(error);
         });
   },
    updateUser(){
      const id = this.$router.history.current.params.id
      axios.post(baseUrl + '/api/user/update/' + id, this.user)
          .then(response => {
            if(response.data.code === 200){
              Swal.fire({
                icon: 'success',
                title: 'Cập nhật tài khoản thành công',
                showConfirmButton: false,
                timer: 1500
              })
            }
          })
          .catch(error => {
            console.log(error);
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
