import DashboardLayout from "@/pages/Layout/DashboardLayout.vue";
import {EditProfileForm, AddProfileForm, UserProfile} from "@/pages/UserProfile";
import {Category, AddCategory, EditCategory} from "@/pages/Categories";
import {Product, AddProduct, EditProduct} from "@/pages/Product";
import {Login} from "@/pages/Admin";
import Dashboard from "@/pages/Dashboard.vue";
const routes = [
  {
    path: "/login",
    component: Login
  },
  {
    path: "/",
    component: DashboardLayout,
    children: [
      {
        path: "dashboard",
        name: "dashboard",
        component: Dashboard
      },
        //Router User
      {
        path: "user",
        name: "user",
        component: UserProfile,
      },
      {
        path: "user/create",
        name: "createUser",
        component: AddProfileForm,
      },
      {
        path: "user/edit/:id",
        name: "updateUser",
        component: EditProfileForm,
      },
        //Router Category
      {
        path: "category",
        name: "category",
        component: Category,
      },
      {
        path: "category/create",
        name: "createCategory",
        component: AddCategory,
      },
      {
        path: "category/edit/:id",
        name: "updateCategory",
        component: EditCategory,
      },
        //Router Product
      {
        path: "product",
        name: "product",
        component: Product,
      },
      {
        path: "product/create",
        name: "createProduct",
        component: AddProduct,
      },
      {
        path: "product/edit/:id",
        name: "updateProduct",
        component: EditProduct,
      },
    ]
  }
];

export default routes;
