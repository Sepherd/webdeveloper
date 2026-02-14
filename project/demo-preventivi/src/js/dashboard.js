async function getData(request) {
    const response = await fetch(`./api/get-data.php?request=${request}`);
    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }
    const data = await response.json();
    return data;
}

const prevListLayout = (quote) => {
    const quoteAmount = parseFloat(quote.total) || 0;
    const status = quote.status;
    let statusIcon, statusColor;
    switch (status) {
        case 'accepted':
            statusIcon = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>`;
            statusColor = 'accettati';
            break;
        case 'sent':
            statusIcon = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send w-4 h-4"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>`;
            statusColor = 'emissione';
            break;
        case 'rejected':
            statusIcon = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-circle w-4 h-4"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>`;
            statusColor = 'rifiutati';
            break;
        case 'draft':
            statusIcon = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file w-4 h-4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>`;
            statusColor = 'bozze';
            break;
        default:
            statusIcon = '';
            statusColor = 'slate-500';
    }
    return `
    <a class="flex items-center gap-4 p-3 rounded-lg hover:bg-${statusColor}/50 transition-colors" href="/dashboard/quotes/quote-${quote.id}">
        <div class="p-2 rounded-lg bg-${statusColor}/10 text-${statusColor}">
            ${statusIcon}
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2">
                <p class="font-medium text-foreground truncate">PRV-${quote.id}</p>
                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-xs bg-${statusColor}/10 text-${statusColor}">${status.charAt(0).toUpperCase() + status.slice(1)}</div>
            </div>
            <p class="text-sm text-muted-foreground truncate">${quote.clientName}</p>
        </div>
        <div class="text-right">
            <p class="font-medium text-foreground">${quoteAmount.toFixed(2).replace('.', ',')}€</p>
            <p class="text-xs text-muted-foreground">${quote.updatedAt}</p>
        </div>
    </a > `;
};

document.addEventListener('DOMContentLoaded', async function () {
    const totalQuotesElement = document.getElementById('total-quotes');
    const totalPendingElement = document.getElementById('total-pending');
    const draftsElement = document.getElementById('drafts');
    const sentElement = document.getElementById('sent');
    const totalAcceptedElement = document.getElementById('total-accepted');
    const acceptanceRateElement = document.getElementById('acceptance-rate');
    const fatturatoElement = document.getElementById('fatturato');
    try {
        const quotes = await getData('quotes');
        if (!Array.isArray(quotes)) {
            console.error('quotes non è un array:', quotes);
            return;
        }
        totalQuotesElement.textContent = quotes.length;
        const pending = quotes.filter(quote => quote.status !== 'accepted' && quote.status !== 'rejected');
        totalPendingElement.textContent = pending.length;
        const drafts = quotes.filter(quote => quote.status === 'draft');
        const sent = quotes.filter(quote => quote.status === 'sent');
        draftsElement.textContent = drafts.length === 1 ? '1 bozza' : `${drafts.length} bozze`;
        sentElement.textContent = sent.length === 1 ? '1 inviato' : `${sent.length} inviati`;
        const accepted = quotes.filter(quote => quote.status === 'accepted');
        totalAcceptedElement.textContent = accepted.length;
        const totalAcceptedAmount = accepted.reduce((sum, quote) => sum + (parseFloat(quote.total) || 0), 0);
        fatturatoElement.textContent = totalAcceptedAmount.toFixed(2).replace('.', ',') + '€';
        const totalActiveQuotes = accepted.length + sent.length;
        const acceptanceRate = quotes.length > 0 ? (accepted.length / totalActiveQuotes * 100).toFixed(2) : 0;
        acceptanceRateElement.textContent = `${acceptanceRate}% tasso di accettazione`;
        const ordinatedQuotes = quotes.sort((a, b) => new Date(b.updatedAt) - new Date(a.updatedAt));
        ordinatedQuotes.forEach(quote => {
            const quoteHTML = prevListLayout(quote);
            document.getElementById('recent-quotes').insertAdjacentHTML('beforeend', quoteHTML);
        });
    } catch (error) {
        console.error('Errore caricamento preventivi:', error);
        totalQuotesElement.textContent = '0';
        totalPendingElement.textContent = '0';
        draftsElement.textContent = '0 bozze';
        sentElement.textContent = '0 inviati';
        totalAcceptedElement.textContent = '0';
        fatturatoElement.textContent = '0,00€';
        acceptanceRateElement.textContent = '0% tasso di accettazione';
    }
});