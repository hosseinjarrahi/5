import Vue from 'vue'
import Vuex from  'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state:{
      'pic':'',
      'items':'',
      level:'',
       adminRoute: [
        { icon: 'mdi-account-group-outline', text: '  مدیریت کاربران ' ,link:'users'},
        { icon: 'mdi-account-badge-outline', text: 'آخرین مطالبات ثبت شده ' ,link:'demands'},
        { icon: 'mdi-checkbox-marked-circle-outline', text: 'تایید حساب کاربری' ,link:'verify'},
      ],
      NormalRoute: [
        { icon: 'mdi-account-group-outline', text: '  مدیریت کاربران ' ,link:'users'},
        { icon: 'mdi-account-badge-outline', text: 'آخرین مطالبات ثبت شده ' ,link:'demands'},
        { icon: 'mdi-checkbox-marked-circle-outline', text: 'تایید حساب کاربری' ,link:'verify'},
      ],
      SuperAdminRoute: [
        { icon: 'mdi-account-group-outline', text: '  مدیریت کاربران ' ,link:'users'},
        { icon: 'mdi-account-badge-outline', text: 'آخرین مطالبات ثبت شده ' ,link:'demands'},
        { icon: 'mdi-checkbox-marked-circle-outline', text: 'تایید حساب کاربری' ,link:'verify'},
      ]
    },
    getters:{
      getItems(state){
        switch(state.level){
          case 'admin':
            return state.SuperAdminRoute;
          break;

          case 'folan':

          break;

          default:

        }
      }
    },
    mutations:{
      setProfile:(state ,Pic)=>{
        state.pic=Pic;
      },
      setItem:(state,Item)=>{
        state.items=Item
      },
      setLevel(state,level){
        state.level = level;
      }
    },
    actions:{
        setItem(context){
            let level = localStorage.getItem('loggedLevel');
            context.commit('setItem',level);
        }
    }

})
