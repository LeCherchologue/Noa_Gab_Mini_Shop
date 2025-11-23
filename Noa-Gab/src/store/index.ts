import { createStore } from 'vuex'
import { Storage } from '@ionic/storage';
import axios from 'axios'

const app_storage = new Storage({
    name: 'yams_app_db'
});

export default createStore({
    state() {
        return {
            isLoading: false,
            authenticated: false,
            connexion: 0,
            first_connexion: 0,
            user: {
                photo: null,
                name: null,
                telephone1: null,
                telephone2: null,
                date_naissance: null,
                adresse: null,
                type: null,
                poste: null,
                permissions: [],
                
            },
            notifications: [],
            mobileNotifications: [],
           
            api_url: 'https://latest-api.yamslogistics.com/',
            app_url: 'https://transporteur-app-mobile.yamslogistics.com/',
        }
    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        },
        permissions(state) {
            return state.user.permissions
        },
        apiUrl(state) {
            return state.api_url
        },
        appUrl(state) {
            return state.app_url
        },
        async appStorage () {
            const user = await app_storage.get('yams_app_user_session')
            return user
        },
    },
    mutations: {
        setMobileNotifications(state, value){
            state.mobileNotifications.push(value)
        },
        setNotifications(state, value){
            state.notifications = value
        },
        setConfiguration(state, value){
            state.first_connexion = value
            app_storage.create();
            app_storage.set('yams_configuration', value)
            window.localStorage.setItem('yams_configuration', value)
            console.log('first connexion', app_storage.get('yams_configuration'))
        },
        setAuthenticated(state, value) {
            state.authenticated = true
            state.connexion = 1
            state.user = value
            app_storage.create();
            app_storage.set('yams_app_user_session', JSON.stringify(value))
            window.localStorage.setItem('yams_user_session', JSON.stringify(value))
            // window.localStorage.setItem('yams_first_connexion', state.first_connexion)
            
            // console.log('user_init', value)

            axios.defaults.headers.common = {
                'Authorization': 'Bearer ' + value.token,
            };
        },
        clearUserData(state) {
            state.authenticated = false
            state.connexion = 0
            state.user = {
                photo: null,
                name: null,
                telephone1: null,
                telephone2: null,
                date_naissance: null,
                adresse: null,
                type: null,
                poste: null,
                permissions: []
            }

            window.localStorage.removeItem('yams_user_session')
            // window.location.reload()
            // app_storage.clear();
            console.log('welcome', app_storage.get('yams_app_user_session'))
            console.log('state', state.authenticated)
        },
        setUserPhoto(state, value) {
            state.user.photo = value
        },
        setUserProfile(state, value) {
            state.user.name = value.name
            state.user.telephone1 = value.telephone1
            state.user.telephone2 = value.telephone2
            state.user.date_naissance = value.date_naissance
            state.user.adresse = value.adresse
        }
    },
    actions: {},
    modules: {},
})