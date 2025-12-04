"use client"

import { useCart } from "@/lib/cart-context"
import { useState } from "react"

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
    const [showArrow, setShowArrow] = useState(false)

    const handleAddToCart = () => {
        addItem(product)
        // Показываем стрелку на 1.5 секунды
        setShowArrow(true)
        setTimeout(() => setShowArrow(false), 1500)
    }

    return (
        <div className="relative">
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

            {/* Анимированная стрелка */}
            {showArrow && (
                <div className="absolute -top-16 left-1/2 transform -translate-x-1/2 animate-bounce" style={{ filter: 'drop-shadow(0 4px 6px rgba(0, 0, 0, 0.5))' }}>
                    <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="#d19e06" strokeWidth="2.5">
                        <path d="M12 5v14M19 12l-7 7-7-7" />
                    </svg>
                </div>
            )}
        </div>
    )
}
