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
    <h4>Nuevo cliente registrado:</h4>
    <table>
        <tbody>
            <tr>
                <td class="title">Nombre:</td>
                <td>{{ $client->full_name }}</td>
            </tr>
            <tr>
                <td class="title">Email:</td>
                <td>{{ $client->email }}</td>
            </tr>
            <tr>
                <td class="title">IVA:</td>
                <td>{{ $client->type_taxpayer->name }}</td>
            </tr>
            <tr>
                <td class="title">DNI:</td>
                <td>{{ $client->default_profile->dni }}</td>
            </tr>
            <tr>
                <td class="title">Teléfono:</td>
                <td>{{ $client->default_profile->phone }}</td>
            </tr>
            <tr>
                <td class="title">Dirección:</td>
                <td>{{ $client->default_profile->address }}</td>
            </tr>
            <tr>
                <td class="title">Empresa:</td>
                <td>{{ $client->default_profile->business_name }}</td>
            </tr>
            <tr>
                <td class="title">CUIT:</td>
                <td>{{ $client->default_profile->cuit }}</td>
            </tr>
            <tr>
                <td class="title">Provincia:</td>
                <td>{{ $client->default_profile->location_1_name }}</td>
            </tr>
            <tr>
                <td class="title">Localidad:</td>
                <td>{{ $client->default_profile->location_2_name }}</td>
            </tr>
            <tr>
                <td class="title">Código Postal:</td>
                <td>{{ $client->default_profile->zip }}</td>
            </tr>
            <tr>
                <td class="title">Nombre de usuario:</td>
                <td>{{ $client->username }}</td>
            </tr>
        </tbody>
    </table>
    {{--<a href="{{ route('admin.cliente.trash') }}" style="margin-top: 5px; display: inline-block; padding: 8px 33px; border: 1px solid; text-decoration: none; font-size: 16px; font-weight: bold; background: #15c; color: #FFF;">Ir a ver</a>--}}
</body>
</html>
