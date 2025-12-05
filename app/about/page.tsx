import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import Image from "next/image"

export default function About() {
  return (
    <div className="min-h-screen bg-white">
      <Header />

      <main className="max-w-4xl mx-auto px-6 py-16">
        <h1 className="text-4xl font-bold text-gray-900 mb-8">Что такое Инмунофлам</h1>

        <div className="prose prose-lg max-w-none text-gray-700">
          <p className="text-xl font-medium text-emerald-800 mb-6">
            Инмунофлам — это натуральный препарат на основе экстракта коры лианы Uncaria Tomentosa (Кошачий коготь), произрастающей в тропических лесах Перу.
          </p>

          <p>
            Наш продукт создан для тех, кто заботится о своем здоровье и хочет укрепить иммунитет естественным путем.
            Инмунофлам обладает мощным иммуномодулирующим действием, помогая организму справляться с вирусными инфекциями,
            воспалительными процессами и негативным влиянием окружающей среды.
          </p>

          <h2 className="text-2xl font-bold text-gray-900 mt-8 mb-4">Почему выбирают Инмунофлам?</h2>

          <ul className="list-disc pl-6 space-y-2">
            <li><strong>Натуральный состав:</strong> Только чистый экстракт Ункарии Томентоза без химических добавок.</li>
            <li><strong>Доказанная эффективность:</strong> Исследования подтверждают способность активировать Т-клеточный иммунитет.</li>
            <li><strong>Комплексное действие:</strong> Противовирусное, противовоспалительное и антиоксидантное действие.</li>
            <li><strong>Безопасность:</strong> Не вызывает привыкания и имеет минимум побочных эффектов.</li>
          </ul>

          <h2 className="text-2xl font-bold text-gray-900 mt-8 mb-4">Наша миссия</h2>
          <p>
            Мы стремимся сделать здоровье доступным каждому, предлагая качественный и эффективный продукт, подаренный самой природой.
            Наша цель — помочь вам сохранить активность, бодрость и крепкий иммунитет на долгие годы.
          </p>
        </div>
      </main>

      <Footer />
    </div>
  )
}
