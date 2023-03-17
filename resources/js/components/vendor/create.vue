<template>
    <div class="wrapper">  
    <navComponent></navComponent>    
    <sidemenuComponent></sidemenuComponent>      
        <div class="content-wrapper">
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>&nbsp;</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Company</li>
                    </ol>
                </div>
                </div>
            </div>
            </section>

            <section class="content">
            <div class="container-fluid">
                <div class="row">
                <div class="col-12">

                    
                    <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Vendor</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body">            
                        
                        <form class="user" @submit.prevent="addEmployee" enctype="multipart/form-data">
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" id="" placeholder="Enter Vendor" v-model="form.vendor">
                                        <small class="text-danger" v-if="errors.vendor">{{ errors.vendor[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Contact No.</label>
                                        <input type="text" class="form-control" id="" placeholder="Enter Product Contact No." v-model="form.contactno">
                                        <small class="text-danger" v-if="errors.contactno">{{ errors.contactno[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" id="" placeholder="Enter Product Email" v-model="form.email">
                                        <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" rows="3" placeholder="Enter ..." v-model="form.address"></textarea>
                                    <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-check">
                                        <input type="checkbox" class="form-check-input" :checked="form.status" v-model="form.status">
                                        <label class="form-check-label" for="exampleCheck1">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                    

                            <!-- <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <h4>Type</h4>
                                        <select  class="form-control" v-model="form.type">
                                            <option value="Staff">Staff</option>
                                            <option value="Doctor">Doctor</option>
                                            <option value="Administrator">Administrator</option>
                                        </select>
                                        <small class="text-danger" v-if="errors.type">{{ errors.type[0] }}</small>
                                    </div>
                                </div>
                            </div> -->                            

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>

                        </div>
                    </div>
                </div>
                </div>
            </div>
            </section>   
   
        </div>
      <footerComponent></footerComponent>
    </div>
</template>

<script type="text/javascript">
import AppStorage from '../../Helpers/AppStorage';


    export default {
        created(){
            if(!User.loggedIn()){
                this.$router.push({name: '/'})
            }
            let checkId = this.$route.params.id
            if(checkId!=0){
                this.getId = checkId;
                this.editForm();
                this.isNew = false;
            }
        },

        data() {
            return {
                form: {
                    vendor: '',
                    address: '',
                    email: '',
                    contactno: '',
                    status: false,
                },
                user_info:{
                    patientname: '',
                    contactno: '',
                    pk_pspatregisters: '',
                },
                getId: 0,
                isNew: true,
                errors:{}
            }
        },

        methods:{
            addEmployee(){
                
                /* if(this.isNew){
                    axios.post('/api/vend-add',this.form)
                    .then(res => {
                        this.$router.push({name: 'company_list'});
                        Toast.fire({
                            icon: 'success',
                            title: 'Saved successfully'
                        })
                    })
                    .catch(error => this.errors = error.response.data.errors)
                }else{
                    axios.post('/api/vend-update',{
                        data: this.form,
                        id: this.getId
                    })
                    .then(res => {
                        this.$router.push({name: 'company_list'});
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated successfully'
                        })
                    })
                    .catch(error => this.errors = error.response.data.errors)
                } */
                axios.post('/api/vend-update',{
                    data: this.form,
                    id: this.getId
                })
                .then(res => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Saved successfully'
                    });
                })
                .catch(error => this.errors = error.response.data.errors)
            },
            editForm(){                
                let id = this.$route.params.id
                axios.get('/api/vend-detail/'+id)
                    .then(({ data }) => (
                        this.form.vendor = data.name,  
                        this.form.address = data.address,             
                        this.form.email = data.email,             
                        this.form.contactno = data.contactno,      
                        this.form.status =  data.status
                ))
                .catch(console.log('error'))
            }
            
        }
    }
    
</script>

<style>
 .pull-right{
    float:right !important;
 }
</style>