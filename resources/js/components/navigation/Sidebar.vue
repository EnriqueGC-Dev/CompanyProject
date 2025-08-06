<template v-slot:prepend>
    <v-navigation-drawer
      class="deep-purple accent-4"
      dark
      permanent
    >

        <v-list density="compact" :elevation="3">
            <v-list-item class="mt-4" >
                <img src="https://randomuser.me/api/portraits/men/24.jpg">                    
            </v-list-item>
            <v-list-item
                :title=$store.state.user_name
                :subtitle=$store.state.user_mail>
            </v-list-item>
        </v-list>

        <v-list>
            <v-list-item
            v-for="item in items"
            :key="item.title"
            link
            >
            <v-list-item-icon>
                <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
                <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item-content>
            </v-list-item>
        </v-list>

      <template v-slot:append>
        <div class="pa-2">
          <v-btn color="first" block @click="logout()">
            cerrar sesión
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>
    
</template>
   
   <script>
    export default {
     data () {
      return {
        items: [
          { title: 'Dashboard', icon: 'mdi-view-dashboard' },
          { title: 'Account', icon: 'mdi-account-box' },
          { title: 'Admin', icon: 'mdi-gavel' },
        ],

      }
     },

     methods: {
        logout: function () {
            this.$store.dispatch("setLogout");
            this.$router.push("/");
        }
    },

    }
   </script>