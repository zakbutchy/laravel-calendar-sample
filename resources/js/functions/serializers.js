import { format } from 'date-fns';

// Vuexのストアで行っていたイベントをJSのオブジェクトにする処理を切り分ける
// Vuexは状態の管理やAPIとの連携のみを行う様にしておく事で見通しが良くなる
export const serializeEvent = event => {
    if (event === null) {
        return null;
    }

    const start = new Date(event.start);
    const end = new Date(event.end);
    return {
        ...event,
        start,
        end,
        startDate: format(start, 'yyyy/MM/dd'),
        startTime: format(start, 'HH:mm'),
        endDate: format(end, 'yyyy/MM/dd'),
        endTime: format(end, 'HH:mm'),
        color: event.color || '#216a1a',
    };
};
