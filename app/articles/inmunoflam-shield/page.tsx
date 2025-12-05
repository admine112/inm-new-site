import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import Link from "next/link"
import Image from "next/image"

export default function Article3() {
    return (
        <div className="min-h-screen bg-white">
            <Header />

            <article className="max-w-4xl mx-auto px-6 py-16">
                <Link href="/articles" className="text-emerald-600 hover:text-emerald-700 mb-6 inline-block">
                    ← Назад к статьям
                </Link>

                <h1 className="text-4xl font-bold text-gray-900 mb-6">
                    Инмунофлам - надежный щит иммунной системы
                </h1>

                <div className="mb-8 rounded-xl overflow-hidden">
                    <Image
                        src="/article-shield-new.png"
                        alt="Инмунофлам - щит иммунитета"
                        width={800}
                        height={400}
                        className="w-full h-auto object-cover"
                    />
                </div>

                <div className="prose prose-lg max-w-none">
                    <p className="text-xl text-gray-700 mb-6">
                        Помимо этого Инмунофлам способен стимулировать выработку белка интерферона, задерживающего проникновение вирусов и бактерий в глубь ДНК клеток.
                    </p>

                    <div className="bg-emerald-50 p-8 rounded-lg my-8">
                        <h2 className="text-2xl font-bold text-gray-900 mb-4">Достигаемый результат:</h2>
                        <ul className="space-y-3">
                            <li className="flex items-start">
                                <span className="text-emerald-600 mr-2">✓</span>
                                <span>Т-клеточный иммунитет быстро укрепляется</span>
                            </li>
                            <li className="flex items-start">
                                <span className="text-emerald-600 mr-2">✓</span>
                                <span>Иммунная система быстро восстанавливается</span>
                            </li>
                            <li className="flex items-start">
                                <span className="text-emerald-600 mr-2">✓</span>
                                <span>Уходят хронические укоренившиеся патологии</span>
                            </li>
                            <li className="flex items-start">
                                <span className="text-emerald-600 mr-2">✓</span>
                                <span>Излечиваются заболевания, от которых человек не мог избавиться в течение многих лет</span>
                            </li>
                        </ul>
                    </div>

                    <blockquote className="border-l-4 border-emerald-600 pl-6 py-4 my-8 bg-gray-50 rounded-r-lg">
                        <p className="text-lg italic mb-2">
                            "Ункария Томентоза Wild DC - растение мирового класса, которое обладает возможностью восстанавливать и поворачивать вспять развитие глубоко укоренившихся патологий, что ведет к быстрому возвращению здоровья"
                        </p>
                        <footer className="text-sm text-gray-600 mt-2">
                            — Доктор Бренд В. Девис
                        </footer>
                    </blockquote>

                    <div className="mt-8 p-6 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-lg">
                        <h3 className="text-xl font-bold text-gray-900 mb-3">Основной компонент Инмунофлама</h3>
                        <p>
                            <strong>Ункария Томентоза (Uncaria tomentosa)</strong> - уникальное растение из тропических лесов Перу, которое на протяжении веков использовалось коренными народами для укрепления иммунитета и борьбы с различными заболеваниями.
                        </p>
                    </div>

                    <div className="mt-8 text-center">
                        <Link
                            href="/shop"
                            className="inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-lg font-semibold transition-colors"
                        >
                            Перейти в магазин
                        </Link>
                    </div>
                </div>
            </article>

            <Footer />
        </div>
    )
}
