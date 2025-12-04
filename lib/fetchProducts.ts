import { directus } from './directus';
import { readItems } from '@directus/sdk';
import { products as staticProducts, Product } from './products';

export async function getProducts(): Promise<Product[]> {
    try {
        // Attempt to fetch from Directus
        // We assume the collection is named 'products' and fields match our interface
        // Adjust 'products' to your actual collection name if different
        const result = await directus.request(readItems('products', {
            fields: ['id', 'name', 'description', 'price', 'image', 'category']
        }));

        if (result && Array.isArray(result) && result.length > 0) {
            // Map Directus result to our Product interface if necessary
            // For now assuming direct mapping works or fields are compatible
            return result.map((item: any) => ({
                id: item.id,
                name: item.name,
                description: item.description,
                price: item.price,
                image: item.image ? `${process.env.NEXT_PUBLIC_DIRECTUS_URL}/assets/${item.image}` : '/placeholder.svg', // Handle image URL
                category: item.category
            })) as Product[];
        }
    } catch (error) {
        console.warn('Failed to fetch products from Directus, falling back to static data:', error);
    }

    // Fallback to static data
    return staticProducts;
}
