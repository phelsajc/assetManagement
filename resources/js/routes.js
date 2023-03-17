
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default
let forget = require('./components/auth/forget.vue').default
let logout = require('./components/auth/logout.vue').default

//End Aithetication
let home = require('./components/home.vue').default

let userslist = require('./components/users/index.vue').default
let usersadd = require('./components/users/create.vue').default

//Products
let product_list = require('./components/products/index.vue').default
let product_add = require('./components/products/create.vue').default

//Company
let Department_list = require('./components/department/index.vue').default
let Department_add = require('./components/department/create.vue').default

//Collections
let Vendor_list = require('./components/vendor/index.vue').default
let Vendor_add = require('./components/vendor/create.vue').default


/*
    path, component & name should be the same inorder to work
*/

export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forget', component: forget, name: 'logout' },
    { path: '/logout', component: logout, name: 'forget' },
    { path: '/home', component: home, name: 'home' },

    //Users
    { path: '/userslist', component: userslist, name: 'userslist' },
    { path: '/usersadd', component: usersadd, name: 'usersadd' },
    
    //Products
    { path: '/product_list', component: product_list, name: 'product_list' },
    { path: '/product_add/:id', component: product_add, name: 'product_add' },

    //Company
    { path: '/Department_list', component: Department_list, name: 'Department_list' },
    { path: '/Department_add/:id', component: Department_add, name: 'Department_add' },

    //Vendor
    { path: '/Vendor_list', component: Vendor_list, name: 'Vendor_list' },
    { path: '/Vendor_add/:id', component: Vendor_add, name: 'Vendor_add' },
]


