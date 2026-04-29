@extends('layouts.app')

@section('title', 'Pointage Mensualités')

@section('content')
@vite(['resources/js/list/months-status.js','resources/js/payment/markAsPaid.js'])

<div class="space-y-8 max-w-7xl mx-auto text-white">
    <div class="bg-gray-900 border border-gray-800 p-8 rounded-3xl flex items-center gap-6">
        <div class="w-20 h-20 rounded-3xl overflow-hidden border-2 border-amber-500/20 shrink-0 bg-gray-800 flex items-center justify-center">
                <img src="" alt="avatar" id="studentPhoto">
        </div>
        <div class="flex-1 min-w-0">
            <h1 class="text-3xl font-black tracking-tight text-white truncate" id="studentName">
                Chargement...
            </h1>
        </div>
    </div>

    <form id="paymentForm">

        <section class="bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800/50">
                            <th class="px-10 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest w-24 text-center">
                                Action
                            </th>
                            <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest">
                                Mois
                            </th>
                            <th class="px-8 py-5 text-[11px] uppercase font-bold text-gray-500 tracking-widest text-right">
                                Statut
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-800" id="paymentsTableBody">
                        <tr class="hover:bg-gray-800/20 transition-colors">
                            <td colspan="3" class="px-8 py-12 text-center text-gray-500">
                                <div class="flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-spinner fa-spin text-amber-500"></i>
                                    <span>Chargement des paiements...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <footer class="bg-gray-800/30 px-10 py-10 border-t border-gray-800 flex justify-end gap-4">
                <button
                    type="submit"
                    id="confirmBtn"
                    class="bg-amber-500 hover:bg-amber-600 text-black font-black py-4 px-12 rounded-2xl transition-all active:scale-95 text-sm uppercase tracking-widest flex items-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span>Confirmer</span>
                </button>
            </footer>
        </section>
    </form>
</div>

<div id="paymentAlert" class="hidden fixed bottom-8 right-8 max-w-sm z-50">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 text-sm text-white shadow-lg">
    </div>
</div>

<template id="paymentRowTemplate">
    <tr class="hover:bg-gray-800/20 transition-colors group" data-payment-id="" data-paid="">
        <td class="px-10 py-6 text-center">
            <label class="relative inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    name="payment_ids[]"
                    class="peer sr-only payment-checkbox"
                    value="">

                <div class="w-7 h-7 border-2 rounded-xl transition-all flex items-center justify-center
                    bg-black border-gray-700 group-hover:border-amber-500 peer-checked:bg-emerald-500 peer-checked:border-emerald-500">
                    <i class="fa-solid fa-check text-xs text-black font-black opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                </div>
            </label>
        </td>

        <td class="px-8 py-6 text-lg font-bold text-white">
            <span class="month-display"></span>
            <span class="text-[10px] text-gray-600 uppercase tracking-tighter block mt-1 month-id"></span>
        </td>

        <td class="px-8 py-6 text-right">
            <span class="inline-block text-[10px] font-black uppercase tracking-widest px-4 py-2 rounded-full border
                text-emerald-400 bg-emerald-400/10 border-emerald-400/20 status-badge">
                Impayé
            </span>
        </td>
    </tr>
</template>

@endsection
