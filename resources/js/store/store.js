import { createApp } from 'vue'
import { createStore } from 'vuex'
import axios from 'axios';
import App from '../components/App.vue';

const store = createStore({
    state () {
        return {
            authentication: false,
            user_id: null,
            user_name: null,
            user_mail: null,
            company_id: null,
        }
    },
    mutations: {
        LOGIN: async function (state, callback) {
            let response = await axios.get("/api/user/data");   

            if (response.data.status == 'OK') {
                state.authentication = true;
                state.user_id = response.data.id;
                state.user_name = response.data.name;
                state.user_mail = response.data.email;
                state.company_id = response.data.company_id;
                if (typeof callback == 'function') {
                    callback(true);
                }
            }
            else {
                state.authentication = false; 
                state.user_id = null;
                state.user_name = null;
                state.user_mail = null;
                state.company_id = null;
                if (typeof callback == 'function') {
                    callback(false);
                }
            }
        }
    },
    actions: {
        setLogin: function (context, callback) {
            context.commit('LOGIN', callback);
        },
        setLogout: function (context) {
            axios.post("/api/user/logout")
                .then(response => {
                    context.commit('LOGOUT');
                });
        }
    },
    getters: {
        isUserLogged(state) {
            return state.authentication;
        },
    }
})

const app = createApp(App)
app.use(store)

export default store