<!-- resources/views/create_ticket.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Ticket</title>
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

        button:hover {
            background-color: #45a049;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1 style="text-align: center">Créer un Ticket</h1>
@if(session('success'))
    <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
@endif

<form action="{{ route('create_ticket') }}" method="post">
    @csrf
    @error('name')
    <div style="color: red; margin-bottom: 10px;">{{ $message }}</div>
    @enderror
    <label for="nom">Nom :</label>
    <input type="text" name="name" required>
    @error('contact')
    <div style="color: red; margin-bottom: 10px;">{{ $message }}</div>
    @enderror
    <label for="contact">Contact :</label>
    <input type="tel" name="contact" required>
    @error('type_table')
    <div style="color: red; margin-bottom: 10px;">{{ $message }}</div>
    @enderror
    <label for="type_table">Type de Table :</label>
    <select name="type_table" required>
        <option value="PASS_SIMPLE">PASS SIMPLE</option>
        <option value="SALON_SILVER">SALON SILVER</option>
        <option value="SALON_GOLD">SALON GOLD</option>
        <option value="SALON_PLATINUM">SALON PLATINUM</option>
        <option value="SALON_VIP">SALON VIP</option>
    </select>
    <button type="submit">Créer le ticket</button>
</form>

</body>
</html>

