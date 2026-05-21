const API_URL = import.meta.env.VITE_API_URL.replace(/\/$/, "");
export const STORAGE_URL = import.meta.env.VITE_STORAGE_URL.replace(/\/$/, "");

export async function apiFetch(endpoint, options = {}) {
    const token = localStorage.getItem("token");
    const isFormData = options.body instanceof FormData;

    const headers = {
        Accept: "application/json",
        ...(!isFormData && { "Content-Type": "application/json" }),
        ...(token && { Authorization: `Bearer ${token}` }),
        ...(options.headers || {}),
    };

    const response = await fetch(`${API_URL}${endpoint}`, {
        ...options,
        headers,
    });

    return response;
}

export function getImageUrl(imagen, placeholder = "https://via.placeholder.com/400x300") {
    if (!imagen) {
        return placeholder;
    }

    const imagenLimpia = String(imagen).replace(/^\/+/, "");

    if (imagenLimpia.startsWith("http")) {
        return imagenLimpia;
    }

    const APP_URL = STORAGE_URL.replace(/\/storage$/, "");

    if (imagenLimpia.startsWith("storage/")) {
        return `${APP_URL}/${imagenLimpia}`;
    }

    return `${STORAGE_URL}/${imagenLimpia}`;
}