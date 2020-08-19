<template>
  <div class="container">
    <div class="columns">
      <div class="column">
        <!-- <div class="message" v-for="status in statuses" :key="status.id">
          <div class="message-header">
            {{status.user.name}}
          </div>
          <div class="message-body">
            {{status.body}}
          </div>
        </div> -->
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      // statuses:[]
    }
  },
  created(){
    // axios.get('/statuses')
    // .then(({data}) => this.statuses = data);
  }
}
</script>

<style>

</style>