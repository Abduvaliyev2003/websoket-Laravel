// resources/assets/js/components/ChatForm.vue

<template>
     <div>
  
     <div class="input-group" v-if="updatebtn == false">
        <input id="btn-input"  @input="inputValue"  type="text" name="message" class="form-control input-sm" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">
        <button @click="startAudio">Start</button>
         <button @click="stopAudio">Stop</button>
       
        <span class="input-group-btn ">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                Send
            </button>
        </span>
    </div>
    <div class="input-group" v-else>
        <input id="btn-input" type="text" name="message" :value="updateob.message" class="form-control input-sm" placeholder="Type your message here..."  @input="newMessage = $event.target.value" @keyup.enter="updateMessage">
        <div>
        
         <!-- <button @click="stopRecording">Ses Kaydı Durdur</button> -->
        </div>

        <span class="input-group-btn ">
            <button class="btn btn-primary btn-sm" id="btn-chat" @click="updateMessage">
                Update
            </button>
        </span>
    </div>
  
   </div>
    
</template>

<script>
    export default {
        props: ['user', 'senderid' , 'channel', 'updatebtn', 'updateob'],

        data() {
            return {
                newMessage: ''
            }
        },

        methods: {
            inputValue(event){
              this.$emit('getvale', this.newMessage);
            },
            startAudio(){
                this.$emit('storeaudio');
            },  
            stopAudio(){
                this.$emit('stopaudio');
            }, 
            sendMessage() {
                this.$emit('messagesent', {
                    user_id: this.user.id,
                    conversation_id: this.channel,
                    receriver_id: this.senderid, 
                    message: this.newMessage
                });
               
                this.newMessage = ''
            },

            updateMessage() {
                 this.$emit('update', {
                     'user_id': this.user.id,
                     'message_id': this.updateob.id,
                     'message': this.newMessage !== "" ? this.newMessage : this.updateob.message

                 });

                 this.newMessage = ''
            }

        }    
    }
</script>

