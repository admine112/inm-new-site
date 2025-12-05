import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import Image from "next/image"

export default function About() {
  return (
    <div className="min-h-screen bg-white">
      <Header />

      {/* Page Header */}
      <section className="bg-emerald-50 border-b border-emerald-100 py-12">
        <div className="max-w-7xl mx-auto px-6">
          <h1 className="text-4xl font-bold text-gray-900 mb-3">О Иммунофлам</h1>
          <p className="text-gray-600 text-lg">
            Миссия: давать людям инструменты для крепкого здоровья и активной жизни
          </p>
        </div>
      </section>

      {/* Story Section */}
      <section className="max-w-7xl mx-auto px-6 py-20">
        <div className="grid grid-cols-2 gap-16 items-center mb-20">
          <div>
            <h2 className="text-3xl font-bold text-gray-900 mb-6">Наша история</h2>
            <p className="text-gray-600 text-lg leading-relaxed mb-4">
              Иммунофлам появился из простой идеи: создать препараты, которые действительно работают, на основе
              проверенных временем натуральных компонентов. Наша команда учёных-фитофармакологов потратила 5 лет на
              разработку и тестирование каждого продукта.
            </p>
            <p className="text-gray-600 text-lg leading-relaxed mb-4">
              Мы верим, что здоровье — это не отсутствие болезни, а полнота сил и энергии. Поэтому Иммунофлам помогает
              не просто защититься от простуд, а укрепить организм изнутри.
            </p>
            <p className="text-gray-600 text-lg leading-relaxed">
              Сегодня нашей продукции доверяют более 100 тысяч человек по всей России. Это наша гордость и
              ответственность.
            </p>
          </div>
          <div className="bg-emerald-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow">
            <Image
              src="/placeholder.svg?height=500&width=500"
              alt="Наша история"
              width={500}
              height={500}
              className="w-full rounded-lg"
            />
          </div>
        </div>
      </section>

      {/* Values Section */}
      <section className="bg-emerald-50 py-20">
              },
        {
          title: "Доступность",
        description:
        "Здоровье не должно быть привилегией. Мы предлагаем премиум качество по справедливым ценам.",
              },
        {
          title: "Забота о людях",
        description: "Мы слышим наших клиентов, совершенствуем продукты и создаём сообщество здоровых людей.",
              },
        {
          title: "Экологичность",
        description: "Заботимся о природе: используем переработанную упаковку и поддерживаем экопроекты.",
              },
            ].map((value, idx) => (
        <div key={idx} className="card">
          <h3 className="text-lg font-semibold text-emerald-700 mb-3">{value.title}</h3>
          <p className="text-gray-600 text-sm leading-relaxed">{value.description}</p>
        </div>
            ))}
    </div>
        </div >
      </section >

    {/* Team Section */ }
    < section className = "max-w-7xl mx-auto px-6 py-20" >
        <h2 className="text-3xl font-bold text-gray-900 mb-4">Наша команда</h2>
        <p className="text-gray-600 text-lg mb-12">Единомышленники, объединённые верой в силу природы</p>

        <div className="grid grid-cols-4 gap-8">
          {[
            {
              name: "Евгения Морозова",
              role: "Основатель, Фитофармаколог",
              image: "/placeholder.svg?height=300&width=300",
            },
            {
              name: "Сергей Волков",
              role: "Директор исследований",
              image: "/placeholder.svg?height=300&width=300",
            },
            {
              name: "Анна Лебедева",
              role: "Главный химик",
              image: "/placeholder.svg?height=300&width=300",
            },
            {
              name: "Игорь Петров",
              role: "Директор качества",
              image: "/placeholder.svg?height=300&width=300",
            },
          ].map((member, idx) => (
            <div key={idx} className="card text-center">
              <div className="bg-emerald-50 rounded-lg p-6 mb-4 h-56">
                <Image
                  src={member.image || "/placeholder.svg"}
                  alt={member.name}
                  width={300}
                  height={300}
                  className="w-full h-full object-cover rounded"
                />
              </div>
              <h3 className="text-lg font-semibold text-gray-900">{member.name}</h3>
              <p className="text-emerald-600 text-sm">{member.role}</p>
            </div>
          ))}
        </div>
      </section >

    {/* Stats Section */ }
    < section className = "bg-emerald-600 text-white py-16" >
      <div className="max-w-7xl mx-auto px-6">
        <div className="grid grid-cols-4 gap-8 text-center">
          {[
            { number: "100K+", label: "Довольных клиентов" },
            { number: "5+", label: "Лет разработок" },
            { number: "6", label: "Эффективных продуктов" },
            { number: "99%", label: "Положительных отзывов" },
          ].map((stat, idx) => (
            <div key={idx}>
              <p className="text-5xl font-bold mb-2">{stat.number}</p>
              <p className="text-emerald-100">{stat.label}</p>
            </div>
          ))}
        </div>
      </div>
      </section >

    {/* Contact Section */ }
    < section className = "max-w-7xl mx-auto px-6 py-20" >
        <h2 className="text-3xl font-bold text-gray-900 mb-4">Свяжитесь с нами</h2>
        <p className="text-gray-600 text-lg mb-8">Есть вопросы? Мы здесь, чтобы помочь</p>

        <div className="grid grid-cols-3 gap-8 mb-12">
          {[
            {
              icon: "📞",
              title: "Телефон",
              value: "+7 (800) 555-35-35",
            },
            {
              icon: "✉️",
              title: "Email",
              value: "info@immunoflam.ru",
            },
            {
              icon: "📍",
              title: "Адрес",
              value: "Москва, ул. Здоровья, д. 42",
            },
          ].map((contact, idx) => (
            <div key={idx} className="card text-center">
              <div className="text-4xl mb-4">{contact.icon}</div>
              <h3 className="text-lg font-semibold text-gray-900 mb-2">{contact.title}</h3>
              <p className="text-gray-600">{contact.value}</p>
            </div>
          ))}
        </div>

        <div className="card">
          <h3 className="text-2xl font-semibold text-gray-900 mb-6">Напишите нам</h3>
          <form className="grid grid-cols-2 gap-6">
            <input
              type="text"
              placeholder="Ваше имя"
              className="px-6 py-3 rounded-lg border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            />
            <input
              type="email"
              placeholder="Email"
              className="px-6 py-3 rounded-lg border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            />
            <textarea
              placeholder="Ваше сообщение"
              rows={4}
              className="col-span-2 px-6 py-3 rounded-lg border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500"
            ></textarea>
            <button type="submit" className="col-span-2 btn-primary">
              Отправить сообщение
            </button>
          </form>
        </div>
      </section >

    <Footer />
    </div >
  )
}
