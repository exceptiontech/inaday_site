import './bootstrap';
import Swal from 'sweetalert2';
// import router from "./routes";

// new Vue({
//   el: "#app",
//   router
// })

$(document).ready(function() {



  let app = new Vue({
    el: '#contact',
    data:{
      isLoading: false,
      errors:{},
      success:false,
      submitSuccess:false,
      submitError:false,
      fields: {
        name:'',
        email:'',
        mobile:'',
        subject:'',
        message:'',
      }
    },
    computed:{
      isComplete () {
        return this.fields.name &&
        this.fields.email &&
        this.fields.mobile &&
        this.fields.subject&&
        this.fields.message
      }
    },
    methods:{
      onSubmit(){
          

        this.errors = {};
        this.isLoading = true
        axios.post('/contact-send', this.fields)
        .then(response => {

          if (response.data.success) {
            this.success = true
            this.submitSuccess = true
            Swal.fire({
              title: 'تم الارسال بنجاح',
              html: 'سنقوم بالرد عليك في أقرب فرصه',
              icon: 'success',
              confirmButtonText: 'اغلاق'
            })
            // reset the form
            this.fields.name= '';
            this.fields.email= '';
            this.fields.mobile= '';
            this.fields.subject= '';
            this.fields.message= '';
          }
        this.isLoading = false
        })
        .catch(error => {
          if (error.response.status && error.response.status === 422 && error.response.data.errors) {
            this.errors = error.response.data.errors || {};
            this.submitError = true;
            let mapedErrors = '<ol>';
            for (const er in this.errors) {
              if (this.errors.hasOwnProperty(er)) {
                mapedErrors += '<li class="text-right text-danger">'+this.errors[er][0]+'</li>'
              }
            }
            mapedErrors += '</ol>';
            Swal.fire({
              title: 'الرجاء حل الاخطاء التالية',
              html: mapedErrors,
              icon: 'error',
              confirmButtonText: 'اغلاق'
            })
          }
          this.isLoading = false
        });
      },
    }
  })
});