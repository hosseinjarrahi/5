function checkAuth() {
    let authEl = document.querySelector('#authEl');
    let auth = authEl.getAttribute('value');
    authEl.remove();
    return auth ? auth : null;
}

function redirect(url) {
    window.location = url;
};

async function init(Vue, store = {'null': 'null'}) {
    let EventBus = window.EventBus = new Vue({});
    window.EventBus.auth = await checkAuth();
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
