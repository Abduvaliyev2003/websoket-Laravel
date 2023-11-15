/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import Echo from 'laravel-echo';
/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */




import ChatMessages from './components/ChatMessages.vue';
import ChatForm from './components/ChatForm.vue';
import ChatList from './components/ChatList.vue';
import Profile from './components/Profile.vue';
app.component('chat-messages', ChatMessages);
app.component('chat-form', ChatForm);
app.component('chat-list', ChatList);
app.component('profile-user', Profile);
app.mixin({
  data() {
    return {
      arrayOn: null,
      resiver: null,
      intext: false,
      convert:null,
      messages: [],
      chatList:  [],
      updateObjectv: null,
      updateBtn: false,
      typeWrite: false,
      convertid: null,
      resiverid:null,
      isOnline:false,
      users: [],
      user_ob: null,
      audioChunks:[],
      mediaRecorder: null,
    };
  },
  created() {
    this.fetchMessages();
    this.fetchChatList();
   
   
    // resources/assets/js/app.js
   
    
  
  window.Echo.private('message-update').listen('MessageUpdated', (e) => {
    
    const updatedMessageId = e.message_id;
    const updatedMessageText = e.message.message;

    // Find the index of the updated message in the messages array
    const messageIndex = this.messages.findIndex((message) => message.id === updatedMessageId);
    
    // If the updated message is found in the array, update its content
    if (messageIndex !== -1) {
      this.messages[messageIndex].message = updatedMessageText;
    }
});






  },
  mounted() {
    console.log( this.arrayOn);
    // Retrieve resiver and convert from localStorage
    const resiverFromLocalStorage = localStorage.getItem('resiver');
    const convertFromLocalStorage = localStorage.getItem('convert');
    this.listen();
    window.Echo.private('chat').listen('MessageSent', (e) => {
      console.log(e)
        this.messages.push({
          id: e.message.id,
          message: e.message.message,
          user: e.user,
          audio: e.message.audio
        });
    }).listenForWhisper('stop-typing', (e) => {
      this.typeWrite = false;

    }).listenForWhisper('typing', (e) => {
      this.typeWrite = true;
      this.convertid = e.covert_id;
      this.resiverid = e.resiver
    });
    
    // Set resiver and convert to the retrieved values
    this.resiver = resiverFromLocalStorage;
    this.convert = convertFromLocalStorage;
  },
  methods: {
    
     
    listen() {
    window.Echo.join('chat')
          .here((users) => {
              this.users = users;
            //  console.log(users)
            console.log(users);
              users?.forEach(element => {
                this.arrayOn = {
                  user_id:  element.id,
                  status: true
                }
                axios.put('/user/online/'+ element.id, {}).then((response) => {
                     
                  
  
                });
              });
          })
          .joining((user) => {
            // console.log(user.name)
            this.users.splice(this.users.length, 0, user);
            
               axios.put('/user/online/'+ user.id, {}).then((response) => {
                

              });
          })
          .leaving((user) => {
              this.users.filter(item => item.id !== user.id)
              axios.put('/user/onffline/'+ user.id, {}).then((response) => {
                
                this.arrayOn = {
                  user_id: user.id,
                  status: false
                };

              });
          });
       
  },
    



    scrollToBottom() {
      // Scroll to the bottom of the chat messages container
      const messageContainer = this.$refs.messageContainer;
      if (messageContainer) {
        messageContainer.scrollTop = messageContainer.scrollHeight;
      }
    },
     
    inputValue(event) {
      let value = event;
     
       if(value.length === 0){
        window.Echo.private('chat').whisper('stop-typing', {
          name:"user"
        });
        console.log(value.length)
       }  else {
        window.Echo.private('chat').whisper('typing', {
          name: 'User' ,
          covert_id: this.convert,
          resiver: this.resiver,
           // Foydalanuvchi ismi yoki identifikatori
         });
       }
    },
    
     fetchMessages(id,sender_id) {
      localStorage.setItem('resiver', sender_id);
      localStorage.setItem('convert', id);

      this.resiver = sender_id;
      this.convert = id;
      
      axios.get('/messages/' + id + '/user/' + sender_id).then(response => {
      
        this.messages = response.data.message ?? [];
       
        this.user_ob  = response.data.user;
          
        this.$nextTick(() => {
          this.scrollToBottom();
        });
      });
    },
    
    fetchChatList() {
        axios.get('/conver').then(response => {
          
           this.chatList = response.data;
        });
    },
     
    updateUserStatus(userId, status) {
      // Find the user in the chat list and update their status
      const userIndex = this.chatList.findIndex((user) => user.user_id === userId);
      console.log(this.chatList[userIndex])
      if (userIndex !== -1) {
        this.$set(this.chatList[userIndex], 'status', status);
      }
    },

    addMessage(message) {
      
      this.doneTyping();
      this.messages.push(message);
      this.$nextTick(() => {
        this.scrollToBottom();
      });
      axios.post('/messages', message).then(response => {
        console.log(response.data);
        
      });
    },
    
    editCreate(message) {
      this.startTyping()
      this.updateBtn = true;
      console.log(message);
      this.updateObjectv = {
         'id': message.id,
         'message': message.text
      } 
    },
    

    updatedMessage(data) {
      this.doneTyping();
      const messageIndex = this.messages.findIndex(
        (msg) => msg.id === data.message_id
      );
       
      this.messages[messageIndex].message = data.message;
      this.updateBtn = false;
      axios.post('/edit', data).then(response => {
          console.log(response.data)
          this.updateObjectv = null
      })
    },
  async startRecording() {
      const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
      this.mediaRecorder = new MediaRecorder(stream);

      this.mediaRecorder.ondataavailable = (event) => {
        if (event.data.size > 0) {
          this.audioChunks.push(event.data);
        }
      };

      this.mediaRecorder.onstop = () => {
        
        const audioBlob = new Blob(this.audioChunks, {type: 'audio/mp3' });
          console.log(audioBlob);
         
       // FormData obyekti yaratish
    const formData = new FormData();
     formData.append('audio', audioBlob, 'audio.mp3');
    formData.append('conversation_id', this.convert);
    formData.append('receriver_id', this.resiver);

         
          // this.messages.push(message);
        
          this.$nextTick(() => {
            this.scrollToBottom();
          });
          
          axios.post('/messages', formData , {
            headers: {
              'Content-Type': 'multipart/form-data', // Set the content type correctly
            },
          }).then(response => {
            
            
          });
          this.audioChunks = []; 
          // this.sendAudioToServer(audioUrl);
        };

        this.mediaRecorder.start();
      },
      stopRecording() {
        if (this.mediaRecorder) {
          this.mediaRecorder.stop();
       
        }
      },
    sendAudioToServer(audioUrl) {
      this.doneTyping();
      const formData = new FormData();
        formData.append('audio', audioUrl);
     
      
      let  message = {
        conversation_id: this.convert,
        receriver_id: this.resiver, 
        audio:  audioUrl,
        messages: null
      }
      this.messages.push(message);
     
      this.$nextTick(() => {
        this.scrollToBottom();
      });
      
      axios.post('/messages', message, ).then(response => {
        this.messages.push({
          id: response.data.data.message,
          message: e.message.message,
          user: e.user,
          audio: e.message.audio
        });
      });
      // Axios veya başka bir HTTP istemcisini kullanarak Laravel sunucusuna ses verisini gönderin.
    },
  

  startTyping() {
          // "typing" eventni yuborish
          window.Echo.private('chat').whisper('typing', {
              name: 'User', // Foydalanuvchi ismi yoki identifikatori
              covert_id: this.convert,
              resiver: this.resiver,
          });
  },
  
  doneTyping() {
      // Klaviaturadan yozish tugaganida "typing" eventni to'xtatib yuborish
      window.Echo.private('chat').whisper('stop-typing', {
        name:"user"
      });
      
  }
  }
});



app.mount('#app');
