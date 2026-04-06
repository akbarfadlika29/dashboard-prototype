<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $dataset->nama }}</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        h2 {
            margin-bottom: 4px;
        }

        p {
            margin-top: 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }
    </style>
</head>

<body>

    <h2>{{ $dataset->nama }}</h2>
    <p>{{ $dataset->deskripsi }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>

                @foreach($dataset->kolom as $column)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach($rows as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    @foreach($dataset->schema_json as $key)
                        <td>{{ $row->data_json[$key] ?? '-' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>