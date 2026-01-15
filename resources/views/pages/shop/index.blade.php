{{--  --}}

the filters not working 
@push('head')
    <script>
        // Safety for snippets expecting a global tailwind config object.
        window.tailwind = window.tailwind || {};
        window.tailwind.config = window.tailwind.config || {};
    </script>
    <style>
        .sff {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: linear-gradient(120deg, #eef2ff, #e0f2fe);
            border: 1px solid #cbd5e1;
            box-shadow: 0 18px 40px -18px rgba(15, 23, 42, 0.35);
            border-radius: 18px;
            padding: 18px 24px;
        }

        .sfg,
        .sfh,
        .sfi,
        .sfl,
        .sfn,
        .sfp,
        .sfq,
        .sfs,
        .sfu,
        .sfw,
        .sfz,
        .sgz,
        .sha,
        .shb {}

        .sfj,
        .sgj {
            color: #0f172a;
        }

        .sgd {
            color: #475569;
        }

        .sge,
        .sgh,
        .sgs {
            color: #0f172a;
            text-decoration: underline;
            font-weight: 600;
        }

        .sfi.sfk.sfm.sfo {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .sfr.sfv.sga.sgb.sgc.sge.sgj.sgm.sgn.sgo.sgq.sgv.sgw.sgy {
            background: linear-gradient(135deg, #2563eb, #1e3a8a);
            color: #fff;
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 700;
            box-shadow: 0 10px 25px -10px rgba(37, 99, 235, 0.6);
            border: 1px solid #1d4ed8;
            transition: transform 150ms ease, box-shadow 150ms ease;
        }

        .sfr.sfv.sga.sgb.sgc.sge.sgj.sgm.sgn.sgo.sgq.sgv.sgw.sgy:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 30px -14px rgba(37, 99, 235, 0.75);
        }

        .sgd.sge.sgf.sgu {
            background: transparent;
            color: #0f172a;
            padding: 10px 14px;
            border-radius: 12px;
            border: 1px dashed #94a3b8;
            font-weight: 600;
            transition: border-color 150ms ease, color 150ms ease;
        }

        .sgd.sge.sgf.sgu:hover {
            color: #0b1f44;
            border-color: #0b1f44;
        }

        @media (max-width: 640px) {
            .sff {
                border-radius: 0;
            }
        }

        [data-product-grid][data-view="grid"] {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        [data-product-grid][data-view="two-column"] {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        [data-product-grid][data-view="list"] {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }

        @media (min-width: 640px) {
            [data-product-grid][data-view="grid"] {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            [data-product-grid][data-view="two-column"] {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            [data-product-grid][data-view="grid"] {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            [data-product-grid][data-view="two-column"] {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 768px) {
            [data-product-grid][data-view="list"] [data-product-card] {
                display: grid;
                grid-template-columns: minmax(0, 280px) minmax(0, 1fr);
                align-items: stretch;
            }

            [data-product-grid][data-view="list"] [data-product-card]>a {
                height: 100%;
                min-height: 100%;
            }

            [data-product-grid][data-view="list"] [data-product-card]>a img {
                height: 100%;
            }
        }

        @keyframes preview-fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes preview-pop-in {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        dialog.preview-dialog[open] {
            animation: preview-fade-in 180ms ease-out;
        }

        dialog.preview-dialog::backdrop {
            animation: preview-fade-in 200ms ease-out;
        }

        dialog.preview-dialog[open] .preview-panel {
            animation: preview-pop-in 220ms ease-out;
        }

        @media (prefers-reduced-motion: reduce) {

            dialog.preview-dialog[open],
            dialog.preview-dialog::backdrop,
            dialog.preview-dialog[open] .preview-panel {
                animation: none;
            }
        }
    </style>
@endpush
<x-layouts.app>
    <div class="bg-white">
        <!-- Mobile filter dialog -->
        <el-dialog>
            <dialog id="mobile-filters" class="overflow-hidden backdrop:bg-transparent lg:hidden">
                <el-dialog-backdrop
                    class="fixed inset-0 bg-black/25 transition-opacity duration-300 ease-linear data-closed:opacity-0"></el-dialog-backdrop>

                <div tabindex="0" class="fixed inset-0 flex focus:outline-none">
                    <el-dialog-panel
                        class="relative ml-auto flex size-full max-w-xs transform flex-col overflow-y-auto bg-white pt-4 pb-6 shadow-xl transition duration-300 ease-in-out data-closed:translate-x-full">
                        <div class="flex items-center justify-between px-4">
                            <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                            <button type="button" command="close" commandfor="mobile-filters"
                                class="relative -mr-2 flex size-10 items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:outline-hidden">
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Close menu</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    data-slot="icon" aria-hidden="true" class="size-6">
                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                        <!-- Filters -->
                        <form class="mt-4 border-t border-gray-200">
                            <h3 class="sr-only">Categories</h3>
                            <ul role="list" class="px-2 py-3 font-medium text-gray-900">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="#" class="block px-2 py-3">{{ $category['label'] }}</a>
                                    </li>
                                @endforeach
                            </ul>


                            <div class="border-t border-gray-200 px-4 py-6">
                                <h3 class="-mx-2 -my-3 flow-root">
                                    <button type="button" command="--toggle" commandfor="filter-section-mobile-color"
                                        class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                        <span class="font-medium text-gray-900">Color</span>
                                        <span class="ml-6 flex items-center">
                                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                                aria-hidden="true" class="size-5 in-aria-expanded:hidden">
                                                <path
                                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                            </svg>
                                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                                aria-hidden="true" class="size-5 not-in-aria-expanded:hidden">
                                                <path
                                                    d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                    clip-rule="evenodd" fill-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </button>
                                </h3>
                                <el-disclosure id="filter-section-mobile-color" hidden class="block pt-6">
                                    <div class="space-y-6">
                                        @foreach ([['Black', 'black'], ['Gray', 'gray'], ['Multicolor', 'multicolor'], ['Clear', 'clear']] as [$label, $value])
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-mobile-color-{{ $value }}"
                                                            type="checkbox" name="color[]" value="{{ $value }}"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                        <svg viewBox="0 0 14 14" fill="none"
                                                            class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                            <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="opacity-0 group-has-checked:opacity-100" />
                                                            <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="opacity-0 group-has-indeterminate:opacity-100" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-mobile-color-{{ $value }}"
                                                    class="min-w-0 flex-1 text-gray-500">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </el-disclosure>
                            </div>

                            <div class="border-t border-gray-200 px-4 py-6">
                                <h3 class="-mx-2 -my-3 flow-root">
                                    <button type="button" command="--toggle"
                                        commandfor="filter-section-mobile-category"
                                        class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                        <span class="font-medium text-gray-900">Category</span>
                                        <span class="ml-6 flex items-center">
                                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                                aria-hidden="true" class="size-5 in-aria-expanded:hidden">
                                                <path
                                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                            </svg>
                                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                                aria-hidden="true" class="size-5 not-in-aria-expanded:hidden">
                                                <path
                                                    d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                    clip-rule="evenodd" fill-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </button>
                                </h3>
                                <el-disclosure id="filter-section-mobile-category" hidden class="block pt-6">
                                    <div class="space-y-6">
                                        @foreach ($categories as $category)
                                            <div class="flex gap-3">
                                                <div class="flex h-5 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input id="filter-mobile-category-{{ $category['value'] }}"
                                                            type="checkbox" name="category[]"
                                                            value="{{ $category['value'] }}"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                        <svg viewBox="0 0 14 14" fill="none"
                                                            class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                            <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="opacity-0 group-has-checked:opacity-100" />
                                                            <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="opacity-0 group-has-indeterminate:opacity-100" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <label for="filter-mobile-category-{{ $category['value'] }}"
                                                    class="min-w-0 flex-1 text-gray-500">{{ $category['label'] }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </el-disclosure>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-6">
                                <h3 class="-mx-2 -my-3 flow-root">
                                    <button type="button" command="--toggle" commandfor="filter-section-mobile-size"
                                        class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                        <span class="font-medium text-gray-900">Size</span>
                                        <span class="ml-6 flex items-center">
                                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                                aria-hidden="true" class="size-5 in-aria-expanded:hidden">
                                                <path
                                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                            </svg>
                                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                                aria-hidden="true" class="size-5 not-in-aria-expanded:hidden">
                                                <path
                                                    d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                    clip-rule="evenodd" fill-rule="evenodd" />
                                            </svg>
                                        </span>
                                    </button>
                                </h3>
                                <el-disclosure id="filter-section-mobile-size" hidden class="block pt-6">
                                    <div class="space-y-6">
                                        <div class="flex gap-3">
                                            <div class="flex h-5 shrink-0 items-center">
                                                <div class="group grid size-4 grid-cols-1">
                                                    <input id="filter-mobile-size-0" type="checkbox" name="size[]"
                                                        value="2l"
                                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                    <svg viewBox="0 0 14 14" fill="none"
                                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                        <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="opacity-0 group-has-checked:opacity-100" />
                                                        <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="opacity-0 group-has-indeterminate:opacity-100" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <label for="filter-mobile-size-0"
                                                class="min-w-0 flex-1 text-gray-500">2L</label>
                                        </div>
                                        <div class="flex gap-3">
                                            <div class="flex h-5 shrink-0 items-center">
                                                <div class="group grid size-4 grid-cols-1">
                                                    <input id="filter-mobile-size-1" type="checkbox" name="size[]"
                                                        value="6l"
                                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                    <svg viewBox="0 0 14 14" fill="none"
                                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                        <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="opacity-0 group-has-checked:opacity-100" />
                                                        <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="opacity-0 group-has-indeterminate:opacity-100" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <label for="filter-mobile-size-1"
                                                class="min-w-0 flex-1 text-gray-500">6L</label>
                                        </div>
                                        <div class="flex gap-3">
                                            <div class="flex h-5 shrink-0 items-center">
                                                <div class="group grid size-4 grid-cols-1">
                                                    <input id="filter-mobile-size-2" type="checkbox" name="size[]"
                                                        value="12l"
                                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                    <svg viewBox="0 0 14 14" fill="none"
                                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                        <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="opacity-0 group-has-checked:opacity-100" />
                                                        <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="opacity-0 group-has-indeterminate:opacity-100" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <label for="filter-mobile-size-2"
                                                class="min-w-0 flex-1 text-gray-500">12L</label>
                                        </div>
                                        <div class="flex gap-3">
                                            <div class="flex h-5 shrink-0 items-center">
                                                <div class="group grid size-4 grid-cols-1">
                                                    <input id="filter-mobile-size-3" type="checkbox" name="size[]"
                                                        value="18l"
                                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                    <svg viewBox="0 0 14 14" fill="none"
                                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                        <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="opacity-0 group-has-checked:opacity-100" />
                                                        <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="opacity-0 group-has-indeterminate:opacity-100" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <label for="filter-mobile-size-3"
                                                class="min-w-0 flex-1 text-gray-500">18L</label>
                                        </div>
                                        <div class="flex gap-3">
                                            <div class="flex h-5 shrink-0 items-center">
                                                <div class="group grid size-4 grid-cols-1">
                                                    <input id="filter-mobile-size-4" type="checkbox" name="size[]"
                                                        value="20l"
                                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                    <svg viewBox="0 0 14 14" fill="none"
                                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                        <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="opacity-0 group-has-checked:opacity-100" />
                                                        <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="opacity-0 group-has-indeterminate:opacity-100" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <label for="filter-mobile-size-4"
                                                class="min-w-0 flex-1 text-gray-500">20L</label>
                                        </div>
                                        <div class="flex gap-3">
                                            <div class="flex h-5 shrink-0 items-center">
                                                <div class="group grid size-4 grid-cols-1">
                                                    <input id="filter-mobile-size-5" type="checkbox" name="size[]"
                                                        value="40l"
                                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                    <svg viewBox="0 0 14 14" fill="none"
                                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                        <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="opacity-0 group-has-checked:opacity-100" />
                                                        <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="opacity-0 group-has-indeterminate:opacity-100" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <label for="filter-mobile-size-5"
                                                class="min-w-0 flex-1 text-gray-500">40L</label>
                                        </div>
                                    </div>
                                </el-disclosure>
                            </div>
                        </form>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>


        <main class="container mx-auto px-4">
            <div class="flex items-baseline justify-between border-b border-gray-200 pt-24 pb-6">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900">New Arrivals</h1>

                <div class="flex items-center">
                    <el-dropdown class="relative inline-block text-left">
                        <button
                            class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900">
                            Sort
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                class="-mr-1 ml-1 size-5 shrink-0 text-gray-400 group-hover:text-gray-500">
                                <path
                                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" fill-rule="evenodd" />
                            </svg>
                        </button>

                        <el-menu anchor="bottom end" popover
                            class="w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black/5 transition transition-discrete [--anchor-gap:--spacing(2)] focus:outline-hidden data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                            <div class="py-1">
                                <a href="#" data-sort="popular"
                                    class="block px-4 py-2 text-sm font-medium text-gray-900 focus:bg-gray-100 focus:outline-hidden">Most
                                    Popular</a>
                                <a href="#" data-sort="rating"
                                    class="block px-4 py-2 text-sm text-gray-500 focus:bg-gray-100 focus:outline-hidden">Best
                                    Rating</a>
                                <a href="#" data-sort="newest"
                                    class="block px-4 py-2 text-sm text-gray-500 focus:bg-gray-100 focus:outline-hidden">Newest</a>
                                <a href="#" data-sort="price-asc"
                                    class="block px-4 py-2 text-sm text-gray-500 focus:bg-gray-100 focus:outline-hidden">Price:
                                    Low to High</a>
                                <a href="#" data-sort="price-desc"
                                    class="block px-4 py-2 text-sm text-gray-500 focus:bg-gray-100 focus:outline-hidden">Price:
                                    High to Low</a>
                            </div>
                        </el-menu>
                    </el-dropdown>

                    <button type="button" data-view-grid aria-pressed="true"
                        class="-m-2 ml-5 p-2 text-gray-400 hover:text-gray-500 sm:ml-7"
                        onclick="window.setShopView && window.setShopView('grid')">
                        <span class="sr-only">View grid</span>
                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                            class="size-5">
                            <path
                                d="M4.25 2A2.25 2.25 0 0 0 2 4.25v2.5A2.25 2.25 0 0 0 4.25 9h2.5A2.25 2.25 0 0 0 9 6.75v-2.5A2.25 2.25 0 0 0 6.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 2 13.25v2.5A2.25 2.25 0 0 0 4.25 18h2.5A2.25 2.25 0 0 0 9 15.75v-2.5A2.25 2.25 0 0 0 6.75 11h-2.5Zm9-9A2.25 2.25 0 0 0 11 4.25v2.5A2.25 2.25 0 0 0 13.25 9h2.5A2.25 2.25 0 0 0 18 6.75v-2.5A2.25 2.25 0 0 0 15.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 11 13.25v2.5A2.25 2.25 0 0 0 13.25 18h2.5A2.25 2.25 0 0 0 18 15.75v-2.5A2.25 2.25 0 0 0 15.75 11h-2.5Z"
                                clip-rule="evenodd" fill-rule="evenodd" />
                        </svg>
                    </button>
                    <button type="button" data-view-two-column aria-pressed="false"
                        class="-m-2 ml-1 p-2 text-gray-400 hover:text-gray-500"
                        onclick="window.setShopView && window.setShopView('two-column')">
                        <span class="sr-only">View two column</span>
                        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
                            <path
                                d="M4.25 2A2.25 2.25 0 0 0 2 4.25v11.5A2.25 2.25 0 0 0 4.25 18h2.5A2.25 2.25 0 0 0 9 15.75V4.25A2.25 2.25 0 0 0 6.75 2h-2.5Zm9 0A2.25 2.25 0 0 0 11 4.25v11.5A2.25 2.25 0 0 0 13.25 18h2.5A2.25 2.25 0 0 0 18 15.75V4.25A2.25 2.25 0 0 0 15.75 2h-2.5Z"
                                clip-rule="evenodd" fill-rule="evenodd" />
                        </svg>
                    </button>
                    <button type="button" data-view-list aria-pressed="false"
                        class="-m-2 ml-1 p-2 text-gray-400 hover:text-gray-500"
                        onclick="window.setShopView && window.setShopView('list')">
                        <span class="sr-only">View list</span>
                        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
                            <path
                                d="M4 5.25A1.25 1.25 0 0 1 5.25 4h9.5a1.25 1.25 0 0 1 0 2.5h-9.5A1.25 1.25 0 0 1 4 5.25Zm0 5A1.25 1.25 0 0 1 5.25 9h9.5a1.25 1.25 0 0 1 0 2.5h-9.5A1.25 1.25 0 0 1 4 10.25Zm1.25 4.75a1.25 1.25 0 0 0 0 2.5h9.5a1.25 1.25 0 0 0 0-2.5h-9.5Z"
                                clip-rule="evenodd" fill-rule="evenodd" />
                        </svg>
                    </button>
                    <button type="button" command="show-modal" commandfor="mobile-filters"
                        class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden">
                        <span class="sr-only">Filters</span>
                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                            class="size-5">
                            <path
                                d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 0 1 .628.74v2.288a2.25 2.25 0 0 1-.659 1.59l-4.682 4.683a2.25 2.25 0 0 0-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 0 1 8 18.25v-5.757a2.25 2.25 0 0 0-.659-1.591L2.659 6.22A2.25 2.25 0 0 1 2 4.629V2.34a.75.75 0 0 1 .628-.74Z"
                                clip-rule="evenodd" fill-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <section aria-labelledby="products-heading" class="pt-6 pb-24">
                <h2 id="products-heading" class="sr-only">Products</h2>

                <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                    <!-- Filters -->
                    <form class="hidden lg:block">
                        <h3 class="sr-only">Categories</h3>
                        <ul role="list"
                            class="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900">
                            <li>
                                <a href="#">Totes</a>
                            </li>
                            <li>
                                <a href="#">Backpacks</a>
                            </li>
                            <li>
                                <a href="#">Travel Bags</a>
                            </li>
                            <li>
                                <a href="#">Hip Bags</a>
                            </li>
                            <li>
                                <a href="#">Laptop Sleeves</a>
                            </li>
                        </ul>

                        <div class="border-b border-gray-200 py-6">
                            <h3 class="-my-3 flow-root">
                                <button type="button" command="--toggle" commandfor="filter-section-color"
                                    class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                                    <span class="font-medium text-gray-900">Color</span>
                                    <span class="ml-6 flex items-center">
                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                            aria-hidden="true" class="size-5 in-aria-expanded:hidden">
                                            <path
                                                d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                        </svg>
                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                            aria-hidden="true" class="size-5 not-in-aria-expanded:hidden">
                                            <path
                                                d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                clip-rule="evenodd" fill-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                            </h3>
                            <el-disclosure id="filter-section-color" hidden class="block pt-6">
                                <div class="space-y-4">
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-color-0" type="checkbox" name="color[]"
                                                    value="white"
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-color-0" class="text-sm text-gray-600">White</label>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-color-1" type="checkbox" name="color[]"
                                                    value="beige"
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-color-1" class="text-sm text-gray-600">Beige</label>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-color-2" type="checkbox" name="color[]"
                                                    value="blue" checked
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-color-2" class="text-sm text-gray-600">Blue</label>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-color-3" type="checkbox" name="color[]"
                                                    value="brown"
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-color-3" class="text-sm text-gray-600">Brown</label>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-color-4" type="checkbox" name="color[]"
                                                    value="green"
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-color-4" class="text-sm text-gray-600">Green</label>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-color-5" type="checkbox" name="color[]"
                                                    value="purple"
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-color-5" class="text-sm text-gray-600">Purple</label>
                                    </div>
                                </div>
                            </el-disclosure>
                        </div>

                        <div class="border-b border-gray-200 py-6">
                            <h3 class="-my-3 flow-root">
                                <button type="button" command="--toggle" commandfor="filter-section-category"
                                    class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                                    <span class="font-medium text-gray-900">Category</span>
                                    <span class="ml-6 flex items-center">
                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                            aria-hidden="true" class="size-5 in-aria-expanded:hidden">
                                            <path
                                                d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                        </svg>
                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                            aria-hidden="true" class="size-5 not-in-aria-expanded:hidden">
                                            <path
                                                d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                clip-rule="evenodd" fill-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                            </h3>
                            <el-disclosure id="filter-section-category" hidden class="block pt-6">
                                <div class="space-y-4">
                                    @foreach ($categories as $category)
                                        <div class="flex gap-3">
                                            <div class="flex h-5 shrink-0 items-center">
                                                <div class="group grid size-4 grid-cols-1">
                                                    <input id="filter-category-{{ $loop->index }}" type="checkbox"
                                                        name="category[]" value="{{ $category['value'] }}"
                                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                    <svg viewBox="0 0 14 14" fill="none"
                                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                        <path d="M3 8L6 11L11 3.5" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="opacity-0 group-has-checked:opacity-100" />
                                                        <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="opacity-0 group-has-indeterminate:opacity-100" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <label for="filter-category-{{ $loop->index }}"
                                                class="text-sm text-gray-600">{{ $category['label'] }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </el-disclosure>
                        </div>
                        <div class="border-b border-gray-200 py-6">
                            <h3 class="-my-3 flow-root">
                                <button type="button" command="--toggle" commandfor="filter-section-size"
                                    class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                                    <span class="font-medium text-gray-900">Size</span>
                                    <span class="ml-6 flex items-center">
                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                            aria-hidden="true" class="size-5 in-aria-expanded:hidden">
                                            <path
                                                d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                        </svg>
                                        <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon"
                                            aria-hidden="true" class="size-5 not-in-aria-expanded:hidden">
                                            <path
                                                d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                clip-rule="evenodd" fill-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                            </h3>
                            <el-disclosure id="filter-section-size" hidden class="block pt-6">
                                <div class="space-y-4">
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-size-0" type="checkbox" name="size[]"
                                                    value="2l"
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-size-0" class="text-sm text-gray-600">2L</label>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-size-1" type="checkbox" name="size[]"
                                                    value="6l"
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-size-1" class="text-sm text-gray-600">6L</label>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-size-2" type="checkbox" name="size[]"
                                                    value="12l"
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-size-2" class="text-sm text-gray-600">12L</label>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-size-3" type="checkbox" name="size[]"
                                                    value="18l"
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-size-3" class="text-sm text-gray-600">18L</label>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-size-4" type="checkbox" name="size[]"
                                                    value="20l"
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-size-4" class="text-sm text-gray-600">20L</label>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex h-5 shrink-0 items-center">
                                            <div class="group grid size-4 grid-cols-1">
                                                <input id="filter-size-5" type="checkbox" name="size[]"
                                                    value="40l" checked
                                                    class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto" />
                                                <svg viewBox="0 0 14 14" fill="none"
                                                    class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25">
                                                    <path d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-checked:opacity-100" />
                                                    <path d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="opacity-0 group-has-indeterminate:opacity-100" />
                                                </svg>
                                            </div>
                                        </div>
                                        <label for="filter-size-5" class="text-sm text-gray-600">40L</label>
                                    </div>
                                </div>
                            </el-disclosure>
                        </div>
                    </form>

                    <!-- Product grid -->
                    <div class="lg:col-span-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" data-product-grid
                            data-view="grid">
                            @foreach ($products as $product)
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-2xl h-full flex flex-col relative group"
                                    data-product-card data-loaded="true" data-id="{{ $product['id'] }}"
                                    data-name="{{ $product['name'] }}" data-price="{{ $product['price'] }}"
                                    data-image="{{ $product['image'] }}"
                                    data-description="{{ $product['description'] }}"
                                    data-badge="{{ $product['badge'] ?? '' }}"
                                    data-category="{{ strtolower($product['category']) }}"
                                    data-color="{{ strtolower($product['color'] ?? '') }}"
                                    data-size="{{ strtolower($product['size'] ?? '') }}">
                                    <div
                                        class="absolute inset-0 z-20 flex items-center justify-center gap-2 opacity-0 pointer-events-none transition-opacity duration-300 group-hover:opacity-100">
                                        <button type="button"
                                            class="pointer-events-auto p-2 rounded-full bg-white/90 backdrop-blur border border-slate-200 text-slate-700 shadow hover:bg-white"
                                            aria-label="Add to wishlist" data-wishlist="{{ $product['id'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.0" stroke="currentColor"
                                                class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                            </svg>

                                        </button>
                                        <button type="button"
                                            class="pointer-events-auto p-2 rounded-full bg-white/90 backdrop-blur border border-slate-200 text-slate-700 shadow hover:bg-white"
                                            aria-label="Quick preview" data-preview="{{ $product['id'] }}"
                                            onclick="const dialog = document.getElementById('product-preview'); if (dialog) { dialog.showModal ? dialog.showModal() : dialog.setAttribute('open', 'open'); }">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                    <a class="block relative overflow-hidden h-64 bg-slate-100 group"
                                        href="{{ route('product.show', ['locale' => app()->getLocale(), 'slug' => $product['slug']]) }}">
                                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                                            loading="lazy"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        <div class="absolute top-3 left-3 flex flex-col gap-2">
                                            <div
                                                class="bg-blue-600/90 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                                {{ $product['category'] }}</div>
                                            @if (!empty($product['badge']))
                                                <div
                                                    class="bg-amber-500/90 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                                    {{ $product['badge'] }}</div>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="p-5 flex flex-col flex-1">
                                        <a class="hover:text-blue-600 transition-colors"
                                            href="{{ route('product.show', ['locale' => app()->getLocale(), 'slug' => $product['slug']]) }}">
                                            <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-1">
                                                {{ $product['name'] }}</h3>
                                        </a>
                                        <p class="text-slate-600 text-sm mb-4 line-clamp-2 flex-grow">
                                            {{ $product['description'] }}</p>
                                        <div class="flex items-center justify-between mt-auto">
                                            <span class="text-xl font-bold text-blue-600"><x-currency
                                                    :amount="number_format($product['price'], 2)" /></span>
                                            <div class="flex items-center gap-2">
                                                <x-button type="button" size="sm" variant="solid"
                                                    class="rounded-full px-4" data-add-to-cart>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="lucide lucide-shopping-cart w-4 h-4 mr-2"
                                                        data-cart-icon>
                                                        <circle cx="8" cy="21" r="1"></circle>
                                                        <circle cx="19" cy="21" r="1"></circle>
                                                        <path
                                                            d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12">
                                                        </path>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        class="hidden w-4 h-4 mr-2 text-emerald-500" data-check-icon>
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg>
                                                    Add
                                                </x-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="product-sentinel" class="h-10"></div>
                    </div>
                </div>
            </section>

            @php($previewProduct = $products[0] ?? null)
            <dialog id="product-preview"
                class="preview-dialog fixed inset-0 z-50 m-0 h-full w-full overflow-y-auto bg-transparent p-4 backdrop:bg-black/60 backdrop:backdrop-blur-sm">
                <div class="flex min-h-full items-center justify-center">
                    <div
                        class="preview-panel relative w-full max-w-4xl overflow-hidden rounded-3xl bg-white shadow-2xl">
                        <button type="button" data-preview-close
                            class="absolute right-4 top-4 inline-flex size-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-700"
                            onclick="const dialog = document.getElementById('product-preview'); if (dialog) { dialog.close ? dialog.close() : dialog.removeAttribute('open'); }">
                            <span class="sr-only">Close</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                aria-hidden="true" class="size-5">
                                <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </button>

                        <div class="grid gap-8 p-6 md:p-8 lg:grid-cols-[1fr,1.1fr]">
                            <div class="space-y-4">
                                <div class="overflow-hidden rounded-2xl bg-slate-100">
                                    <img data-preview-image
                                        src="{{ $previewProduct['image'] ?? '' }}"
                                        alt="{{ $previewProduct['name'] ?? '' }}" class="h-full w-full object-cover">
                                </div>
                                <div
                                    class="flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <span data-preview-badge
                                        class="rounded-full bg-amber-100 px-3 py-1 text-amber-700">{{ $previewProduct['badge'] ?? '' }}</span>
                                    <span data-preview-category
                                        class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">Category:
                                        {{ $previewProduct['category'] ?? '' }}</span>
                                    <span data-preview-color
                                        class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">Color: {{ $previewProduct['color'] ?? '' }}</span>
                                    <span data-preview-size
                                        class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">Size:
                                        {{ $previewProduct['size'] ?? '' }}</span>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <h2 data-preview-title class="text-2xl font-bold text-slate-900 md:text-3xl">
                                        {{ $previewProduct['name'] ?? '' }}</h2>
                                    <p data-preview-price class="text-xl font-semibold text-blue-600">
                                        <x-currency :amount="number_format($previewProduct['price'] ?? 0, 2)" />
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="flex items-center text-amber-400">
                                        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                            class="size-4">
                                            <path
                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                                clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                            class="size-4">
                                            <path
                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                                clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                            class="size-4">
                                            <path
                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                                clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                            class="size-4">
                                            <path
                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                                clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                                            class="size-4 text-slate-200">
                                            <path
                                                d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z"
                                                clip-rule="evenodd" fill-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-slate-500">3.9 out of 5</span>
                                    <a href="#"
                                        class="text-sm font-semibold text-blue-600 hover:text-blue-500">See all
                                        reviews</a>
                                </div>

                                <p data-preview-description class="text-slate-600">{{ $previewProduct['description'] ?? '' }}</p>

                                <div class="flex flex-wrap gap-3">
                                    <x-button type="button" size="lg" variant="solid"
                                        class="rounded-full px-6">Add to bag</x-button>
                                    <a data-preview-link href="{{ route('product.show', ['locale' => app()->getLocale(), 'slug' => $previewProduct['slug'] ?? '']) }}"
                                        class="inline-flex h-12 items-center justify-center rounded-full border border-slate-200 px-6 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">View
                                        full details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </dialog>
        </main>
    </div>
</x-layouts.app>

@push('scripts')
    <script>
        const setShopView = (view) => {
            const grid = document.querySelector('[data-product-grid]') || document.querySelector(
                '.lg\\:col-span-3 > .grid');
            if (!grid) return;
            const viewGridButton = document.querySelector('[data-view-grid]');
            const viewTwoColumnButton = document.querySelector('[data-view-two-column]');
            const viewListButton = document.querySelector('[data-view-list]');
            const gridColumnClasses = ['sm:grid-cols-2', 'lg:grid-cols-2', 'lg:grid-cols-3'];

            grid.dataset.view = view;
            grid.classList.remove(...gridColumnClasses);
            if (view === 'grid') {
                grid.classList.add('sm:grid-cols-2', 'lg:grid-cols-3');
            } else if (view === 'two-column') {
                grid.classList.add('sm:grid-cols-2', 'lg:grid-cols-2');
            }

            [viewGridButton, viewTwoColumnButton, viewListButton].forEach(button => {
                if (!button) return;
                const isActive = button.dataset.viewGrid !== undefined ? view === 'grid' :
                    button.dataset.viewTwoColumn !== undefined ? view === 'two-column' :
                    view === 'list';
                button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                button.classList.toggle('text-gray-900', isActive);
            });
        };

        window.setShopView = setShopView;

        const initShopPage = () => {
            const cards = Array.from(document.querySelectorAll('[data-product-card]'));
            const grid = document.querySelector('[data-product-grid]') || document.querySelector(
                '.lg\\:col-span-3 > .grid');
            const hasCards = cards.length > 0;
            const viewGridButton = document.querySelector('[data-view-grid]');
            const viewTwoColumnButton = document.querySelector('[data-view-two-column]');
            const viewListButton = document.querySelector('[data-view-list]');
            const gridColumnClasses = ['sm:grid-cols-2', 'lg:grid-cols-2', 'lg:grid-cols-3'];

            const mapCategory = (val) => ({
                'new-arrivals': 'interior',
                'sale': 'storage',
                'travel': 'electronics',
                'organization': 'car care',
                'accessories': 'tools',
            } [val] || val);
            const mapColor = (val) => ({
                'white': 'black',
                'beige': 'gray',
                'blue': 'multicolor',
                'brown': 'clear',
                'green': 'black',
                'purple': 'multicolor',
            } [val] || val);
            const mapSize = (val) => ({
                '2l': 'small',
                '6l': 'small',
                '12l': 'standard',
                '18l': 'standard',
                '20l': 'standard',
                '40l': 'standard',
            } [val] || val);

            const getChecked = (name, mapper = (v) => v) => Array.from(document.querySelectorAll(
                `input[name="${name}[]"]:checked`)).map(i => mapper(i.value.toLowerCase()));

            const applyFilters = () => {
                if (!hasCards) return;
                const categories = getChecked('category', mapCategory);
                const colors = getChecked('color', mapColor);
                const sizes = getChecked('size', mapSize);

                cards.forEach(card => {
                    const matchCategory = !categories.length || categories.includes(card.dataset.category);
                    const matchColor = !colors.length || colors.includes(card.dataset.color);
                    const matchSize = !sizes.length || sizes.includes(card.dataset.size);
                    card.style.display = (matchCategory && matchColor && matchSize) ? '' : 'none';
                });
            };

            const applySort = (sort) => {
                if (!hasCards || !grid) return;
                const visibleCards = cards.filter(c => c.style.display !== 'none');
                const sorter = {
                    'price-asc': (a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price),
                    'price-desc': (a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price),
                    'name-asc': (a, b) => a.dataset.name.localeCompare(b.dataset.name),
                } [sort];
                if (!sorter) return;
                visibleCards.sort(sorter).forEach(card => grid.appendChild(card));
            };

            document.querySelectorAll('input[name="category[]"], input[name="color[]"], input[name="size[]"]').forEach(
                input => {
                    input.addEventListener('change', applyFilters, {
                        passive: true
                    });
                });

            document.querySelectorAll('[data-sort]').forEach(link => {
                link.addEventListener('click', e => {
                    e.preventDefault();
                    const sort = link.dataset.sort;
                    if (sort === 'newest' || sort === 'popular' || sort === 'rating')
                        return; // not implemented
                    applySort(sort);
                });
            });

            const setActiveButton = (activeButton) => {
                [viewGridButton, viewTwoColumnButton, viewListButton].forEach(button => {
                    if (!button) return;
                    const isActive = button === activeButton;
                    button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
                    button.classList.toggle('text-gray-900', isActive);
                });
            };

            const applyGridView = () => {
                if (!grid) return;
                setShopView('grid');
            };

            const applyTwoColumnView = () => {
                if (!grid) return;
                setShopView('two-column');
            };

            const applyListView = () => {
                if (!grid) return;
                setShopView('list');
            };

            if (viewGridButton) {
                viewGridButton.addEventListener('click', () => {
                    applyGridView();
                });
            }
            if (viewTwoColumnButton) {
                viewTwoColumnButton.addEventListener('click', () => {
                    applyTwoColumnView();
                });
            }
            if (viewListButton) {
                viewListButton.addEventListener('click', () => {
                    applyListView();
                });
            }

            applyFilters();
            applyGridView();

            // Products are already rendered; keep the sentinel only if you want lazy-load effects later.
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initShopPage, {
                once: true
            });
        } else {
            initShopPage();
        }
    </script>
@endpush
