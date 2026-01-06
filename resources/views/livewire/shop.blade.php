
<!-- Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
    <div>
        <h1 class="text-4xl font-bold text-slate-900 mb-2">Shop All</h1>
        <p class="text-slate-500">
            Explore our complete collection of automotive accessories
        </p>
    </div>

    <button class="flex items-center gap-2 border rounded-md px-4 py-2 text-sm">
        Sort By
    </button>
</div>

<div class="flex flex-col lg:flex-row gap-8">

    <!-- Sidebar -->
    <aside class="w-full lg:w-64 space-y-6">
        <div class="bg-white p-6 rounded-xl shadow border">
            <h3 class="font-bold mb-4">Categories</h3>

            <ul class="space-y-2 text-sm">
                <li class="text-blue-600 font-semibold">All</li>
                <li class="text-slate-600">Interior</li>
                <li class="text-slate-600">Storage</li>
                <li class="text-slate-600">Electronics</li>
                <li class="text-slate-600">Car Care</li>
                <li class="text-slate-600">Tools</li>
            </ul>
        </div>
    </aside>

    <!-- Products Grid -->
    <section class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Product Card -->
        <div class="bg-white rounded-xl shadow hover:shadow-xl transition flex flex-col">
            <img src="https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=800&q=80"
                class="h-64 w-full object-cover rounded-t-xl" alt="Product">

            <div class="p-5 flex flex-col flex-1">
                <h3 class="font-bold text-lg mb-2">
                    Premium Leather Seat Covers
                </h3>

                <p class="text-sm text-slate-600 mb-4 flex-grow">
                    Transform your car interior with premium leather.
                </p>

                <div class="flex justify-between items-center">
                    <span class="text-blue-600 font-bold text-xl"><x-currency amount="189.99" /></span>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm">
                        Add
                    </button>
                </div>
            </div>
        </div>

        <!-- Duplicate cards manually for now -->

    </section>

</div>
