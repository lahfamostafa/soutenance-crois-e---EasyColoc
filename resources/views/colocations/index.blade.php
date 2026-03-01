<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Mes Colocations
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap');
        .coloc-root { font-family: 'Sora', sans-serif; }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.03em;
        }
        .dark .page-title { color: #f1f5f9; }

        .btn-create {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #0f172a, #1e40af);
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 11px 22px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(30,64,175,0.3);
        }
        .btn-create:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(30,64,175,0.4); }

        .alert-box {
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }

        .empty-state {
            text-align: center;
            padding: 70px 20px;
            background: #f8fafc;
            border-radius: 20px;
            border: 2px dashed #e2e8f0;
        }
        .dark .empty-state { background: #1e293b; border-color: #334155; }
        .empty-state .es-icon { font-size: 3.5rem; margin-bottom: 16px; }
        .empty-state h3 { font-size: 1.2rem; font-weight: 600; color: #334155; }
        .dark .empty-state h3 { color: #cbd5e1; }
        .empty-state p { color: #94a3b8; font-size: 0.9rem; margin-top: 6px; }

        .coloc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .coloc-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            text-decoration: none;
            display: block;
            transition: all 0.25s;
            position: relative;
            overflow: hidden;
        }
        .dark .coloc-card { background: #1e293b; border-color: #334155; }
        .coloc-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.1); border-color: #6366f1; }

        .coloc-card.active-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #22c55e, #16a34a);
            border-radius: 18px 18px 0 0;
        }
        .coloc-card.inactive-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #94a3b8, #64748b);
            border-radius: 18px 18px 0 0;
        }

        .card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .card-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
        }
        .dark .card-name { color: #f1f5f9; }

        .badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-family: 'DM Mono', monospace;
        }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-inactive { background: #f1f5f9; color: #64748b; }
        .dark .badge-inactive { background: #334155; color: #94a3b8; }

        .card-stats {
            display: flex;
            gap: 20px;
            margin-top: 12px;
        }
        .cs-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.8rem;
            color: #64748b;
        }
        .cs-item .cs-icon { font-size: 0.9rem; }
        .cs-item strong { color: #334155; font-weight: 600; }
        .dark .cs-item strong { color: #cbd5e1; }

        .card-arrow {
            position: absolute;
            bottom: 20px; right: 20px;
            color: #cbd5e1;
            font-size: 1.2rem;
            transition: all 0.2s;
        }
        .coloc-card:hover .card-arrow { color: #6366f1; transform: translateX(4px); }
    </style>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto coloc-root">

        @if(session('error'))
            <div class="alert-box alert-error">⚠️ {{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert-box alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="page-header">
            <div>
                <h1 class="page-title">Mes Colocations</h1>
                <p style="color:#94a3b8; font-size:0.875rem; margin-top:2px;">{{ $colocations->count() }} colocation(s) trouvée(s)</p>
            </div>
            <a href="{{ route('colocations.create') }}" class="btn-create">
                + Nouvelle colocation
            </a>
        </div>

        @if($colocations->isEmpty())
            <div class="empty-state">
                <div class="es-icon">🏡</div>
                <h3>Aucune colocation pour l'instant</h3>
                <p>Créez votre première colocation ou attendez une invitation.</p>
                <a href="{{ route('colocations.create') }}" class="btn-create" style="display:inline-flex; margin-top:20px;">
                    + Créer une colocation
                </a>
            </div>
        @else
            <div class="coloc-grid">
                @foreach($colocations as $colocation)
                    <a href="{{ route('colocations.show', $colocation) }}"
                       class="coloc-card {{ $colocation->status === 'active' ? 'active-card' : 'inactive-card' }}">

                        <div class="card-top">
                            <div class="card-name">{{ $colocation->name }}</div>
                            <span class="badge {{ $colocation->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                                {{ $colocation->status === 'active' ? '● Active' : '○ Inactive' }}
                            </span>
                        </div>

                        <div class="card-stats">
                            <div class="cs-item">
                                <span class="cs-icon">👥</span>
                                <strong>{{ $colocation->active_members_count }}</strong>
                                <span>membres</span>
                            </div>
                            @if($colocation->owner_id === auth()->id())
                                <div class="cs-item">
                                    <span class="cs-icon">📩</span>
                                    <strong>{{ $colocation->pending_invitations_count }}</strong>
                                    <span>invitations</span>
                                </div>
                                <div class="cs-item">
                                    <span class="cs-icon">👑</span>
                                    <span>Propriétaire</span>
                                </div>
                            @endif
                        </div>

                        <div class="card-arrow">→</div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>