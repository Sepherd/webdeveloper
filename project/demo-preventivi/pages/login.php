<?php
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
                        <!-- <CheckCircle2 class="w-5 h-5 text-indigo-400" /> -->
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
                <button
                    class="w-full cursor-pointer group flex items-center p-4 border border-gray-200 rounded-xl hover:border-indigo-500 hover:shadow-lg transition-all duration-300 bg-white hover:bg-indigo-50">
                    <div class="bg-indigo-100 p-3 rounded-full text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                        <Building2 class="w-6 h-6" />
                    </div>
                    <div class="ml-4 text-left">
                        <h4 class="font-bold text-gray-800">Agenzia Web</h4>
                        <p class="text-xs text-gray-500">Servizi digitali, marketing, hosting</p>
                    </div>
                </button>
                <button
                    class="w-full cursor-pointer group flex items-center p-4 border border-gray-200 rounded-xl hover:border-orange-500 hover:shadow-lg transition-all duration-300 bg-white hover:bg-orange-50">
                    <div class="bg-orange-100 p-3 rounded-full text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <Hammer class="w-6 h-6" />
                    </div>
                    <div class="ml-4 text-left">
                        <h4 class="font-bold text-gray-800">Impresa Edile</h4>
                        <p class="text-xs text-gray-500">Lavori, materiali, manodopera</p>
                    </div>
                </button>

                <button
                    class="w-full cursor-pointer group flex items-center p-4 border border-gray-200 rounded-xl hover:border-emerald-500 hover:shadow-lg transition-all duration-300 bg-white hover:bg-emerald-50">
                    <div class="bg-emerald-100 p-3 rounded-full text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                        <Briefcase class="w-6 h-6" />
                    </div>
                    <div class="ml-4 text-left">
                        <h4 class="font-bold text-gray-800">Consulente Freelance</h4>
                        <p class="text-xs text-gray-500">Consulenze orarie, prestazioni</p>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>