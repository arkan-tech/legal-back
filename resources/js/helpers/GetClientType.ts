function GetClientType(type) {
    let currentType;
    switch (type) {
        case 1:
            currentType = "فرد";
            break;
        case 2:
            currentType = "مؤسسة";
            break;
        case 3:
            currentType = "شركة";
            break;
        case 4:
            currentType = "جهة حكومية";
            break;
        case 5:
            currentType = "هيئة";
            break;
    }
    return currentType;
}

export default GetClientType;
