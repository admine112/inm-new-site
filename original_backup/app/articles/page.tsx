import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import Image from "next/image"

const articles = [
  {
    id: 1,
    title: "Как правильно укреплять иммунитет осенью",
    excerpt:
      "С приходом осени организм нуждается в особой защите. Узнайте, какие витамины и микроэлементы помогут вам избежать сезонных простуд.",
    date: "15 ноября 2024",
    readTime: "5 мин чтения",
    category: "Здоровье",
  },
  {
    id: 2,
    title: "Куркума: золотой стандарт иммунной поддержки",
    excerpt:
      "Древняя специя с доказанной научной базой. Разберёмся, почему куркума так эффективна против воспалительных процессов.",
    date: "12 ноября 2024",
    readTime: "7 мин чтения",
    category: "Компоненты",
  },
  {
    id: 3,
    title: "Пробиотики: живые помощники вашего кишечника",
    excerpt: "Кишечник — второй мозг организма. Узнайте, как полезные бактерии влияют на иммунитет и общее здоровье.",
    date: "8 ноября 2024",
    readTime: "6 мин чтения",
    category: "Наука",
  },
  {
    id: 4,
    title: "Витамин D: солнце в таблетке",
    excerpt: "Почему витамин D называют витамином иммунитета? Как определить дефицит и правильно его восполнить?",
    date: "1 ноября 2024",
    readTime: "8 мин чтения",
    category: "Витамины",
  },
  {
    id: 5,
    title: "Антиоксиданты против свободных радикалов",
    excerpt:
      "Свободные радикалы ускоряют старение и ослабляют иммунитет. Как естественными способами защитить свои клетки?",
    date: "25 октября 2024",
    readTime: "9 мин чтения",
    category: "Здоровье",
  },
  {
    id: 6,
    title: "Имбирь: острый защитник организма",
    excerpt:
      "От согревающего напитка до мощного средства иммунной поддержки. История и применение имбиря в современной медицине.",
    date: "18 октября 2024",
    readTime: "6 мин чтения",
    category: "Компоненты",
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
        <div className="card p-0 overflow-hidden h-80">
          <div className="flex h-full">
            <div className="flex-1 bg-emerald-50">
              <Image
                src="/placeholder.svg?height=500&width=500"
                alt="Featured article"
                width={500}
                height={500}
                className="w-full h-full object-cover"
              />
            </div>
            <div className="flex-1 p-12 flex flex-col justify-center">
              <p className="text-emerald-600 font-semibold mb-2">РЕКОМЕНДУЕМ</p>
              <h2 className="text-3xl font-bold text-gray-900 mb-4">Как правильно укреплять иммунитет осенью</h2>
              <p className="text-gray-600 leading-relaxed mb-6">
                С приходом осени организм нуждается в особой защите. Узнайте, какие витамины и микроэлементы помогут вам
                избежать сезонных простуд.
              </p>
              <div className="flex items-center gap-4 text-sm text-gray-500">
                <span>15 ноября 2024</span>
                <span>5 мин чтения</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Articles Grid */}
      <section className="max-w-7xl mx-auto px-6 py-12">
        <h2 className="text-3xl font-bold text-gray-900 mb-8">Последние публикации</h2>

        <div className="grid grid-cols-2 gap-8">
          {articles.map((article) => (
            <div key={article.id} className="card cursor-pointer hover:shadow-lg transition-all">
              {/* Article Image */}
              <div className="bg-emerald-50 rounded-lg overflow-hidden mb-6 h-48">
                <Image
                  src="/placeholder.svg?height=300&width=400"
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
