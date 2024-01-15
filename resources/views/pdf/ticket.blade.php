<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    * {
        font-family: 'Arial', 'Helvetica', sans-serif;
    }

    .text-center {
        text-align: center;
    }

    .both_border {
        border-top: 1px dotted black;
        border-bottom: 1px dotted black;

    }

    td.description,
    th.description {
        width: 30mm;
        max-width: 30mm;
    }

    td.quantity,
    th.quantity {
        width: 10mm;
        max-width: 10mm;
        word-break: break-all;
        text-align: center;
    }

    td.price,
    th.price {
        width: 20mm;
        max-width: 20mmpx;
        word-break: break-all;
        text-align: right;
    }

    .centered {
        text-align: center;
        align-content: center;
    }

    .ticket {
        width: 60mm;
        max-width: 60mm;
    }

    td.totales {
        font-size: 15px;
    }
</style>

<body>
    <section>
        {{-- <table celpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="2" class="text-center" width="100%">
                    <h4>Sistema de ventas S.A de C.V</h2>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <p style="font-weight: bold">Teléfono: <span>311-126-98-96</span></p>
                </td>
            </tr>
        </table> --}}
        <table celpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="2" class="text-center">
                    <h4 font-weight: bold;" class="primary">SISTEMA VENTAS</h4>
                </td>
            </tr>
            <tr>
                {{-- <td class="text-left text-company" width="33%" style="vertical-align: top; padding-top:10px;">
                    <img src="http://localhost:8000/assets/img/livewire.png" alt="">
                </td> --}}
                <td class="text-left text-company" width="100%" style="text-align:center; padding-top:10px;">
                    <span style="font-size: 15px; text-align:center; color:#202127"><strong>Sistema web S.A de
                            C.V</strong></span>
                    <span style="font-size: 15px; color:#202127"><strong>Teléfono:</strong>311-156-69-98</span>
                    <br>
                    <span style="font-size: 16px;  color:#202127""><strong>Dirección:</strong>65892, Los Fresnos,
                        Tepic</span>

                    <br>
                    <span style="font-size: 14px; color:#202127;"><strong>Fecha:
                        </strong>{{ \Carbon\Carbon::now()->format('Y-m-d H:m:s') }}</span>
                </td>
            </tr>
        </table>
    </section>
    <br>
    <br>
    <br>
    <section>
        <table>
            <thead>
                <tr>
                    <th class="quantity both_border">Cant.</th>
                    <th class="description both_border">Descripción</th>
                    <th class="price both_border">Total</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($saleDetails as $sale)
                <tr>
                    <td class="quantity">${{number_format($sale->quantity,2)}}</td>
                    <td class="description">{{$sale->product}}</td>
                    <td class="price">${{number_format($sale->price,2)}}</td>
                </tr>
                @endforeach
                
                <tr>
                    <th class="price totales both_border" colspan=3> TOTAL IMPORTE ${{number_format($total,2)}}</th>
                </tr>
            </tbody>
        </table>
        <p class="centered">Gracias por su compra!
            <br>www.josedaniel.com
        </p>

    </section>
</body>

</html>
