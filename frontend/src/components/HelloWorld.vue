<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    <b-button type="is-success">
      <span class="mdi mdi-home"></span>
      Testing buefy and mdi
    </b-button>
    <p>
      Work in progress
    </p>
  </div>
</template>

<script>
export default {
  name: "HelloWorld",
  props: {
    msg: String
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
