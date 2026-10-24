const pad = (number) => String(number).padStart(2, '0');

const toDateString = (date) => `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`;

/**
 * Parse server dates the way moment did: plain dates and timezone-less
 * date times are local, and Safari needs microseconds trimmed to milliseconds.
 */
export function parseDate(value) {
    if (value instanceof Date) {
        return value;
    }

    const normalized = String(value)
        .replace(/^(\d{4}-\d{2}-\d{2})$/, '$1T00:00:00')
        .replace(' ', 'T')
        .replace(/(\.\d{3})\d+/, '$1');

    return new Date(normalized);
}

/** MM/DD/YY */
export function formatShortDate(value) {
    const date = parseDate(value);

    return `${pad(date.getMonth() + 1)}/${pad(date.getDate())}/${pad(date.getFullYear() % 100)}`;
}

/** h:mm am */
export function formatTime(value) {
    const date = parseDate(value);
    const hours = date.getHours() % 12 || 12;

    return `${hours}:${pad(date.getMinutes())} ${date.getHours() >= 12 ? 'pm' : 'am'}`;
}

/** MM/DD h:mm am */
export function formatMonthDayTime(value) {
    const date = parseDate(value);

    return `${pad(date.getMonth() + 1)}/${pad(date.getDate())} ${formatTime(date)}`;
}

export function yearsOld(value) {
    const birthDate = parseDate(value);
    const today = new Date();
    const monthDifference = today.getMonth() - birthDate.getMonth();
    let age = today.getFullYear() - birthDate.getFullYear();

    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    return age;
}

/** The ISO week containing the date, as used by <input type="week">: YYYY-Www */
export function isoWeekString(value) {
    const date = parseDate(value);
    const thursday = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 3 - ((date.getDay() + 6) % 7));
    const januaryFourth = new Date(thursday.getFullYear(), 0, 4);
    const week = 1 + Math.round(((thursday - januaryFourth) / 86400000 - 3 + ((januaryFourth.getDay() + 6) % 7)) / 7);

    return `${thursday.getFullYear()}-W${pad(week)}`;
}

/** Monday and Sunday (YYYY-MM-DD) of an ISO week string: YYYY-Www */
export function isoWeekRange(weekString) {
    const [year, week] = weekString.split('-W').map(Number);
    const januaryFourth = new Date(year, 0, 4);
    const start = new Date(year, 0, 4 - ((januaryFourth.getDay() + 6) % 7) + (week - 1) * 7);
    const end = new Date(start.getFullYear(), start.getMonth(), start.getDate() + 6);

    return { start: toDateString(start), end: toDateString(end) };
}
