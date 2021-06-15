<template>
  <div class="content">
    <div class="col-md-12">
      <form @submit.prevent="addUser">
        <md-card>
          <md-card-header :data-background-color="dataBackgroundColor">
            <h4 class="title">Thêm mới tài khoản</h4>
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
                  <label>Email <span class="error">(*)</span><span class="error" v-if="errors.email"> {{ errors.email[0] }}</span></label>
                  <md-input v-model="user.email" class="is-invalid" type="email"></md-input>

                </md-field>
              </div>

              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Số điện thoại <span class="error">(*)</span><span class="error" v-if="errors.phone"> {{ errors.phone[0] }}</span></label>
                  <md-input v-model="user.phone" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Password <span class="error">(*)</span><span class="error" v-if="errors.password"> {{ errors.password[0] }}</span></label>
                  <md-input v-model="user.password" type="password"></md-input>
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
  name: "edit-profile-form",
  props: {
    dataBackgroundColor: {
      type: String,
      default: "green"
    }
  },
  data() {
    return {
      user:{
        name: null,
        email: null,
        phone: null,
        password: null,
      },
      errors: {}
    };
  },
  methods:{
    addUser: function (){
      axios.post(baseUrl + '/api/user/register', this.user)
          .then(response => {
            if(response.data.code === 200){
              this.$router.push({name:'user'});
              Swal.fire({
                icon: 'success',
                title: 'Thêm mới tài khoản thành công',
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
