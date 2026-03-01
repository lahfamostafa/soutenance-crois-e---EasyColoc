{{-- ====================== CREATE VIEW ====================== --}}
{{-- resources/views/colocations/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Créer une colocation
        </h2>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap');
        .create-root { font-family: 'Sora', sans-serif; }

        .create-wrapper {
            max-width: 520px;
            margin: 60px auto;
        }
        .create-card {
            background: #fff;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            border: 1px solid #f1f5f9;
        }
        .dark .create-card { background: #1e293b; border-color: #334155; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }

        .create-icon {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        .create-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.03em;
        }
        .dark .create-title { color: #f1f5f9; }
        .create-sub {
            color: #94a3b8;
            font-size: 0.875rem;
            margin-top: 4px;
            margin-bottom: 28px;
        }

        .form-field label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .dark .form-field label { color: #94a3b8; }

        .form-field input[type="text"] {
            width: 100%;
            padding: 13px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-family: 'Sora', sans-serif;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #f8fafc;
            box-sizing: border-box;
        }
        .dark .form-field input[type="text"] { background: #0f172a; border-color: #334155; color: #f1f5f9; }
        .form-field input[type="text"]:focus {
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 24px;
            transition: all 0.2s;
            letter-spacing: -0.01em;
        }
        .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); box-shadow: 0 12px 30px rgba(99,102,241,0.35); }

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

    <div class="py-8 px-4 create-root">
        <div class="create-wrapper">
            <a href="{{ route('colocations.index') }}" class="back-link">← Retour</a>

            <div class="create-card">
                <div class="create-icon">🏠</div>
                <h1 class="create-title">Nouvelle colocation</h1>
                <p class="create-sub">Donnez un nom à votre espace partagé.</p>

                <form action="{{ route('colocations.store') }}" method="POST">
                    @csrf
                    <div class="form-field">
                        <label for="name">Nom de la colocation</label>
                        <input type="text" name="name" id="name"
                               placeholder="Ex: Appartement Paris 11ème"
                               value="{{ old('name') }}"
                               required autofocus>
                        @error('name')
                            <p style="color:#ef4444; font-size:0.8rem; margin-top:6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">Créer la colocation ✨</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>