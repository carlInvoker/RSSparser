<template>
  <div class="home">
    <h1>ARTICLES FORM</h1>
    <p id="Warning" style="margin:0;">Didn't do image add/edit, to save time. Can provide this functionality if neccessery.</p>
    <form class="login-form">
      <div class="form-item">
        <label for="Title">Title</label>
        <input type="text" name="title" v-model="title"  id="Title">
      </div>
      <div class="form-item">
        <label for="Description">Description</label>
        <textarea id="Description" name="description" rows="4" cols="50" v-model="description"></textarea>
      </div>
      <div class="form-item">
        <label for="Category">Category (press enter)</label>
        <input type="text" name="Category" placeholder="add category" v-on:keyup.enter="addCategory($event.target)" id="Category">
        <button type="button" name="button" v-on:click="addCategory()">Add Category</button>
        <button type="button" name="button" v-on:click="removeCategory()">Remove Category</button>
        <p>Categories: {{ category }}</p>
      </div>
      <div class="buttons-container">
        <button type="button" name="button" v-on:click="(!this.query) ? createArticle() : updateArticle()">Save</button>
      </div>
      <span id="Error"> {{ error }} </span>
    </form>
  </div>
</template>

<script>
export default {
      data() {
          return {
           title: '',
           link: '',
           description: '',
           HTMLdescription: '',
           category: [],
           error: '',
           oldImageLink: '',
         }
      },
      props: ['query'], // news id in porams
      mounted() {
        if(this.query) {
          axios.get('/news/' + this.query, {})
          .then(response => {
            this.title = response.data.title
            this.HTMLdescription = response.data.description
            this.description = this.stripHTML(this.HTMLdescription)
            this.link = response.data.link
            this.category = JSON.parse(response.data.category)
          })
          .catch(error => {
            console.log(error)
          });
        }
      },
      methods: {
       createArticle () {
        this.error = ''
        axios.post('/news', {
          title: this.title,
          description: "<img src='https://picsum.photos/200' alt='img'/><p>" + this.description + "</p>",
          category: JSON.stringify(this.category),
         })
         .then(() => {
           this.$router.push({ name: 'admin' })
         })
         .catch(err => {
           console.log(err.response.data)
           this.error = err.response.data
         })
       },
       updateArticle () {
        this.error = ''
        var desc = this.getDescription()
        axios.put('/news/' + this.query, {
          title: this.title,
          description: desc,
          category: JSON.stringify(this.category),
         })
         .then(() => {
           this.$router.push({ name: 'admin' })
         })
         .catch(err => {
           console.log(err.response.data)
           this.error = err.response.data
         })
       },
       addCategory(target) {
         var categoryItem
         if(!target) {
           categoryItem = document.getElementById('Category')
         }
         else {
           categoryItem = target
         }
         if(categoryItem.value.length > 0) {
           this.category.push(categoryItem.value)
           categoryItem.value = ""
         }
       },
       removeCategory() {
         this.category.pop()
       },
       stripHTML(str) {
         let regex = /(<([^>]+)>)/ig
         return str.replace(regex, "").slice(0, -12)
       },
       getDescription() {
         if(this.link.includes('lifehacker')) {
           let parser = new DOMParser()
           const doc = parser.parseFromString(this.HTMLdescription, 'text/html')
           let img = doc.getElementsByTagName('img')
           var desc = img[0].outerHTML + "<p>" + this.description + "</p>"
         }
         else {
           var desc = "<img src='https://picsum.photos/200' alt='img'/><p>" + this.description + "</p>"
         }
         return desc
       },
      },
    }
</script>
