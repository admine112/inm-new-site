"use client"

import { useState } from "react"
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from "@/components/ui/dialog"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Textarea } from "@/components/ui/textarea"

interface ConsultationButtonProps {
    className?: string
    children: React.ReactNode
}

export function ConsultationButton({ className, children }: ConsultationButtonProps) {
    const [open, setOpen] = useState(false)
    const [submitted, setSubmitted] = useState(false)

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault()
        // Mock submission
        setTimeout(() => {
            setSubmitted(true)
        }, 500)
    }

    return (
        <Dialog open={open} onOpenChange={setOpen}>
            <DialogTrigger asChild>
                <button className={className} onClick={() => setOpen(true)}>
                    {children}
                </button>
            </DialogTrigger>
            <DialogContent className="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>Получить консультацию</DialogTitle>
                    <DialogDescription>
                        Заполните форму ниже, и наш специалист свяжется с вами в ближайшее время.
                    </DialogDescription>
                </DialogHeader>

                {!submitted ? (
                    <form onSubmit={handleSubmit} className="grid gap-4 py-4">
                        <div className="grid gap-2">
                            <Label htmlFor="name">Имя</Label>
                            <Input id="name" required placeholder="Иван Иванов" />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="email">Почта</Label>
                            <Input id="email" type="email" required placeholder="ivan@example.com" />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="phone">Телефон</Label>
                            <Input id="phone" type="tel" required placeholder="+380..." />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="description">Описание проблемы</Label>
                            <Textarea id="description" required placeholder="Опишите вашу проблему..." />
                        </div>
                        <Button type="submit" className="bg-emerald-600 hover:bg-emerald-700 text-white">
                            Отправить
                        </Button>
                    </form>
                ) : (
                    <div className="py-8 text-center">
                        <div className="mb-4 flex justify-center text-emerald-600">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        </div>
                        <h3 className="text-xl font-semibold text-gray-900 mb-2">Спасибо!</h3>
                        <p className="text-gray-600">Ваша заявка принята. Мы свяжемся с вами в ближайшее время.</p>
                        <Button
                            onClick={() => {
                                setOpen(false)
                                setSubmitted(false)
                            }}
                            className="mt-6 bg-emerald-600 hover:bg-emerald-700 text-white"
                        >
                            Закрыть
                        </Button>
                    </div>
                )}
            </DialogContent>
        </Dialog>
    )
}
