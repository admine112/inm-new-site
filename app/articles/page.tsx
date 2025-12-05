import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import Image from "next/image"
import Link from "next/link"

const articles = [
  {
    id: 1,
    title: "Хотите жить дольше? Укрепляйте Т-клеточный иммунитет!",
    excerpt:
      "Научные исследования доказали, что от численности иммунных клеток Т-лимфоцитов зависит, как наш организм справится с вирусом.",
    date: "15 ноября 2024",
    readTime: "5 мин",
    category: "Иммунитет",
    slug: "t-cell-immunity",
    image: "/article-sick-new.png",
  },
  {
    id: 2,
    title: "Главные защитники организма - Т-лимфоциты и В-лимфоциты",
    excerpt:
      "Т-лимфоциты и В-лимфоциты – главные защитники нашего организма. Что вы знаете о них?",
    date: "10 ноября 2024",
    readTime: "4 мин",
    category: "Наука",
    slug: "t-b-lymphocytes",
    image: "/article-science-new.png",
  },
  {
    id: 3,
    title: "Инмунофлам - надежный щит иммунной системы",
    excerpt:
      "Инмунофлам – это натуральный препарат, который помогает укрепить иммунитет и защитить организм от вирусов.",
    date: "5 ноября 2024",
    readTime: "3 мин",
    category: "Препараты",
    slug: "inmunoflam-shield",
    image: "/article-shield-new.png",
  },
]

export default function Articles() {
  return (
    <div className="min-h-screen bg-white">
      <Header />

      {/* Page Header */}
      <section className="bg-emerald-50 border-b border-emerald-100 py-12">
        <div className="max-w-7xl mx-auto px-6">
          <h1 className="text-4xl font-bold text-gray-900 mb-3">Статьи и Советы</h1>
          <p className="text-gray-600 text-lg">
            Полезная информация о здоровье, иммунитете и натуральной поддержке организма
          </p>
        </div>
      </section>

      {/* Featured Article */}
      <section className="max-w-7xl mx-auto px-6 py-16">
        <Link href="/articles/t-cell-immunity">
          <div className="card p-0 overflow-hidden h-auto md:h-80 cursor-pointer hover:shadow-xl transition-all">
            <div className="flex flex-col md:flex-row h-full">
              <div className="flex-1 bg-emerald-50 h-64 md:h-auto">
                <Image
                  src="/article-sick-new.png"
                  alt="Featured article"
                  width={500}
                  height={500}
                  className="w-full h-full object-cover"
                />
              </div>
              <div className="flex-1 p-8 md:p-12 flex flex-col justify-center">
                <p className="text-emerald-600 font-semibold mb-2">РЕКОМЕНДУЕМ</p>
                <h2 className="text-3xl font-bold text-gray-900 mb-4">Хотите жить дольше? Укрепляйте Т-клеточный иммунитет!</h2>
                <p className="text-gray-600 leading-relaxed mb-6">
                  Научные исследования доказали, что от численности иммунных клеток Т-лимфоцитов зависит, как наш организм справится с вирусом. Узнайте, как укрепить клеточный иммунитет.
                </p>
                <div className="flex items-center gap-4 text-sm text-gray-500">
                  <span>Актуальная статья</span>
                  <span>5 мин чтения</span>
                </div>
              </div>
            </div>
          </div>
        </Link>
      </section>

      {/* Articles Grid */}
      <section className="max-w-7xl mx-auto px-6 py-12">
        <h2 className="text-3xl font-bold text-gray-900 mb-8">Последние публикации</h2>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
          {articles.map((article) => (
            <Link key={article.id} href={`/articles/${article.slug}`}>
              <div className="card cursor-pointer hover:shadow-lg transition-all">
                {/* Article Image */}
                <div className="bg-emerald-50 rounded-lg overflow-hidden mb-6 h-48">
                  <Image
                    src={article.image}
                    alt={article.title}
                    width={400}
                    height={300}
                    className="w-full h-full object-cover"
                  />
                </div>

                {/* Article Content */}
                <div className="flex flex-col h-full">
                  <div className="mb-4">
                    <span className="inline-block bg-emerald-100 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full mb-3">
                      {article.category}
                    </span>
                    <h3 className="text-xl font-semibold text-gray-900 mb-3 leading-tight hover:text-emerald-600 transition-colors">
                      {article.title}
                    </h3>
                    <p className="text-gray-600 text-sm leading-relaxed mb-4">{article.excerpt}</p>
                  </div>

                  {/* Meta */}
                  <div className="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                    <span>{article.date}</span>
                    <span>{article.readTime}</span>
                  </div>
                </div>
              </div>
            </Link>
          ))}
        </div>
      </section>

      {/* Newsletter */}
      <section className="bg-emerald-50 border-t border-emerald-100 py-16">
        <div className="max-w-2xl mx-auto px-6 text-center">
          <h2 className="text-3xl font-bold text-gray-900 mb-3">Не пропустите новые статьи</h2>
          <p className="text-gray-600 mb-8">
            Подпишитесь на нашу рассылку и получайте полезные советы о здоровье прямо на почту
          </p>
          <div className="flex gap-3">
            <input
              type="email"
              placeholder="Ваш email"
              className="flex-1 px-6 py-3 rounded-lg border border-emerald-200 bg-white text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            />
            <button className="btn-primary">Подписаться</button>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  )
}
