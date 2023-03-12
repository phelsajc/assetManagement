<template>
    
  <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements :value="bizboxid" -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">&nbsp;</h3>
            </div>
            
            <form class="user" @submit.prevent="addProduct" enctype="multipart/form-data">
              <div class="card-body">
                <div class="alert alert-danger alert-dismissible" v-if="isDuplicate">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  Duplicate equipment!
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Bizbox ID </label>
                  <input type="text" class="form-control" readonly  placeholder="Enter Desctiption" v-model="form.bizboxid">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <input type="text" class="form-control" readonly placeholder="Enter Desctiption" v-model="form.dept">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Location</label>
                  <input type="text" class="form-control"  placeholder="Enter Desctiption" v-model="form.loc">
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" v-model="form.status">
                  <label class="form-check-label" for="exampleCheck1">Active</label>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>

        </div>
      </div>
 </template>

 <script>
 
  export default{ 
      props: {
          bizboxid: {
              type: String,
              default: ''
          },
          department: {
              type: String,
              default: ''
          },
          fval: {
              type: String,
              default: ''
          },
      },
      data(){
          return {
              form: {
                  bizboxid: this.bizboxid,                    
                  dept: this.department,             
                  loc: '',             
                  status: false,
              },
              isDuplicate: false,
              localMessage: this.fval
          }
      }, 
      watch: {
        bizboxid(v) {
          this.form.bizboxid = v
        },
        department(v) {
          this.form.dept = v
        },        
      },
      computed: {
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
              this.form.val = id.desc;
              this.results = []
           //  this.$emit( 'handle-form-data', this.results2 );
          },
          setValue(value) {
          this.form.desc = value
          },
          clearForm() {
              this.form.val = ''
          },
          addProduct(){            
            axios.post('/api/dept-add',this.form)
              .then(res => {
                if(res.data=="Duplicate Equipment"){
                  this.isDuplicate = true
                }else{
                  this.isDuplicate = false
                  this.form.dept = ''
                  this.form.bizboxid = ''
                  this.form.loc = ''
                  this.form.status = false
                  this.$emit("update-message", this.localMessage);
                }
              Toast.fire({
                  icon: 'success',
                  title: 'Saved successfully'
              });
            })
            .catch(error => this.errors = error.response.data.errors)
          }   
      },     
      created() {
          this.$parent.$on('update', this.setValue);
      },
  }
 </script>