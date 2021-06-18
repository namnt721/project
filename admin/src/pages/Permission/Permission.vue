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

<!--          <tr v-for="category in categories" :key="category.id">-->
<!--            <td>{{ category.id }}</td>-->
<!--            <td>{{ category.name }}</td>-->
<!--            <td>-->
<!--              <router-link :to="{name: 'updateCategory', params: { id: category.id }}" class="btn btn-success" style="margin-right:5px">Sửa</router-link>-->
<!--              <button class="btn btn-danger" @click="deleteCategory(category.id)">Xoá</button>-->
<!--            </td>-->
<!--          </tr>-->

          </tbody>
        </table>

      </div>
    </div>
  </div>
</template>

<script>
export default{

}
</script>

<style>

</style>
