// resources/assets/js/components/ChatMessages.vue


   <template>
   <div>
        <div class="chat">
    <div class="list-item" v-for="list in chatList" :key="list.id">
      <div  @click="handleClick(list.id, list.user.id == user.id ? list.sender.id : list.user.id)" >
      
       <div>

           <div class="list-item-content" v-if="list.user.id == user.id">
           <div>
          <img v-bind:src="list.sender.image" alt="Avatar" class="avatar">
          </div>
           <div> 
             <h4>{{ list.sender.name}}</h4>
             <div class="profile" >
                 <button id="status" v-if="users.find(userd => userd.id === list.sender.id)">
                <i></i> <span>Online</span>
              </button>
              <button id="status" v-else>
                <i></i> <span>Offline</span>
              </button>
             </div>
             <div v-if="typewrite == true && list.id == convertid">
                <div class="one"></div>
                <div class="one"></div>
                <div class="one"></div>
                <div class="one"></div>
                <div class="one"></div> 
              </div>
            <div  v-else>
             <p>{{  list.sender.email }}</p>
               
            </div>
            
           </div>
           
        
        </div>
        <div class="list-item-content" v-else>
          <div>
          <img v-bind:src="list.user.image" alt="Avatar" class="avatar">
          </div>
           <div> 
             <h4>{{ list.user.name}}</h4>
             <div class="profile" >
              <button id="status" v-if="users.find(userd => userd.id === list.user.id)">
                <i></i> <span>Online</span>
              </button>
              <button id="status" v-else>
                <i></i> <span>Offline</span>
              </button>
             </div>
             
             </div>
              
              <div v-if="typewrite == true && list.id == convertid">
                <div class="one"></div>
                <div class="one"></div>
                <div class="one"></div>
                <div class="one"></div>
                <div class="one"></div> 
              </div>
              <div  v-else>
                <p>{{  list.user.email }}</p>
              </div>

          
           </div>
          
        </div>
       </div>
      
      </div>
    </div>
  </div>
 
  
   
</template>





<script>
  export default {
    props: ['chatList', 'user','convertid', 'typewrite', 'arrayon', 'users'],

    methods: {
        handleClick(id, sender) {
          this.$emit('addchatlist', id , sender);
     }
    }
   
           
  };
</script>

