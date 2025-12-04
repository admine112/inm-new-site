"use client"

import Link from "next/link"
import Image from "next/image"

export function Header() {
  return (
    <header className="bg-white border-b border-gray-100 shadow-md">
      <div className="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        {/* Logo */}
        <Link href="/" className="flex items-center gap-3">
          <div className="relative w-10 h-10">
            <Image src="/images/logo.png" alt="Иммунофлам" width={40} height={40} className="object-contain" />
          </div>
          <span className="text-xl font-semibold text-emerald-700 hidden sm:inline">Иммунофлам</span>
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
