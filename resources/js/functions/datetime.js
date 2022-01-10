// TimeForm.vueで選択できる様にする時間の間隔をオブジェクトとして渡す関数（15分単位で時間指定）
export const getTimeIntervalList = () => {
    const hours = [...Array(24)].map((_, i) => ('0' + i).slice(-2));
    const minutes = ['00', '15', '30', '45'];
    return hours.map(hour => minutes.map(minute => hour + ':' + minute)).flat();
}
