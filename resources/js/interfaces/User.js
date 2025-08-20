export default class APIUser {

    constructor(id) {
        this.id = id;
    }

    static EmptyUser = {
        name: null,
        email: null,
        user_role_id: null,
        user_active: false,
        user_photo: null,
        user_phone: null,
        user_birthday: null,
        user_company_admin: false,
    }
}