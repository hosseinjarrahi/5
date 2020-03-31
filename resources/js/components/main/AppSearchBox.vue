<template>
  <div class="w-100">
    <form action="">
      <div class="input-group my-3 shadow position-relative">
        <input v-model="search" type="text" class="form-control" style="padding:20px !important" placeholder="جست و جو...">
        <div class="input-group-append" @click="find">
          <span class="input-group-text text-white pointer" style="background:#e20"><span class="fas fa-search"></span></span>
        </div>

        <div class="row justify-content-center droper">
          <div class="col-12" v-if="results.length > 0">
            <div class="menu rounded shadow bg-light p-3">
              <a class="menu-item text-justify" href="/purchases" v-for="result in results">
                <span class="fas fa-arrow-left"></span>
                <span>{{ result.title }}</span>
                <div class="dropdown-divider"></div>
              </a>
              <a class="dropdown-item text-center border border-dark py-1" href="/purchases">
                <span>بیشتر ...</span>
              </a>
            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                results: [],
                search: ''
            }
        },
        methods: {
            find() {
                this.load();
                axios.get('/search', {search: this.search})
                    .then(res => this.results = res.data)
                    .then(() => {
                        this.closeLoad();
                    });
                console.log(this.results);
            }
        }

    }
</script>

<style>
  .droper {
    position: absolute;
    left: 0;
    right:0;
    top: 45px;
    z-index:5;

  }
  .menu{
    padding-top: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    overflow: hidden;

  }
</style>