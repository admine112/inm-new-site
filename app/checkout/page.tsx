"use client"

import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import Link from "next/link"
import Image from "next/image"
import { useCart } from "@/lib/cart-context"
import { useState } from "react"

export default function Checkout() {
    const { items, removeItem, updateQuantity, totalPrice, clearCart } = useCart()
    const [formData, setFormData] = useState({
        name: "",
        phone: "",
        email: "",
        delivery: "novaposhta",
        city: "",
        address: "",
        comment: "",
    })
    const [submitted, setSubmitted] = useState(false)

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault()
        // TODO: Отправить заказ на сервер
        console.log("Order submitted:", { ...formData, items, totalPrice })
        setSubmitted(true)
        clearCart()
    }

    if (submitted) {
        return (
            <div className="min-h-screen bg-white">
                <Header />
                <div className="max-w-2xl mx-auto px-6 py-32 text-center">
                    <div className="mb-6 flex justify-center text-emerald-600">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </div>
                    <h1 className="text-4xl font-bold text-gray-900 mb-4">Спасибо за заказ!</h1>
                    <p className="text-lg text-gray-600 mb-8">
                        Мы получили ваш заказ и свяжемся с вами в ближайшее время для подтверждения.
                    </p>
                    <Link href="/shop" className="inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                        Продолжить покупки
                    </Link>
                </div>
                <Footer />
            </div>
        )
    }

    return (
        <div className="min-h-screen bg-white">
            <Header />

            <div className="max-w-7xl mx-auto px-6 py-16">
                <h1 className="text-4xl font-bold text-gray-900 mb-8">Оформление заказа</h1>

                {items.length === 0 ? (
                    <div className="text-center py-16">
                        <p className="text-xl text-gray-600 mb-6">Ваша корзина пуста</p>
                        <Link href="/shop" className="inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                            Перейти в магазин
                        </Link>
                    </div>
                ) : (
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {/* Order Form */}
                        <div className="lg:col-span-2">
                            <div className="bg-white border border-gray-200 rounded-lg p-6">
                                <h2 className="text-2xl font-semibold text-gray-900 mb-6">Контактная информация</h2>

                                <form onSubmit={handleSubmit} className="space-y-6">
                                    {/* Name */}
                                    <div>
                                        <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                                            Имя и Фамилия *
                                        </label>
                                        <input
                                            type="text"
                                            id="name"
                                            required
                                            value={formData.name}
                                            onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            placeholder="Иван Иванов"
                                        />
                                    </div>

                                    {/* Phone */}
                                    <div>
                                        <label htmlFor="phone" className="block text-sm font-medium text-gray-700 mb-2">
                                            Телефон *
                                        </label>
                                        <input
                                            type="tel"
                                            id="phone"
                                            required
                                            value={formData.phone}
                                            onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            placeholder="+380 (XX) XXX-XX-XX"
                                        />
                                    </div>

                                    {/* Email */}
                                    <div>
                                        <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                                            Email
                                        </label>
                                        <input
                                            type="email"
                                            id="email"
                                            value={formData.email}
                                            onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            placeholder="ivan@example.com"
                                        />
                                    </div>

                                    <h2 className="text-2xl font-semibold text-gray-900 mt-8 mb-6">Доставка</h2>

                                    {/* Delivery Method */}
                                    <div>
                                        <label className="block text-sm font-medium text-gray-700 mb-3">
                                            Способ доставки *
                                        </label>
                                        <div className="space-y-3">
                                            <label className="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                                <input
                                                    type="radio"
                                                    name="delivery"
                                                    value="novaposhta"
                                                    checked={formData.delivery === "novaposhta"}
                                                    onChange={(e) => setFormData({ ...formData, delivery: e.target.value })}
                                                    className="mr-3"
                                                />
                                                <div>
                                                    <div className="font-medium">Новая Почта</div>
                                                    <div className="text-sm text-gray-500">Доставка в отделение</div>
                                                </div>
                                            </label>
                                            <label className="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                                <input
                                                    type="radio"
                                                    name="delivery"
                                                    value="ukrposhta"
                                                    checked={formData.delivery === "ukrposhta"}
                                                    onChange={(e) => setFormData({ ...formData, delivery: e.target.value })}
                                                    className="mr-3"
                                                />
                                                <div>
                                                    <div className="font-medium">Укрпочта</div>
                                                    <div className="text-sm text-gray-500">Доставка в отделение</div>
                                                </div>
                                            </label>
                                            <label className="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                                <input
                                                    type="radio"
                                                    name="delivery"
                                                    value="courier"
                                                    checked={formData.delivery === "courier"}
                                                    onChange={(e) => setFormData({ ...formData, delivery: e.target.value })}
                                                    className="mr-3"
                                                />
                                                <div>
                                                    <div className="font-medium">Курьерская доставка</div>
                                                    <div className="text-sm text-gray-500">По адресу</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    {/* City */}
                                    <div>
                                        <label htmlFor="city" className="block text-sm font-medium text-gray-700 mb-2">
                                            Город *
                                        </label>
                                        <input
                                            type="text"
                                            id="city"
                                            required
                                            value={formData.city}
                                            onChange={(e) => setFormData({ ...formData, city: e.target.value })}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            placeholder="Киев"
                                        />
                                    </div>

                                    {/* Address/Department */}
                                    <div>
                                        <label htmlFor="address" className="block text-sm font-medium text-gray-700 mb-2">
                                            Адрес или номер отделения *
                                        </label>
                                        <input
                                            type="text"
                                            id="address"
                                            required
                                            value={formData.address}
                                            onChange={(e) => setFormData({ ...formData, address: e.target.value })}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            placeholder="Отделение №1 или ул. Крещатик, 1"
                                        />
                                    </div>

                                    {/* Comment */}
                                    <div>
                                        <label htmlFor="comment" className="block text-sm font-medium text-gray-700 mb-2">
                                            Комментарий к заказу
                                        </label>
                                        <textarea
                                            id="comment"
                                            rows={4}
                                            value={formData.comment}
                                            onChange={(e) => setFormData({ ...formData, comment: e.target.value })}
                                            className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            placeholder="Дополнительная информация..."
                                        />
                                    </div>

                                    <button
                                        type="submit"
                                        className="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-lg font-semibold transition-colors lg:hidden"
                                    >
                                        Оформить заказ
                                    </button>
                                </form>
                            </div>
                        </div>

                        {/* Order Summary */}
                        <div className="lg:col-span-1">
                            <div className="bg-gray-50 border border-gray-200 rounded-lg p-6 sticky top-6">
                                <h2 className="text-xl font-semibold text-gray-900 mb-4">Ваш заказ</h2>

                                <div className="space-y-4 mb-6">
                                    {items.map((item) => (
                                        <div key={item.id} className="flex gap-4">
                                            <div className="w-16 h-16 bg-emerald-50 rounded flex-shrink-0">
                                                <Image
                                                    src={item.image}
                                                    alt={item.name}
                                                    width={64}
                                                    height={64}
                                                    className="w-full h-full object-contain"
                                                />
                                            </div>
                                            <div className="flex-1">
                                                <h3 className="font-medium text-sm">{item.name}</h3>
                                                <div className="flex items-center gap-2 mt-1">
                                                    <button
                                                        onClick={() => updateQuantity(item.id, item.quantity - 1)}
                                                        className="w-6 h-6 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100"
                                                    >
                                                        -
                                                    </button>
                                                    <span className="text-sm">{item.quantity}</span>
                                                    <button
                                                        onClick={() => updateQuantity(item.id, item.quantity + 1)}
                                                        className="w-6 h-6 flex items-center justify-center border border-gray-300 rounded hover:bg-gray-100"
                                                    >
                                                        +
                                                    </button>
                                                    <button
                                                        onClick={() => removeItem(item.id)}
                                                        className="ml-auto text-red-600 hover:text-red-700 text-sm"
                                                    >
                                                        Удалить
                                                    </button>
                                                </div>
                                                <p className="text-sm text-emerald-600 font-semibold mt-1">
                                                    {item.price * item.quantity} грн
                                                </p>
                                            </div>
                                        </div>
                                    ))}
                                </div>

                                <div className="border-t border-gray-300 pt-4 mb-6">
                                    <div className="flex justify-between text-lg font-semibold">
                                        <span>Итого:</span>
                                        <span className="text-emerald-600">{totalPrice} грн</span>
                                    </div>
                                </div>

                                <button
                                    onClick={handleSubmit}
                                    type="button"
                                    className="hidden lg:block w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-lg font-semibold transition-colors"
                                >
                                    Оформить заказ
                                </button>

                                <Link href="/shop" className="block text-center text-emerald-600 hover:text-emerald-700 mt-4">
                                    ← Продолжить покупки
                                </Link>
                            </div>
                        </div>
                    </div>
                )}
            </div>

            <Footer />
        </div>
    )
}
