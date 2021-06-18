<template>
  <div class="content">
    <div class="col-md-12">
      <form @submit.prevent="addCategory">
        <md-card>
          <md-card-header :data-background-color="dataBackgroundColor">
            <h4 class="title">Thêm mới danh mục</h4>
          </md-card-header>

          <md-card-content>
            <div class="md-layout">

              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>Mã voucher <span class="error">(*)</span><span class="error" v-if="errors.code"> {{ errors.code[0] }}</span></label>
                  <md-input v-model="discount.code" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <md-field>
                  <label>% <span class="error">(*)</span><span class="error" v-if="errors.discount"> {{ errors.discount[0] }}</span></label>
                  <md-input v-model="discount.discount" type="text"></md-input>
                </md-field>
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                  <label>Ngày bắt đầu <span class="error">(*)</span><span class="error" v-if="errors.discount"> {{ errors.discount[0] }}</span></label>
                  <md-datepicker v-model="discount.start_day" />
              </div>
              <div class="md-layout-item md-small-size-100 md-size-100">
                <label>Ngày kết thúc <span class="error">(*)</span><span class="error" v-if="errors.discount"> {{ errors.discount[0] }}</span></label>
                <md-datepicker v-model="discount.end_day" />
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
  name: 'FormCategory',
  props: {
    dataBackgroundColor: {
      type: String,
      default: "green"
    }
  },
  data() {
    return {
      discount:{
        code: null,
        discount: null,
        start_day: null,
        end_day: null,
      },
      errors: {}
    };
  },
  methods:{
    addCategory: function (){
      axios.post(baseUrl + '/api/category/create', this.category)
          .then(response => {
            if(response.data.code === 200){
              this.$router.push({name:'category'});
              Swal.fire({
                icon: 'success',
                title: 'Thêm mới danh mục thành công',
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
