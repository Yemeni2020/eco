<div class="space-y-6" x-data="{ tab: @entangle('activeTab') }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $product ? 'Edit Product' : 'Create Product' }}</h1>
            <p class="text-sm text-slate-500">Advanced product editor with options, variants, media, and inventory.</p>
        </div>
        <button wire:click="save"
            class="rounded-lg bg-slate-900 text-white px-4 py-2 text-sm font-semibold hover:bg-slate-800">
            Save
        </button>
    </div>

    <div class="flex flex-wrap gap-2">
        @foreach (['basic' => 'Basic', 'options' => 'Options', 'variants' => 'Variants', 'media' => 'Media', 'attributes' => 'Attributes'] as $key => $label)
            <button type="button"
                class="rounded-full px-4 py-2 text-sm font-semibold border {{ $activeTab === $key ? 'border-blue-500 text-blue-600' : 'border-slate-200 text-slate-600' }}"
                @click="tab = '{{ $key }}'">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div x-show="tab === 'basic'" class="space-y-6">
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <h3 class="text-sm font-semibold text-slate-600">Arabic</h3>
                <input type="text" wire:model.defer="name_translations.ar" placeholder="الاسم"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                <input type="text" wire:model.defer="slug_translations.ar" placeholder="الاسم اللطيف"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                <textarea wire:model.defer="summary_translations.ar" placeholder="ملخص"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" rows="3"></textarea>
                <textarea wire:model.defer="description_translations.ar" placeholder="وصف"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" rows="4"></textarea>
            </div>
            <div class="space-y-3">
                <h3 class="text-sm font-semibold text-slate-600">English</h3>
                <input type="text" wire:model.defer="name_translations.en" placeholder="Name"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                <input type="text" wire:model.defer="slug_translations.en" placeholder="Slug"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                <textarea wire:model.defer="summary_translations.en" placeholder="Summary"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" rows="3"></textarea>
                <textarea wire:model.defer="description_translations.en" placeholder="Description"
                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" rows="4"></textarea>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <label class="text-sm font-semibold text-slate-600">Category</label>
                <select wire:model="category_id" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-3">
                <label class="text-sm font-semibold text-slate-600">Status</label>
                <select wire:model="status" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                    <option value="ACTIVE">ACTIVE</option>
                    <option value="DRAFT">DRAFT</option>
                </select>
                <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" wire:model="is_active" class="rounded border-slate-300">
                    Active
                </label>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <input type="number" step="0.01" wire:model.defer="price" placeholder="Price"
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
            <input type="number" step="0.01" wire:model.defer="compare_at_price" placeholder="Compare at"
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
            <input type="text" wire:model.defer="sku" placeholder="Base SKU"
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <input type="number" wire:model.defer="stock" placeholder="Stock"
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
            <input type="number" wire:model.defer="reserved_stock" placeholder="Reserved"
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
            <input type="number" wire:model.defer="weight_grams" placeholder="Weight (g)"
                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
        </div>
    </div>

    <div x-show="tab === 'options'" class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">Options</h2>
            <button type="button" wire:click="addOption"
                class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-600">
                Add Option
            </button>
        </div>

        @foreach ($options as $optionIndex => $option)
            <div class="rounded-xl border border-slate-200 bg-white p-4 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="grid md:grid-cols-3 gap-3 flex-1">
                        <input type="text" wire:model.defer="options.{{ $optionIndex }}.code" placeholder="code"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <input type="text" wire:model.defer="options.{{ $optionIndex }}.name_translations.en" placeholder="Name (EN)"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <input type="text" wire:model.defer="options.{{ $optionIndex }}.name_translations.ar" placeholder="Name (AR)"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                    </div>
                    <button type="button" wire:click="removeOption({{ $optionIndex }})"
                        class="text-rose-500 text-sm font-semibold">Remove</button>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-slate-600">Values</h3>
                        <button type="button" wire:click="addOptionValue({{ $optionIndex }})"
                            class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600">
                            Add Value
                        </button>
                    </div>
                    <div class="space-y-2">
                        @foreach ($option['values'] as $valueIndex => $value)
                            <div class="grid md:grid-cols-5 gap-2">
                                <input type="text" wire:model.defer="options.{{ $optionIndex }}.values.{{ $valueIndex }}.value" placeholder="value"
                                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                                <input type="text" wire:model.defer="options.{{ $optionIndex }}.values.{{ $valueIndex }}.label_translations.en" placeholder="Label (EN)"
                                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                                <input type="text" wire:model.defer="options.{{ $optionIndex }}.values.{{ $valueIndex }}.label_translations.ar" placeholder="Label (AR)"
                                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                                <input type="text" wire:model.defer="options.{{ $optionIndex }}.values.{{ $valueIndex }}.swatch_hex" placeholder="Swatch #"
                                    class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                                <button type="button" wire:click="removeOptionValue({{ $optionIndex }}, {{ $valueIndex }})"
                                    class="text-rose-500 text-xs font-semibold">Remove</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div x-show="tab === 'variants'" class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">Variants</h2>
            <div class="flex items-center gap-2">
                <button type="button" wire:click="generateVariants"
                    class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600">
                    Generate Color x Size
                </button>
                <button type="button" wire:click="addVariant"
                    class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600">
                    Add Variant
                </button>
            </div>
        </div>

        <div class="space-y-4">
            @foreach ($variants as $variantIndex => $variant)
                <div class="rounded-xl border border-slate-200 bg-white p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="grid md:grid-cols-4 gap-2 flex-1">
                            <input type="text" wire:model.defer="variants.{{ $variantIndex }}.sku" placeholder="SKU"
                                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                            <input type="number" wire:model.defer="variants.{{ $variantIndex }}.price_cents" placeholder="Price cents"
                                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                            <input type="number" wire:model.defer="variants.{{ $variantIndex }}.compare_at_cents" placeholder="Compare cents"
                                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                            <input type="number" wire:model.defer="variants.{{ $variantIndex }}.sale_cents" placeholder="Sale cents"
                                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        </div>
                        <button type="button" wire:click="removeVariant({{ $variantIndex }})"
                            class="text-rose-500 text-sm font-semibold">Remove</button>
                    </div>

                    <div class="grid md:grid-cols-3 gap-2">
                        @foreach ($options as $option)
                            <select wire:model="variants.{{ $variantIndex }}.option_values.{{ $option['code'] }}"
                                class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                                <option value="">Select {{ $option['code'] }}</option>
                                @foreach ($option['values'] as $value)
                                    <option value="{{ $value['value'] }}">{{ $value['label'] ?? $value['value'] }}</option>
                                @endforeach
                            </select>
                        @endforeach
                    </div>

                    <div class="grid md:grid-cols-4 gap-2">
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" wire:model.defer="variants.{{ $variantIndex }}.has_sensor" class="rounded border-slate-300">
                            Has sensor
                        </label>
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" wire:model.defer="variants.{{ $variantIndex }}.is_active" class="rounded border-slate-300">
                            Active
                        </label>
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" wire:model.defer="variants.{{ $variantIndex }}.track_inventory" class="rounded border-slate-300">
                            Track inventory
                        </label>
                        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" wire:model.defer="variants.{{ $variantIndex }}.allow_backorder" class="rounded border-slate-300">
                            Allow backorder
                        </label>
                    </div>

                    <div class="grid md:grid-cols-4 gap-2">
                        <input type="number" wire:model.defer="variants.{{ $variantIndex }}.low_stock_threshold" placeholder="Low stock threshold"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <input type="number" wire:model.defer="variants.{{ $variantIndex }}.weight_grams" placeholder="Weight g"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <input type="number" wire:model.defer="variants.{{ $variantIndex }}.length_mm" placeholder="Length mm"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <input type="number" wire:model.defer="variants.{{ $variantIndex }}.width_mm" placeholder="Width mm"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                    </div>

                    <div class="grid md:grid-cols-3 gap-2">
                        <input type="number" wire:model.defer="variants.{{ $variantIndex }}.height_mm" placeholder="Height mm"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <input type="number" wire:model.defer="variants.{{ $variantIndex }}.inventory.on_hand" placeholder="On hand (MAIN)"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <input type="number" wire:model.defer="variants.{{ $variantIndex }}.inventory.reserved" placeholder="Reserved (MAIN)"
                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div x-show="tab === 'media'" class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">Media</h2>
            <button type="button" wire:click="addMedia"
                class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600">
                Add Media
            </button>
        </div>

        @foreach ($media as $mediaIndex => $item)
            <div class="rounded-xl border border-slate-200 bg-white p-4 space-y-3">
                <div class="grid md:grid-cols-3 gap-2">
                    <input type="text" wire:model.defer="media.{{ $mediaIndex }}.url" placeholder="Image URL"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                    <input type="text" wire:model.defer="media.{{ $mediaIndex }}.alt_text" placeholder="Alt text"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                    <select wire:model.defer="media.{{ $mediaIndex }}.type"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <option value="image">IMAGE</option>
                        <option value="video">VIDEO</option>
                        <option value="model_3d">MODEL_3D</option>
                    </select>
                </div>
                <div class="grid md:grid-cols-4 gap-2">
                    <input type="number" wire:model.defer="media.{{ $mediaIndex }}.position" placeholder="Position"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                    <select wire:model.defer="media.{{ $mediaIndex }}.option_value_id"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <option value="">Assign Color (optional)</option>
                        @foreach ($options as $option)
                            @foreach ($option['values'] as $value)
                                <option value="{{ $value['id'] }}">{{ $option['code'] }}: {{ $value['label'] ?? $value['value'] }}</option>
                            @endforeach
                        @endforeach
                    </select>
                    <select wire:model.defer="media.{{ $mediaIndex }}.variant_sku"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <option value="">Assign Variant (optional)</option>
                        @foreach ($variants as $variant)
                            <option value="{{ $variant['sku'] }}">{{ $variant['sku'] }}</option>
                        @endforeach
                    </select>
                    <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" wire:model.defer="media.{{ $mediaIndex }}.is_primary" class="rounded border-slate-300">
                        Primary
                    </label>
                </div>
                <button type="button" wire:click="removeMedia({{ $mediaIndex }})"
                    class="text-rose-500 text-xs font-semibold">Remove Media</button>
            </div>
        @endforeach
    </div>

    <div x-show="tab === 'attributes'" class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-800">Attributes</h2>
            <button type="button" wire:click="addAttribute"
                class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600">
                Add Attribute
            </button>
        </div>

        @foreach ($productAttributes as $attrIndex => $attribute)
            <div class="rounded-xl border border-slate-200 bg-white p-4 space-y-3">
                <div class="grid md:grid-cols-3 gap-2">
                    <select wire:model.defer="productAttributes.{{ $attrIndex }}.definition_key"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <option value="">Select attribute</option>
                        @foreach ($attributeDefinitions as $definition)
                            <option value="{{ $definition['key'] }}">{{ $definition['label'] }}</option>
                        @endforeach
                    </select>
                    <input type="text" wire:model.defer="productAttributes.{{ $attrIndex }}.value" placeholder="Value or JSON"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                    <select wire:model.defer="productAttributes.{{ $attrIndex }}.variant_sku"
                        class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                        <option value="">Product-level</option>
                        @foreach ($variants as $variant)
                            <option value="{{ $variant['sku'] }}">{{ $variant['sku'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" wire:click="removeAttribute({{ $attrIndex }})"
                    class="text-rose-500 text-xs font-semibold">Remove Attribute</button>
            </div>
        @endforeach
    </div>
</div>
