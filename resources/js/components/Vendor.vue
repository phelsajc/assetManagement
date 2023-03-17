<template>
    <div>
        <div class="col-md-6">
        <div class="input-group mb-3">
            <input type="text" placeholder="what are you looking for?" v-model="form.val" v-on:keyup="autoComplete" class="form-control">
            <div class="input-group-append">
                <button class="btn btn-outline-warning" @click="register()" type="button">Clear</button>
            </div>
        </div>
        </div>
        <div class="panel-footer" v-if="results.length">
        <ul class="list-group list-group-result">
            <li class="list-group-item" v-for="result in results" @click="getDepartment(result)">
                {{ result.bizboxid }} ({{ result.VendorName }})
            </li>
        </ul>
        </div>
        <div>
            <RegisterVendor :bizboxid="bbid" :fval="form.val" :vendor="vendorName" :contact="vendorContact" :email="vendorEmail" :address="vendorAddress" ref="regRef" @update-message="updateParentMessage"></RegisterVendor>
        </div>
    </div>
   </template>
   <script>
    export default{
        data(){
            return {
                form: {
                    val: this.meds,
                },
                isRegistered: false,
                results: [],
                results2: {
                    pk_iwitems: '',
                    itemdesc: '',
                    genericname: '',
                    dc_price: 0,
                    sc_price: 0,
                    reg_price: 0,      
                },
                bbid: '',   
                vendorName: '',   
                vendorContact: '',   
                vendorAddress: '',   
                vendorEmail: '',   
            }
        },
        methods: {
            autoComplete(){
                this.results = [];                
                axios.post('/api/find_vend',this.form)
                .then(res => {
                    this.results = res.data  
                })
                .catch(error => this.errors = error.response.data.errors)        
            },
            getDepartment(id) {
                //alert(id.VendorName)
                this.getValue = id     
                this.form.val = id.VendorName;
                this.bbid = id.bizboxid;
                this.vendorName = id.VendorName;
                this.vendorContact = id.contact;
                this.vendorAddress = id.add;
                this.vendorEmail = id.email;
                //this.$refs.regRef.form.testval = id.desc 
                this.$emit( 'handle-form-data', this.results2 );         
                this.results = [] ;       
            },
            setValue(value) {
                this.form.val = value
            },
            clearForm() {
                this.form.val = '';
            },     
            register(){
                //this.isRegistered = true;
                this.results = [] ;
            },
    updateParentMessage: function (newMessage) {
      this.form.val = newMessage;
    }
        },    
        props: ['products'],
    }
   </script>

<style>
.list-group-result {
    position: absolute;
    display: block;
    z-index: 1051;
    width: 100%;
}
</style>