<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
        .title {
            white-space: nowrap;
            width: 30px;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .featured-title {
            font-size: 17px;
            margin-right: 30px;
            padding: 20px 0;
            white-space: nowrap;
            color: #D00E24;
            font-weight: 600;
        }
        .mensaje {
            font-size: 2em;
            font-weight: bold;
            color: #D00E24;
            text-align: center;
        }
    </style>
</head>
<body>
    <h4>Mensaje de contacto:</h4>
    <table>
        <tbody>
            @if(count($inputs) == 0)
            <tr>
                <td class="title">Nombre:</td>
                <td>{{ $data->name }}</td>
            </tr>
            <tr>
                <td class="title">Empresa:</td>
                <td>{{ $data->company }}</td>
            </tr>
            <tr>
                <td class="title">Teléfono:</td>
                <td>{{ $data->phone }}</td>
            </tr>
            <tr>
                <td class="title">Email:</td>
                <td>{{ $data->email }}</td>
            </tr>
            @if(array_key_exists('address', $data) && $data->address)
            <tr>
                <td class="title">Dirección:</td>
                <td>{{ $data->address }}</td>
            </tr>
            @endif
            <tr>
                <td class="title" colspan="2">Consulta:</td>
            </tr>
            <tr>
                <td colspan="2">{{ $data->message }}</td>
            </tr>
            @else
            @foreach($inputs as $key => $input)
                <tr>
                    <th class="title">{{ $input['label'] }}:</td>
                    <td>{{ $data->{$key} }}</td>
                </tr>
            @endforeach
            @endif            
        </tbody>
    </table>
    @if ($data->items && count($data->items) && ($data->type == 'budget' || $data->type == 'shopping-cart'))
    <table class="table align-middle table-striped table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data->items as $item)
            <tr>
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</body>
</html>