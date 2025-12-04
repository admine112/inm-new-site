export interface Product {
  id: number
  name: string
  description: string
  price: number
  image: string
  category: string
}

export const products: Product[] = [
  {
    id: 1,
    name: "Иммунофлам Форте",
    description:
      "Комплексная поддержка иммунитета с витаминами C и D, цинком и селеном. Усиливает защитные функции организма.",
    price: 890,
    image: "/placeholder.svg?height=400&width=300",
    category: "supplements",
  },
  {
    id: 2,
    name: "Антиоксидант Плюс",
    description:
      "Мощный антиоксидантный комплекс с экстрактом куркумы, имбиря и ягод годжи. Защита клеток от окислительного стресса.",
    price: 1290,
    image: "/placeholder.svg?height=400&width=300",
    category: "supplements",
  },
  {
    id: 3,
    name: "Витамин D3 Натуральный",
    description:
      "Высокодозированный витамин D3 из натурального источника. Укрепляет кости, зубы и поддерживает иммунитет.",
    price: 650,
    image: "/placeholder.svg?height=400&width=300",
    category: "vitamins",
  },
  {
    id: 4,
    name: "Probio Balance",
    description:
      "Пробиотический комплекс с 10 миллиардами полезных бактерий. Улучшает пищеварение и укрепляет иммунную систему.",
    price: 1550,
    image: "/placeholder.svg?height=400&width=300",
    category: "probiotics",
  },
  {
    id: 5,
    name: "Имбирь и Куркума",
    description:
      "Натуральный экстракт имбиря и куркумы в виде чая. Противовоспалительное действие, согревает и тонизирует.",
    price: 420,
    image: "/placeholder.svg?height=400&width=300",
    category: "herbal",
  },
  {
    id: 6,
    name: "Цинк+Селен Комплекс",
    description:
      "Синергетичная комбинация цинка и селена. Критически важные минералы для поддержания здорового иммунитета.",
    price: 780,
    image: "/placeholder.svg?height=400&width=300",
    category: "minerals",
  },
]
