import Link from "next/link"

export function Footer() {
  return (
    <footer className="bg-gray-50 border-t border-gray-100 mt-20">
      <div className="max-w-7xl mx-auto px-6 py-12">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
          <div>
            <h3 className="text-lg font-semibold text-emerald-700 mb-4">Иммунофлам</h3>
            <p className="text-gray-600 text-sm">Натуральная поддержка вашего иммунитета</p>
          </div>
          <div>
            <h4 className="font-semibold text-gray-900 mb-4">Магазин</h4>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/shop" className="text-gray-600 hover:text-emerald-600">
                  Все товары
                </Link>
              </li>
              <li>
                <Link href="/shop#new" className="text-gray-600 hover:text-emerald-600">
                  Новое
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h4 className="font-semibold text-gray-900 mb-4">Информация</h4>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/articles" className="text-gray-600 hover:text-emerald-600">
                  Статьи
                </Link>
              </li>
              <li>
                <Link href="/about" className="text-gray-600 hover:text-emerald-600">
                  О бренде
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h4 className="font-semibold text-gray-900 mb-4">Контакты</h4>
            <div className="space-y-2 text-sm text-gray-600">
              <p>Киев, Оболонская пл., 5</p>
              <p className="font-semibold text-gray-900 mt-3">Телефоны:</p>
              <p>(044) 578-17-48</p>
              <p>(063) 578-17-48</p>
              <p>(067) 233-74-80</p>
              <p className="font-semibold text-gray-900 mt-3">Email:</p>
              <p>lda7@ukr.net</p>
              <p className="font-semibold text-gray-900 mt-3">Мессенджеры:</p>
              <p>+380 50 857 25 64</p>
            </div>
          </div>
        </div>
        <div className="border-t border-gray-200 pt-8 text-center text-gray-500 text-sm">
          <p>&copy; 2025 Иммунофлам. Все права защищены.</p>
        </div>
      </div>
    </footer>
  )
}
