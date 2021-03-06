import DashboardLayout from "@/pages/Layout/DashboardLayout.vue";
import {EditProfileForm, AddProfileForm, UserProfile} from "@/pages/UserProfile";
import {Category, AddCategory, EditCategory} from "@/pages/Categories";
import {Product, AddProduct, EditProduct} from "@/pages/Product";
import {Permission, AddPermission} from "@/pages/Permission";
import {Role, AddRole, EditRole} from "@/pages/Role";
import {Discount, AddDiscount, EditDiscount} from "@/pages/Discount";
import {Login} from "@/pages/Admin";
import Dashboard from "@/pages/Dashboard.vue";
const routes = [
  {
    path: "/login",
    name: "login",
    component: Login
  },
  {
    path: "/",
    component: DashboardLayout,
    name: 'home',
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
        //Router Permission
      {
        path: "permission",
        name: "permission",
        component: Permission,
      },
      {
        path: "add-permission",
        name: "addPermission",
        component: AddPermission,
      },
      //Router Role
      {
        path: "role",
        name: "role",
        component: Role,
      },
      {
        path: "role/create",
        name: "createRole",
        component: AddRole,
      },
      {
        path: "role/edit/:id",
        name: "updateRole",
        component: EditRole,
      },
      //Router Discount
      {
        path: "discount",
        name: "discount",
        component: Discount,
      },
      {
        path: "discount/create",
        name: "createDiscount",
        component: AddDiscount,
      },
      {
        path: "discount/edit/:id",
        name: "updateDiscount",
        component: EditDiscount,
      },
    ]
  }
];

export default routes;
