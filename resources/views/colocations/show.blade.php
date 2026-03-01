<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $colocation->name }}
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');
        .show-root { font-family: 'Sora', sans-serif; }

        .alert-box {
            border-radius: 12px; padding: 14px 18px; font-size: 0.875rem;
            font-weight: 500; display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
        }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }

        /* Header section */
        .coloc-header {
            border-radius: 20px;
            padding: 36px 36px 28px;
            position: relative;
            overflow: hidden;
            margin-bottom: 28px;
        }
        .coloc-header.is-active {
            background: linear-gradient(135deg, #052e16 0%, #14532d 60%, #065f46 100%);
        }
        .coloc-header.is-inactive {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #334155 100%);
        }
        .coloc-header::before {
            content: '';
            position: absolute; top: -80px; right: -80px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            border-radius: 50%;
        }
        .ch-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            position: relative; z-index: 1;
        }
        .ch-name {
            font-size: 2rem;
            font-weight: 700;
            color: #f8fafc;
            letter-spacing: -0.04em;
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 7px 16px;
            border-radius: 30px;
            font-family: 'DM Mono', monospace;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .is-active .status-pill { background: rgba(34,197,94,0.2); color: #86efac; border: 1px solid rgba(34,197,94,0.3); }
        .is-inactive .status-pill { background: rgba(148,163,184,0.15); color: #94a3b8; border: 1px solid rgba(148,163,184,0.2); }

        .ch-stats {
            display: flex;
            gap: 32px;
            margin-top: 24px;
            position: relative; z-index: 1;
        }
        .ch-stat { }
        .ch-stat .cs-val {
            font-size: 1.8rem;
            font-weight: 700;
            color: #f1f5f9;
            line-height: 1;
        }
        .ch-stat .cs-lab {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 3px;
        }

        /* Main layout */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
        }
        @media (max-width: 900px) { .two-col { grid-template-columns: 1fr; } }

        /* Cards */
        .section-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 20px;
        }
        .dark .section-card { background: #1e293b; border-color: #334155; }

        .section-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 18px;
            font-family: 'DM Mono', monospace;
        }

        /* Members */
        .member-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .dark .member-row { border-color: #334155; }
        .member-row:last-child { border-bottom: none; }

        .member-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        .member-name { font-weight: 600; color: #0f172a; font-size: 0.9rem; }
        .dark .member-name { color: #f1f5f9; }
        .member-role-badge {
            margin-left: auto;
            font-size: 0.68rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            font-family: 'DM Mono', monospace;
            text-transform: uppercase;
        }
        .role-owner { background: #fef9c3; color: #854d0e; }
        .role-membre { background: #eff6ff; color: #1d4ed8; }

        /* Invite form */
        .invite-form {
            display: flex;
            gap: 10px;
        }
        .invite-input {
            flex: 1;
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s;
            background: #f8fafc;
        }
        .dark .invite-input { background: #0f172a; border-color: #334155; color: #f1f5f9; }
        .invite-input:focus { border-color: #6366f1; background: #fff; }
        .btn-invite {
            background: #6366f1;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .btn-invite:hover { background: #4f46e5; }

        /* Pending invitations */
        .inv-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
        }
        .dark .inv-row { border-color: #334155; }
        .inv-row:last-child { border-bottom: none; }
        .inv-email { color: #334155; }
        .dark .inv-email { color: #cbd5e1; }
        .inv-badge {
            font-size: 0.68rem;
            background: #fef9c3;
            color: #92400e;
            padding: 3px 10px;
            border-radius: 20px;
            font-family: 'DM Mono', monospace;
            font-weight: 600;
        }

        /* Danger actions */
        .danger-zone {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            border-radius: 14px;
            padding: 18px 20px;
        }
        .dark .danger-zone { background: rgba(239,68,68,0.07); border-color: rgba(239,68,68,0.2); }
        .danger-zone p { font-size: 0.8rem; color: #9f1239; margin-bottom: 12px; }
        .dark .danger-zone p { color: #fca5a5; }

        .btn-danger {
            background: #ef4444;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-danger:hover { background: #dc2626; }

        .btn-outline-danger {
            background: transparent;
            color: #ef4444;
            border: 1.5px solid #ef4444;
            padding: 10px 18px;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-outline-danger:hover { background: #ef4444; color: #fff; }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 24px;
            transition: color 0.2s;
        }
        .back-link:hover { color: #334155; }
    </style>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto show-root">

        <a href="{{ route('colocations.index') }}" class="back-link">← Retour aux colocations</a>

        @if(session('error'))
            <div class="alert-box alert-error">⚠️ {{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert-box alert-success">✓ {{ session('success') }}</div>
        @endif

        {{-- Header --}}
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
                    <div class="cs-lab">Invitations en attente</div>
                </div>
                <div class="ch-stat">
                    <div class="cs-val">{{ $colocation->created_at->format('M Y') }}</div>
                    <div class="cs-lab">Créée en</div>
                </div>
            </div>
        </div>

        <div class="two-col">
            {{-- Left column --}}
            <div>
                {{-- Members --}}
                <div class="section-card">
                    <div class="section-title">👥 Membres ({{ $stats['members_active'] }})</div>
                    @foreach($colocation->memberShips as $membership)
                        @if($membership->left_at === null)
                            <div class="member-row">
                                <div class="member-avatar">{{ strtoupper(substr($membership->user->name, 0, 1)) }}</div>
                                <div>
                                    <div class="member-name">{{ $membership->user->name }}</div>
                                    <div style="font-size:0.75rem; color:#94a3b8;">{{ $membership->user->email }}</div>
                                </div>
                                <span class="member-role-badge {{ $membership->role === 'owner' ? 'role-owner' : 'role-membre' }}">
                                    {{ $membership->role === 'owner' ? '👑 Owner' : 'Membre' }}
                                </span>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Pending invitations (owner only) --}}
                @if($stats['is_owner'] && $colocation->status === 'active')
                    <div class="section-card">
                        <div class="section-title">📩 Invitations en attente</div>
                        @php $pendingInvs = $colocation->invitations->where('status','pending'); @endphp
                        @if($pendingInvs->isEmpty())
                            <p style="color:#94a3b8; font-size:0.875rem;">Aucune invitation en attente.</p>
                        @else
                            @foreach($pendingInvs as $inv)
                                <div class="inv-row">
                                    <span class="inv-email">{{ $inv->invited_email }}</span>
                                    <span class="inv-badge">En attente</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>

            {{-- Right column --}}
            <div>
                {{-- Invite form (owner + active) --}}
                @if($stats['is_owner'] && $colocation->status === 'active')
                    <div class="section-card">
                        <div class="section-title">✉️ Inviter un membre</div>
                        <form method="POST" action="{{ route('invitations.store', $colocation) }}">
                            @csrf
                            <div class="invite-form">
                                <input type="email" name="invited_email"
                                       class="invite-input"
                                       placeholder="email@exemple.com"
                                       required>
                                <button type="submit" class="btn-invite">Inviter</button>
                            </div>
                        </form>
                    </div>
                @endif

                {{-- Quit colocation (non-owner) --}}
                @if(!$stats['is_owner'] && $colocation->status === 'active')
                    <div class="danger-zone" style="margin-bottom:20px;">
                        <div class="section-title" style="color:#9f1239;">⚠️ Quitter la colocation</div>
                        <p>En quittant, vous perdrez accès à cette colocation.</p>
                        <form action="{{ route('colocations.quit', $colocation) }}" method="post">
                            @csrf
                            <button type="submit" class="btn-outline-danger">Quitter la colocation</button>
                        </form>
                    </div>
                @endif

                {{-- Deactivate (owner + active) --}}
                @if($stats['is_owner'] && $colocation->status === 'active')
                    <div class="danger-zone">
                        <div class="section-title" style="color:#9f1239;">⚠️ Zone de danger</div>
                        <p>La désactivation mettra fin à la colocation. Cette action est irréversible.</p>
                        <form method="POST" action="{{ route('colocations.destroy', $colocation) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">Désactiver la colocation</button>
                        </form>
                    </div>
                @endif

                {{-- Inactive notice --}}
                @if($colocation->status !== 'active')
                    <div class="section-card" style="background:#f8fafc; border-style: dashed;">
                        <div style="text-align:center; padding: 20px 0;">
                            <div style="font-size:2rem; margin-bottom:10px;">🔒</div>
                            <div style="font-weight:600; color:#475569;">Colocation inactive</div>
                            <div style="font-size:0.8rem; color:#94a3b8; margin-top:4px;">Cette colocation n'accepte plus de membres ni d'invitations.</div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>