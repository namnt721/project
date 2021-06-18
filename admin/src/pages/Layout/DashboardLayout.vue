<template>
  <div class="wrapper" :class="{ 'nav-open': $sidebar.showSidebar }">


    <side-bar
      :sidebar-item-color="sidebarBackground"
      :sidebar-background-image="sidebarBackgroundImage"
    >
      <mobile-menu slot="content"></mobile-menu>
      <sidebar-link to="/dashboard">
        <md-icon>dashboard</md-icon>
        <p>Trang chủ</p>
      </sidebar-link>
      <sidebar-link to="/user">
        <md-icon>person</md-icon>
        <p>Tài khoản</p>
      </sidebar-link>
      <sidebar-link to="/category">
        <md-icon>C</md-icon>
        <p>Danh mục</p>
      </sidebar-link>
      <sidebar-link to="/product">
        <md-icon>P</md-icon>
        <p>Sản phẩm</p>
      </sidebar-link>
      <sidebar-link to="/discount">
        <md-icon>local_offer</md-icon>
        <p>Voucher</p>
      </sidebar-link>
      <sidebar-link to="/role">
        <md-icon>fingerprint</md-icon>
        <p>Phân quyền</p>
      </sidebar-link>
      <sidebar-link to="/add-permission">
        <md-icon>add_circle_outline</md-icon>
        <p>Tạo quyền</p>
      </sidebar-link>
    </side-bar>

    <div class="main-panel">
      <top-navbar></top-navbar>

      <fixed-plugin
        :color.sync="sidebarBackground"
        :image.sync="sidebarBackgroundImage"
      >
      </fixed-plugin>

      <dashboard-content> </dashboard-content>

      <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
  </div>
</template>

<script>
import TopNavbar from "./TopNavbar.vue";
import ContentFooter from "./ContentFooter.vue";
import DashboardContent from "./Content.vue";
import MobileMenu from "@/pages/Layout/MobileMenu.vue";
import FixedPlugin from "./Extra/FixedPlugin.vue";
import {axios, baseUrl} from "@/pages";

export default {
  components: {
    TopNavbar,
    DashboardContent,
    ContentFooter,
    MobileMenu,
    FixedPlugin
  },
  data() {
    return {
      sidebarBackground: "green",
      sidebarBackgroundImage: require("@/assets/img/sidebar-2.jpg")
    };
  },
  mounted(){
    this.checkLoggin()
  },
  methods: {
    checkLoggin(){
      const token = window.localStorage.getItem('token')
      if(token == null){
        this.$router.push({name: 'login'})
      }
      axios.get(baseUrl + '/api/check-login', {headers: {Authorization : 'Bearer ' + token}})
          .then(response => {

          })
          .catch(error => {
            this.$router.push({name: 'login'})
          });
    }
  },


};
</script>
