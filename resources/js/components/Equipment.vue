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
            <li class="list-group-item" v-for="result in results" @click="getEquipment(result)">
                {{ result.bizboxid }} ({{ result.desc }})
            </li>
        </ul>
        </div>
        <div>
            <RegisterEquipment :bizboxid="bbid" :description="bbdesc"  ref="regRef"></RegisterEquipment>
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
                bbdesc: '',   
            }
        },
        methods: {
            autoComplete(){
                this.results = [];                
                axios.post('/api/find_item',this.form)
                .then(res => {
                    this.results = res.data  
                })
                .catch(error => this.errors = error.response.data.errors)        
            },
            getEquipment(id) {
                this.getValue = id            
                this.results = [] ;
                this.form.val = id.desc;
                this.bbid = id.bizboxid;
                this.bbdesc = id.desc;
                this.$refs.regRef.form.testval = id.desc
                this.$emit( 'handle-form-data', this.results2 );
                
            },
            setValue(value) {
                this.form.val = value
            },
            clearForm() {
                this.form.val = ''
            },     
            register(){
                //this.isRegistered = true;
                this.results = [] ;
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