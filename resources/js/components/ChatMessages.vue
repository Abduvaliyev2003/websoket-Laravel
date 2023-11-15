

<template>
  <ul class="chat">

    <div style="width:100%;">
      <li class="left clearfix" v-for="message in messages">
        <div class="chat-body clearfix" v-if="message.user_id === (user ? user.id : null)">
          <div class="  chatleft">
            <div class="chat-box  boxrigth">
              <div class="iconUp" @click="getValue(message.id, message.message)">
              </div>
              <div v-if="message.audio == null">
                <p>
                  {{ message.message }}
                </p>
              </div>
              <div v-else>
                <audio controls>
                  <source :src="message.audio">
                </audio>
              </div>

            </div>

          </div>

        </div>
        <div class="chat-body clearfix" v-else>
          <div>
            <div class="chat-box  boxleft">

              <div v-if="message.audio == null">
                <p>
                  {{ message.message }}
                </p>
              </div>
              <div v-else>
                <audio controls>
                  <source :src="message.audio">
                </audio>
              </div>
            </div>


          </div>

        </div>
      </li>
      <div v-if="convertid === channel">
        <div v-if="typewrite == true">
          <div class="one"></div>
          <div class="one"></div>
          <div class="one"></div>
          <div class="one"></div>
          <div class="one"></div>
        </div>
        <div v-else>

        </div>

      </div>
      <div v-else>


      </div>

    </div>

  </ul>
</template>





<script>
export default {
  props: ['messages', 'user', 'typewrite', 'convertid', 'channel', 'userob'],


  methods: {
    getValue(id, message) {

      this.$emit('edittext', {
        'id': id,
        'text': message
      });
    }


  }
};
</script>

