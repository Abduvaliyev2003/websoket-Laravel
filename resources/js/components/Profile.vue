


<template>

<div class="profilecontainer" v-if="userob">
          <div  class="profile-left">
              <div >
                <img v-bind:src='userob.image'  alt="Avatar" class="profile_avatar">
              </div>
              <h2 class="profile_title">{{ userob.name }}</h2>
          </div>
          <div class="profile-rigth">
              
          </div>
        </div>

</template>



<script>
  export default {
    props: ['userob'],
     

    methods: {
       

    
    }
  };
</script>