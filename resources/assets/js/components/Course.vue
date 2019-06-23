<template>
  <div>
    <button type="submit" name="button" class="btn btn-link" @click="deleteCourse">Delete Course</button>
    <button id="show-modal" @click="showModal">Edit Course </button>
    <div class="small-modal">
        <modal v-if="isModalVisible" @close="closeModal" :my_course=Course>
          <template slot="header">{{ Course.name }} </template>
          <template slot="body">
            <form @submit="update">
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
                  <textarea name="reply" rows="8" class="form-control" required
                   id="description" v-model="description">
                  </textarea>
                </div>
                <input type="hidden" name="uuid" v-model="uuid">
                <button  class="btn btn-xs btn-link"> Update </button>
          </form>

          </template>
        </modal>
    </div>

  </div>

</template>

<script>
import modal from './modal.vue';
export default {
  props:[],
  components:{
    modal
  },
  data(){
    return {
      isModalVisible:false,
      Course:window.course,
      name:window.course.name,
      uuid:window.course.uuid,
      description:window.course.description,
      status:window.course.status,
      code:window.course.code,
      isActive:window.course.isActive,
      signedIn:window.signedIn
    };
  },

  methods: {
    showModal(){
      this.isModalVisible =true;
    },
    closeModal(){
      this.isModalVisible = false;
    },
    deleteCourse(){
      alert('delete in progress');
    },
    update(){
      if(this.name.length>1&&this.description.length>5&&(this.status!==null)){
        axios.put('/api/course/update',{
            name:this.name,
            uuid:this.uuid,
            description:this.description,
            status:this.status,
            code:this.code
        })
        .catch(error =>{
          console.log(error);
          flash(error.response.data,'danger');
        }).then(({data})=>{
          console.log('successfull update');
          flash('Course has been updated successfully','success');
          //this.$emit('updated',data);
        });
      }else{
        flash('please check inputs and try again');
      }
    },
  }
}

</script>

<style>
  .small-modal{
    max-width: 800px;
  }
</style>
