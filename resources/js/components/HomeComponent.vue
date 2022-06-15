<template>
  <div class="home">
    <h1>News List</h1>
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
    <div class="news-item" v-for="value in news.data">
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
      <a class="link" :href="value.link">Read Article</a>
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
            news: {},
            date: "desc",
          }
        },
        mounted() {
            console.log('Component mounted.')
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
              console.log(this.news)
            })
            .catch(error => {
              console.log(error)
            });
          },
        },
    }
</script>
