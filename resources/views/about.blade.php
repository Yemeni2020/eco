<x-layouts.app>

    <div class="min-h-screen bg-slate-50">
        <section class="bg-slate-900 text-white py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-blue-600/10"></div>
            <div class="container mx-auto px-4 relative z-10 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Driving Innovation Forward</h1>
                <p class="text-xl text-slate-300 max-w-2xl mx-auto">Otex is premier destination for automotive
                    enthusiasts who demand quality, performance, and style.</p>
            </div>
        </section>

        <section class="py-20 container mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-6">Our Mission</h2>
                    <p class="text-slate-600 leading-relaxed mb-6">Founded in 2023, Otex started with a simple idea: car
                        accessories should be as high-quality as the vehicles they go into. We were tired of cheap,
                        ill-fitting parts that didn't last.</p>
                    <p class="text-slate-600 leading-relaxed">Today, we curate a selection of premium accessories from
                        around the globe, testing each product rigorously to ensure it meets our standards for
                        durability, aesthetics, and functionality. We're not just selling parts; we're upgrading your
                        lifestyle on the road.</p>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <x-card class="p-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-shield-check w-8 h-8 text-blue-600 mb-4">
                            <path
                                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                            </path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                        <h3 class="font-bold text-slate-900 mb-2">Quality First</h3>
                        <p class="text-sm text-slate-500">We never compromise on materials or build quality.</p>
                    </x-card>
                    <x-card class="p-6 mt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-users w-8 h-8 text-indigo-600 mb-4">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <h3 class="font-bold text-slate-900 mb-2">Community</h3>
                        <p class="text-sm text-slate-500">Building a community of passionate drivers.</p>
                    </x-card>
                    <x-card class="p-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-target w-8 h-8 text-emerald-600 mb-4">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="6"></circle>
                            <circle cx="12" cy="12" r="2"></circle>
                        </svg>
                        <h3 class="font-bold text-slate-900 mb-2">Precision</h3>
                        <p class="text-sm text-slate-500">Products that fit your vehicle perfectly, every time.</p>
                    </x-card>
                    <x-card class="p-6 mt-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-rocket w-8 h-8 text-amber-600 mb-4">
                            <path
                                d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                            </path>
                            <path
                                d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                            </path>
                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                        </svg>
                        <h3 class="font-bold text-slate-900 mb-2">Innovation</h3>
                        <p class="text-sm text-slate-500">Always looking for the next big thing in auto tech.</p>
                    </x-card>
                </div>
            </div>
        </section>

        <section class="bg-white py-20">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold text-slate-900 mb-12">Meet The Team</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ([['name' => 'John Doe', 'role' => 'Product Specialist'], ['name' => 'John Doe', 'role' => 'Product Specialist'], ['name' => 'John Doe', 'role' => 'Product Specialist']] as $member)
                        <div class="group">
                            <div class="w-48 h-48 mx-auto bg-slate-200 rounded-full mb-6 overflow-hidden">
                                <img alt="Portrait of a smiling team member in a professional setting"
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500"
                                    src="https://images.unsplash.com/photo-1635185481431-661b09594e6c">
                            </div>
                            <h3 class="font-bold text-xl text-slate-900">{{ $member['name'] }}</h3>
                            <p class="text-blue-600 font-medium text-sm">{{ $member['role'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>

</x-layouts.app>
