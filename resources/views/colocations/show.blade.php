<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $colocation->name }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap');

        * { box-sizing: border-box; }
        .show-root { font-family: 'Sora', sans-serif; color: #18181b; }

        /* ── Alerts ── */
        .alert-box {
            border-radius: 14px; padding: 13px 18px; font-size: 0.875rem;
            font-weight: 500; display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
        }
        .alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }

        /* ── Back ── */
        .back-link {
            display: inline-flex; align-items: center; gap: 5px;
            color: #a1a1aa; text-decoration: none; font-size: 0.78rem;
            font-weight: 500; margin-bottom: 22px; transition: color 0.2s;
            font-family: 'DM Mono', monospace; letter-spacing: 0.02em;
        }
        .back-link:hover { color: #18181b; }

        /* ── Header banner ── */
        .coloc-header {
            border-radius: 20px; padding: 32px 36px 26px;
            position: relative; overflow: hidden; margin-bottom: 28px;
            border: 1px solid #e8eaf0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.05);
        }
        .coloc-header.is-active {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-color: #bbf7d0;
        }
        .coloc-header.is-inactive {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-color: #e2e8f0;
        }
        .ch-top { display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
        .ch-name { font-size: 1.8rem; font-weight: 800; letter-spacing: -0.04em; }
        .is-active   .ch-name { color: #14532d; }
        .is-inactive .ch-name { color: #334155; }

        .status-pill {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.72rem; font-weight: 700; padding: 6px 14px;
            border-radius: 30px; font-family: 'DM Mono', monospace;
            text-transform: uppercase; letter-spacing: 0.06em;
        }
        .is-active   .status-pill { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .is-inactive .status-pill { background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1; }

        .ch-stats { display: flex; gap: 32px; margin-top: 22px; flex-wrap: wrap; }
        .ch-stat .cs-val { font-size: 1.6rem; font-weight: 800; line-height: 1; }
        .is-active   .ch-stat .cs-val { color: #15803d; }
        .is-inactive .ch-stat .cs-val { color: #475569; }
        .ch-stat .cs-lab { font-size: 0.68rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.09em; margin-top: 3px; }

        /* ── Main grid ── */
        .main-grid { display: grid; grid-template-columns: 1fr 340px; gap: 22px; align-items: start; }
        @media (max-width: 960px) { .main-grid { grid-template-columns: 1fr; } }

        /* ── Card ── */
        .s-card {
            background: #fff; border: 1px solid #e8eaf0; border-radius: 18px;
            margin-bottom: 18px; overflow: hidden;
            box-shadow: 0 1px 8px rgba(0,0,0,0.04);
            transition: box-shadow 0.2s;
        }
        .s-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }

        .s-card-head {
            padding: 16px 22px; display: flex; align-items: center; gap: 10px;
            border-bottom: 1px solid #f4f4f5;
            background: #fafafa;
        }
        .sch-icon { font-size: 1rem; }
        .sch-title { font-size: 0.875rem; font-weight: 700; color: #18181b; }
        .sch-sub   { font-size: 0.7rem; color: #a1a1aa; margin-top: 1px; }
        .sch-badge {
            margin-left: auto; font-size: 0.65rem; font-weight: 700;
            padding: 3px 9px; border-radius: 20px; font-family: 'DM Mono', monospace;
            background: #f4f4f5; color: #71717a; border: 1px solid #e4e4e7;
        }
        .s-card-body { padding: 18px 22px 22px; }

        /* ── Members ── */
        .member-row {
            display: flex; align-items: center; gap: 11px;
            padding: 9px 0; border-bottom: 1px solid #f4f4f5;
        }
        .member-row:last-child { border-bottom: none; }
        .member-av {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 0.8rem; flex-shrink: 0;
        }
        .member-name  { font-weight: 600; color: #18181b; font-size: 0.875rem; }
        .member-email { font-size: 0.7rem; color: #a1a1aa; }
        .role-badge {
            margin-left: auto; font-size: 0.62rem; font-weight: 700;
            padding: 3px 9px; border-radius: 20px;
            font-family: 'DM Mono', monospace; text-transform: uppercase;
        }
        .role-owner  { background: #fef9c3; color: #854d0e; }
        .role-membre { background: #eff6ff; color: #1d4ed8; }

        /* ── Expense form ── */
        .exp-label {
            display: block; font-size: 0.68rem; font-weight: 700; color: #71717a;
            text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px;
            font-family: 'DM Mono', monospace;
        }
        .exp-input, .exp-select {
            width: 100%; padding: 10px 13px;
            border: 1.5px solid #e4e4e7; border-radius: 11px;
            font-family: 'Sora', sans-serif; font-size: 0.85rem;
            outline: none; background: #fafafa; color: #18181b;
            transition: all 0.2s; appearance: none;
        }
        .exp-input::placeholder { color: #a1a1aa; }
        .exp-input:focus, .exp-select:focus {
            border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.08);
        }
        .exp-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 14px; }
        @media (max-width: 600px) { .exp-grid { grid-template-columns: 1fr; } }
        .exp-select-wrap { position: relative; }
        .exp-select-wrap::after {
            content: '↓'; position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%); font-size: 0.7rem; color: #a1a1aa;
            pointer-events: none; font-family: 'DM Mono', monospace;
        }
        .exp-select { padding-right: 32px; cursor: pointer; }
        .exp-error { color: #ef4444; font-size: 0.72rem; margin-top: 4px; }
        .exp-submit {
            width: 100%; background: #6366f1; color: #fff; border: none;
            padding: 12px 20px; border-radius: 12px;
            font-family: 'Sora', sans-serif; font-weight: 700; font-size: 0.875rem;
            cursor: pointer; transition: all 0.2s; margin-top: 4px;
        }
        .exp-submit:hover { background: #4f46e5; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(99,102,241,0.3); }

        /* ── Balances table ── */
        .bal-table { width: 100%; border-collapse: collapse; }
        .bal-table th {
            font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em;
            color: #a1a1aa; font-family: 'DM Mono', monospace; font-weight: 600;
            padding: 0 0 12px; text-align: left; border-bottom: 1px solid #f0f0f0;
        }
        .bal-table th:last-child { text-align: right; }
        .bal-table td { padding: 11px 0; border-bottom: 1px solid #f4f4f5; vertical-align: middle; }
        .bal-table tr:last-child td { border-bottom: none; }

        .bal-av {
            width: 32px; height: 32px; border-radius: 50%; flex-shrink: 0;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.7rem; font-weight: 700; font-family: 'DM Mono', monospace;
        }
        .bal-av-pos  { background: #dcfce7; color: #166534; }
        .bal-av-neg  { background: #fee2e2; color: #991b1b; }
        .bal-av-zero { background: #f4f4f5; color: #71717a; }
        .bal-name { font-size: 0.85rem; font-weight: 600; color: #18181b; padding-left: 10px; }
        .bal-tag {
            font-size: 0.6rem; font-weight: 700; padding: 3px 8px; border-radius: 20px;
            font-family: 'DM Mono', monospace; text-transform: uppercase;
        }
        .bal-tag-pos  { background: #dcfce7; color: #166534; }
        .bal-tag-neg  { background: #fee2e2; color: #991b1b; }
        .bal-tag-zero { background: #f4f4f5; color: #a1a1aa; }
        .bal-amt {
            font-size: 0.88rem; font-weight: 800; font-family: 'DM Mono', monospace;
            text-align: right;
        }
        .bal-pos  { color: #16a34a; }
        .bal-neg  { color: #dc2626; }
        .bal-zero { color: #a1a1aa; }

        .bal-total-row td {
            padding-top: 14px; border-top: 2px solid #f0f0f0; border-bottom: none;
        }
        .bal-total-label { font-size: 0.72rem; color: #a1a1aa; text-transform: uppercase; letter-spacing: 0.08em; font-family: 'DM Mono', monospace; }
        .bal-total-amt   { font-size: 1rem; font-weight: 800; font-family: 'DM Mono', monospace; color: #18181b; text-align: right; }

        /* ── Invite ── */
        .invite-wrap { display: flex; gap: 8px; }
        .invite-input {
            flex: 1; padding: 10px 13px;
            border: 1.5px solid #e4e4e7; border-radius: 11px;
            font-family: 'Sora', sans-serif; font-size: 0.85rem;
            outline: none; background: #fafafa; color: #18181b; transition: all 0.2s;
        }
        .invite-input::placeholder { color: #a1a1aa; }
        .invite-input:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.08); }
        .invite-btn {
            background: #18181b; color: #fff; border: none;
            padding: 10px 16px; border-radius: 11px;
            font-family: 'Sora', sans-serif; font-weight: 700; font-size: 0.82rem;
            cursor: pointer; transition: all 0.2s; white-space: nowrap;
        }
        .invite-btn:hover { background: #27272a; transform: translateY(-1px); }

        /* ── Pending invitations ── */
        .inv-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 8px 0; border-bottom: 1px solid #f4f4f5; font-size: 0.84rem;
        }
        .inv-row:last-child { border-bottom: none; }
        .inv-email { color: #27272a; font-weight: 500; }
        .inv-dot-badge {
            display: inline-flex; align-items: center; gap: 5px; font-size: 0.62rem;
            font-family: 'DM Mono', monospace; font-weight: 700; padding: 3px 9px;
            border-radius: 20px; background: #fefce8; color: #854d0e; border: 1px solid #fef08a;
        }
        .inv-dot {
            width: 5px; height: 5px; background: #eab308; border-radius: 50%;
            animation: blink 1.8s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{opacity:1;} 50%{opacity:0.35;} }

        /* ── Danger zone ── */
        .danger-zone {
            background: #fff1f2; border: 1px solid #fecdd3; border-radius: 14px;
            padding: 16px 18px; margin-bottom: 14px;
        }
        .dz-title { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.1em; color: #f43f5e; font-family: 'DM Mono', monospace; font-weight: 700; margin-bottom: 7px; }
        .danger-zone p { font-size: 0.78rem; color: #9f1239; margin-bottom: 12px; line-height: 1.5; }
        .btn-danger {
            background: #ef4444; color: #fff; border: none; padding: 10px 16px;
            border-radius: 10px; font-family: 'Sora', sans-serif; font-weight: 700;
            font-size: 0.82rem; cursor: pointer; transition: all 0.2s;
        }
        .btn-danger:hover { background: #dc2626; }
        .btn-outline-danger {
            background: transparent; color: #ef4444; border: 1.5px solid #fca5a5;
            padding: 10px 16px; border-radius: 10px; font-family: 'Sora', sans-serif;
            font-weight: 700; font-size: 0.82rem; cursor: pointer; transition: all 0.2s;
        }
        .btn-outline-danger:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

        /* ── Inactive notice ── */
        .inactive-notice {
            background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 14px;
            text-align: center; padding: 28px 20px;
        }
    </style>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto show-root">

        <a href="{{ route('colocations.index') }}" class="back-link">← colocations</a>

        @if(session('error'))
            <div class="alert-box alert-error">⚠️ {{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert-box alert-success">✓ {{ session('success') }}</div>
        @endif

        {{-- ══ HEADER ══ --}}
        <div class="coloc-header {{ $colocation->status === 'active' ? 'is-active' : 'is-inactive' }}">
            <div class="ch-top">
                <div class="ch-name">{{ $colocation->name }}</div>
                <span class="status-pill">
                    {{ $colocation->status === 'active' ? '● Active' : '○ Inactive' }}
                </span>
            </div>
            <div class="ch-stats">
                <div class="ch-stat">
                    <div class="cs-val">{{ $stats['members_active'] }}</div>
                    <div class="cs-lab">Membres actifs</div>
                </div>
                <div class="ch-stat">
                    <div class="cs-val">{{ $colocation->invitations->where('status','pending')->count() }}</div>
                    <div class="cs-lab">Invitations</div>
                </div>
                <div class="ch-stat">
                    <div class="cs-val">{{ number_format($colocation->expences->sum('amount'), 0) }} DH</div>
                    <div class="cs-lab">Total dépenses</div>
                </div>
                <div class="ch-stat">
                    <div class="cs-val">{{ $colocation->created_at->format('M Y') }}</div>
                    <div class="cs-lab">Créée en</div>
                </div>
            </div>
        </div>

        {{-- ══ MAIN GRID ══ --}}
        <div class="main-grid">

            {{-- ─── GAUCHE ─── --}}
            <div>

                {{-- Membres + Balances (1 seul tableau) --}}
                <div class="s-card">
                    <div class="s-card-head">
                        <span class="sch-icon">👥</span>
                        <div>
                            <div class="sch-title">Membres & Balances</div>
                            <div class="sch-sub">État des comptes en temps réel</div>
                        </div>
                        <span class="sch-badge">{{ $stats['members_active'] }}</span>
                    </div>
                    <div class="s-card-body">
                        @php
                            $activeMembers = $colocation->memberShips->whereNull('left_at');
                            $maxAbs = $activeMembers->max(fn($m) => abs((float)$m->balance)) ?: 1;
                        @endphp
                        <table class="bal-table">
                            <thead>
                                <tr>
                                    <th>Membre</th>
                                    <th>Rôle</th>
                                    <th>Statut</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeMembers as $m)
                                    @php $b = (float)$m->balance; @endphp
                                    <tr>
                                        <td>
                                            <div style="display:flex; align-items:center; gap:0;">
                                                <div class="bal-av {{ $b > 0 ? 'bal-av-pos' : ($b < 0 ? 'bal-av-neg' : 'bal-av-zero') }}">
                                                    {{ strtoupper(substr($m->user->name, 0, 2)) }}
                                                </div>
                                                <div class="bal-name">{{ $m->user->name }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="role-badge {{ $m->role === 'owner' ? 'role-owner' : 'role-membre' }}">
                                                {{ $m->role === 'owner' ? '👑 Owner' : 'Membre' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="bal-tag {{ $b > 0 ? 'bal-tag-pos' : ($b < 0 ? 'bal-tag-neg' : 'bal-tag-zero') }}">
                                                {{ $b > 0 ? 'créditeur' : ($b < 0 ? 'débiteur' : 'équilibré') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="bal-amt {{ $b > 0 ? 'bal-pos' : ($b < 0 ? 'bal-neg' : 'bal-zero') }}">
                                                {{ $b > 0 ? '+' : '' }}{{ number_format($b, 2) }} DH
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bal-total-row">
                                    <td colspan="3"><span class="bal-total-label">Total dépenses</span></td>
                                    <td><span class="bal-total-amt">{{ number_format($colocation->expences->sum('amount'), 2) }} DH</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Ajouter une dépense --}}
                @if($colocation->status === 'active')
                <div class="s-card">
                    <div class="s-card-head">
                        <span class="sch-icon">➕</span>
                        <div>
                            <div class="sch-title">Ajouter une dépense</div>
                            <div class="sch-sub">Divisée équitablement entre tous les membres</div>
                        </div>
                    </div>
                    <div class="s-card-body">
                        <form method="POST" action="{{ route('expences.store', $colocation) }}">
                            @csrf
                            <div style="margin-bottom:14px;">
                                <label class="exp-label">Titre</label>
                                <input name="title" type="text" class="exp-input"
                                       value="{{ old('title') }}"
                                       placeholder="Ex: Électricité, Loyer, Courses...">
                                @error('title') <div class="exp-error">{{ $message }}</div> @enderror
                            </div>
                            <div class="exp-grid">
                                <div>
                                    <label class="exp-label">Montant (DH)</label>
                                    <input type="number" step="0.01" min="0.01" name="amount" class="exp-input"
                                           value="{{ old('amount') }}" placeholder="0.00">
                                    @error('amount') <div class="exp-error">{{ $message }}</div> @enderror
                                </div>
                                <div>
                                    <label class="exp-label">Date</label>
                                    <input type="date" name="expence_date" class="exp-input"
                                           value="{{ old('expence_date', now()->toDateString()) }}">
                                    @error('expence_date') <div class="exp-error">{{ $message }}</div> @enderror
                                </div>
                                <div>
                                    <label class="exp-label">Payé par</label>
                                    <div class="exp-select-wrap">
                                        <select name="payer_id" class="exp-select">
                                            @foreach($activeMembers as $m)
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
                            <button type="submit" class="exp-submit">Ajouter la dépense →</button>
                        </form>
                    </div>
                </div>
                @endif

            </div>

            {{-- ─── DROITE ─── --}}
            <div>

                {{-- Inviter un membre --}}
                @if($stats['is_owner'] && $colocation->status === 'active')
                <div class="s-card">
                    <div class="s-card-head">
                        <span class="sch-icon">✉️</span>
                        <div>
                            <div class="sch-title">Inviter un membre</div>
                            <div class="sch-sub">Par adresse email</div>
                        </div>
                    </div>
                    <div class="s-card-body">
                        <form method="POST" action="{{ route('invitations.store', $colocation) }}">
                            @csrf
                            <div class="invite-wrap">
                                <input type="email" name="invited_email" class="invite-input"
                                       placeholder="email@exemple.com" required>
                                <button type="submit" class="invite-btn">Inviter →</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                {{-- Invitations en attente --}}
                @if($stats['is_owner'] && $colocation->status === 'active')
                @php $pendingInvs = $colocation->invitations->where('status','pending'); @endphp
                <div class="s-card">
                    <div class="s-card-head">
                        <span class="sch-icon">📩</span>
                        <div><div class="sch-title">Invitations en attente</div></div>
                        <span class="sch-badge">{{ $pendingInvs->count() }}</span>
                    </div>
                    <div class="s-card-body">
                        @if($pendingInvs->isEmpty())
                            <div style="text-align:center; padding:14px 0; color:#a1a1aa; font-size:0.8rem;">
                                <div style="font-size:1.4rem; margin-bottom:5px;">📭</div>
                                Aucune invitation en attente
                            </div>
                        @else
                            @foreach($pendingInvs as $inv)
                                <div class="inv-row">
                                    <span class="inv-email">{{ $inv->invited_email }}</span>
                                    <span class="inv-dot-badge"><span class="inv-dot"></span>En attente</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                @endif

                {{-- Quitter --}}
                @if(!$stats['is_owner'] && $colocation->status === 'active')
                <div class="danger-zone">
                    <div class="dz-title">⚠️ Quitter</div>
                    <p>En quittant, vous perdrez accès à cette colocation.</p>
                    <form action="{{ route('colocations.quit', $colocation) }}" method="post">
                        @csrf
                        <button type="submit" class="btn-outline-danger">Quitter la colocation</button>
                    </form>
                </div>
                @endif

                {{-- Désactiver --}}
                @if($stats['is_owner'] && $colocation->status === 'active')
                <div class="danger-zone">
                    <div class="dz-title">⚠️ Zone de danger</div>
                    <p>La désactivation mettra fin à la colocation. Cette action est irréversible.</p>
                    <form method="POST" action="{{ route('colocations.destroy', $colocation) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">Désactiver la colocation</button>
                    </form>
                </div>
                @endif

                {{-- Inactive --}}
                @if($colocation->status !== 'active')
                <div class="inactive-notice">
                    <div style="font-size:2rem; margin-bottom:8px;">🔒</div>
                    <div style="font-weight:700; color:#334155; font-size:0.9rem;">Colocation inactive</div>
                    <div style="font-size:0.76rem; color:#94a3b8; margin-top:4px; line-height:1.5;">Cette colocation n'accepte plus de membres ni d'invitations.</div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>