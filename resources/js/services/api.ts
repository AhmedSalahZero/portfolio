import axios, { type AxiosInstance } from 'axios';

const TOKEN_KEY = 'portfolio_admin_token';

export function getStoredToken(): string | null {
  return localStorage.getItem(TOKEN_KEY);
}

export function setStoredToken(token: string | null): void {
  if (token) {
    localStorage.setItem(TOKEN_KEY, token);
  } else {
    localStorage.removeItem(TOKEN_KEY);
  }
}

const api: AxiosInstance = axios.create({
  baseURL: '/api',
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
  },
});

api.interceptors.request.use((config) => {
  const token = getStoredToken();
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

let onUnauthorized: (() => void) | null = null;

export function setUnauthorizedHandler(handler: () => void): void {
  onUnauthorized = handler;
}

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401 && onUnauthorized) {
      onUnauthorized();
    }
    return Promise.reject(error);
  },
);

/**
 * Normalizes Laravel validation errors ({ field: [msg] }) into a flat map.
 */
export function extractValidationErrors(error: unknown): Record<string, string> {
  const result: Record<string, string> = {};
  if (axios.isAxiosError(error) && error.response?.status === 422) {
    const errors = (error.response.data?.errors ?? {}) as Record<string, string[]>;
    for (const [field, messages] of Object.entries(errors)) {
      result[field] = messages[0] ?? 'Invalid value';
    }
  }
  return result;
}

export function extractMessage(error: unknown, fallback = 'Something went wrong.'): string {
  if (axios.isAxiosError(error)) {
    return (error.response?.data?.message as string) ?? fallback;
  }
  return fallback;
}

export default api;
