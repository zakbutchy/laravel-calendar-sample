import axios from 'axios';

// 一元管理するデータの状態
const state = {
    events: []
};

// stateを取得する（getterを使わないrenderもある）
const getters = {
    events: state => state.events.map(event => {
        return {
            ...event,
            start: new Date(event.start),
            end: new Date(event.end)
        };
    }),
}

// stateを更新する、更新は同期的に行う
const mutations = {
    setEvents: (state, events) => (state.events = events)
}

// データの加工や、WebAPI呼び出しを非同期的に行う
const actions = {
    async fetchEvents({ commit }) {
        const response = await axios.get('/api/events');
        commit('setEvents', response.data);
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
