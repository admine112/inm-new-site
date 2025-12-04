import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import Link from "next/link"

export default function Article2() {
    return (
        <div className="min-h-screen bg-white">
            <Header />

            <article className="max-w-4xl mx-auto px-6 py-16">
                <Link href="/articles" className="text-emerald-600 hover:text-emerald-700 mb-6 inline-block">
                    ← Назад к статьям
                </Link>

                <h1 className="text-4xl font-bold text-gray-900 mb-6">
                    Главные защитники организма - "Т"-лимфоциты и "В" лимфоциты. Что вы знаете о них?
                </h1>

                <div className="prose prose-lg max-w-none">
                    <p>
                        О "Т"-клетках говорит и Григорий Ефимов, заведующий лабораторией трансплантационной иммунологии Национального медицинского исследовательского центра (НМИЦ) гематологии Минздрава:
                    </p>

                    <blockquote className="border-l-4 border-emerald-600 pl-4 italic my-6">
                        "У части выздоровевших иммунный ответ обеспечивается только за счет Т-клеток, чего, по всей видимости, оказывается достаточно"
                    </blockquote>

                    <p className="text-xl font-semibold text-emerald-700 my-6">
                        Вы, главное, поймите вот что: Чем сильнее Т-клеточный иммунитет, тем выше шанс оставаться здоровыми.
                    </p>

                    <div className="bg-emerald-50 p-6 rounded-lg my-8">
                        <h2 className="text-2xl font-bold text-gray-900 mb-4">Что такое Т-лимфоциты?</h2>
                        <p>
                            Т-лимфоциты - это главные клетки клеточного иммунитета. Они распознают и уничтожают зараженные вирусами клетки, а также координируют работу всей иммунной системы.
                        </p>
                    </div>

                    <div className="bg-gray-50 p-6 rounded-lg my-8">
                        <h2 className="text-2xl font-bold text-gray-900 mb-4">Что такое В-лимфоциты?</h2>
                        <p>
                            В-лимфоциты отвечают за выработку антител - специальных белков, которые нейтрализуют вирусы и бактерии в крови и других жидкостях организма.
                        </p>
                    </div>

                    <p className="mt-8">
                        Для эффективной защиты организма необходима слаженная работа обоих типов лимфоцитов. Препарат <strong>Инмунофлам®</strong> помогает поддерживать оптимальный баланс и активность иммунных клеток.
                    </p>
                </div>
            </article>

            <Footer />
        </div>
    )
}
