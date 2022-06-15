<template>
  <div class="home">
    <div class="admin-header">
      <h1>HELLO {{ userName }}</h1>
      <button class="link create" type="button" name="button" v-on:click="createArticle()">Create Article</button>
    </div>
     <div class="sort-block">
       <div>
         <label for="SortOptions">Sort by date:</label>
         <select class="sort-item"  name="date" v-model="date" v-on:change="changePage()">
           <option value="desc" selected>Newest First</option>
           <option value="asc">Oldest First</option>
         </select>
       </div>
     </div>
     <div class="no-news" v-if="(Array.isArray(news.data) && news.data.length === 0)">
       <h3>No news yet !</h3>
     </div>
    <div class="news-item" v-for="value in news.data" :id="value.id">
      <span class="title">{{ value.title }}</span>
      <div class="description" >
        <div v-html="value.description"></div>
      </div>
      <div class="info">
        <div class="category">
          <span v-for="item in JSON.parse(value.category)">{{ item }}&nbsp</span>
        </div>
        <span class="pubdate"> {{ value.pubdate }}</span>
      </div>
      <div class="admin-actions">
        <a class="link" :href="value.link">Read Article</a>
        <button class="link edit" :value="value.id" type="button" name="button" v-on:click="updateArticle($event.target.value)">Edit</button>
        <button class="link delete" :value="value.id" type="button" name="button" v-on:click="deleteArticle($event.target.value)">Delete</button>
      </div>
    </div>
    <div class="pagination">
      <button type="button" name="button" :value="news.first_page_url" :disabled="(news.prev_page_url ? false : true)" v-on:click="changePage($event.target.value)">First page</button>
      <button type="button" name="button" :value="news.prev_page_url" :disabled="(news.prev_page_url ? false : true)" v-on:click="changePage($event.target.value)">Previous</button>
      <button type="button" name="button" :value="news.next_page_url" :disabled="(news.next_page_url ? false : true)" v-on:click="changePage($event.target.value)">Next</button>
    </div>
  </div>
</template>

<script>
    import axios from 'axios'
    export default {
      data: function () {
        return {
          userName: null,
          news: {},
          date: "desc",
        }
      },
    created() {
        axios.get('/tokenStatus', {})
        .then(response => {
          console.log(response.data.valid)
          let user = JSON.parse(localStorage.getItem('user')).user
          this.userName = user.name
        })
        .catch(error => {
        //  console.log(error)
          if (error.response.status === 401) {
            this.$store.dispatch('tokenNotValid')
            this.$router.push({ name: 'home' })
          }
        });
      },
      mounted() {
          this.changePage()
      },
      methods: {
        changePage(link='/news') {
            axios.get(link, {
              params: {
                date: this.date
              }
            })
            .then(response => {
              this.news = response.data
            })
            .catch(error => {
              console.log(error)
            });
          },
        deleteArticle(id) {
          let comfirm = window.confirm("Do you wish to delete this article ?")
          if(comfirm) {
            axios.delete('/news/' + id)
            .then(response => {
              document.getElementById(id).style.display = "none"
            })
            .catch(error => {
              console.log(error)
            });
          }
        },
        createArticle() {
          this.$router.push({ name: 'create' })
        },
        updateArticle(articleId) {  
          this.$router.push({ name: 'create', query: {id: articleId} })
        },
      },
    }
</script>
