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
                    <li class="breadcrumb-item active">Equipment</li>
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
                        <h3 class="card-title">Edit Equipment</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        </div>
                    </div>
                    <div class="card-body">            
                        
                        <form class="user" @submit.prevent="addProduct" enctype="multipart/form-data">
                            
                            <div class="row">
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label>BizboxID</label>
                                    <input type="text" class="form-control" id="" placeholder="Enter Product name" v-model="form.bbid" readonly>
                                    <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                                </div>
                                </div>
                                <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" id="" placeholder="Enter Product Description" v-model="form.desc">
                                    <small class="text-danger" v-if="errors.desc">{{ errors.desc[0] }}</small>
                                </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Life </label>
                                        <input type="number" class="form-control" id="" placeholder="Enter Product Life" v-model="form.life">
                                        <small class="text-danger" v-if="errors.life">{{ errors.life[0] }}</small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-check">
                                        <input type="checkbox" class="form-check-input" :checked="form.isPreventive" v-model="form.isPreventive">
                                        <label class="form-check-label" for="exampleCheck1">Is preventive?</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="form-check">
                                        <input type="checkbox" class="form-check-input" :checked="form.active" v-model="form.active">
                                        <label class="form-check-label" for="exampleCheck1">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>                     

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
import Datepicker from 'vuejs-datepicker'


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
        components: {
            Datepicker
        },
        data() {
            return {
                form: {
                    bbid: '',
                    desc: '',
                    life: '',
                    isPreventive: false,
                    active:false,
                    id:0,
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
            addProduct(){
                /* if(this.isNew){
                    axios.post('/api/products-add',this.form)
                    .then(res => {
                        this.$router.push({name: 'product_list'});
                        Toast.fire({
                            icon: 'success',
                            title: 'Saved successfully'
                        });
                    })
                    .catch(error => this.errors = error.response.data.errors)
                    }else{
                    axios.post('/api/products-update',{
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
                    }
                */
                axios.post('/api/products-update',{
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
                axios.get('/api/products-detail/'+id)
                    .then(({ data }) => (
                        this.form.bbid = data.bizboxid,  
                        this.form.desc =  data.description,            
                        this.form.life =  data.life,               
                        this.form.isPreventive =  data.isforpreventive,  
                        this.form.active =  data.status,            
                        this.form.price =  data.price                                              
                ))
                .catch(error => this.errors = console.log(error.response.data.errors))
            }            
        }
    }
    
</script>

<style>
 .pull-right{
    float:right !important;
 }
</style>