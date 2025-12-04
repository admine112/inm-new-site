const fs = require('fs');
const path = require('path');

const DIRECTUS_URL = 'http://localhost:8055';
const ADMIN_EMAIL = 'admin@example.com';
const ADMIN_PASSWORD = 'password';

async function request(endpoint, method = 'GET', body = null, token = null) {
    const headers = {
        'Content-Type': 'application/json'
    };
    if (token) headers['Authorization'] = `Bearer ${token}`;

    const options = {
        method,
        headers,
    };
    if (body) options.body = JSON.stringify(body);

    const response = await fetch(`${DIRECTUS_URL}${endpoint}`, options);
    const data = await response.json();

    if (!response.ok) {
        // Ignore specific errors (like "collection already exists")
        if (data.errors?.[0]?.extensions?.code === 'RECORD_NOT_UNIQUE' ||
            data.errors?.[0]?.extensions?.code === 'INVALID_PAYLOAD') { // Field exists
            return data;
        }
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

        // 1. Create Collection
        console.log('Creating "products" collection...');
        try {
            await request('/collections', 'POST', {
                collection: 'products',
                schema: {},
                meta: {
                    hidden: false,
                    icon: 'box',
                    display_template: '{{name}}'
                }
            }, token);
            console.log('Collection created.');
        } catch (e) {
            console.log('Collection might already exist:', e.message);
        }

        // 2. Create Fields
        const fields = [
            { field: 'name', type: 'string', meta: { interface: 'input', required: true, width: 'half' } },
            { field: 'slug', type: 'string', meta: { interface: 'input', required: true, width: 'half' } },
            { field: 'price', type: 'integer', meta: { interface: 'input', required: true, width: 'half' } },
            {
                field: 'category', type: 'string', meta: {
                    interface: 'select-dropdown', options: {
                        choices: [
                            { text: 'Комплексные добавки', value: 'supplements' },
                            { text: 'Витамины', value: 'vitamins' },
                            { text: 'Пробиотики', value: 'probiotics' },
                            { text: 'Травяные чаи', value: 'herbal' },
                            { text: 'Минералы', value: 'minerals' }
                        ]
                    }, width: 'half'
                }
            },
            { field: 'in_stock', type: 'boolean', meta: { interface: 'boolean', width: 'half', special: ['cast-boolean'] } },
            { field: 'description', type: 'text', meta: { interface: 'input-rich-text-html', width: 'full' } },
            // Image field creation via API is complex, usually just creating the field is enough, Directus handles relation
            { field: 'image', type: 'uuid', meta: { interface: 'file-image', special: ['file'], width: 'full' }, schema: { foreign_key_table: 'directus_files' } }
        ];

        for (const field of fields) {
            try {
                await request('/fields/products', 'POST', field, token);
                console.log(`Field "${field.field}" created.`);
            } catch (e) {
                // Ignore
            }
        }

        // 3. Import Data
        const dataPath = path.join(__dirname, '../data/products.json');
        if (fs.existsSync(dataPath)) {
            const products = JSON.parse(fs.readFileSync(dataPath, 'utf8'));

            for (const product of products) {
                console.log(`Importing "${product.name}"...`);
                try {
                    await request('/items/products', 'POST', {
                        name: product.name,
                        slug: product.slug || product.name.toLowerCase().replace(/ /g, '-'),
                        price: product.price,
                        description: product.description,
                        category: product.category,
                        in_stock: product.inStock
                    }, token);
                    console.log('Imported.');
                } catch (e) {
                    console.log('Error importing item:', e.message);
                }
            }
        }

        // 4. Create Homepage Collection (Singleton-like)
        console.log('Creating "homepage" collection...');
        try {
            await request('/collections', 'POST', {
                collection: 'homepage',
                schema: {},
                meta: {
                    hidden: false,
                    icon: 'home',
                    display_template: '{{hero_title}}',
                    singleton: true // Directus 10+ supports this flag in meta
                }
            }, token);
            console.log('Homepage collection created.');
        } catch (e) {
            console.log('Homepage collection might already exist:', e.message);
        }

        // 5. Create Homepage Fields
        const homepageFields = [
            { field: 'hero_title', type: 'string', meta: { interface: 'input', required: true, width: 'full' } },
            { field: 'hero_subtitle', type: 'text', meta: { interface: 'input-multiline', required: true, width: 'full' } },
            { field: 'hero_image', type: 'uuid', meta: { interface: 'file-image', special: ['file'], width: 'full' }, schema: { foreign_key_table: 'directus_files' } },
            { field: 'benefits', type: 'json', meta: { interface: 'list', width: 'full' } }, // Simple list for benefits
            { field: 'cta_title', type: 'string', meta: { interface: 'input', width: 'half' } },
            { field: 'cta_text', type: 'text', meta: { interface: 'input-multiline', width: 'half' } }
        ];

        for (const field of homepageFields) {
            try {
                await request('/fields/homepage', 'POST', field, token);
                console.log(`Field "${field.field}" created.`);
            } catch (e) {
                // Ignore
            }
        }

        // 6. Populate Homepage Data
        console.log('Populating Homepage data...');
        try {
            // Check if exists
            const existing = await request('/items/homepage', 'GET', null, token);
            if (!existing.data) {
                await request('/items/homepage', 'POST', {
                    hero_title: 'Иммунитет под защитой',
                    hero_subtitle: 'Натуральные препараты с доказанной эффективностью. Укрепляйте свой иммунитет вместе с Иммунофлам и живите полной жизнью.',
                    // hero_image: ... (skip for now, user can upload)
                    cta_title: 'Начните заботиться о здоровье сегодня',
                    cta_text: 'Получите бесплатную консультацию от наших специалистов',
                    benefits: [
                        { title: "Натуральные компоненты", description: "Только проверенные растительные ингредиенты, без синтетики и вредных добавок" },
                        { title: "Клинически доказано", description: "Каждый продукт прошёл независимые исследования и имеет все необходимые сертификаты" },
                        { title: "Высокая биодоступность", description: "Специальная формула для максимального усвоения организмом полезных веществ" },
                        { title: "Безопасность", description: "Никаких побочных эффектов. Подходит для взрослых и детей от 12 лет" },
                        { title: "Результаты видны быстро", description: "Первые улучшения уже через 2-3 недели регулярного приёма" },
                        { title: "Доступная цена", description: "Премиум качество по справедливой цене, доступному каждому" }
                    ]
                }, token);
                console.log('Homepage data populated.');
            } else {
                console.log('Homepage data already exists.');
            }
        } catch (e) {
            console.log('Error populating homepage:', e.message);
        }

        console.log('Setup complete!');

    } catch (error) {
        console.error('Error:', error);
    }
}

setup();
