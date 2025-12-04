import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import Link from "next/link"
import Image from "next/image"

export default function Home() {
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
                src="/placeholder.svg?height=500&width=500"
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

      {/* Featured Products */}
      <section className="max-w-7xl mx-auto px-6 py-20">
        <h2 className="text-4xl font-bold text-gray-900 mb-4">Популярные товары</h2>
        <p className="text-gray-600 mb-12">Начните с лучших продаж, которые полюбили наши клиенты</p>

        <div className="grid grid-cols-3 gap-8 mb-12">
          {[
            {
              name: "Иммунофлам Форте",
              price: "890 ₽",
              image: "/placeholder.svg?height=300&width=300",
            },
            {
              name: "Антиоксидант Плюс",
              price: "1 290 ₽",
              image: "/placeholder.svg?height=300&width=300",
            },
            {
              name: "Probio Balance",
              price: "1 550 ₽",
              image: "/placeholder.svg?height=300&width=300",
            },
          ].map((product, idx) => (
            <div
              key={idx}
              className="bg-white rounded-xl p-6 shadow-md border border-gray-100 hover:shadow-lg transition-shadow"
            >
              <div className="bg-emerald-50 rounded-lg p-6 mb-4 h-64">
                <Image
                  src={product.image || "/placeholder.svg"}
                  alt={product.name}
                  width={300}
                  height={300}
                  className="w-full h-full object-cover rounded"
                />
              </div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">{product.name}</h3>
              <p className="text-emerald-600 font-bold text-xl mb-4">{product.price}</p>
              <button className="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors cursor-pointer w-full">
                В корзину
              </button>
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
          <button className="bg-white text-emerald-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-50 transition-colors cursor-pointer">
            Заказать консультацию
          </button>
        </div>
      </section>

      <Footer />
    </div>
  )
}
