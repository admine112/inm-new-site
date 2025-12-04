"use client"

import { useCart } from "@/lib/cart-context"

interface AddToCartButtonProps {
    product: {
        id: string
        name: string
        price: number
        image: string
    }
}

export function AddToCartButton({ product }: AddToCartButtonProps) {
    const { addItem } = useCart()

    const handleAddToCart = () => {
        addItem(product)
    }

    return (
        <button
            onClick={handleAddToCart}
            className="bg-emerald-600 hover:bg-emerald-700 text-white p-3 rounded-lg transition-colors"
            title="Добавить в корзину"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <circle cx="9" cy="21" r="1" />
                <circle cx="20" cy="21" r="1" />
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
            </svg>
        </button>
    )
}
