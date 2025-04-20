const translations = {
    // Permissions for managing books (المكتبة)
    "read-books": "قراءة المكتبة",
    "create-books": "إنشاء المكتبة",
    "delete-books": "حذف المكتبة",
    "update-books": "تحديث المكتبة",

    // Permissions for managing judicial guide (الدليل العدلي)
    "read-judicial-guide": "قراءة الدليل العدلي",
    "create-judicial-guide": "إنشاء الدليل العدلي",
    "delete-judicial-guide": "حذف الدليل العدلي",
    "update-judicial-guide": "تحديث الدليل العدلي",

    // Permissions for managing law guide (الدليل العدلي)
    "read-law-guide": "قراءة دليل الأنظمة",
    "create-law-guide": "إنشاء دليل الأنظمة",
    "delete-law-guide": "حذف دليل الأنظمة",
    "update-law-guide": "تحديث دليل الأنظمة",

    // Permissions for managing users (المستخدمين)
    "read-users": "قراءة المستخدمين",
    "create-users": "إنشاء المستخدمين",
    "delete-users": "حذف المستخدمين",
    "update-users": "تحديث المستخدمين",

    // Roles
    "manage-books": "إدارة المكتبة",
    "manage-judicial-guide": "إدارة الدليل العدلي",
    "manage-law-guide": "إدارة دليل الأنظمة",
    "manage-users": "إدارة المستخدمين",

    "super-admin": "متحكم كامل",
    standard: "عادي",
};

export function findTranslation(word) {
    return translations[word] || word;
}
