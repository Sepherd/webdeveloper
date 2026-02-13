<?php
require_once __DIR__ . '/../app/helpers.php';
sessionChecker();

if (!isset($_SESSION['demo']['account']) && $_GET['page'] !== 'login') {
    header('Location: index.php?page=login');
    exit;
}
$account = $_SESSION['demo']['account'] ?? [];
$clients = $_SESSION['demo']['clients'] ?? [];
$quotes = $_SESSION['demo']['quotes'] ?? [];
$services = $_SESSION['demo']['service'] ?? [];
$categories = $_SESSION['demo']['categories'] ?? [];

$theme = $account['theme'] ?? '';

?>
<div class="min-h-screen bg-background flex" data-theme="<?php echo $account['theme'] ?? 'default'; ?>">
    <aside class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-primary-700 flex flex-col transform transition-transform duration-200 ease-in-out lg:transform-none -translate-x-full lg:translate-x-0">
        <div class="p-4 border-b border-primary-600">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center">
                    <span class="text-sm font-medium text-slate-100">
                        <svg class="size-6 shrink-0">
                            <use href="<?php echo $account['icon']; ?>"></use>
                        </svg>
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-100 truncate"><?php echo echoAccount('name'); ?></p>
                    <p class="text-xs text-slate-100/60"><?php echo echoAccount('description'); ?></p>
                </div>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1"><a aria-current="page" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors bg-primary-500 text-slate-100 active" href="/dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard w-5 h-5">
                    <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                    <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                    <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                    <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                </svg>Dashboard</a><a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors text-slate-100/70 hover:text-slate-100 hover:bg-primary-500/50" href="/dashboard/quotes"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text w-5 h-5">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                    <path d="M10 9H8"></path>
                    <path d="M16 13H8"></path>
                    <path d="M16 17H8"></path>
                </svg>Preventivi</a><a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors text-slate-100/70 hover:text-slate-100 hover:bg-primary-500/50" href="/dashboard/clients"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-5 h-5">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>Clienti</a><a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors text-slate-100/70 hover:text-slate-100 hover:bg-primary-500/50" href="/dashboard/services"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package w-5 h-5">
                    <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path>
                    <path d="M12 22V12"></path>
                    <path d="m3.3 7 7.703 4.734a2 2 0 0 0 1.994 0L20.7 7"></path>
                    <path d="m7.5 4.27 9 5.15"></path>
                </svg>Servizi</a><a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors text-slate-100/70 hover:text-slate-100 hover:bg-primary-500/50" href="/dashboard/settings"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings w-5 h-5">
                    <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>Impostazioni</a></nav>
        <div class="p-4 border-t border-primary-600"><button class="inline-flex items-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 h-10 px-4 py-2 w-full justify-start text-slate-100/70 hover:text-slate-100 hover:bg-primary-500/50"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out w-5 h-5 mr-3">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" x2="9" y1="12" y2="12"></line>
                </svg>Esci</button></div>
    </aside>
    <div class="flex-1 flex flex-col md:flex-none min-h-screen">
        <header class="h-16 lg:hidden bg-card border-b flex items-center justify-between px-4 lg:px-6">
            <div class="flex items-center gap-4">
                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-10 w-10 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu w-5 h-5">
                        <line x1="4" x2="20" y1="12" y2="12"></line>
                        <line x1="4" x2="20" y1="6" y2="6"></line>
                        <line x1="4" x2="20" y1="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-400 hidden sm:block">
                    <?= echoAccount('email'); ?>
                </span>
            </div>
        </header>
        <main class="flex-1 p-4 lg:p-6 overflow-auto">
            <div class="space-y-6 animate-fade-in">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Benvenuto, <?php echo echoAccount('name'); ?></h1>
                        <p class="text-slate-500">
                            <?php echo echoAccount('attivita'); ?>
                        </p>
                    </div>
                    <a href="/dashboard/quotes/new">
                        <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary-700 text-primary-50 hover:bg-primary-600/90 h-10 px-4 py-2 gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus w-4 h-4">
                                <path d="M5 12h14"></path>
                                <path d="M12 5v14"></path>
                            </svg>
                            Nuovo Preventivo
                        </button>
                    </a>
                </div>
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-lg border border-card-border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-muted-foreground">Preventivi Emessi</p>
                                    <p class="text-3xl font-bold text-foreground mt-1"><?= count($quotes); ?></p>
                                </div>
                                <div class="p-3 rounded-xl bg-emissione/10 text-emissione">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text w-6 h-6 text-primary">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M10 9H8"></path>
                                        <path d="M16 13H8"></path>
                                        <path d="M16 17H8"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-lg border border-card-border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-muted-foreground">In Attesa</p>
                                    <p class="text-3xl font-bold text-foreground mt-1">2</p>
                                </div>
                                <div class="p-3 rounded-xl bg-warning/10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-6 h-6 text-warning">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg></div>
                            </div>
                            <div class="flex gap-2 mt-3">
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 text-xs">1 bozze</div>
                                <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 text-xs">1 inviati</div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-lg border border-card-border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-muted-foreground">Accettati</p>
                                    <p class="text-3xl font-bold text-foreground mt-1">1</p>
                                </div>
                                <div class="p-3 rounded-xl bg-success/10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-6 h-6 text-success">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg></div>
                            </div>
                            <p class="text-xs text-muted-foreground mt-3">33% tasso di accettazione</p>
                        </div>
                    </div>
                    <div class="rounded-lg border border-card-border bg-card text-card-foreground shadow-sm">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-muted-foreground">Fatturato Accettato</p>
                                    <p class="text-2xl font-bold text-foreground mt-1">8120,32&nbsp;€</p>
                                </div>
                                <div class="p-3 rounded-xl bg-accent/10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-6 h-6 text-accent">
                                        <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                        <polyline points="16 7 22 7 22 13"></polyline>
                                    </svg></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg border border-card-border bg-card text-card-foreground shadow-sm">
                    <div class="space-y-1.5 p-6 flex flex-row items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-semibold leading-none tracking-tight">Preventivi Recenti</h3>
                            <p class="text-sm text-muted-foreground">Ultimi preventivi aggiornati</p>
                        </div><a href="/dashboard/quotes"><button class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 gap-1">Vedi tutti<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></button></a>
                    </div>
                    <div class="p-6 pt-0">
                        <div class="space-y-3"><a class="flex items-center gap-4 p-3 rounded-lg hover:bg-muted/50 transition-colors" href="/dashboard/quotes/quote-wa-3">
                                <div class="p-2 rounded-lg bg-muted text-muted-foreground"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-4 h-4">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="font-medium text-foreground truncate">PRV-2024-003</p>
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-xs bg-muted text-muted-foreground">Bozza</div>
                                    </div>
                                    <p class="text-sm text-muted-foreground truncate">Studio Legale Bianchi</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-foreground">3050,00&nbsp;€</p>
                                    <p class="text-xs text-muted-foreground">15/03/2024</p>
                                </div>
                            </a><a class="flex items-center gap-4 p-3 rounded-lg hover:bg-muted/50 transition-colors" href="/dashboard/quotes/quote-wa-2">
                                <div class="p-2 rounded-lg bg-primary/10 text-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send w-4 h-4">
                                        <path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"></path>
                                        <path d="m21.854 2.147-10.94 10.939"></path>
                                    </svg></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="font-medium text-foreground truncate">PRV-2024-002</p>
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-xs bg-primary/10 text-primary">Inviato</div>
                                    </div>
                                    <p class="text-sm text-muted-foreground truncate">Ristorante Da Luigi</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-foreground">6710,00&nbsp;€</p>
                                    <p class="text-xs text-muted-foreground">10/03/2024</p>
                                </div>
                            </a><a class="flex items-center gap-4 p-3 rounded-lg hover:bg-muted/50 transition-colors" href="/dashboard/quotes/quote-wa-1">
                                <div class="p-2 rounded-lg bg-success/10 text-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check w-4 h-4">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg></div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="font-medium text-foreground truncate">PRV-2024-001</p>
                                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 text-xs bg-success/10 text-success">Accettato</div>
                                    </div>
                                    <p class="text-sm text-muted-foreground truncate">TechStart SRL</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-foreground">8120,32&nbsp;€</p>
                                    <p class="text-xs text-muted-foreground">05/03/2024</p>
                                </div>
                            </a></div>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-3"><a href="/dashboard/quotes/new">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-soft transition-shadow cursor-pointer h-full">
                            <div class="p-6 flex items-center gap-4">
                                <div class="p-3 rounded-xl bg-primary/10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus w-6 h-6 text-primary">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg></div>
                                <div>
                                    <h3 class="font-medium text-foreground">Nuovo Preventivo</h3>
                                    <p class="text-sm text-muted-foreground">Crea un preventivo</p>
                                </div>
                            </div>
                        </div>
                    </a><a href="/dashboard/clients">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-soft transition-shadow cursor-pointer h-full">
                            <div class="p-6 flex items-center gap-4">
                                <div class="p-3 rounded-xl bg-accent/10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text w-6 h-6 text-accent">
                                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                        <path d="M10 9H8"></path>
                                        <path d="M16 13H8"></path>
                                        <path d="M16 17H8"></path>
                                    </svg></div>
                                <div>
                                    <h3 class="font-medium text-foreground">Gestisci Clienti</h3>
                                    <p class="text-sm text-muted-foreground">Anagrafica clienti</p>
                                </div>
                            </div>
                        </div>
                    </a><a href="/dashboard/services">
                        <div class="rounded-lg border bg-card text-card-foreground shadow-sm hover:shadow-soft transition-shadow cursor-pointer h-full">
                            <div class="p-6 flex items-center gap-4">
                                <div class="p-3 rounded-xl bg-success/10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-euro w-6 h-6 text-success">
                                        <path d="M4 10h12"></path>
                                        <path d="M4 14h9"></path>
                                        <path d="M19 6a7.7 7.7 0 0 0-5.2-2A7.9 7.9 0 0 0 6 12c0 4.4 3.5 8 7.8 8 2 0 3.8-.8 5.2-2"></path>
                                    </svg></div>
                                <div>
                                    <h3 class="font-medium text-foreground">Listino Prezzi</h3>
                                    <p class="text-sm text-muted-foreground">Servizi e prodotti</p>
                                </div>
                            </div>
                        </div>
                    </a></div>
            </div>
        </main>
    </div>

</div>