<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h1 style="text-align: center">Création des tickets !</h1>
<p style="text-align: center">Entrez les informations relatives au lot de tickets que vous voulez générer.</p>

<form action="{{ route('process_tickets') }}" method="post">
    @csrf

    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif

    <label for="title">Titre du Ticket:</label>
    <input type="text" id="title" name="title" placeholder="Entrez un titre" required>
    @error('title')
    <div style="color: red; margin-bottom: 10px;">{{ $message }}</div>
    @enderror

    <label for="quantity">Nombre de Tickets:</label>
    <input type="number" id="quantity" name="quantity" min="1" placeholder="Entrez le nombre de tickets" required>
    @error('quantity')
    <div style="color: red; margin-bottom: 10px;">{{ $message }}</div>
    @enderror

    <button type="submit">Créer des Tickets</button>
</form>

</body>
</html>
