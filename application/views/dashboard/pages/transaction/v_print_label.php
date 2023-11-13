<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <title><?= $title ?></title>
    <style>
        * {
            font-size: 10px;
            font-family: 'Times New Roman';
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
            /* width: 100%; */
            padding: 5px;
        }

        table.received {
            width: 100%;
            padding: 30px;
        }


        td.description,
        th.description {
            width: 35%;
            max-width: 35%;
        }

        td.quantity,
        th.quantity {
            width: 15%;
            max-width: 15%;
            word-break: break-all;
        }

        td.price,
        th.price {
            text-align: right;
            width: 25%;
            max-width: 25%;
            word-break: break-all;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        tr.received {
            border-top: 1px solid dashed;
            border-bottom: 1px solid dashed;
        }

        .bold {
            font-weight: bold;
        }

        .ticket {
            width: 75mm;
            max-width: 75mm;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }

        h3 {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <h3 class="centered">Koperasi <br>Bandes Rekayasa Digital</h3>
        <!-- <img src="./logo.png" alt="Logo"> -->
        <p class="centered">No. Pesanan <?= $order['no_invoice'] ?>
            <br><?= $pemesan['name'] ?> - <?= $pemesan['nama_perusahaan'] ?>
        </p>
        <table>
            <thead>
                <tr>
                    <th class="description">Nama produk</th>
                    <th class="">Harga</th>
                    <th class="quantity">Jumlah</th>
                    <th class="">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($details as $d) {

                    $id = $d->id_product;
                    $item = $this->M_Product->detail_product_id($id);
                ?>
                    <tr>
                        <td><?= $item['menu_nama'] ?></td>
                        <td class="price">Rp<?= number_format($d->harga_satuan) ?></td>
                        <td class="centered"><?= $d->jumlah ?> pc(s)</td>
                        <td class="price">Rp<?= number_format($d->subtotal) ?></td>
                    </tr>
                <?php
                    $total += $d->subtotal;
                }
                ?>
                <tr>
                    <td colspan="3" class="centered bold">TOTAL</td>
                    <td class="price">Rp<?= number_format($total) ?></td>
                </tr>
            </tbody>
        </table>
        <p class="centered">Thanks for your purchase!
            <br>Koperasi Bandes Rekayasa Digital
            <br>
            <br>
        </p>

        <table class="received">
            <tbody>
                <tr class="received">
                    <td class="centered"><br><?= $order['no_invoice'] ?><br><br></td>
                    <td class="centered bold">
                        <br>TANDA TERIMA <br><br>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <button id="btnPrint" class="hidden-print">Print</button>
    <!-- <script src="script.js"></script> -->
    <script>
        const $btnPrint = document.querySelector("#btnPrint");
        $btnPrint.addEventListener("click", () => {
            window.print();
        });
    </script>
</body>

</html>