require('./bootstrap');
import 'fullcalendar';
// require('./script');
import Vue from 'vue'
import { Form, HasError, AlertError } from 'vform'
import VueProgressBar from 'vue-progressbar'
import Multiselect from 'vue-multiselect'

const VueProgressBarOptions = {
    color: '#1cd362',
    failedColor: '#87111d',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}
Vue.use(VueProgressBar, VueProgressBarOptions);
// vForm config
window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

// Multi select global component
Vue.component('multiselect', Multiselect);

// Auth component
Vue.component('login-component', require('./components/auth/LoginComponent.vue'));
Vue.component('register-component', require('./components/auth/RegisterComponent.vue'));

// Forms component
Vue.component('branch-form', require('./components/form/Branch.vue'));
Vue.component('department-form', require('./components/form/Department.vue'));
Vue.component('designation-form', require('./components/form/Designation.vue'));
Vue.component('employee-form', require('./components/form/Employee.vue'));


const app = new Vue({
    el: '#app'
});
