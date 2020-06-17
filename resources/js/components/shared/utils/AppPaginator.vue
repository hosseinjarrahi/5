<template>
  <nav class="my-3 text-light" v-if="hasPages">
    <ul class="px-0" style="list-style-type: none;display: flex;flex-direction: row-reverse;">

      <li :class="{pointer:!prevDisabled}">
        <span class="right-horizon bg-dark-gray py-2 px-3" @click="paginate(currentPage - 1)">&rsaquo;</span>
      </li>

      <template v-for="n in pageNumber">
        <li :class="{pointer:currentPage != n + currentPage - 1}">
          <span :class="['py-2 px-3',(currentPage == n + currentPage - 1) ? 'bg-gray' : 'bg-dark-gray']"
                @click="paginate(currentPage + n - 1)">
            {{ currentPage + n - 1 }}
          </span>
        </li>
      </template>

      <li :class="{pointer:hasMorePages}">
        <a class="bg-dark-gray left-horizon py-2 px-3" @click="paginate(currentPage + 1)">&lsaquo;</a>
      </li>

    </ul>
  </nav>
</template>

<script>
  import {mapMutations} from 'vuex';

  export default {
    name: "AppPaginator",
    props: ['paginator', 'route'],
    methods: {
      ...mapMutations(['loadOff', 'loadOn']),
      paginate(page) {
        if (!(this.currentPage != page && page >= 1 && page <= this.paginator.last_page))
          return;
        this.loadOn();
        axios.post(`${this.route}?page=${page}`)
          .then(({data}) => {
            this.$emit('response', data);
            this.currentPage = page;
          })
          .catch(error => {
          })
          .finally(() => {
            this.loadOff();
          });
      }
    },
    data() {
      return {
        currentPage: 1
      }
    },
    computed: {
      hasPages() {
        return this.paginator.last_page > 1;
      },
      prevDisabled() {
        return this.currentPage == 1;
      },
      hasMorePages() {
        return this.paginator.last_page != this.currentPage;
      },
      pageNumber() {
        let diff = this.paginator.last_page - this.currentPage + 1;
        return diff < 5 ? diff : 5;
      }
    }
  }
</script>

<style scoped>

</style>
