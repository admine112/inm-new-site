import { Header } from "@/components/header"
import { Footer } from "@/components/footer"
import { Facebook, Send, Phone, MapPin, Clock, Mail } from "lucide-react"

export default function ContactsPage() {
    return (
        <div className="min-h-screen bg-white">
            <Header />

            <main className="max-w-7xl mx-auto px-6 py-12">
                <h1 className="text-4xl font-bold text-gray-900 mb-12 text-center">Где нас найти</h1>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {/* Contact Info */}
                    <div className="space-y-8">
                        <div className="bg-emerald-50 p-8 rounded-2xl">
                            <h2 className="text-2xl font-bold text-emerald-800 mb-6">Офис Инмунофлам</h2>

                            <div className="space-y-6">
                                <div className="flex items-start gap-4">
                                    <MapPin className="text-emerald-600 mt-1" size={24} />
                                    <div>
                                        <p className="font-semibold text-gray-900">Адрес:</p>
                                        <p className="text-gray-700">Киев, 02000, Оболонская пл., 5</p>
                                        <p className="text-sm text-gray-500 mt-1">GPS: 50.502183, 30.502577</p>
                                    </div>
                                </div>

                                <div className="flex items-start gap-4">
                                    <Clock className="text-emerald-600 mt-1" size={24} />
                                    <div>
                                        <p className="font-semibold text-gray-900">График работы:</p>
                                        <p className="text-gray-700">ПН-ПТ: 10:00 - 19:00</p>
                                        <p className="text-sm text-gray-500">(согласовать время предварительно)</p>
                                    </div>
                                </div>

                                <div className="flex items-start gap-4">
                                    <Mail className="text-emerald-600 mt-1" size={24} />
                                    <div>
                                        <p className="font-semibold text-gray-900">Email:</p>
                                        <a href="mailto:lda7@ukr.net" className="text-emerald-700 hover:underline">
                                            lda7@ukr.net
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="bg-white border border-gray-200 p-8 rounded-2xl">
                            <h3 className="text-xl font-bold text-gray-900 mb-6">Свяжитесь с нами</h3>

                            <div className="mb-6">
                                <p className="text-gray-600 mb-2">Viber, Telegram, WhatsApp:</p>
                                <a href="tel:+380508572564" className="text-2xl font-bold text-emerald-700 block mb-4">
                                    +380 50 857 25 64
                                </a>
                                <div className="flex gap-4">
                                    <a
                                        href="https://www.facebook.com/inmunoflam/"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition-colors"
                                    >
                                        <Facebook size={24} />
                                    </a>
                                    <a
                                        href="https://t.me/+380508572564"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-12 h-12 bg-sky-500 text-white rounded-full flex items-center justify-center hover:bg-sky-600 transition-colors"
                                    >
                                        <Send size={24} />
                                    </a>
                                    <a
                                        href="viber://chat?number=%2B380508572564"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-12 h-12 bg-purple-600 text-white rounded-full flex items-center justify-center hover:bg-purple-700 transition-colors"
                                    >
                                        <Phone size={24} />
                                    </a>
                                </div>
                            </div>

                            <div>
                                <p className="text-gray-600 mb-2">Вопросы применения:</p>
                                <div className="space-y-1">
                                    <a href="tel:0445781748" className="block text-lg font-medium text-gray-900 hover:text-emerald-700">
                                        (044) 578-17-48
                                    </a>
                                    <a href="tel:0635781748" className="block text-lg font-medium text-gray-900 hover:text-emerald-700">
                                        (063) 578-17-48
                                    </a>
                                    <a href="tel:0672337480" className="block text-lg font-medium text-gray-900 hover:text-emerald-700">
                                        (067) 233-74-80
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Map & Facebook */}
                    <div className="space-y-8">
                        {/* Google Map */}
                        <div className="h-[400px] bg-gray-100 rounded-2xl overflow-hidden border border-gray-200">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2537.499999999999!2d30.502577!3d50.502183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTDCsDMwJzA3LjkiTiAzMMKwMzAnMDkuMyJF!5e0!3m2!1sen!2sua!4v1635765432109!5m2!1sen!2sua"
                                width="100%"
                                height="100%"
                                style={{ border: 0 }}
                                allowFullScreen
                                loading="lazy"
                            ></iframe>
                        </div>

                        {/* Facebook Widget */}
                        <div className="bg-white p-6 rounded-2xl border border-gray-200">
                            <h3 className="text-xl font-bold text-gray-900 mb-4">Мы в Facebook</h3>
                            <div className="overflow-hidden">
                                <iframe
                                    src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Finmunoflam%2F&tabs=timeline&width=500&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                                    width="500"
                                    height="500"
                                    style={{ border: 'none', overflow: 'hidden', maxWidth: '100%' }}
                                    scrolling="no"
                                    frameBorder="0"
                                    allowFullScreen={true}
                                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                ></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <Footer />
        </div>
    )
}
