function checkAuth() {
    let H = localStorage.getItem('H');
    if (H && H != 'false') return H;
    return axios.post('/check-auth')
        .then(res => {
            localStorage.setItem('H', res.data);
            return res.data;
        })
        .catch(err => console.log(err));
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
        }
    });
};

export default init;
