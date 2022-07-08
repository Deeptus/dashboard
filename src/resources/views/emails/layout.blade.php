<!DOCTYPE html>
<html>
<head>
    <title>Send Email</title>
    <style>
        .body {
            background-color: #edf2f7;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px !important;
        }

        tr:nth-child(even) {
            background-color: #e2e2e2 !important;
        }
        tr:nth-child(even) td, tr:nth-child(even) th {
            background-color: #e2e2e2 !important;
        }
        .title {
            white-space: nowrap;
            width: 30px;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .white-space-nowrap {
            white-space: nowrap;
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
        .email-body {
            padding: 32px;
            background-color: #ffffff;
            max-width: 800px !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        .email-footer {
            padding: 32px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="body">
        @yield('content')
    </div>
</body>
</html>