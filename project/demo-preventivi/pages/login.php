<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../app/routing.php';

$accounts = require __DIR__ . '/../app/accounts.php';
$features = [
    "Preventivi illimitati",
    "Gestione clienti CRM",
    "Esportazione PDF",
    "Listini personalizzabili",
];
?>

<div class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center p-4">
    <div class="max-w-4xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
        <div class="md:w-1/2 p-8 md:p-12 bg-indigo-900 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
                </svg>
            </div>
            <div class="z-10">
                <h1 class="text-3xl font-bold mb-2">PrevPro</h1>
                <p class="text-indigo-200 text-sm uppercase tracking-widest font-semibold mb-8">Demo Gestionale</p>

                <h2 class="text-2xl font-light mb-6">La soluzione flessibile per la tua attività.</h2>

                <ul class="space-y-4">
                    <?php foreach ($features as $feature): ?>
                        <li class="flex items-center space-x-3">
                            <svg class="size-5 shrink-0 text-indigo-400">
                                <use href="./src/svg/icons.svg#circle-check"></use>
                            </svg>
                            <span class="text-indigo-100"><?php echo $feature; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="mt-8 z-10">
                <p class="text-xs text-indigo-300">
                    Progetto dimostrativo. I dati sono salvati localmente per la durata della sessione.
                </p>
            </div>
        </div>
        <div class="md:w-1/2 p-8 md:p-12 bg-white flex flex-col justify-center">
            <h3 class="text-xl font-bold text-gray-800 mb-6 text-center">Scegli una Demo</h3>
            <p class="text-gray-500 text-center mb-8 text-sm">Seleziona un profilo per vedere come la piattaforma si adatta a diversi settori.</p>
            <div class="space-y-4">
                <?php foreach ($accounts as $account): ?>
                    <button data-theme="<?php echo $account['theme'] ?? 'default'; ?>"
                        class="login-btn w-full cursor-pointer group flex items-center p-4 border border-gray-200 rounded-xl hover:border-primary-500 hover:shadow-lg transition-all bg-white hover:bg-primary-50 duration-300" data-account="<?php echo strtolower(str_replace(' ', '-', $account['name'])); ?>">
                        <div class="bg-primary-100 p-3 rounded-full text-primary-600 group-hover:bg-primary-600 transition-colors duration-300">
                            <svg class="size-6 shrink-0 text-primary-500 group-hover:text-white duration-300">
                                <use href="<?php echo $account['icon']; ?>"></use>
                            </svg>
                        </div>
                        <div class="ml-4 text-left">
                            <h4 class="font-bold text-gray-800"><?php echo $account['name']; ?></h4>
                            <p class="text-xs text-gray-500"><?php echo $account['description']; ?></p>
                        </div>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script src="./src/js/login.js"></script>