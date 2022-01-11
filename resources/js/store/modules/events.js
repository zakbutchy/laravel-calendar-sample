import axios from 'axios';
import { isDateWithinInterval, compareDates } from '../../functions/datetime';
import { serializeEvent } from '../../functions/serializers';

// 一元管理するデータの状態
const state = {
    events: [],
    event: null,
    isEditMode: false,
    clickedDate: null,
};

// stateを取得する（getterを使わないrenderもある）
const getters = {
    events: state => state.events.map(event => serializeEvent(event)),
    event: state => serializeEvent(state.event),

    // クリックした日付の予定を取得する
    dayEvents: state =>
        state.events
            .map(event => serializeEvent(event))
            .filter(event => isDateWithinInterval(state.clickedDate, event.startDate, event.endDate))
            .sort(compareDates),

    isEditMode: state => state.isEditMode,
    clickedDate: state => state.clickedDate,
};

// stateを更新する、更新は同期的に行う
const mutations = {
    setEvents: (state, events) => (state.events = events),
    appendEvent: (state, event) => (state.events = [...state.events, event]),
    setEvent: (state, event) => (state.event = event),
    removeEvent: (state, event) => (state.events = state.events.filter(e => e.id !== event.id)),
    resetEvent: state => (state.event = null),
    updateEvent: (state, event) => (state.events = state.events.map(e => (e.id === event.id ? event : e))),
    setEditMode: (state, bool) => (state.isEditMode = bool),
    setClickedDate: (state, date) => (state.clickedDate = date),
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
    // イベント更新
    async updateEvent({ commit }, event) {
        const response = await axios.put(`/api/events/${event.id}`, event);
        commit('updateEvent', response.data);
    },
    // イベント削除
    async deleteEvent({ commit }, id) {
        const response = await axios.delete(`/api/events/${id}`);
        commit('removeEvent', response.data);
        commit('resetEvent');
    },
    setEvent({ commit }, event) {
        commit('setEvent', event);
    },
    setEditMode({ commit }, bool) {
        commit('setEditMode', bool)
    },
    setClickedDate({ commit }, date) {
        commit('setClickedDate', date);
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
