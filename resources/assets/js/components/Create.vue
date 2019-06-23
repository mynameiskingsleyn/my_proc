<template>
  <div class="">
    <a class="nav-link" href="#" id="show-create-modal" @click="showModal">Create new Course</a>
    <modal v-if="isModalVisible" @close="closeModal">
      <template slot="header" >
        <button class="modal-default-button" @click="closeModal()">
            close
        </button>
        Create new Course
      </template>
      <template slot="body">
        <form @submit.prevent="create_course">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control" required id="name" v-model="name">
            </div>
            <div class="form-group">
              <label for="code">Code</label>
              <input type="text" name="code" class="form-control" required id="code" v-model="code">
            </div>
            <div class="form-group">
              <label for="status">Status</label>
              <select v-model="status">
                <option value="1">Active</option>
                <option value="0">Not Active</option>
              </select>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="reply" rows="4" class="form-control" required minlength=10
               id="description" v-model="description">
              </textarea>
            </div>
            <button  class="btn btn-xs btn-link"> Create </button>
          </form>

      </template>

     </modal>
  </div>

</template>

<script>
 import collection from '../mixins/collection';
 export default {
   components:{},
   mixins:[collection],
   data(){
     return {
       name:'new course',
       description:'Describe',
       status:1,
       code:'',
       isModalVisible:false,
       signedIn:window.App.signedIn,
       homeUrl:'/course',
     };
   },
   methods:{
     create_course(){
       if(this.name.length>1&&this.description.length>5 && this.status!==null){
         if(this.signedIn){
           axios.post('/api/course/save',{
               name:this.name,
               description:this.description,
               status:this.status,
               code:this.code,

           })
           .catch(error =>{
             console.log(error.response.data);
             var message = error.response.data.message?error.response.data.message:'Unknown Error has occured'
             flash(message,'danger');
           }).then(({data})=>{
             console.log('successfully created');
             if(data){
               console.log(data.response);
             }
             flash('Course has been created successfully','success');
             this.closeModal();
             this.goHome();
           });
         }else{
           flash('UnAuthorized operation','danger');
         }

       }else{
         flash('please check inputs and try again','error');
       }
     },
   }

 }

</script>
