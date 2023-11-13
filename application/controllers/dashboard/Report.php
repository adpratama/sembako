<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('M_Order');
        $this->load->model('M_Auth');
        $this->load->model('M_Product');
        $this->load->model('M_Setting');
        $this->load->helper('date');

        if (!$this->session->userdata('is_logged_in')) {

            $this->session->set_flashdata('message_name', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
			You have to login first.
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>');
            redirect('auth');
        } else {
            if ($this->session->userdata('role_id') == "2") {
                redirect('/');
            }
        }
    }

    public function index()
    {
        $id = $this->session->userdata('username');

        $data = [
            'title' => 'Transaction',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/report/v_report',
            'script' => 'dashboard/layouts/_script',
            'partners' => $this->M_Setting->partners(),
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'user' => $this->M_Auth->cek_user($id)
        ];
        $this->load->view('dashboard/index', $data);
    }

    public function excel()
    {
        $jenis = $this->uri->segment(4);

        if ($jenis == "shopping-list") {
            $payment_status = 1;
        }

        // jenis report
        // shopping-list => status = 1;
        // tagihan => status = 2;
        // selesai => status = 3;
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $excel = new PHPExcel();


        // Settingan awal fil excel
        $excel->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('Bandes Rekayasa Digital')
            ->setTitle("Daftar Belanja")
            ->setSubject("Belanja")
            ->setDescription("Laporan Semua Daftar Belanja")
            ->setKeywords("Daftar Belanja");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Daftar Belanja"); // Set kolom A1 dengan tulisan "Daftar Belanja"
        $excel->getActiveSheet()->mergeCells('A1:C1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "No."); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Produk"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Jumlah"); // Set kolom C3 dengan tulisan "NAMA"
        // $excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        // $excel->setActiveSheetIndex(0)->setCellValue('E3', "ALAMAT"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        // $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        // $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

        $sql = "SELECT id_produk, qty, SUM(jumlah) AS total FROM detail_product a INNER JOIN transaction_detail b ON a.id_paket = b.id_product INNER JOIN transaction c ON b.id_transaction = c.Id WHERE payment_status = '$payment_status' group by id_produk";
        $t_details = $this->db->query($sql)->result();

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($t_details as $td) { // Lakukan looping pada variabel siswa
            $id_td = $td->id_produk;
            $isi_paket = $td->qty;
            $jumlah_pesanan = $td->total;
            $total_belanja = $isi_paket * $jumlah_pesanan;

            $product = $this->M_Product->detail_product_id($id_td);
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $product['menu_nama']);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $total_belanja);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            // $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            // $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Daftar Belanja");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        // ob_end_clean();
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Shopping-list.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");
        ob_end_clean();
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="Daftar Belanja.xlsx"'); // Set nama file excel nya
        // header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function tanda_terima()
    {
        $id = $this->session->userdata('username');

        $data = [
            'title' => 'Transaction',
            'style' => 'dashboard/layouts/_style',
            'pages' => 'dashboard/pages/transaction/v_check_tanda_terima',
            'script' => 'dashboard/layouts/_script',
            'unpaid' => $this->M_Order->unpaid_list(),
            'order' => $this->M_Order->order_count(),
            'orders' => $this->M_Order->order_notification(),
            'user' => $this->M_Auth->cek_user($id)
        ];
        $this->load->view('dashboard/index', $data);
    }

    public function download()
    {
        $jenis = $this->input->post('jenis');
        $bulan = $this->input->post('bulan');
        $perusahaan = $this->input->post('perusahaan');

        $bills = $this->M_Setting->download_tagihan($bulan, $perusahaan);

        if ($jenis == "tagihan") {
            $this->download_tagihan($bills);
        }
    }

    private function download_tagihan($bills)
    {
        echo '<table><tbody>';
        $no = 1;


        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $excel = new PHPExcel();


        // Settingan awal fil excel
        $excel->getProperties()->setCreator('My Notes Code')
            ->setLastModifiedBy('Bandes Rekayasa Digital')
            ->setTitle("Daftar Belanja")
            ->setSubject("Belanja")
            ->setDescription("Laporan Semua Daftar Belanja")
            ->setKeywords("Daftar Belanja");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Daftar Tagihan"); // Set kolom A1 dengan tulisan "Daftar Belanja"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "No."); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "No. Transaksi"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Pemesan"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Perusahaan"); // Set kolom D3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Qty"); // Set kolom E3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "Subtotal"); // Set kolom F3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "Order time"); // Set kolom G3 dengan tulisan "NAMA"
        // $excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        // $excel->setActiveSheetIndex(0)->setCellValue('E3', "ALAMAT"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($bills as $b) { // Lakukan looping pada variabel siswa
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $b->no_invoice);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $b->name);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $b->nama_perusahaan);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $b->total_item);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $b->subtotal);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, format_eng($b->order_time));

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Daftar Tagihan");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        // ob_end_clean();
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="Daftar-tagihan.xlsx"');
        header("Pragma: no-cache");
        header("Expires: 0");
        ob_end_clean();
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="Daftar Belanja.xlsx"'); // Set nama file excel nya
        // header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}
