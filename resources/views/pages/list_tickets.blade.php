<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Lots de Tickets</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .download-btn {
            padding: 8px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
        }
        .add-btn {
            padding: 8px;
            background-color: darkblue;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            border-radius: 4px;
        }


        .download-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Liste des Lots de Tickets</h2>
@if(session('success'))
    <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
@endif
<a href="{{ route('add_tickets') }}" class="add-btn">Ajouter</a>
<table>
    <thead>
    <tr>
        <th>Titre</th>
        <th>Nombre</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lots as $lot)
        <tr>
            <td>{{ $lot->title }}</td>
            <td>{{ $lot->ticket_count }}</td>
            <td>
                <a href="{{ route('download_tickets', ['title' => $lot->title]) }}" class="download-btn">Télécharger</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

