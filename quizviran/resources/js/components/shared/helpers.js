function checkAuth() {
    let authEl = document.querySelector('#authEl');
    let auth = authEl.getAttribute('value');
    authEl.remove();
    return auth ? auth : null;
}

function redirect(url) {
    window.location = url;
};

async function init(Vue, globalMixin, store = {'null': 'null'}) {
    let EventBus = window.EventBus = new Vue({});
    window.EventBus.auth = await checkAuth();
    Vue.mixin(globalMixin);
    const app = new Vue({
        data() {
            return {
                EventBus
            }
        },
        el: '#app',
        store,
        mounted() {
            document.getElementById('pageLoader').classList.remove('d-flex');
            document.getElementById('pageLoader').classList.add('d-none');
            // let docs = document.getElementsByClassName('tinymce-mathText');
            // console.log(docs);
            // docs.forEach((doc) => {
            //     let svg = doc.querySelector('svg');
            //     svg.setAttribute('height', '100%');
            //     svg.setAttribute('width', '100%');
            // });
        }
    });
};

export default init;
