export default{


  methods:{
    showModal(){
      this.isModalVisible =true;
    },
    closeModal(){
      this.isModalVisible = false;
    },
    goHome(url=null){
      //alert(this.homeUrl);
      setTimeout(() => {
        if(url){
          document.location.replace(url);
        }else{
          document.location.replace(this.homeUrl);
        }

      },5000);


    }
  }
}
