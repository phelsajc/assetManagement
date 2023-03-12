<template>
    <aside id="sidebar" class="main-sidebar sidebar-dark-primary elevation-4">
      <router-link to="/all_employee" class="brand-link">
        <img
          src="../../../../public/backend2/uk_logo.jpg"
          alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3"
          style="opacity: 0.8"
        />
        <span class="brand-text font-weight-light">Asset Management</span>
      </router-link>
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img
              src="../../../../public/backend2/uk_logo.jpg"
              class="img-circle elevation-2"
              alt="User Image"
            />
          </div>
          <div class="info">
            <user-info></user-info>
          </div>
        </div>
        <nav class="mt-2">
          <ul
            class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview"
            role="menu"
            data-accordion="false"
          >
          <li class="nav-item" :class="{'menu-open':this.$route.name=='company_add'||this.$route.name=='product_add'||this.$route.name=='rproduct_add'||this.$route.name=='rproduct_list'||this.$route.name=='company_list'||this.$route.name=='product_list'}">        
            <a href="javascript:void(0);" class="nav-link" :class="{'active':this.$route.name=='rproduct_list'||this.$route.name=='company_list'||this.$route.name=='product_list'}">
            <i class="nav-icon fas fa-folder-plus"></i>
              <p>
                Master Files
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="javascript:void(0);" class="nav-link" :class="{'active':this.$route.name=='rproduct_list'||this.$route.name=='rproduct_add'}">
                  <i class="far fa-circle nav-icon"></i>
                  <router-link to="/department" 
                      >Department</router-link
                    >
                </a>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0);" class="nav-link" :class="{'active':this.$route.name=='product_list'||this.$route.name=='product_add'}">
                  <i class="far fa-circle nav-icon"></i>
                    <router-link to="/product_list" 
                      >Products</router-link
                    >
                </a>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0);" class="nav-link" :class="{'active':this.$route.name=='company_list'||this.$route.name=='company_add'}">
                  <i class="far fa-circle nav-icon"></i>
                    <router-link to="/company_list" 
                      >Company</router-link
                    >
                </a>
              </li>
            </ul>
              
          </li>

            
            <li class="nav-item">
              <a href="javascript:void(0);" class="nav-link" id="usermenu" :class="{'active':this.$route.name=='userslist'||this.$route.name=='usersadd'}">
                <i class="far fa-circle nav-icon"></i>
                <router-link to="/userslist" class="collapse-item"
                  >Users</router-link
                >
              </a>
            </li>
  
            <li class="nav-item">
              <router-link to="/logout" class="nav-link">
                <p>Logout</p>
              </router-link>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
  </template>
  <script>
  export default {
    data() {
      return {}
    },
  }
  </script>
  