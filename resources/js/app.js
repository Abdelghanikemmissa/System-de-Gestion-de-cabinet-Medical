import './bootstrap';

window.apiFetch = async (url, options = {}) => {
    const token = localStorage.getItem('user_token');
    
    const defaultHeaders = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': token ? `Bearer ${token}` : ''
    };

    const response = await fetch(url, {
        ...options,
        headers: { ...defaultHeaders, ...options.headers }
    });

    // Si le token est expiré ou invalide (401)
    if (response.status === 401) {
        localStorage.clear();
        window.location.href = '/login';
    }

    return response;
};
async function logout() {
    const token = localStorage.getItem('user_token');

    try {
        // 1. Appel au Backend pour invalider le token (Route: POST /api/logout)
        await fetch('/api/logout', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });
    } catch (error) {
        console.error("Erreur lors de la déconnexion côté serveur", error);
    } finally {
        // 2. Nettoyage du Frontend quoi qu'il arrive
        localStorage.clear();
        
        // 3. Redirection vers la page de login
        window.location.href = '/login';
    }
}