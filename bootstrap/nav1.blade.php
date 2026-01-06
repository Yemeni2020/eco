{{-- <flux:navbar class="flex justify-center navbar bg-base-100 shadow-sm">
    <div class="flex ">
        <a class="btn btn-ghost text-xl">daisyUI</a>
    </div>
    <flux:navbar.item href="#" class="text-lg">Home</flux:navbar.item>
    <flux:navbar.item href="#" class="text-lg">Features</flux:navbar.item>
    <flux:navbar.item href="#" class="text-lg">Pricing</flux:navbar.item>
    <flux:navbar.item href="#" class="text-lg">About</flux:navbar.item>
    <flux:dropdown>
        <flux:navbar.item icon:trailing="chevron-down">Account</flux:navbar.item>
        <flux:navmenu>
            <flux:navmenu.item href="#" class="text-lg">Profile</flux:navmenu.item>
            <flux:navmenu.item href="#" class="text-lg">Settings</flux:navmenu.item>
            <flux:navmenu.item href="#" class="text-lg">Billing</flux:navmenu.item>
        </flux:navmenu>
    </flux:dropdown>

    <flux:dropdown x-data align="end" position="bottom end">
        <flux:button variant="subtle" square class="group" aria-label="Preferred color scheme">
            <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini" class="text-zinc-500 dark:text-white" />
            <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini" class="text-zinc-500 dark:text-white" />
            <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" variant="mini" />
            <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini" />
        </flux:button>
        <flux:menu>
            <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
            <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
            <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System</flux:menu.item>
        </flux:menu>
    </flux:dropdown>
    <flux:dropdown>
        <flux:navbar.item icon:trailing="chevron-down">Account</flux:navbar.item>
        <flux:navmenu>
            <flux:navmenu.item href="#">Profile</flux:navmenu.item>
            <flux:navmenu.item href="#">Settings</flux:navmenu.item>
            <flux:navmenu.item href="#">Billing</flux:navmenu.item>
        </flux:navmenu>
    </flux:dropdown>
    
</flux:navbar> --}}
