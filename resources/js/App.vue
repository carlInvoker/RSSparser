<template>
    <div id="GeneralContainer">
      <nav class="navbar">
          <router-link to="/" id="Logo">LOGO</router-link>
            <ul>
              <li class="nav-item">
                <router-link to="/create" class="nav-link">Create Article</router-link>
              </li>
              <li class="nav-item">
                <router-link to="/login" class="nav-link">Login</router-link>
              </li>
            </ul>
        </nav><br />
        <div>
          <router-view v-slot="{ Component }">
            <transition name="fade">
              <component :is="Component" />
            </transition>
          </router-view>
        </div>
    </div>
</template>

<style>
    .fade-enter-active, .fade-leave-active {
      transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
      opacity: 0
    }
</style>

<script>

    export default{
    }
</script>
