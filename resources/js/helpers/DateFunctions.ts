function GetArabicDateTime(created_at: Date | string | null): string | null {
    let arabic_datetime: string | null = null;
    if (created_at === null) {
        arabic_datetime = null;
    } else {
        const date: Date =
            typeof created_at === "string" ? new Date(created_at) : created_at;

        const months: { [key: string]: string } = {
            Jan: "يناير",
            Feb: "فبراير",
            Mar: "مارس",
            Apr: "أبريل",
            May: "مايو",
            Jun: "يونيو",
            Jul: "يوليو",
            Aug: "أغسطس",
            Sep: "سبتمبر",
            Oct: "أكتوبر",
            Nov: "نوفمبر",
            Dec: "ديسمبر",
        };

        const en_month: string = date.toString().split(" ")[1]; // Extracting month in English from the date
        const ar_month: string | undefined = months[en_month]; // Getting Arabic month from the months object

        const find: string[] = [
            "Sat",
            "Sun",
            "Mon",
            "Tue",
            "Wed",
            "Thu",
            "Fri",
        ];
        const replace: string[] = [
            "السبت",
            "الأحد",
            "الإثنين",
            "الثلاثاء",
            "الأربعاء",
            "الخميس",
            "الجمعة",
        ];
        const ar_day_format: string = date.toLocaleDateString("en-US", {
            weekday: "short",
        }); // The Current Day
        const ar_day: string = ar_day_format.replace(
            new RegExp(find.join("|"), "g"),
            (match) => replace[find.indexOf(match)]
        );

        const standard: string[] = [
            "0",
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
        ];
        const eastern_arabic_symbols: string[] = [
            "٠",
            "١",
            "٢",
            "٣",
            "٤",
            "٥",
            "٦",
            "٧",
            "٨",
            "٩",
        ];

        const current_date: string =
            date.getDate() + " " + ar_month + " " + date.getFullYear();
        const current_time: string =
            ("0" + date.getHours()).slice(-2) +
            ":" +
            ("0" + date.getMinutes()).slice(-2); // Format HH:MM
        const arabic_date: string = current_date.replace(
            new RegExp(standard.join("|"), "g"),
            (match) => eastern_arabic_symbols[standard.indexOf(match)]
        );
        const arabic_time: string = current_time.replace(
            new RegExp(standard.join("|"), "g"),
            (match) => eastern_arabic_symbols[standard.indexOf(match)]
        );

        arabic_datetime = arabic_date + " " + arabic_time;
    }
    return arabic_datetime;
}
function GetArabicDate(created_at: Date | string | null): string | null {
    let arabic_date: string | null = null;
    if (created_at === null) {
        arabic_date = null;
    } else {
        const date: Date =
            typeof created_at === "string" ? new Date(created_at) : created_at;

        const months: { [key: string]: string } = {
            Jan: "يناير",
            Feb: "فبراير",
            Mar: "مارس",
            Apr: "أبريل",
            May: "مايو",
            Jun: "يونيو",
            Jul: "يوليو",
            Aug: "أغسطس",
            Sep: "سبتمبر",
            Oct: "أكتوبر",
            Nov: "نوفمبر",
            Dec: "ديسمبر",
        };

        const en_month: string = date.toString().split(" ")[1]; // Extracting month in English from the date
        const ar_month: string | undefined = months[en_month]; // Getting Arabic month from the months object

        const standard: string[] = [
            "0",
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9",
        ];
        const eastern_arabic_symbols: string[] = [
            "٠",
            "١",
            "٢",
            "٣",
            "٤",
            "٥",
            "٦",
            "٧",
            "٨",
            "٩",
        ];

        const current_date: string =
            date.getDate() + " " + ar_month + " " + date.getFullYear();

        arabic_date = current_date.replace(
            new RegExp(standard.join("|"), "g"),
            (match) => eastern_arabic_symbols[standard.indexOf(match)]
        );
    }
    return arabic_date;
}

function GetArabicTime(time: string): string {
    let arabic_datetime: string | null = null;
    const standard: string[] = [
        "0",
        "1",
        "2",
        "3",
        "4",
        "5",
        "6",
        "7",
        "8",
        "9",
    ];
    const eastern_arabic_symbols: string[] = [
        "٠",
        "١",
        "٢",
        "٣",
        "٤",
        "٥",
        "٦",
        "٧",
        "٨",
        "٩",
    ];

    const hours = time.split(":")[0];
    const minutes = time.split(":")[1];
    const current_time: string = hours + ":" + minutes;

    const arabic_time: string = current_time.replace(
        new RegExp(standard.join("|"), "g"),
        (match) => eastern_arabic_symbols[standard.indexOf(match)]
    );

    arabic_datetime = arabic_time;

    return arabic_datetime;
}
export { GetArabicDateTime, GetArabicTime, GetArabicDate };
