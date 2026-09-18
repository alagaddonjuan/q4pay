<x-filament-widgets::widget>
    <x-filament::section class="border-blue-200 shadow-md">
        <x-slot name="heading">
            <div class="flex items-center gap-2 text-blue-700">
                <i class="las la-sparkles text-2xl"></i>
                <span class="font-bold text-lg">Irene's Insights</span>
            </div>
        </x-slot>

        <x-slot name="description">
            <div class="text-sm text-gray-500">
                AI-driven operational summary of your platform's current state.
            </div>
        </x-slot>

        <div class="space-y-4 mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($insights as $insight)
                @php
                    $bgColor = 'bg-gray-50';
                    $textColor = 'text-gray-800';
                    $borderColor = 'border-gray-200';
                    $iconColor = 'text-gray-500';

                    if ($insight['type'] === 'warning') {
                        $bgColor = 'bg-yellow-50';
                        $textColor = 'text-yellow-800';
                        $borderColor = 'border-yellow-200';
                        $iconColor = 'text-yellow-500';
                    } elseif ($insight['type'] === 'danger') {
                        $bgColor = 'bg-red-50';
                        $textColor = 'text-red-800';
                        $borderColor = 'border-red-200';
                        $iconColor = 'text-red-500';
                    } elseif ($insight['type'] === 'info') {
                        $bgColor = 'bg-blue-50';
                        $textColor = 'text-blue-800';
                        $borderColor = 'border-blue-200';
                        $iconColor = 'text-blue-500';
                    } elseif ($insight['type'] === 'success') {
                        $bgColor = 'bg-green-50';
                        $textColor = 'text-green-800';
                        $borderColor = 'border-green-200';
                        $iconColor = 'text-green-500';
                    }
                @endphp

                <div class="p-5 rounded-xl border {{ $bgColor }} {{ $borderColor }} flex flex-col justify-between transition-all hover:scale-[1.01] shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="shrink-0 p-3 bg-white rounded-full shadow-sm mt-1">
                            <i class="{{ $insight['icon'] }} text-3xl {{ $iconColor }}"></i>
                        </div>
                        <div class="{{ $textColor }} text-sm pt-1 leading-relaxed">
                            {!! \Illuminate\Support\Str::markdown($insight['message']) !!}
                        </div>
                    </div>
                    
                    @if(isset($insight['action_url']) && $insight['action_url'])
                        <div class="mt-4 flex justify-end w-full">
                            <a href="{{ $insight['action_url'] }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border {{ $borderColor }} rounded-lg text-sm font-medium {{ $textColor }} hover:bg-gray-50 transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2">
                                {{ $insight['action_label'] }}
                                <i class="las la-arrow-right ml-2"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
