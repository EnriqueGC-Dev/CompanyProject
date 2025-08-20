import { createApp } from 'vue';
import store from './store/store';
import '@mdi/font/css/materialdesignicons.css';
import { es } from 'vuetify/locale'

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

import Perfil from './components/profile/Perfil.vue';
import PerfilGeneral from './components/profile/PerfilGeneral.vue';
import PerfilControl from './components/profile/PerfilControl.vue';

import Home from './components/home/Home.vue';
import Home1 from './components/home/Home1.vue';

import FirstLogin from './components/dialogs/FirstLogin.vue';
import PopUpMessage from './components/dialogs/PopUpMessage.vue';

import DateSelector from './components/specialComponents/DateSelector.vue';

//Router
import router from './router';


const app = createApp(Index)
const vuetify = createVuetify({
  locale: {
    locale: 'es',
    fallback: 'es',
    messages: { es },
  },
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

app.component('FirstLogin', FirstLogin)
app.component('PopUpMessage', PopUpMessage)

app.component('Navbar', Navbar)
app.component('Sidebar', Sidebar)

app.component('Perfil', Perfil)
app.component('PerfilGeneral', PerfilGeneral)
app.component('PerfilControl', PerfilControl)

app.component('Home', Home)
app.component('Home1', Home1)

app.component('DateSelector', DateSelector)

app.mount('#app');