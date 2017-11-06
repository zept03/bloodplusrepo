<template>
    <li class="dropdown">
            <a  v-on:click="counter" class="dropdown-toggle navlinks" data-toggle="dropdown" href="#">
            <i class="glyphicon glyphicon-bell"></i>
            <span v-if="count != 0" class="label label-success">{{count}}
            </span>
            </a>
            <ul class="dropdown-menu first-dropdown">
              <li class="notification-list" v-for="notification in notifications">
                <a v-bind:href="'/bloodplususers/public/notifications/'+notification.data.class['id']+'?class='+notification.data.class['class']">
                  <div class ="media">
                  <div class="media-left">
                    <img :src=getImageUrl(notification.data.user) class="media-object" style="width:60px">
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading">{{notification.data.user['name']}}</h4>
                    <span>{{notification.data.message}}</span>
                    <br>
                    {{notification.data.class['time'] | formatDate}}
                  </div>
                  </div>
                </a>
                <hr>
              </li>
            </ul>
    </li>            
</template>

<script>
    export default {
        props: [
          'notifications','count' 
        ],
        mounted: function()
        { 
          console.log(this.count);
          console.log(this.notifications);
          console.log("Component created!"); 
        },
        methods: {
          getImageUrl(object) {
            return object['picture'];
          },
          counter()
          {
          console.log('niagi dri');
            this.$emit('readnotif');
          }
        }
    }
</script>
