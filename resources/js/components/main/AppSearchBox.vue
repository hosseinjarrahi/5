<template>
  <div class="w-100">
    <div class="input-group my-3 shadow position-relative" style="border-radius:50px;">
      <input @keyup.enter="find" v-model="search" type="text" class="no-shadow p-2 search form-control" placeholder="جست و جو...">
      <div class="input-group-append" @click="find">
        <span class="input-group-text text-white pointer" style="border-radius:25px 0px 0px 25px;background:#e20"><span class="fas fa-search"></span></span>
      </div>

      <div class="row justify-content-center droper">
        <transition name="slide">
          <div class="col-12" v-if="results.length > 0">
            <div class="menu rounded shadow bg-light p-3">
              <div class="dropdown-item text-center text-danger border border-danger py-1" @click="results=[]">
                <span>&times;</span>
              </div>
              <div class="dropdown-divider"></div>
              <a class="menu-item text-justify" :href="result.url" v-for="result in results">
                <span class="fas fa-arrow-left"></span>
                <span>{{ result.title }}</span>
                <div class="dropdown-divider"></div>
              </a>
              <a class="dropdown-item text-center border border-dark py-1" :href="'/search?view=true&search='+search">
                <span>بیشتر ...</span>
              </a>
            </div>
          </div>
        </transition>
      </div>

    </div>
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
                if(this.search == '')
                    return;
                this.load();
                axios.get('/search?search=' + this.search)
                    .then(res => this.results = res.data)
                    .then(() => {
                        this.closeLoad();
                    });
            }
        }

    }
</script>

<style>
  .droper {
    position: absolute;
    left: 0;
    right: 0;
    top: 45px;
    z-index: 5;

  }

  .menu {
    padding-top: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    overflow: hidden;

  }
</style>
