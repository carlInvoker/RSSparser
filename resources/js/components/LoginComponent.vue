<template>
  <div>
    <form class="login-form" action="" method="post">
      <h2>Admin login</h2>
      <div class="form-item">
        <label for="Email">Email</label>
        <input type="text" name="email" value="" id="Email">
      </div>
      <div class="form-item">
        <label for="Password">Password</label>
        <input type="text" name="Password" value="" id="Password">
      </div>
      <div class="buttons-container">
        <button type="submit" name="button">Login</button>
      </div>
    </form>
  </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
