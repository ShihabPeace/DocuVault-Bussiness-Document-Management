export interface Documents {
    id: number;
    content: string;
    link: string;
    user: Users;
    action: Actions[];
    checked: boolean;
    status: 'PENDING' | 'PUBLISHED' | 'CANCELLED' | 'EXPIRED'; // depends on your Status enum
    created_at: string;
    
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
  document_name: string;
  user: Users;
  document: Documents;
  user_id: number | null;
  action: 'created' | 'published' | 'updated' | 'deleted' | 'viewed';
  created_at:Date;
}
