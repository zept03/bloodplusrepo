var moment = require('moment');




//
// secondly, require or import Vuetable and optional VuetablePagination component

//
// thirdly, register components to Vue
//
Vue.component('notifications', require('./components/Notifications.vue'));


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */





const app = new Vue({
    el: '#app',
    data: {
        notifications: [],
        count: [],
        userId: id,
        role: role,
    },
    created() {
        this.getNotifications();
        console.log("niagi dri");
        if(this.role == 'User')
        {
        Echo.private('users.' + this.userId)
        .notification((notification) => {
            console.log(notification);  
            this.count++;
            this.notifications.unshift(notification);   
        });
        }
        else
        {
        Echo.private('admin.' + this.userId)
        .notification((notification) => {
            this.count++;
            this.notifications.unshift(notification);  
            console.log(notification.class);
            console.log(notification); 
            console.log(this.notifications);
        });    
        }
    },
    methods: {
        getNotifications() {
            // console.log(msg.user_id);
            axios.get('/bloodplususers/public/notifications').then(response => {
                this.count = response.data.count;
                this.notifications = response.data.notif;
                console.log(response.data.notif);
                console.log(response);
            });
        },
        unreadNotifications() {
            axios.get('/bloodplususers/public/notifications/unread').then(response => {
            });    
            this.count = 0;
        }
    }
});
