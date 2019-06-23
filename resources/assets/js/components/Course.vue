<template>
  <div>
    <article>
        <h4>{{ name }}</h4>
        <!-- check update capability -->

        <!-- end can -->
        <div class="body">{{ description }}</div>
        <label><strong>Status</strong></label>-->
        <span v-if="isActive">Active</span>
        <span v-else> Not Active </span>

    </article>
    <button type="submit" name="button" class="btn btn-link" @click="deleteCourse">Delete Course</button>
    <button id="show-modal" @click="showModal">Edit Course </button>
    <div class="small-modal">
        <modal v-if="isModalVisible" @close="closeModal" :my_course=Course>
          <template slot="body">
            <form @submit.prevent="update_course">
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
                <input type="hidden" name="uuid" v-model="uuid">
                <button  class="btn btn-xs btn-link"> Update </button>
          </form>

          </template>
        </modal>
    </div>

  </div>

</template>

<script>
import collection from '../mixins/collection';
export default {
  props:[],
  components:{

  },
  mixins:[collection],
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
      signedIn:window.App.signedIn,
      homeUrl:'/course',
    };
  },

  methods: {
    deleteCourse(){
      //this.goHome();
      axios.delete('/api/course/delete',{
        data:{uuid:this.uuid}
      })
      .catch(error =>{
        console.log(error.response.data.message);
        var error = error.response.data.message?error.response.data.message:'Unknown Error has occured'
        flash(error,'danger');
      }).then(({data})=>{
        console.log('successfull update');
        flash('Course has been deleted successfully','success');
        this.closeModal();
        this.goHome();
      });

    },
    update_course(){
      if(this.name.length>1&&this.description.length>5 && this.status!==null){
        if(this.signedIn){
          axios.patch('/api/course/update',{
              name:this.name,
              uuid:this.uuid,
              description:this.description,
              status:this.status,
              code:this.code,

          })
          .catch(error =>{
            console.log(error.response);
            var error = error.response.data.message?error.response.data.message:'Unknown Error has occured'
            flash(error,'danger');
          }).then(({data})=>{
            console.log('successfull update');
            flash('Course has been updated successfully','success');
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

<style>
  .small-modal{
    max-width: 800px;
  }
</style>
