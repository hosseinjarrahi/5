window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.onload = async function(){
    document.getElementById('pageLoader').classList.remove('d-flex');
    document.getElementById('pageLoader').classList.add('d-none');
}