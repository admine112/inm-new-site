import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import Link from "next/link"
import Image from "next/image"

export default function Article1() {
    return (
        <div className="min-h-screen bg-white">
            <Header />

            <article className="max-w-4xl mx-auto px-6 py-16">
                <Link href="/articles" className="text-emerald-600 hover:text-emerald-700 mb-6 inline-block">
                    ← Назад к статьям
                </Link>

                <h1 className="text-4xl font-bold text-gray-900 mb-6">
                    Хотите жить дольше? Укрепляйте Т-клеточный иммунитет!
                </h1>

                <div className="mb-8 rounded-xl overflow-hidden">
                    <Image
                        src="/article-sick-new.png"
                        alt="Т-клеточный иммунитет"
                        width={800}
                        height={400}
                        className="w-full h-auto object-cover"
                    />
                </div>

                <div className="prose prose-lg max-w-none">
                    <p>
                        На сегодняшний день практически каждый уже столкнулся с коронавирусом, если не сам, то родственники, друзья, коллеги. Я не стану вас убеждать берегите себя, соблюдайте меры предосторожности, носите маски, - это бесполезно. Те, что очень береглись тоже заболели, и получили осложнения.
                    </p>

                    <h2>Почему?</h2>
                    <p>
                        Потому, что со слабым клеточным иммунитетом, мы беззащитны перед любой болезнью.
                    </p>

                    <p>
                        Именно от численности иммунных клеток "Т"-лимфоцитов, а НЕ антител, "В" лимфоцитов зависит как наш организм справится с вирусом.
                    </p>

                    <p>
                        Научные исследования доказали, что если клеточный иммунитет в результате возрастных изменений снижается, то нам нужно оказывать своим иммунным т-клеткам своевременную поддержку.
                    </p>

                    <p>
                        Чем больше т-клеток будет в организме, тем выше шанс оставаться здоровыми.
                    </p>

                    <p>
                        Помогайте своим защитникам организма в борьбе с патогенными вирусами, и организм отблагодарит вас отменным здоровьем.
                    </p>

                    <h2>Авторитетное мнение</h2>
                    <p>
                        Авторитетное мнение о лекарственном препарате Инмунофлам® - ученого-фармаколога, доктора медицинских наук, профессора, член корреспондента Национальной академии наук и Академии медицинских наук Украины Ивана Чекмана:
                    </p>

                    <div className="my-6">
                        <a
                            href="https://youtu.be/pgSS6CWz7S4"
                            target="_blank"
                            rel="noopener noreferrer"
                            className="text-emerald-600 hover:text-emerald-700 underline"
                        >
                            Смотреть видео →
                        </a>
                    </div>
                </div>
            </article>

            <Footer />
        </div>
    )
}
