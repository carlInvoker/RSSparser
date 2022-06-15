 <template>
    <div id="GeneralContainer">
      <nav class="navbar">
          <router-link to="/" id="Logo">LOGO</router-link>
            <ul>
              <!-- <li class="nav-item">
                <router-link to="/create" class="nav-link">Create Article</router-link>
              </li> -->
              <!-- <li class="nav-item">
                <router-link to="/login" class="nav-link">Login</router-link>
              </li> -->
              <li class="nav-item">
                <router-link to="/admin" class="nav-link">Admin Panel</router-link>
              </li>
              <li class="nav-item" v-if="authenticated">
                <a href="#" v-on:click.prevent="logout()">Logout</a>
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
    import axios from 'axios'
    export default{
      computed: {
        authenticated () { return this.$store.state.authenticated }
      },
      methods: {
        logout () {
          this.$store.dispatch('logout')
        },
      },
      created: function () {
         let user = localStorage.getItem('user')
         if(user !== null) {
           let user = JSON.parse(localStorage.getItem('user'))
           let bearer = "Bearer " + user.access_token
           axios.defaults.headers.common['Authorization'] = bearer
           this.$store.state.authenticated = true
         }
      },
    }
</script>
