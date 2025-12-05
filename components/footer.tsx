import Link from "next/link"
import { Facebook, Send, Phone } from "lucide-react"

export function Footer() {
  return (
    <footer className="bg-emerald-900 text-emerald-100">
      <div className="max-w-7xl mx-auto px-6 py-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
          <div>
            <h3 className="text-lg font-semibold text-emerald-400 mb-4">Офис Инмунофлам</h3>
            <p className="mb-2">Киев, 02000, Оболонская пл., 5</p>
            <p className="text-sm text-emerald-300 mb-4">GPS: 50.502183, 30.502577</p>

            <h4 className="text-sm font-semibold text-emerald-400 mb-2">График работы:</h4>
            <p className="text-sm">ПН-ПТ: 10:00 - 19:00</p>
            <p className="text-xs text-emerald-300">(согласовать время предварительно)</p>
          </div>

          <div>
            <h3 className="text-lg font-semibold text-emerald-400 mb-4">Навигация</h3>
            <ul className="space-y-2">
              <li>
                <Link href="/" className="hover:text-white transition-colors">
                  Главная
                </Link>
              </li>
              <li>
                <Link href="/shop" className="hover:text-white transition-colors">
                  Магазин
                </Link>
              </li>
              <li>
                <Link href="/articles" className="hover:text-white transition-colors">
                  Статьи
                </Link>
              </li>
              <li>
                <Link href="/about" className="hover:text-white transition-colors">
                  Что такое Инмунофлам
                </Link>
              </li>
              <li>
                <Link href="/contacts" className="hover:text-white transition-colors">
                  Где нас найти
                </Link>
              </li>
            </ul>
          </div>

          <div>
            <h3 className="text-lg font-semibold text-emerald-400 mb-4">Консультации</h3>
            <div className="space-y-2 text-sm">
              <p>Viber, Telegram, WhatsApp:</p>
              <a href="tel:+380508572564" className="block text-lg font-bold hover:text-white transition-colors mb-2">
                +380 50 857 25 64
              </a>
              <div className="flex gap-4 mt-4">
                <a href="https://www.facebook.com/inmunoflam/" target="_blank" rel="noopener noreferrer" className="hover:text-white transition-colors">
                  <Facebook size={24} />
                </a>
                <a href="https://t.me/+380508572564" target="_blank" rel="noopener noreferrer" className="hover:text-white transition-colors">
                  <Send size={24} />
                </a>
                <a href="viber://chat?number=%2B380508572564" target="_blank" rel="noopener noreferrer" className="hover:text-white transition-colors">
                  <Phone size={24} />
                </a>
              </div>
              <p className="mt-4">
                <a href="mailto:lda7@ukr.net" className="hover:text-white transition-colors">
                  lda7@ukr.net
                </a>
              </p>
            </div>
          </div>

          <div>
            <h3 className="text-lg font-semibold text-emerald-400 mb-4">Вопросы применения</h3>
            <div className="space-y-2">
              <a href="tel:0445781748" className="block hover:text-white transition-colors">
                (044) 578-17-48
              </a>
              <a href="tel:0635781748" className="block hover:text-white transition-colors">
                (063) 578-17-48
              </a>
              <a href="tel:0672337480" className="block hover:text-white transition-colors">
                (067) 233-74-80
              </a>
            </div>
          </div>
        </div>

        <div className="border-t border-emerald-800 pt-8 text-center text-sm text-emerald-400">
          <p>&copy; {new Date().getFullYear()} Инмунофлам. Все права защищены.</p>
        </div>
      </div>
    </footer>
  )
}
