export interface Documents {
    id: number;
    filename: string;
    checked: number;
    link: string;
    is_pending_checked: boolean;
    is_quick_checked: boolean;
    is_expired_checked: boolean;
    user: Users;
    expire_date: string;
    action: Actions[];
    status: 'pending' | 'published' | 'canceled' | 'expired' | 'deleted'; // depends on your Status enum
    created_at: Date;
}

export interface Users {
    id: number;
    name: string;
    action: Actions[];
    document: Documents[];
    email: string;
    password: string;
    role: 'admin' | 'manager' | 'finance' | 'hr' | 'employee';
    created_at: string;
}

export interface Actions {
    id: number;
    filename: string;
    checked: number;
    user: Users;
    document: Documents;
    event_type: 'created' | 'published' | 'updated' | 'deleted' | 'viewed';
    created_at: Date;
}

export interface Error422 {
    code: string;
    response: {
        data: {
            errors: {
                email: string[];
                password: string[];
                message: string;
            };
            status: number;
        };
        status: number;
    };
}
export interface Error400_1_3 {
    data: {
        message: string;
    };
    status: number;
}

export interface AuthUserData {
    id: number;
    name: string;
    email: string;
    role: 'admin' | 'manager' | 'finance' | 'hr' | 'employee';
    created_at: string;
}

export interface AuthData {
    auth_user: AuthUserData | false;
}
export interface falseAuthData {
    auth_user: false;
}

export const appName: string = import.meta.env.VITE_APP_NAME || 'DocuVault';
