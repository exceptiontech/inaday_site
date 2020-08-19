import './bootstrap';
import Swal from 'sweetalert2';

import router from "./routes";

// new Vue({
//   el: "#app",
//   router
// })

$(document).ready(function() {

  $(".parts-slider").slick({
    autoplay: true,
    autoplaySpeed: 1000,
    speed: 600,
    slidesToShow: 5,
    slidesToScroll: 2,
    pauseOnHover: false,
    dots: false,
    pauseOnDotsHover: true,
    arrows: false, 
    cssEase: 'linear',
    // fade:true,
    rtl: true,
    draggable: true
  });

  let app = new Vue({
    el: '#newOrder',
    data:{
      editMode:false,
      editText: 'تعديل',
      isLoading: false,
      errors:{},
      success:false,
      submitSuccess:false,
      submitError:false,
      fields: {
        name:'',
        email:'',
        mobile:'',
        vinNo:'',
        brand:'',
        carName:'',
        carVersion:'',
        carModel:'',
        parts:[{
          partName:'',
          partCount:'1'
        }],
      }
    },
    computed:{
      isComplete () {
        return this.fields.name &&
        this.fields.email &&
        this.fields.mobile &&
        // this.fields.vinNo &&
        this.fields.brand &&
        this.fields.carName &&
        this.fields.carVersion &&
        this.fields.carModel &&
        (this.fields.parts[0].partName.trim())
      }
    },
    methods:{
      addPart(){
        // console.log(this.parts[this.parts.length-1].partName.length);
        if(this.fields.parts[this.fields.parts.length-1].partName.length > 0 ){
          this.fields.parts.push({partName:'',partCount:'1'})
        }
      },
      editParts(){
        this.editMode = !this.editMode;
        this.editText = (this.editMode)?'حفظ' : 'تعديل';
      },

      removePart(i){
        // console.log(this.parts[i]);
        this.fields.parts.splice(i,1);
      },
      onSubmit(){
        this.errors = {};
        this.isLoading = true
        axios.post('/neworder', this.fields)
        .then(response => {
          // alert('Message sent!');
          console.log(response.data.success);
          if (response.data.success) {
            this.success = true
            this.submitSuccess = true
            Swal.fire({
              title: 'تم الارسال بنجاح',
              html: `سيقوم أحد ممثلي خدمة العملاء بالتواصل معك قريبا <strong>رقم طلبك هو: hbg-${response.data.order_id}</strong>`,
              icon: 'success',
              confirmButtonText: 'اغلاق'
            })
            // reset the form
            this.fields.name= '';
            this.fields.email= '';
            this.fields.mobile= '';
            this.fields.vinNo= '';
            this.fields.brand= '';
            this.fields.carName= '';
            this.fields.carVersion= '';
            this.fields.carModel= '';
            this.fields.parts= [{
              partName:'',
              partCount:'1'
            }];
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

  // let follow = new Vue({
  //   el: '#follow',
  //   data:{
  //     order_id:'',
  //     mobile:''
  //   },
  //   methods:{
  //     onSubmit(){
        
  //     }
  //   },    
  //   computed:{
  //     isComplete () {
  //       return this.mobile
  //     }
  //   }
  // })
});