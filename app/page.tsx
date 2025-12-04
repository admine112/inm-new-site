import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import Link from "next/link"
import Image from "next/image"
import { getProducts } from "@/lib/fetchProducts"
import { ConsultationButton } from "@/components/ConsultationButton"

export default async function Home() {
    const products = await getProducts();
    // Фильтруем только нужные товары: Инмунофлам, Проставит, Кровь Дракона
    const featuredProducts = products.filter(p =>
        p.name === "Инмунофлам®" || p.name === "Проставит" || p.name === "Кровь Дракона"
    );

    return (
        <div className="min-h-screen bg-white">
            <Header />

            {/* Hero Section */}
            <section className="max-w-7xl mx-auto px-6 py-20">
                <div className="flex items-center gap-16">
                    <div className="flex-1">
                        <h1 className="text-6xl font-bold text-gray-900 mb-6 leading-tight">
                            Иммунитет под <span className="text-emerald-600">защитой</span>
                        </h1>
                        <p className="text-xl text-gray-600 mb-8 leading-relaxed">
                            Натуральные препараты с доказанной эффективностью. Укрепляйте свой иммунитет вместе с Иммунофлам и живите
                            полной жизнью.
                        </p>
                        <div className="flex gap-4">
                            <Link
                                href="/shop"
                                className="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors cursor-pointer"
                            >
                                Перейти в магазин
                            </Link>
                            <Link
                                href="/about"
                                className="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 px-6 py-3 rounded-lg font-medium transition-colors cursor-pointer border border-emerald-200"
                            >
                                Узнать больше
                            </Link>
                        </div>
                    </div>
                    <div className="flex-1">
                        <div className="bg-emerald-50 rounded-2xl p-12 shadow-lg hover:shadow-xl transition-shadow">
                            <Image
                                src="/product-main.png"
                                alt="Иммунная система"
                                width={500}
                                height={500}
                                className="w-full"
                            />
                        </div>
                    </div>
                </div>
            </section>

            {/* Benefits Section */}
            <section className="bg-emerald-50 py-20">
                <div className="max-w-7xl mx-auto px-6">
                    <h2 className="text-4xl font-bold text-center text-gray-900 mb-16">Почему выбирают Иммунофлам</h2>

                    <div className="grid grid-cols-3 gap-8">
                        {[
                            {
                                title: "Натуральные компоненты",
                                description: "Только проверенные растительные ингредиенты, без синтетики и вредных добавок",
                            },
                            {
                                title: "Клинически доказано",
                                description: "Каждый продукт прошёл независимые исследования и имеет все необходимые сертификаты",
                            },
                            {
                                title: "Высокая биодоступность",
                                description: "Специальная формула для максимального усвоения организмом полезных веществ",
                            },
                            {
                                title: "Безопасность",
                                description: "Никаких побочных эффектов. Подходит для взрослых и детей от 12 лет",
                            },
                            {
                                title: "Результаты видны быстро",
                                description: "Первые улучшения уже через 2-3 недели регулярного приёма",
                            },
                            {
                                title: "Доступная цена",
                                description: "Премиум качество по справедливой цене, доступному каждому",
                            },
                        ].map((benefit, idx) => (
                            <div
                                key={idx}
                                className="bg-white rounded-xl p-6 shadow-md border border-gray-100 hover:shadow-lg transition-shadow"
                            >
                                <h3 className="text-lg font-semibold text-emerald-700 mb-3">{benefit.title}</h3>
                                <p className="text-gray-600 text-sm leading-relaxed">{benefit.description}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Featured Products - FROM DIRECTUS */}
            <section className="max-w-7xl mx-auto px-6 py-20">
                <h2 className="text-4xl font-bold text-gray-900 mb-4">Популярные товары</h2>
                <p className="text-gray-600 mb-12 text-lg">Начните с лучших продаж, которые полюбили наши клиенты</p>

                <div className="grid grid-cols-3 gap-8 mb-12">
                    {featuredProducts.map((product) => (
                        <div
                            key={product.id}
                            className="bg-white rounded-xl p-6 border border-emerald-100 hover:border-emerald-300 hover:shadow-xl transition-all duration-300 flex flex-col"
                        >
                            {/* Fixed Image Frame */}
                            <div className="bg-gradient-to-br from-emerald-50 to-white rounded-lg mb-6 flex items-center justify-center" style={{ width: '100%', height: '320px' }}>
                                <div className="relative" style={{ width: '280px', height: '280px' }}>
                                    <Image
                                        src={product.image || "/placeholder.svg"}
                                        alt={product.name}
                                        fill
                                        className="object-contain"
                                    />
                                </div>
                            </div>

                            {/* Product Info */}
                            <div className="flex flex-col flex-1">
                                <p className="text-sm text-emerald-600 font-medium mb-2">
                                    {product.category === "supplements" && "Комплексные добавки"}
                                    {product.category === "vitamins" && "Витамины"}
                                    {product.category === "probiotics" && "Пробиотики"}
                                    {product.category === "herbal" && "Травяные чаи"}
                                    {product.category === "minerals" && "Минералы"}
                                </p>

                                <h3 className="text-xl font-semibold text-gray-900 mb-3 leading-tight">{product.name}</h3>

                                <p className="text-gray-600 text-sm leading-relaxed mb-6 flex-1">{product.description}</p>

                                {/* Price and Action */}
                                <div className="flex items-center justify-between">
                                    <span className="text-3xl font-bold text-emerald-600">{product.price} грн</span>
                                    <button className="bg-emerald-600 hover:bg-emerald-700 text-white p-3 rounded-lg transition-colors">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                                            <circle cx="9" cy="21" r="1" />
                                            <circle cx="20" cy="21" r="1" />
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                <div className="text-center">
                    <Link
                        href="/shop"
                        className="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors cursor-pointer inline-block"
                    >
                        Смотреть все товары
                    </Link>
                </div>
            </section>

            {/* CTA Section */}
            <section className="bg-gradient-to-r from-emerald-600 to-emerald-700 py-16">
                <div className="max-w-4xl mx-auto px-6 text-center">
                    <h2 className="text-4xl font-bold text-white mb-4">Начните заботиться о здоровье сегодня</h2>
                    <p className="text-emerald-100 text-lg mb-8">Получите бесплатную консультацию от наших специалистов</p>
                    <ConsultationButton className="bg-white text-emerald-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-50 transition-colors cursor-pointer">
                        Заказать консультацию
                    </ConsultationButton>
                </div>
            </section>

            <Footer />
        </div>
    )
}
