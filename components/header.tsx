"use client"

import Link from "next/link"
import Image from "next/image"
import { useCart } from "@/lib/cart-context"
import { useState, useEffect } from "react"

export function Header() {
  const { totalItems, onItemAdded } = useCart()
  const [showArrow, setShowArrow] = useState(false)

  useEffect(() => {
    const unsubscribe = onItemAdded(() => {
      setShowArrow(true)
      setTimeout(() => setShowArrow(false), 1500)
    })
    return unsubscribe
  }, [onItemAdded])

  return (
    <header className="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-md">
      <div className="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        {/* Logo */}
        <Link href="/" className="flex items-center">
          <Image src="/logo.png" alt="Иммунофлам" width={150} height={75} className="object-contain" />
        </Link>

        {/* Navigation */}
        <nav className="flex items-center gap-8">
          <Link href="/" className="text-gray-700 hover:text-emerald-600 font-medium transition-colors">
            Главная
          </Link>
          <Link href="/shop" className="text-gray-700 hover:text-emerald-600 font-medium transition-colors">
            Магазин
          </Link>
          <Link href="/articles" className="text-gray-700 hover:text-emerald-600 font-medium transition-colors">
            Статьи
          </Link>
          <Link href="/about" className="text-gray-700 hover:text-emerald-600 font-medium transition-colors">
            О нас
          </Link>

          {/* Cart Icon */}
          <Link href="/checkout" className="relative text-gray-700 hover:text-emerald-600 transition-colors">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
              <circle cx="9" cy="21" r="1" />
              <circle cx="20" cy="21" r="1" />
              <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
            </svg>
            {totalItems > 0 && (
              <span className="absolute -top-2 -right-2 bg-emerald-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                {totalItems}
              </span>
            )}

            {/* Анимированная стрелка под корзиной */}
            {showArrow && (
              <div className="absolute top-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FCD34D" strokeWidth="3">
                  <path d="M12 5v14M19 12l-7 7-7-7" />
                </svg>
              </div>
            )}
          </Link>
        </nav>
      </div>
    </header>
  )
}
