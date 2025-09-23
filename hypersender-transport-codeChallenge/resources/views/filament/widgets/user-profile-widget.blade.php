<x-filament::card class="py-2 px-4">
    <div class="flex flex-wrap items-center gap-4 justify-between">
        <!-- Left: Avatar and Info -->
        <div class="flex items-center gap-3">
            <img src="https://avatars.githubusercontent.com/Ahmed-Hany-Aou"
                 alt="Ahmed Hany Boshra"
                 class="w-10 h-10 rounded-full border border-blue-300" />
            <div>
                <span class="font-semibold text-base text-gray-700 block">Ahmed Hany Boshra</span>
                <span class="text-xs text-gray-500">Software Engineer</span>
            </div>
        </div>
        <!-- Right: Links & Contact -->
        <div class="flex items-center gap-3 text-sm flex-wrap">
            <a href="https://github.com/Ahmed-Hany-Aou" target="_blank" class="flex items-center gap-1 text-blue-700 hover:underline" title="GitHub">
                <x-heroicon-o-link class="w-4 h-4" /> GitHub
            </a>
            <a href="https://linkedin.com/in/ahmed-hany-aou" target="_blank" class="flex items-center gap-1 text-blue-700 hover:underline" title="LinkedIn">
                <x-heroicon-o-link class="w-4 h-4" /> LinkedIn
            </a>
            <a href="https://wa.me/201065232774" target="_blank" class="flex items-center gap-1 text-green-600 hover:underline" title="WhatsApp">
                <x-heroicon-o-phone class="w-4 h-4" /> <span>01065232774</span>
            </a>
        </div>
    </div>
</x-filament::card>
