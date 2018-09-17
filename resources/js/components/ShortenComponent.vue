<template>
   <div>
      <div class="input-group input-group-lg">
         <input type="text" class="form-control" v-model="long_url" placeholder="Your long URL">
         <div class="input-group-append">
            <button @click="getShortUrl" class="btn btn-outline-primary" type="button">Shorten!</button>
         </div>
      </div>
      <template v-if="short_result != null">
         <div class="links">
            -> <a :href="short_result" target="_blank">{{ short_result }}</a>
         </div>
      </template>
   </div>
</template>

<script>
    export default {
        data() {
            return {
               long_url:null,
               short_result:null,
            }
        },
        mounted() {
            // console.log('Component mountedd.')
        },
        methods: {
           getShortUrl: function () {
             const app = this;
             axios.post('/shorten', { // ajax request ke URL Controller
                'long_url':app.long_url
             }).then(response => {
                if (response.data.success) {
                   app.short_result = response.data.data.link;
                }
                // console.log(response.data);
             })
          }
       }
    }
</script>
