<template>
  <div id="login">
    <div>
      <div class="md-layout md-gutter">
        <div class="md-layout-item md-layout md-gutter"></div>
        <div class="md-layout-item md-layout md-gutter">
          <md-content class="md-elevation-24">
            <div class="row">
                <div class="col-md-6 left-image" ></div>
                <div class="col-md-6">
                  <form @submit.prevent="login">
                    <div class="md-layout layout">
                      <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-field>
                          <label>Email <span class="error">(*)</span><span class="error" ></span></label>
                          <md-input v-model="user.email" class="is-invalid" type="email"></md-input>
                        </md-field>
                      </div>
                      <div class="md-layout-item md-small-size-100 md-size-100">
                        <md-field>
                          <label>Mật khẩu <span class="error">(*)</span><span class="error" ></span></label>
                          <md-input v-model="user.password" type="password"></md-input>
                        </md-field>
                      </div>

                      <div class="md-layout-item md-size-100 text-right">
                        <md-button class="md-raised md-success" type="submit">Đăng nhập</md-button>
                      </div>
                    </div>
                  </form>
                </div>

            </div>
          </md-content>
        </div>
        <div class="md-layout-item md-layout md-gutter"></div>
      </div>
    </div>

  </div>
</template>
<script>
import {axios, Swal, baseUrl} from '../index.js'

export default{
  data(){
    return{
      user: {
        email: '',
        password: ''
      }
    }
  },
  methods:{
    login(){
      axios.post(baseUrl + '/api/login', this.user)
          .then(response => {
            window.localStorage.setItem('token', response.data.token);
            // this.$router.push({name:'dashboard'});
          })
          .catch( error => {
            console.log(error);
          });
    }
  }
}
</script>
<style lang="scss" scoped>
.layout{
  margin: 250px 80px;
}
.left-image{
  background-color: #9c27b033;
  height: 800px;
  border-radius: 20px;
}
.md-content {
  width: 1000px;
  height: 800px;
  border-radius: 20px;
  margin-top: 50px;
}
</style>
