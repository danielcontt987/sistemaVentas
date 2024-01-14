<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de ventas</title>
    <style>
        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: normal;
        }

        @page {
            margin-top: 5px;
            padding: 0;
            font-family: 'Montserrat';
        }

        html {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .text-center {
            text-align: center
        }

        .primary {
            color: #3B3F5C;
        }

        .mt-2 {
            margin-top: 5px;
        }

        .content-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            min-width: 400px;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .content-table thead tr {
            background-color: #3B3F5C;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }

        .content-table th,
        .content-table td {
            padding: 12px 15px;
        }

        .content-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .content-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .chip {
            align-items: center;
            background-color: #00CFB5;
            border: 1px solid #00CFB5;
            color: #f3f3f3;
            padding: 4px 4px 4px 4px;
            border-radius: 8px;
            font-weight: bold;
            gap: 5px;
        }
    </style>
</head>

<body>
    <section>
        <table celpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="2" class="text-center">
                    <h2 font-weight: bold;" class="primary">SISTEMA VENTAS</h2>
                </td>
            </tr>
            <tr>
                {{-- <td class="text-left text-company" width="33%" style="vertical-align: top; padding-top:10px;">
                    <img src="http://localhost:8000/assets/img/livewire.png" alt="">
                </td> --}}
                <td class="text-left text-company" width="100%" style="text-align:center; padding-top:10px;">
                    @if ($reportType == 0)
                        <span style="font-size: 16px; text-align:center; color:#3B3F5C"><strong>Reporte de Ventas del
                                Día</strong></span>
                    @else
                        <span style="font-size: 16px; color:#3B3F5C"><strong>Reporte de Ventas por
                                fechas</strong></span>
                    @endif
                    <br>
                    @if ($reportType != 0)
                        <span style="font-size: 16px;  color:#3B3F5C""><strong>Fecha de Consulta: {{ $dateFrom }} al
                                {{ $dateTo }}</strong></span>
                    @else
                        <span style="font-size: 16px; color:#3B3F5C""><strong>Fecha de Consulta:
                                {{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong></span>
                    @endif
                    <br>
                    @if ($user != "Todos")
                        <span style="font-size: 14px; color:#3B3F5C;"><strong>Usuario:
                                {{ $user->name }}</strong></span>
                    @else
                        <span style="font-size: 14px; color:#3B3F5C;"><strong>Usuarios:
                            Todos</strong></span>
                    @endif
                </td>
            </tr>
        </table>
    </section>
    <section>
        <table class="content-table" width="100%">
            <thead>
                <tr>
                    <th>FOLIO</th>
                    <th>IMPORTE</th>
                    <th>CANT</th>
                    <th>ESTAUS</th>
                    <th>USUARIO</th>
                    <th>FECHA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td align="center">{{ $item->id }}</td>
                        <td align="center">${{ number_format($item->total, 2) }}</td>
                        <td align="center">{{ $item->items }}</td>
                        <td align="center"><span class="chip">{{ $item->status }}</span></td>
                        <td align="center">{{ $item->user }}</td>
                        <td align="center">{{ $item->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <script type="text/php">
        if ( isset($pdf) ) {
            $h = $pdf->get_height();
    
            $size = 8;
            $font_bold = $fontMetrics->getFont("helvetica", "bold"); // intenta uno  diferente
            $text_height = $fontMetrics->getFontHeight($font_bold, $size);
            $y = $h - $text_height - 24;
    
            $pdf->page_text(260, $y, "Página {PAGE_NUM} de {PAGE_COUNT}", $font_bold, $size, [0, 0, 0]); // longitud ingresada de la pagina
          }
    </script>
</body>

</html>
