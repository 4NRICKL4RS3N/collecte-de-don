<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        h2 {
            color: #333;
        }

        p {
            font-size: 16px;
        }

        .donation-details {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .donation-details li {
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .highlight {
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="container">
    <p>Cher <span class="highlight">{{ $donation->user->name }}</span>,</p>

    <p>Nous vous remercions pour votre don généreux de <span class="highlight">${{ number_format($payment->donation_amount / 100, 2) }}</span>.
        Votre contribution permettra de faire la différence.</p>

    <h2>Détails du don :</h2>
    <ul class="donation-details">
        <li>Montant : ${{ number_format($payment->donation_amount / 100, 2) }}</li>
        <li>Transaction ID : {{ $payment->transaction_id }}</li>
        <li>Date : {{ $payment->created_at->format('F j, Y') }}</li>
    </ul>

    @if($donation->project)
        <p>Votre don soutiendra le projet : <span class="highlight">{{ $donation->project->title }}</span></p>
    @endif

    <p>Encore merci pour votre soutien !</p>

    <p class="footer">Meilleures salutations,<br>
        {{ config('app.name') }}</p>
</div>
</body>

</html>
