import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import { getProducts } from "@/lib/fetchProducts"
import { ConsultationButton } from "@/components/ConsultationButton"
import Image from "next/image"

export default async function Shop() {
  const products = await getProducts();
  return (
    <div className="min-h-screen bg-white">
      <Header />

      {/* Page Header */}
      <section className="bg-emerald-50 border-b border-emerald-100 py-12">
        <div className="max-w-7xl mx-auto px-6">
          <h1 className="text-4xl font-bold text-gray-900 mb-3">Магазин</h1>
          <p className="text-gray-600 text-lg">Полная линейка натуральных препаратов для иммунитета</p>
        </div>
      </section>

      {/* Filter Section */}
      <section className="max-w-7xl mx-auto px-6 py-8">
        <div className="flex items-center gap-4 pb-8 border-b border-gray-100">
          <button className="bg-emerald-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
            Все товары
          </button>
          <button className="bg-white text-gray-700 px-6 py-2 rounded-lg text-sm font-medium border border-gray-200 hover:bg-gray-50 transition-colors">
            Витамины
          </button>
          <button className="bg-white text-gray-700 px-6 py-2 rounded-lg text-sm font-medium border border-gray-200 hover:bg-gray-50 transition-colors">
            Добавки
          </button>
          <button className="bg-white text-gray-700 px-6 py-2 rounded-lg text-sm font-medium border border-gray-200 hover:bg-gray-50 transition-colors">
            Травяные чаи
          </button>
        </div>
      </section>

      {/* Products Grid */}
      <section className="max-w-7xl mx-auto px-6 py-16">
        <div className="grid grid-cols-3 gap-8">
          {products.map((product) => (
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
      </section>

      {/* Info Banner */}
      <section className="bg-emerald-50 border-t border-emerald-100 py-12">
        <div className="max-w-7xl mx-auto px-6 text-center">
          <h3 className="text-2xl font-semibold text-gray-900 mb-3">Вам помочь?</h3>
          <p className="text-gray-600 mb-6">
            Проконсультируйтесь с нашим специалистом, чтобы выбрать идеальный продукт для вас
          </p>
          <ConsultationButton className="btn-secondary">
            Получить консультацию
          </ConsultationButton>
        </div>
      </section>

      <Footer />
    </div>
  )
}
