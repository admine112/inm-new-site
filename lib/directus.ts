import { createDirectus, rest, authentication } from '@directus/sdk';

const DIRECTUS_URL = process.env.NEXT_PUBLIC_DIRECTUS_URL || 'http://localhost:8055';
const DIRECTUS_EMAIL = process.env.DIRECTUS_EMAIL || 'admin@example.com';
const DIRECTUS_PASSWORD = process.env.DIRECTUS_PASSWORD || 'password';

export const directus = createDirectus(DIRECTUS_URL)
    .with(authentication('json'))
    .with(rest());

// Helper function to get authenticated client
export async function getAuthenticatedClient() {
    await directus.login(DIRECTUS_EMAIL, DIRECTUS_PASSWORD);
    return directus;
}
