"use client"

import Link from "next/link"
import Image from "next/image"

export function Header() {
  return (
    <header className="bg-white border-b border-gray-100 shadow-md">
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
        </nav>
      </div>
    </header>
  )
}
