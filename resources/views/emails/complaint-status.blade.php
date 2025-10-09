<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            margin: 0;
            padding: 0;
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            padding: 20px;
            background: #f9f9f9;
        }
        .header { 
            background: #1e3c72; 
            color: white; 
            padding: 30px; 
            text-align: center; 
            border-radius: 10px 10px 0 0;
        }
        .content { 
            background: white; 
            padding: 30px; 
            border-radius: 0 0 10px 10px;
        }
        .status-badge { 
            display: inline-block; 
            padding: 8px 15px; 
            border-radius: 20px; 
            color: white; 
            font-weight: bold;
            margin: 10px 0;
        }
        .complaint-info {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #1e3c72;
            margin: 20px 0;
        }
        .footer { 
            text-align: center; 
            padding: 20px; 
            font-size: 12px; 
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gemeente Klachten Systeem</h1>
        </div>
        
        <div class="content">
            <!-- ✅ استخدام naam بدلاً من name -->
            <h2>Beste {{ $complaint->melder->naam ?? 'Geachte heer/mevrouw' }},</h2>
            
            <p>Wij informeren u over de actuele status van uw ingediende klacht.</p>
            
            <div class="complaint-info">
                <strong>Klachtgegevens:</strong><br>
                <!-- ✅ استخدام complaint_number بدلاً من id -->
                Klachtnummer: <strong>#{{ $complaint->complaint_number }}</strong><br>
                Categorie: {{ $complaint->category }}<br>
                Locatie: {{ $complaint->address }}<br>
                Datum indiening: {{ $complaint->created_at->format('d-m-Y H:i') }}<br><br>
                
                <strong>Huidige status:</strong><br>
                <span class="status-badge" style="background: 
                    @if($complaint->status == 'new') #ffc107
                    @elseif($complaint->status == 'in_progress') #17a2b8
                    @elseif($complaint->status == 'resolved') #28a745
                    @endif;">
                    <!-- ✅ استدعاء الدالة بشكل صحيح -->
                    {{ $getStatusText($complaint->status) }}
                </span>
            </div>

            @if($statusMessage)
            <div style="background: #e7f3ff; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <strong>Toelichting van de gemeente:</strong><br>
                {{ $statusMessage }}
            </div>
            @endif

            <div style="margin: 20px 0;">
                <strong>Wat betekent deze status?</strong><br>
                @if($complaint->status == 'new')
                ✔️ Uw klacht is bij ons binnen<br>
                ✔️ Wij nemen zo spoedig mogelijk contact op<br>
                ✔️ Het klachtnummer is: <strong>#{{ $complaint->complaint_number }}</strong>
                @elseif($complaint->status == 'in_progress')
                ✔️ Onze medewerkers zijn op de hoogte<br>
                ✔️ We werken aan een oplossing<br>
                ✔️ U wordt op de hoogte gehouden
                @elseif($complaint->status == 'resolved')
                ✔️ Uw klacht is afgehandeld<br>
                ✔️ Het probleem is verholpen<br>
                ✔️ Bedankt voor uw melding!
                @endif
            </div>

            <p>Met vriendelijke groet,<br>
            <strong>Team Gemeente</strong><br>
            Afdeling Klachtenbehandeling</p>
        </div>
        
        <div class="footer">
            <p>Dit is een automatisch bericht. Gelieve niet te reageren op deze e-mail.</p>
            <p>Heeft u vragen? Neem contact op met de gemeente.</p>
            <p>&copy; {{ date('Y') }} Gemeente. Alle rechten voorbehouden.</p>
        </div>
    </div>
</body>
</html>