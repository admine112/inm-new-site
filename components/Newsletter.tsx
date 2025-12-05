"use client"

import { useState } from "react"
import { Send, Check } from "lucide-react"

export function Newsletter() {
    const [email, setEmail] = useState("")
    const [status, setStatus] = useState<"idle" | "loading" | "success">("idle")

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault()
        if (!email) return

        setStatus("loading")

        // Simulate API call
        setTimeout(() => {
            setStatus("success")
            setEmail("")
        }, 1000)
    }

    return (
        <section className="bg-emerald-50 border-t border-emerald-100 py-16">
            <div className="max-w-2xl mx-auto px-6 text-center">
                <h2 className="text-3xl font-bold text-gray-900 mb-3">Не пропустите новые статьи</h2>
                <p className="text-gray-600 mb-8">
                    Подпишитесь на нашу рассылку и получайте полезные советы о здоровье прямо на почту
                </p>

                {status === "success" ? (
                    <div className="bg-white p-6 rounded-xl border border-emerald-200 shadow-sm inline-flex items-center gap-3 text-emerald-700 animate-in fade-in zoom-in duration-300">
                        <div className="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                            <Check size={20} />
                        </div>
                        <div className="text-left">
                            <p className="font-semibold">Вы успешно подписались!</p>
                            <p className="text-sm text-emerald-600">Спасибо, что вы с нами.</p>
                        </div>
                    </div>
                ) : (
                    <form onSubmit={handleSubmit} className="flex gap-3 max-w-md mx-auto relative">
                        <input
                            type="email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            placeholder="Ваш email"
                            required
                            className="flex-1 px-6 py-3 rounded-lg border border-emerald-200 bg-white text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 disabled:opacity-50"
                            disabled={status === "loading"}
                        />
                        <button
                            type="submit"
                            disabled={status === "loading"}
                            className="btn-primary flex items-center gap-2 disabled:opacity-70"
                        >
                            {status === "loading" ? (
                                "Отправка..."
                            ) : (
                                <>
                                    Подписаться
                                    <Send size={18} />
                                </>
                            )}
                        </button>
                    </form>
                )}
            </div>
        </section>
    )
}
