{{-- 
    resources/views/expences/partials/expences-section.blade.php
    À inclure dans colocations/show.blade.php via @include ou directement
    Nécessite: $colocation (avec memberShips.user et expences chargés)
--}}

<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

    .exp-section { font-family: 'Sora', sans-serif; }

    /* ── Shared card base ── */
    .exp-card {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #e8eaf0;
        overflow: hidden;
        box-shadow: 0 4px 32px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04);
        margin-bottom: 20px;
        transition: box-shadow 0.3s;
    }
    .exp-card:hover {
        box-shadow: 0 8px 48px rgba(0,0,0,0.09), 0 2px 8px rgba(0,0,0,0.05);
    }

    /* ── Card header (dark) ── */
    .exp-card-header {
        background: linear-gradient(135deg, #18181b 0%, #27272a 60%, #1c1917 100%);
        padding: 22px 28px 20px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .exp-card-header::before {
        content: '';
        position: absolute; top: -40px; right: -40px;
        width: 140px; height: 140px;
        background: radial-gradient(circle, rgba(250,204,21,0.10) 0%, transparent 70%);
        border-radius: 50%; pointer-events: none;
    }
    .ech-icon {
        width: 40px; height: 40px;
        background: rgba(250,204,21,0.12);
        border: 1px solid rgba(250,204,21,0.25);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
        position: relative; z-index: 1;
    }
    .ech-title {
        font-size: 1rem; font-weight: 700;
        color: #fafaf9; letter-spacing: -0.02em;
        position: relative; z-index: 1;
    }
    .ech-sub {
        font-size: 0.72rem; color: #71717a; margin-top: 1px;
        font-weight: 300; position: relative; z-index: 1;
    }

    /* ── Card body ── */
    .exp-card-body { padding: 24px 28px 28px; }

    /* ── Form fields ── */
    .exp-field { margin-bottom: 16px; }
    .exp-label {
        display: block; font-size: 0.72rem; font-weight: 700;
        color: #71717a; text-transform: uppercase; letter-spacing: 0.08em;
        margin-bottom: 7px; font-family: 'DM Mono', monospace;
    }
    .exp-input, .exp-select {
        width: 100%; padding: 12px 16px;
        border: 1.5px solid #e4e4e7; border-radius: 12px;
        font-family: 'Sora', sans-serif; font-size: 0.875rem;
        outline: none; background: #fafafa; color: #18181b;
        box-sizing: border-box;
        transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
        appearance: none;
    }
    .exp-input::placeholder { color: #a1a1aa; }
    .exp-input:focus, .exp-select:focus {
        border-color: #facc15; background: #fff;
        box-shadow: 0 0 0 3px rgba(250,204,21,0.12);
    }
    .exp-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
    }
    @media (max-width: 640px) { .exp-grid { grid-template-columns: 1fr; } }

    .exp-select-wrap { position: relative; }
    .exp-select-wrap::after {
        content: '↓';
        position: absolute; right: 14px; top: 50%;
        transform: translateY(-50%);
        font-size: 0.75rem; color: #a1a1aa; pointer-events: none;
        font-family: 'DM Mono', monospace;
    }
    .exp-select { padding-right: 36px; cursor: pointer; }

    .exp-error { color: #ef4444; font-size: 0.75rem; margin-top: 5px; }

    /* ── Submit button ── */
    .exp-submit {
        width: 100%; margin-top: 20px;
        display: flex; align-items: center; justify-content: center; gap: 10px;
        background: #18181b; color: #fafaf9; border: none;
        padding: 13px 24px; border-radius: 14px;
        font-family: 'Sora', sans-serif; font-weight: 700; font-size: 0.875rem;
        cursor: pointer; letter-spacing: -0.01em;
        transition: all 0.22s cubic-bezier(0.4,0,0.2,1);
        position: relative; overflow: hidden;
    }
    .exp-submit::before {
        content: ''; position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(250,204,21,0.08), transparent);
        opacity: 0; transition: opacity 0.2s;
    }
    .exp-submit:hover { background: #27272a; transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,0,0,0.18); }
    .exp-submit:hover::before { opacity: 1; }
    .exp-submit:active { transform: translateY(0); box-shadow: none; }
    .exp-submit-arrow {
        width: 22px; height: 22px;
        background: rgba(250,204,21,0.15); border-radius: 6px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.8rem; transition: transform 0.2s;
    }
    .exp-submit:hover .exp-submit-arrow { transform: translateX(3px); }

    /* ── Flash ── */
    .exp-flash {
        border-radius: 12px; padding: 11px 16px; font-size: 0.82rem;
        font-weight: 500; display: flex; align-items: center; gap: 9px;
        margin-bottom: 16px;
    }
    .exp-flash-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .exp-flash-error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

    /* ── Balances ── */
    .balance-list { display: flex; flex-direction: column; gap: 10px; }

    .balance-row {
        display: flex; align-items: center; gap: 14px;
        background: #fafafa; border: 1px solid #f0f0f0;
        border-radius: 14px; padding: 13px 18px;
        transition: all 0.2s;
    }
    .balance-row:hover { background: #f4f4f5; border-color: #e4e4e7; }

    .bal-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; font-weight: 700; flex-shrink: 0;
        font-family: 'DM Mono', monospace;
    }
    .bal-avatar-pos { background: #dcfce7; color: #166534; }
    .bal-avatar-neg { background: #fee2e2; color: #991b1b; }
    .bal-avatar-zero { background: #f4f4f5; color: #71717a; }

    .bal-name {
        font-size: 0.875rem; font-weight: 600; color: #18181b; flex: 1;
    }

    .bal-bar-wrap {
        flex: 1; max-width: 100px;
        height: 4px; background: #f0f0f0; border-radius: 99px;
        overflow: hidden;
    }
    .bal-bar {
        height: 100%; border-radius: 99px;
        transition: width 0.5s ease;
    }
    .bal-bar-pos { background: linear-gradient(90deg, #22c55e, #16a34a); }
    .bal-bar-neg { background: linear-gradient(90deg, #ef4444, #dc2626); }

    .bal-amount {
        font-size: 0.9rem; font-weight: 800;
        font-family: 'DM Mono', monospace;
        letter-spacing: -0.02em; white-space: nowrap;
        min-width: 80px; text-align: right;
    }
    .bal-pos { color: #16a34a; }
    .bal-neg { color: #dc2626; }
    .bal-zero { color: #a1a1aa; }

    .bal-tag {
        font-size: 0.62rem; font-weight: 600; padding: 3px 8px;
        border-radius: 20px; font-family: 'DM Mono', monospace;
        text-transform: uppercase; letter-spacing: 0.05em;
        white-space: nowrap;
    }
    .bal-tag-pos { background: #dcfce7; color: #166534; }
    .bal-tag-neg { background: #fee2e2; color: #991b1b; }
    .bal-tag-zero { background: #f4f4f5; color: #a1a1aa; }

    /* ── Summary total ── */
    .balance-summary {
        display: flex; justify-content: space-between; align-items: center;
        padding: 14px 18px;
        background: linear-gradient(135deg, #18181b, #27272a);
        border-radius: 14px; margin-top: 14px;
    }
    .bs-label { font-size: 0.72rem; color: #71717a; text-transform: uppercase; letter-spacing: 0.1em; font-family: 'DM Mono', monospace; }
    .bs-amount { font-size: 1rem; font-weight: 800; font-family: 'DM Mono', monospace; color: #facc15; }
</style>

<div class="exp-section">

    @if(session('error'))
        <div class="exp-flash exp-flash-error">⚠️ {{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="exp-flash exp-flash-success">✓ {{ session('success') }}</div>
    @endif

    {{-- ═══════════════════════════════
         CARD 1 — Ajouter une dépense
    ═══════════════════════════════ --}}
    <div class="exp-card">
        <div class="exp-card-header">
            <div class="ech-icon">➕</div>
            <div>
                <div class="ech-title">Ajouter une dépense</div>
                <div class="ech-sub">Divisée équitablement entre tous les membres actifs</div>
            </div>
        </div>

        <div class="exp-card-body">
            <form method="POST" action="{{ route('expences.store', $colocation) }}">
                @csrf

                {{-- Titre --}}
                <div class="exp-field">
                    <label class="exp-label">Titre</label>
                    <input name="title" type="text" class="exp-input"
                           value="{{ old('title') }}"
                           placeholder="Ex: Électricité, Loyer, Courses...">
                    @error('title') <div class="exp-error">{{ $message }}</div> @enderror
                </div>

                {{-- Grid: montant + date + payeur --}}
                <div class="exp-grid">
                    <div class="exp-field">
                        <label class="exp-label">Montant (DH)</label>
                        <input type="number" step="0.01" min="0.01" name="amount" class="exp-input"
                               value="{{ old('amount') }}" placeholder="0.00">
                        @error('amount') <div class="exp-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="exp-field">
                        <label class="exp-label">Date</label>
                        <input type="date" name="expence_date" class="exp-input"
                               value="{{ old('expence_date', now()->toDateString()) }}">
                        @error('expence_date') <div class="exp-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="exp-field">
                        <label class="exp-label">Payé par</label>
                        <div class="exp-select-wrap">
                            <select name="payer_id" class="exp-select">
                                @foreach($colocation->memberShips->whereNull('left_at') as $m)
                                    <option value="{{ $m->user_id }}"
                                        @selected(old('payer_id', auth()->id()) == $m->user_id)>
                                        {{ $m->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('payer_id') <div class="exp-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="exp-submit">
                    Ajouter la dépense
                    <span class="exp-submit-arrow">→</span>
                </button>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════
         CARD 2 — Balances
    ═══════════════════════════════ --}}
    <div class="exp-card">
        <div class="exp-card-header">
            <div class="ech-icon">💰</div>
            <div>
                <div class="ech-title">Balances</div>
                <div class="ech-sub">État des comptes en temps réel</div>
            </div>
        </div>

        <div class="exp-card-body">
            @php
                $members = $colocation->memberShips->whereNull('left_at');
                $maxAbs = $members->max(fn($m) => abs((float)$m->balance)) ?: 1;
                $totalDépenses = $colocation->expences->sum('amount') ?? 0;
            @endphp

            <div class="balance-list">
                @foreach($members as $m)
                    @php $b = (float)$m->balance; @endphp
                    <div class="balance-row">
                        {{-- Avatar --}}
                        <div class="bal-avatar {{ $b > 0 ? 'bal-avatar-pos' : ($b < 0 ? 'bal-avatar-neg' : 'bal-avatar-zero') }}">
                            {{ strtoupper(substr($m->user->name, 0, 2)) }}
                        </div>

                        {{-- Name --}}
                        <div class="bal-name">{{ $m->user->name }}</div>

                        {{-- Progress bar --}}
                        <div class="bal-bar-wrap">
                            <div class="bal-bar {{ $b >= 0 ? 'bal-bar-pos' : 'bal-bar-neg' }}"
                                 style="width: {{ $maxAbs > 0 ? min(100, round(abs($b) / $maxAbs * 100)) : 0 }}%">
                            </div>
                        </div>

                        {{-- Tag --}}
                        <span class="bal-tag {{ $b > 0 ? 'bal-tag-pos' : ($b < 0 ? 'bal-tag-neg' : 'bal-tag-zero') }}">
                            {{ $b > 0 ? 'créditeur' : ($b < 0 ? 'débiteur' : 'équilibré') }}
                        </span>

                        {{-- Amount --}}
                        <div class="bal-amount {{ $b > 0 ? 'bal-pos' : ($b < 0 ? 'bal-neg' : 'bal-zero') }}">
                            {{ $b > 0 ? '+' : '' }}{{ number_format($b, 2) }} DH
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div class="balance-summary">
                <div>
                    <div class="bs-label">Total dépenses</div>
                </div>
                <div class="bs-amount">{{ number_format($totalDépenses, 2) }} DH</div>
            </div>
        </div>
    </div>

</div>