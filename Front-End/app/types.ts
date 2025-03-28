export interface User {
    id: number;
    name: string;
    email: string;
    role: string;
    created_at: string;
    updated_at: string;
  }
  
  export interface LoginResponse {
    access_token: string;
    token_type: string;
    user: User;
  }
  