<template>
  <div>
    <form class="login-form" @submit.prevent="login">
      <h2>Admin login</h2>
      <div class="form-item">
        <label for="Email">Email</label>
        <input type="text" name="email" v-model="email"  id="Email">
      </div>
      <div class="form-item">
        <label for="Password">Password</label>
        <input type="password" name="Password"  v-model="password" id="Password">
      </div>
      <div class="buttons-container">
        <button type="submit" name="button">Login</button>
      </div>
      <span id="Error"> {{ error }} </span>
    </form>
  </div>
</template>

<script>
export default {
      data() {
          return {
           email: '',
           password: '',
           error: ''
         }
      },
      mounted() {
          console.log('Component mounted.')
      },
      methods: {
       login () {
         this.error = ''
         this.$store
           .dispatch('login', {
             email: this.email,
             password: this.password
           })
           .then(() => {
             this.$router.push({ name: 'admin' })
           })
           .catch(err => {
             console.log(err.response.data)
             this.error = err.response.data
           })
       },
      },

    }
</script>
