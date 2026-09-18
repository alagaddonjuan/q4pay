<div id="aiChatWidgetContainer" class="font-sans" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999;">
    
    <!-- Floating Button -->
    <button id="aiChatWidgetBtn" onclick="toggleAiChatWidget()" class="bg-[#003366] text-white rounded-full shadow-2xl flex items-center justify-center hover:bg-blue-900 transition-all hover:scale-105 border-2 border-white/20" style="width: 56px; height: 56px;">
        <i class="las la-comment-dots text-3xl"></i>
    </button>

    <!-- Chat Popover Window -->
    <div id="aiChatWidgetWindow" class="hidden bg-white rounded-2xl shadow-2xl border border-slate-200 flex flex-col overflow-hidden transition-all duration-300" style="position: absolute; bottom: 100%; right: 0; margin-bottom: 16px; width: 380px; height: 550px; transform-origin: bottom right;">
        
        <!-- Header -->
        <div class="bg-[#003366] text-white p-4 flex justify-between items-center shrink-0">
            <div>
                <h4 class="font-bold text-lg flex items-center gap-2"><i class="las la-sparkles text-2xl text-blue-300"></i> Irene - AI Support</h4>
                <p class="text-xs text-blue-200">Intelligent, instant assistance</p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="showTicketList()" id="btnBackToTickets" class="hidden text-white/70 hover:text-white transition-colors">
                    <i class="las la-list text-xl"></i>
                </button>
                <button onclick="toggleAiChatWidget()" class="text-white/70 hover:text-white transition-colors">
                    <i class="las la-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Ticket List View -->
        <div id="aiChatTicketListView" class="flex-1 overflow-y-auto bg-slate-50 p-4">
            <button onclick="showNewTicketForm()" class="w-full bg-white border border-dashed border-[#003366] text-[#003366] rounded-xl p-3 font-bold hover:bg-blue-50 transition-colors mb-4 flex items-center justify-center gap-2">
                <i class="las la-plus text-lg"></i> Start New Conversation
            </button>
            
            <div id="aiChatTicketList" class="space-y-3">
                <!-- Loaded via JS -->
                <div class="text-center py-8 text-slate-400 text-sm">
                    <i class="las la-spinner la-spin text-2xl mb-2"></i><br>Loading your history...
                </div>
            </div>
        </div>

        <!-- New Ticket Form -->
        <div id="aiChatNewTicketView" class="hidden flex-1 overflow-y-auto bg-white p-4 flex flex-col">
            <form onsubmit="createWidgetTicket(event)" class="space-y-4 flex-1">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">What is this regarding?</label>
                    <input type="text" id="widgetTicketSubject" required placeholder="E.g., Virtual Account Issue" class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-[#003366]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Your Message</label>
                    <textarea id="widgetTicketMessage" required rows="4" placeholder="Please describe the issue..." class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:border-[#003366]"></textarea>
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="showTicketList()" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 font-bold rounded-lg text-sm hover:bg-slate-200">Cancel</button>
                    <button type="submit" id="widgetCreateBtn" class="flex-1 px-4 py-2 bg-[#003366] text-white font-bold rounded-lg text-sm hover:bg-blue-900">Start Chat</button>
                </div>
            </form>
        </div>

        <!-- Active Chat View -->
        <div id="aiChatActiveView" class="hidden flex-1 flex flex-col bg-slate-50 relative overflow-hidden">
            
            <div class="bg-white border-b border-slate-100 p-2 px-4 flex justify-between items-center text-xs shrink-0 shadow-sm z-10">
                <span class="font-bold text-slate-700 truncate w-2/3" id="widgetChatSubject">...</span>
                <span id="widgetChatStatusBadge"></span>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="widgetChatMessages">
                <!-- Messages injected here -->
            </div>

            <div class="bg-white border-t border-slate-100 p-3 shrink-0" style="border-top: 1px solid #e2e8f0;">
                <form id="widgetChatForm" onsubmit="sendWidgetMessage(event)" class="flex gap-2 relative">
                    <input type="text" id="widgetChatInput" required placeholder="Reply to Irene..." class="flex-1 bg-slate-50 rounded-full px-4 py-2 text-sm focus:outline-none pr-10" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                    <button type="submit" id="widgetChatSubmitBtn" class="absolute bg-[#003366] text-white rounded-full flex items-center justify-center hover:bg-blue-900 transition-colors" style="width: 30px; height: 30px; right: 6px; top: 5px;">
                        <i class="las la-paper-plane"></i>
                    </button>
                </form>
                <div class="text-[10px] text-slate-400 mt-2 text-center">
                    Need human help? Type "escalate".
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let widgetPollInterval = null;
    let widgetCurrentRef = null;

    function toggleAiChatWidget() {
        const win = document.getElementById('aiChatWidgetWindow');
        const icon = document.querySelector('#aiChatWidgetBtn i');
        if (win.classList.contains('hidden')) {
            win.classList.remove('hidden');
            icon.classList.remove('la-comment-dots');
            icon.classList.add('la-times');
            loadAllTickets();
        } else {
            win.classList.add('hidden');
            icon.classList.add('la-comment-dots');
            icon.classList.remove('la-times');
            if (widgetPollInterval) clearInterval(widgetPollInterval);
        }
    }

    function showTicketList() {
        document.getElementById('aiChatTicketListView').classList.remove('hidden');
        document.getElementById('aiChatNewTicketView').classList.add('hidden');
        document.getElementById('aiChatActiveView').classList.add('hidden');
        document.getElementById('btnBackToTickets').classList.add('hidden');
        if (widgetPollInterval) clearInterval(widgetPollInterval);
        widgetCurrentRef = null;
        loadAllTickets();
    }

    function showNewTicketForm() {
        document.getElementById('aiChatTicketListView').classList.add('hidden');
        document.getElementById('aiChatNewTicketView').classList.remove('hidden');
        document.getElementById('aiChatActiveView').classList.add('hidden');
        document.getElementById('btnBackToTickets').classList.remove('hidden');
    }

    async function loadAllTickets() {
        try {
            // Re-using the index route to get JSON if requested via AJAX
            const response = await fetch(`/merchant/support/chat`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json();
            const listDiv = document.getElementById('aiChatTicketList');
            
            if(data.tickets.length === 0) {
                listDiv.innerHTML = `<div class="text-center py-8 text-slate-400 text-sm">No conversations yet.</div>`;
                return;
            }

            let html = '';
            data.tickets.forEach(ticket => {
                let badge = '';
                if(ticket.status === 'open') badge = `<span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-[10px] font-bold">AI Active</span>`;
                else if(ticket.status === 'escalated') badge = `<span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-[10px] font-bold">Agent</span>`;
                else badge = `<span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-[10px] font-bold">Resolved</span>`;

                html += `
                <div onclick="openWidgetChat('${ticket.reference}')" class="bg-white border border-slate-100 p-3 rounded-xl cursor-pointer hover:shadow-md transition-all hover:border-blue-100">
                    <div class="flex justify-between items-start mb-1">
                        <span class="font-bold text-slate-700 text-sm truncate pr-2">${ticket.subject}</span>
                        ${badge}
                    </div>
                    <div class="text-xs text-slate-500">${ticket.reference}</div>
                </div>`;
            });
            listDiv.innerHTML = html;
        } catch (error) {
            console.error('Error loading tickets:', error);
        }
    }

    async function createWidgetTicket(e) {
        e.preventDefault();
        const subject = document.getElementById('widgetTicketSubject').value;
        const message = document.getElementById('widgetTicketMessage').value;
        const btn = document.getElementById('widgetCreateBtn');
        
        btn.disabled = true;
        btn.innerHTML = 'Starting...';
        
        try {
            const response = await fetch(`/merchant/support/chat/tickets`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ subject, message })
            });
            
            const data = await response.json();
            if(data.success) {
                document.getElementById('widgetTicketSubject').value = '';
                document.getElementById('widgetTicketMessage').value = '';
                openWidgetChat(data.ticket.reference);
            }
        } catch(error) {
            alert('Failed to create ticket.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Start Chat';
        }
    }

    async function openWidgetChat(reference) {
        document.getElementById('aiChatTicketListView').classList.add('hidden');
        document.getElementById('aiChatNewTicketView').classList.add('hidden');
        document.getElementById('aiChatActiveView').classList.remove('hidden');
        document.getElementById('btnBackToTickets').classList.remove('hidden');
        
        widgetCurrentRef = reference;
        document.getElementById('widgetChatMessages').innerHTML = '<div class="text-center py-4"><i class="las la-spinner la-spin text-xl text-blue-500"></i></div>';
        
        await fetchWidgetMessages();
        
        if (widgetPollInterval) clearInterval(widgetPollInterval);
        widgetPollInterval = setInterval(fetchWidgetMessages, 3000);
    }

    async function fetchWidgetMessages() {
        if (!widgetCurrentRef) return;
        
        try {
            const response = await fetch(`/merchant/support/chat/tickets/${widgetCurrentRef}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json();
            
            document.getElementById('widgetChatSubject').innerText = data.ticket.subject;
            
            const statusDiv = document.getElementById('widgetChatStatusBadge');
            const input = document.getElementById('widgetChatInput');
            if(data.ticket.status === 'open') {
                statusDiv.innerHTML = `<span class="text-blue-600 font-bold"><i class="las la-sparkles"></i> Irene</span>`;
                input.disabled = false;
            } else if(data.ticket.status === 'escalated') {
                statusDiv.innerHTML = `<span class="text-yellow-600 font-bold"><i class="las la-user"></i> Agent</span>`;
                input.disabled = false;
            } else {
                statusDiv.innerHTML = `<span class="text-green-600 font-bold"><i class="las la-check-circle"></i> Resolved</span>`;
                input.disabled = true;
                input.placeholder = "Ticket is resolved.";
            }

            const messagesDiv = document.getElementById('widgetChatMessages');
            let html = '';
            
            data.messages.forEach(msg => {
                const isMerchant = msg.sender_type === 'merchant';
                const isSystem = msg.sender_type === 'system';
                
                if (isSystem) {
                    html += `
                        <div class="flex justify-center my-4">
                            <div class="text-[11px] px-4 py-1.5 rounded-full font-medium text-center shadow-sm" style="background-color: #fefce8; color: #854d0e; border: 1px solid #fef08a;">
                                <i class="las la-info-circle mr-1"></i> ${msg.message}
                            </div>
                        </div>
                    `;
                } else {
                    const alignment = isMerchant ? 'justify-end' : 'justify-start';
                    
                    // Default merchant styles (inline so they never break)
                    let bubbleStyle = 'background-color: #003366; color: white; border-bottom-right-radius: 4px;';
                    
                    if (!isMerchant) {
                        if (msg.sender_type === 'admin') {
                            bubbleStyle = 'background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; border-bottom-left-radius: 4px;';
                        } else {
                            // AI (Irene)
                            bubbleStyle = 'background-color: #eff6ff; color: #1e3a8a; border: 1px solid #bfdbfe; border-bottom-left-radius: 4px;';
                        }
                    }
                    
                    let avatar = '';
                    if (!isMerchant) {
                        if (msg.sender_type === 'admin') {
                            avatar = `<div class="rounded-full flex items-center justify-center mr-2 shrink-0 shadow-sm" style="width: 28px; height: 28px; background-color: #dcfce7; color: #166534;"><i class="las la-user-tie text-sm"></i></div>`;
                        } else {
                            // AI Avatar
                            avatar = `<div class="rounded-full flex items-center justify-center mr-2 shrink-0 shadow-sm" style="width: 28px; height: 28px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white;"><i class="las la-sparkles text-sm"></i></div>`;
                        }
                    }
                    
                    html += `
                        <div class="flex ${alignment} w-full mb-4" style="align-items: flex-end;">
                            ${avatar}
                            <div class="px-3.5 py-2.5 rounded-2xl max-w-[85%] text-sm shadow-sm" style="${bubbleStyle}">
                                ${msg.message.replace(/\n/g, '<br>')}
                            </div>
                        </div>
                    `;
                }
            });
            
            // Only update DOM if HTML changed or initially
            if(messagesDiv.innerHTML !== html || messagesDiv.innerHTML.includes('la-spinner')) {
                const isAtBottom = messagesDiv.scrollHeight - messagesDiv.scrollTop <= messagesDiv.clientHeight + 50;
                messagesDiv.innerHTML = html;
                if(isAtBottom) {
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                }
            }
            
        } catch (error) {
            console.error('Error fetching messages:', error);
        }
    }

    async function sendWidgetMessage(e) {
        e.preventDefault();
        if(!widgetCurrentRef) return;
        
        const input = document.getElementById('widgetChatInput');
        const message = input.value;
        const btn = document.getElementById('widgetChatSubmitBtn');
        
        if(!message.trim()) return;
        
        input.disabled = true;
        btn.disabled = true;
        btn.innerHTML = '<i class="las la-spinner la-spin"></i>';
        
        try {
            await fetch(`/merchant/support/chat/tickets/${widgetCurrentRef}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message })
            });
            
            input.value = '';
            await fetchWidgetMessages();
            const messagesDiv = document.getElementById('widgetChatMessages');
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        } catch(error) {
            alert('Failed to send message.');
        } finally {
            input.disabled = false;
            btn.disabled = false;
            btn.innerHTML = '<i class="las la-paper-plane"></i>';
            input.focus();
        }
    }
</script>
