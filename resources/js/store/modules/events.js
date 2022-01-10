import axios from 'axios';
import { serializeEvent } from '../../functions/serializers';

// 一元管理するデータの状態
const state = {
    events: [],
    event: null,
    isEditMode: false,
};

// stateを取得する（getterを使わないrenderもある）
const getters = {
    events: state => state.events.map(event => serializeEvent(event)),
    event: state => serializeEvent(state.event),
    isEditMode: state => state.isEditMode,
};

// stateを更新する、更新は同期的に行う
const mutations = {
    setEvents: (state, events) => (state.events = events),
    appendEvent: (state, event) => (state.events = [...state.events, event]),
    setEvent: (state, event) => (state.event = event),
    setEditMode: (state, bool) => (state.isEditMode = bool),
}

// データの加工や、WebAPI呼び出しを非同期的に行う
const actions = {
    // イベント取得
    async fetchEvents({ commit }) {
        const response = await axios.get('/api/events');
        commit('setEvents', response.data);
    },
    // イベント作成
    // 第2引数にはこのアクションを呼び出す時の引数が代入される
    async createEvent({ commit }, event) {
        // eventデータをパラメータとしてPOSTリクエストを送り、responseにはデータベースに登録されたeventデータが代入される
        const response = await axios.post('/api/events', event);
        // appendEventミューテーションに渡し、[...state.events, event]で元々のstate.events配列の末尾にeventデータを追加
        commit('appendEvent', response.data);
    },
    setEvent({ commit }, event) {
        commit('setEvent', event);
    },
    setEditMode({ commit }, bool) {
        commit('setEditMode', bool)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
