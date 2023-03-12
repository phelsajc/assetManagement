
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
let collection_list = require('./components/collections/index.vue').default
let collection_add = require('./components/collections/create.vue').default
let collection_reports = require('./components/collections/Reports.vue').default
//Transaction
let transaction = require('./components/transactions/create.vue').default
let transaction_list = require('./components/transactions/index.vue').default
let transaction_report = require('./components/transactions/DailyReports.vue').default
//reports
let reports = require('./components/transactions/Reports.vue').default
let yearly_report = require('./components/transactions/YearlyReports.vue').default
//ReceivedProducts
let rproduct_list = require('./components/rec_products/index.vue').default
let rproduct_add = require('./components/rec_products/create.vue').default


let stocks = require('./components/stocks/index.vue').default

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
    
    //Transaction
    { path: '/transaction/:id', component: transaction, name: 'transaction' },
    { path: '/transaction_list', component: transaction_list, name: 'transaction_list' },
    { path: '/transaction_report', component: transaction_report, name: 'transaction_report' },
    
    //Reports
    { path: '/reports', component: reports, name: 'reports' },
    { path: '/yearly_report', component: yearly_report, name: 'yearly_report' },
    
    //Products
    { path: '/rproduct_list', component: rproduct_list, name: 'rproduct_list' },
    { path: '/rproduct_add/:id', component: rproduct_add, name: 'rproduct_add' },
    
    { path: '/stocks', component: stocks, name: 'stocks' },

    //Collections
    { path: '/collection_list', component: collection_list, name: 'collection_list' },
    { path: '/collection_add/:id', component: collection_add, name: 'collection_add' },
    { path: '/collection_reports', component: collection_reports, name: 'collection_reports' },
]


