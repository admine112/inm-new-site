const DIRECTUS_URL = 'http://localhost:8055';
const ADMIN_EMAIL = 'admin@example.com';
const ADMIN_PASSWORD = 'password';

async function request(endpoint, method = 'GET', body = null, token = null) {
    const headers = { 'Content-Type': 'application/json' };
    if (token) headers['Authorization'] = `Bearer ${token}`;

    const options = { method, headers };
    if (body) options.body = JSON.stringify(body);

    const response = await fetch(`${DIRECTUS_URL}${endpoint}`, options);
    const data = await response.json();

    if (!response.ok) {
        throw new Error(JSON.stringify(data.errors || data));
    }
    return data;
}

async function setup() {
    try {
        console.log('Authenticating...');
        const auth = await request('/auth/login', 'POST', {
            email: ADMIN_EMAIL,
            password: ADMIN_PASSWORD
        });
        const token = auth.data.access_token;
        console.log('Authenticated!');

        // Get Public role ID
        console.log('Getting Public role...');
        const roles = await request('/roles?filter[name][_eq]=Public', 'GET', null, token);
        const publicRole = roles.data[0];

        if (!publicRole) {
            console.log('Public role not found!');
            return;
        }

        console.log(`Public role ID: ${publicRole.id}`);

        // Grant read access to homepage collection
        console.log('Granting read access to homepage...');
        try {
            await request('/permissions', 'POST', {
                role: publicRole.id,
                collection: 'homepage',
                action: 'read',
                permissions: {},
                fields
