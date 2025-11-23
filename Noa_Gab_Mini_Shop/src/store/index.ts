import { createStore } from 'vuex'
import axios from 'axios'

interface User {
    id: number,
    nom: string,
    prenom: string,
    email: string,
    tel: string,
    adresse: string,
    profil: string,
}

interface State {
    appIsLoading: boolean,
    authenticated: boolean,
    hasSeenDidactitielAt: string,
    app_url: string;
    api_url: string;
    notificationCount: number;
    user: User[];
    fetchInterval: number | null;
}

export default createStore({
    state: {
        appIsLoading: false,
        authenticated: false,
        hasSeenDidactitielAt: '',
        notificationCount: 0,
        api_url: 'http://127.0.0.1:8000',
        app_url: 'https://api-noa-gab.onrender.com',
        user: [],
        fetchInterval: null,
    } as State,

    getters: {
        fetchInterval: (state: State) => state.fetchInterval,
        appIsLoading: (state: State) => state.appIsLoading,
        notificationCount: (state: State) => state.notificationCount,
        authenticated: (state: State) => state.authenticated,
        user: (state: State) => state.user,
        apiUrl: (state: State) => state.api_url ,
        appUrl: (state: State) => state.app_url ,
        hasSeenDidactitielAt: (state: State) => state.hasSeenDidactitielAt ,
    },
    mutations: {
        setNotifications(state: State, nb: number) {
            state.notificationCount = nb;
          },
          setAuthenticated(state: State, value: User[])  {
            state.appIsLoading = true
            state.authenticated = true
            state.user = value
            window.localStorage.setItem('yams_user_session', JSON.stringify(state.user))
            // axios.defaults.headers.common = {
            //     'Authorization': 'Bearer ' + value.token,
            // };
            state.appIsLoading = false
          },
        setHasSeenDidactitielAt(state: State, value: string) {
            state.appIsLoading = true
            state.hasSeenDidactitielAt = value
            window.localStorage.setItem('yams_client_opened_at', JSON.stringify(value))
            state.appIsLoading = false
        },
        clearUserData(state: State) {
            state.appIsLoading = true
            state.authenticated = false
            state.user = []
            window.localStorage.removeItem('yams_user_session')
            state.appIsLoading = false
            window.location.reload()
        },
        setUserProfileDatas(state: State, value: User[]) {
            state.appIsLoading = true
            state.user = value,
              window.localStorage.setItem('yams_user_session', JSON.stringify(state.user))
            setTimeout(() => {
              state.appIsLoading = false
            }, 5000);
        },
        setFetchInterval(state: State, interval: number) {
            state.fetchInterval = interval;
          },
          clearFetchInterval(state: State) {
            state.fetchInterval = null;
          },
    },
    actions: {
        async fetchNotifications({ commit }) {
            try {
              const response = await axios.get('/api/notifications?read_at=null&req_count');
              commit('setNotifications', response.data);
            } catch (error) {
              console.error('Erreur lors de la recupération des notifications:', error);
            }
        },
    },
    modules: {},
})