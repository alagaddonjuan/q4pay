<div class="border border-gray-200 rounded-xl overflow-hidden bg-gray-50 p-4">
    <div class="flex flex-col gap-4 max-h-[500px] overflow-y-auto">
        @php
            $messages = $getRecord()->messages()->orderBy('created_at', 'asc')->get();
        @endphp

        @if($messages->isEmpty())
            <div class="text-center text-gray-500 py-8">
                No messages found for this ticket.
            </div>
        @else
            @foreach($messages as $msg)
                @php
                    $isSystem = $msg->sender_type === 'system';
                    $isAdmin = $msg->sender_type === 'admin';
                    $isMerchant = $msg->sender_type === 'merchant';
                    $isAi = $msg->sender_type === 'ai';
                @endphp

                @if($isSystem)
                    <div class="flex justify-center my-2">
                        <div class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-medium">
                            {{ $msg->message }}
                        </div>
                    </div>
                @else
                    <div class="flex w-full {{ $isMerchant ? 'justify-start' : 'justify-end' }}">
                        <div class="flex max-w-[80%] {{ $isMerchant ? 'flex-row' : 'flex-row-reverse' }} items-end gap-2">
                            
                            <!-- Avatar -->
                            <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 text-white font-bold text-xs
                                {{ $isMerchant ? 'bg-gray-400' : ($isAdmin ? 'bg-indigo-600' : 'bg-blue-500') }}">
                                @if($isMerchant) M
                                @elseif($isAdmin) A
                                @else AI
                                @endif
                            </div>

                            <!-- Bubble -->
                            <div class="px-4 py-3 rounded-2xl shadow-sm text-sm
                                {{ $isMerchant ? 'bg-white border border-gray-200 text-gray-800 rounded-bl-none' : 'bg-indigo-600 text-white rounded-br-none' }}">
                                {!! nl2br(e($msg->message)) !!}
                                <div class="text-[10px] mt-1 opacity-70 {{ $isMerchant ? 'text-gray-500' : 'text-indigo-200 text-right' }}">
                                    {{ $msg->created_at->format('M d, h:i A') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
