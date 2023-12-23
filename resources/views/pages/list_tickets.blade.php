<!-- resources/views/list_tickets.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tickets</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: #fff;
        }

        .download-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
        }

        a{
            text-decoration: none;
        }

        .download-btn.green {
            background-color: #4caf50;
        }

        .download-btn.red {
            background-color: #e74c3c;
        }

        .add-btn {
            padding: 8px;
            background-color: darkblue;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h2 style="text-align: center; margin-top: 10px">Liste des Tickets</h2>
@if(session('success'))
    <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
@endif
<a href="{{ route('add_tickets') }}" class="add-btn">Ajouter</a>
<table>
    <thead>
    <tr>
        <th>Nom</th>
        <th>Contact</th>
        <th>Type de Table</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tickets as $ticket)
        <tr>
            <td>{{ $ticket->name }}</td>
            <td>{{ $ticket->contact }}</td>
            <td>{{ $ticket->type_table }}</td>
            <td>
                <a href="{{ route('download_ticket', ['ticket' => $ticket->id]) }}"
                   class="download-btn {{ $ticket->downloaded ? 'red' : 'green' }}">
                    Télécharger
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

