  <style>
        .floating-wa {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #25D366;
            border: 3px solid #fff;
            border-radius: 50px;
            border-bottom-right-radius: 5px; /* Memberikan efek ekor bubble chat yang menghadap ke sudut kanan */
            display: flex;
            align-items: center;
            padding: 6px 20px 6px 12px;
            text-decoration: none;
            box-shadow: 2px 4px 15px rgba(0,0,0,0.2);
            z-index: 9999;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            gap: 10px;
        }
        .floating-wa:hover {
            transform: translateY(-3px);
            box-shadow: 2px 6px 20px rgba(0,0,0,0.25);
        }
        .floating-wa-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }
        .floating-wa-icon svg {
            width: 32px;
            height: 32px;
            fill: currentColor;
        }
        .floating-wa-text {
            display: flex;
            flex-direction: column;
            color: #fff;
            line-height: 1.2;
        }
        .floating-wa-text .wa-title {
            font-weight: 700;
            font-size: 18px;
            font-family: Arial, sans-serif;
            margin-bottom: 2px;
        }
        .floating-wa-text .wa-subtitle {
            font-size: 13px;
            font-family: Arial, sans-serif;
        }
        @media (max-width: 768px) {
            .floating-wa {
                bottom: 20px;
                right: 20px;
                padding: 5px 15px 5px 10px;
                gap: 8px;
            }
            .floating-wa-icon svg {
                width: 28px;
                height: 28px;
            }
            .floating-wa-text .wa-title {
                font-size: 16px;
            }
            .floating-wa-text .wa-subtitle {
                font-size: 12px;
            }
        }
    </style>

@php
    $phoneSetting = $settings['contact_phone'] ?? '6281234567890';
    $waNumber = preg_replace('/[^0-9]/', '', $phoneSetting);
    if (str_starts_with($waNumber, '0')) {
        $waNumber = '62' . substr($waNumber, 1);
    }
@endphp
  <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="floating-wa" title="Hubungi Kami via WhatsApp">
        <div class="floating-wa-icon">
            <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.964 9.964 0 001.333 4.993L2 22l5.233-1.337a9.994 9.994 0 004.779 1.216h.004c5.502 0 9.985-4.48 9.985-9.984C21.996 6.388 17.518 2 12.012 2zm0 16.892a8.318 8.318 0 01-4.244-1.157l-.304-.18-3.155.805.845-3.076-.197-.313a8.3 8.3 0 01-1.272-4.444c0-4.582 3.731-8.312 8.317-8.312 4.586 0 8.316 3.729 8.316 8.311 0 4.584-3.73 8.315-8.306 8.315zm4.56-6.223c-.25-.125-1.481-.73-1.711-.814-.23-.084-.397-.125-.565.125-.167.25-.646.814-.793 1.001-.146.188-.293.208-.543.084-.25-.125-1.056-.39-2.01-1.243-.742-.664-1.243-1.485-1.39-1.735-.146-.25-.015-.385.11-.51.112-.112.25-.291.375-.438.125-.146.167-.25.25-.417.084-.167.042-.313-.02-.438-.063-.125-.565-1.36-.773-1.862-.204-.492-.41-.425-.565-.433-.146-.008-.313-.008-.48-.008s-.438.063-.667.313c-.23.25-.877.856-.877 2.087 0 1.231.898 2.42 1.023 2.587.125.167 1.763 2.69 4.27 3.712 1.995.814 2.593.702 3.07.568.48-.135 1.481-.605 1.69-1.19.208-.584.208-1.085.146-1.19-.062-.104-.23-.167-.48-.292z" />
            </svg>
        </div>
        <div class="floating-wa-text">
            <span class="wa-title">WhatsApp</span>
            <span class="wa-subtitle">Click to Chat</span>
        </div>
    </a>
