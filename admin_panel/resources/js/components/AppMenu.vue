<template>
  <v-navigation-drawer 
  app right 
  :value="drawer"
  @input="x" 
  >
    <v-list dense nav class="py-0">
      <v-list-item two-line class="miniVariant px-0">
        <v-list-item-avatar>
          <img src="https://randomuser.me/api/portraits/men/81.jpg"/>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title>پنل مدیریت</v-list-item-title>
          <v-list-item-subtitle>تیزویران</v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>

      <v-divider></v-divider>

      <v-list-item link v-for="(item,index) in items" :key="index">
        <v-list-item-icon>
          <v-icon>{{  item.icon }}</v-icon>
        </v-list-item-icon>

        <v-list-item-content>
          <a :href="item.to">
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </a>
        </v-list-item-content>
      </v-list-item>
                               
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import {mapMutations} from 'vuex'
export default {
  name: "AppMenu",
  data(){
    return {
      items:[
        {icon: 'mdi-view-dashboard',title: 'داشبرد',to:'/manager'},
        {icon: 'mdi-archive',title: 'محصولات',to: '/manager/product'},
        {icon: 'mdi-play-box-outline',title: 'اسلایدر',to: '/manager/slider'},
        {icon: 'mdi-calendar-star',title: 'رویدادها',to: '/manager/event'},
        {icon: 'mdi-credit-card-outline',title: 'خریدها',to: '/manager/payment'},
        {icon: 'mdi-account-group',title: 'کاربران',to: '/manager/user'},
        {icon: 'mdi-comment-multiple',title: 'نظرات',to: '/manager/comment'},
        {icon: 'mdi-account-cog',title: 'تنظیمات سایت',to: '/manager/setting'},
      ],
      open:'',
    }
  },
  computed:{
    drawer(){ 
      return this.$store.state.drawer;
    }
  },
  methods:{
    x(e){
      this.$store.state.drawer = e;
    }
  }
};
</script>

<style>
</style>