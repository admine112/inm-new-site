import type React from "react"
import type { Metadata } from "next"

import { Analytics } from "@vercel/analytics/next"
import "./globals.css"


export const metadata: Metadata = {
  title: "Иммунофлам - Натуральная иммунная поддержка",
  description: "Премиум препараты для укрепления иммунитета на основе натуральных компонентов",
  description: "Премиум препараты для укрепления иммунитета на основе натуральных компонентов",
  icons: {
    icon: [
      {
        url: "/icon-light-32x32.png",
        media: "(prefers-color-scheme: light)",
      },
      {
        url: "/icon-dark-32x32.png",
        media: "(prefers-color-scheme: dark)",
      },
      {
        url: "/icon.svg",
        type: "image/svg+xml",
      },
    ],
    apple: "/apple-icon.png",
  },
}

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode
}>) {
  return (
    <html lang="ru" suppressHydrationWarning>
      <body className={`font-sans antialiased bg-white text-gray-900`}>
        {children}
        <Analytics />
      </body>
    </html>
  )
}
