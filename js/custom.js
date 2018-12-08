var app = new Vue({
    el: "#app",
    data:{
        notifications: {}
    },
    methods:{
        loadNotifications: function(){
            axios.post("http://localhost/PHP_FRAMEWORK/notification/getallnotification")
            .then(function (response){
                app.notifications = response.data;
            })
        }
    },
    created(){
        this.loadNotifications();
    }
});