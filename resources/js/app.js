import { createApp } from 'vue';
import store from './store/store';
import '@mdi/font/css/materialdesignicons.css';

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

// Components
import Index from './components/Index.vue';
import App from './components/App.vue';

import Login from './components/login/Login.vue';
import Registro from './components/login/Registro.vue';

import Navbar from './components/navigation/Navbar.vue';
import Sidebar from './components/navigation/Sidebar.vue';
import Home from './components/home/Home.vue';

import FirstLogin from './components/dialogs/FirstLogin.vue';

//Router
import router from './router';


const app = createApp(Index)
const vuetify = createVuetify({
  icons: {
    defaultSet: 'mdi',
  },
  components,
  directives,
  theme: {
    themes: {
      light: {
        dark: false,
        colors: {
          primary: '#113065',
          first: '#0f1056',
          second: '#151269', 
          thirth: '#81b1ce',
          fourth: '#aad6ec',
          cancel: "#FF0000",
          link: "#409fff",
        },
      },
    },
  },
})

app.use(store);
app.use(vuetify)
app.use(router)

app.component('App', App)
app.component('Login', Login)
app.component('Registro', Registro)

app.component('Navbar', Navbar)
app.component('Sidebar', Sidebar)
app.component('Home', Home)
app.component('FirstLogin', FirstLogin)

app.mount('#app');