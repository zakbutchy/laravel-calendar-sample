import axios from 'axios';
import { serializeCalendar } from '../../functions/serializers';

const state = {
    calendars: [],
};

const getters = {
    calendars: state => state.calendars.map(calendar => serializeCalendar(calendar)),
};

const mutations = {
    setCalendars: (state, calendars) => (state.calendars = calendars),
};

const actions = {
    async fetchCalendars({ commit }) {
        const response = await axios.get('/api/calendars');
        commit('setCalendars', response.data);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};
